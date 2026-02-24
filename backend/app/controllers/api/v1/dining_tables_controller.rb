class Api::V1::DiningTablesController < ApplicationController
  def index
    render json: current_tenant.dining_tables.order(:id)
  end

  def show
    render json: dining_table
  end

  def create
    table = current_tenant.dining_tables.new(dining_table_params)

    if table.save
      render json: table, status: :created
    else
      render json: { errors: table.errors.full_messages }, status: :unprocessable_entity
    end
  end

  def update
    if dining_table.update(dining_table_params)
      render json: dining_table
    else
      render json: { errors: dining_table.errors.full_messages }, status: :unprocessable_entity
    end
  end

  def destroy
    dining_table.destroy!
    head :no_content
  rescue ActiveRecord::InvalidForeignKey, ActiveRecord::DeleteRestrictionError => e
    render json: { errors: [e.message] }, status: :unprocessable_entity
  end

  private

  def dining_table
    @dining_table ||= current_tenant.dining_tables.find(params[:id])
  end

  def current_tenant
    Current.tenant
  end

  def dining_table_params
    if params[:dining_table].present?
      params.require(:dining_table).permit(:name, :status)
    else
      params.permit(:name, :status)
    end
  end
end
