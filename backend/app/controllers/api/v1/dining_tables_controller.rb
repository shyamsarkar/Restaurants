class Api::V1::DiningTablesController < ApplicationController
  load_and_authorize_resource

  def index
    with_orders = params[:with_orders] == 'true'
    @dining_tables = @orders.includes(:orders) if with_orders
    render json: @dining_tables
  end

  def create
    if @dining_table.save
      render json: @dining_table, status: :created
    else
      render json: { errors: @dining_table.errors.full_messages }, status: :unprocessable_content
    end
  end

  private

  def dining_table_params
    params.require(:dining_table).permit(:name, :status)
  end
end
