class Api::V1::OrdersController < ApplicationController
  load_and_authorize_resource

  def create
    if @order.save
      render json: { orderId: @order.id }, status: :created
    else
      render json: { errors: @order.errors.full_messages }, status: :unprocessable_content
    end
  end

  def items
    if @order
      render json: @order.order_items.as_json(only: %i[id order_id item_id quantity price])
    else
      render json: { error: 'Order not found for the given dining table' }, status: :not_found
    end
  end

  def add_item
    item_id = params[:item_id]
    quantity = params[:quantity] || 1
    item = Item.find_by(id: item_id, tenant_id: @order.tenant_id)
    if item
      order_item = @order.order_items.find_or_create_by(item_id: item.id)
      order_item.update(quantity: order_item.quantity + quantity)
      render json: { success: true, order_item: order_item.as_json(only: %i[id order_id item_id quantity price]) }
    else
      render json: { error: 'Item not found or not accessible to this tenant' }, status: :not_found
    end
  end

  private

  def order_params
    params.require(:order).permit(:dining_table_id)
  end
end
