# app/controllers/api/v1/tenants_controller.rb
module Api
  module V1
    class TenantsController < ApplicationController
      load_and_authorize_resource

      def index
        render json: @tenants
      end

      def show
        render json: @tenant
      end

      def create
        if @tenant.save
          render json: @tenant, status: :created
        else
          render json: { errors: @tenant.errors.full_messages }, status: :unprocessable_entity
        end
      end

      def update
        if @tenant.update(tenant_params)
          render json: @tenant
        else
          render json: { errors: @tenant.errors.full_messages }, status: :unprocessable_entity
        end
      end

      private

      def tenant_params
        params.require(:tenant).permit(:name, :status)
      end
    end
  end
end
