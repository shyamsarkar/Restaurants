module Api
  class DiningTablesController < ApplicationController
    skip_load_and_authorize_resource only: :create
    def create
      dining_table = DiningTable.new(dining_table_params)
      if dining_table.save
        head :created
      else
        render json: { errors: dining_table.errors.full_messages }, status: :unprocessable_entity
      end
    end

    def update
      if @dining_table.update(dining_table_params)
        head :no_content
      else
        render json: { errors: @dining_table.errors.full_messages }, status: :unprocessable_entity
      end
    end

    def destroy
      @dining_table.update(is_deleted: true)
      head :no_content
    end

    private

    def dining_table_params
      params.require(:dining_table).permit(:name)
    end
  end
end
