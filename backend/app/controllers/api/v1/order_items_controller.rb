# frozen_string_literal: true

class Api::V1::OrderItemsController < ApplicationController
  def index
    dining_table_id = params[:dining_table_id]
    order = current_tenant.orders.includes(order_items: :item).find_by(dining_table_id: dining_table_id, status: :pending)

    if order
      render json: {
        order_id: order.id,
        order_items: order.order_items.map { |order_item| serialize_order_item(order_item) }
      }
    else
      render json: { order_id: nil, order_items: [] }
    end
  end

  def create
    order_item = nil

    ActiveRecord::Base.transaction do
      item = current_tenant.items.find(create_params.dig(:order_item, :item_id))

      order = current_tenant.orders.find_or_create_by!(dining_table_id: create_params[:dining_table_id],
                                                       status: :pending) do |new_order|
        new_order.user = current_user
        new_order.total_price = 0
      end

      order_item = order.order_items.find_by(item_id: item.id)

      if order_item
        order_item.update!(quantity: order_item.quantity + 1)
      else
        order_item = order.order_items.create!(
          item_id: item.id,
          price: create_params.dig(:order_item, :price),
          quantity: 1
        )
      end

      total_price = order.order_items.sum('quantity * price')
      order.update!(total_price: total_price)
    end

    render json: serialize_order_item(order_item), status: :created
  rescue ActiveRecord::RecordNotFound => e
    render json: { error: e.message }, status: :not_found
  rescue ActiveRecord::RecordInvalid => e
    render json: { error: e.record.errors.full_messages }, status: :unprocessable_entity
  end

  def update; end

  def destroy
    deleted_id = nil
    order_id = nil
    total_price = nil

    ActiveRecord::Base.transaction do
      order_item = OrderItem.joins(:order)
                            .where(orders: { tenant_id: current_tenant.id, status: Order.statuses[:pending] })
                            .find(params[:id])
      order = order_item.order
      deleted_id = order_item.id
      order_id = order.id

      order_item.destroy!
      total_price = order.order_items.sum('quantity * price')
      order.update!(total_price: total_price)
    end

    render json: { id: deleted_id, order_id: order_id, total_price: total_price }, status: :ok
  rescue ActiveRecord::RecordNotFound => e
    render json: { error: e.message }, status: :not_found
  rescue ActiveRecord::RecordInvalid => e
    render json: { error: e.record.errors.full_messages }, status: :unprocessable_entity
  end

  private

  def current_tenant
    Current.tenant
  end

  def serialize_order_item(order_item)
    {
      id: order_item.id,
      order_id: order_item.order_id,
      item_id: order_item.item_id,
      quantity: order_item.quantity,
      price: order_item.price,
      name: order_item.item&.name
    }
  end

  def create_params
    params.permit(:dining_table_id, order_item: %i[item_id price])
  end
end
