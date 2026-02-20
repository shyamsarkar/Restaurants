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

  private

  def order_params
    params.require(:order).permit(:dining_table_id)
  end
end
