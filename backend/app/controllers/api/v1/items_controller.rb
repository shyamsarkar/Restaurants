# frozen_string_literal: true

class Api::V1::ItemsController < ApplicationController
  def index
    render json: current_tenant.items.order(:id)
  end

  def show
    render json: item
  end

  def create
    payload = item_params.to_h.symbolize_keys
    payload[:unit] ||= 'piece'

    tenant_item = current_tenant.items.new(payload)

    if tenant_item.save
      render json: tenant_item, status: :created
    else
      render json: { errors: tenant_item.errors.full_messages }, status: :unprocessable_entity
    end
  end

  def update
    payload = item_params.to_h.symbolize_keys
    payload[:unit] ||= item.unit

    if item.update(payload)
      render json: item
    else
      render json: { errors: item.errors.full_messages }, status: :unprocessable_entity
    end
  end

  def destroy
    item.destroy!
    head :no_content
  end

  private

  def item
    @item ||= current_tenant.items.find(params[:id])
  end

  def current_tenant
    Current.tenant
  end

  def item_params
    permitted = if params[:item].present?
                  params.require(:item).permit(:name, :price, :is_available, :menu_id, :unit, :description)
                else
                  params.permit(:name, :price, :is_available, :menu_id, :unit, :description)
                end

    return permitted unless permitted[:menu_id].present?
    return permitted if current_tenant.menus.exists?(id: permitted[:menu_id])

    raise ActiveRecord::RecordNotFound, 'Menu not found'
  end
end
