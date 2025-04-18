class Api::OrdersController < ApplicationController
  skip_load_and_authorize_resource only: :create
  def create
    order = Order.new(order_params)
    order.save
    head :created
  end

  def update
    @order.update(order_params)
    head :ok
  end

  def destroy
    @order.update(is_deleted: true)
    head :ok
  end

  private

  def order_params
    params.require(:order).permit(:total_amount, :total_discount, :total_tax, :payable_amount, :dining_table_id, :user_id)
  end
end
