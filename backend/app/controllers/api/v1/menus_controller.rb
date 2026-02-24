# frozen_string_literal: true

class Api::V1::MenusController < ApplicationController
  def index
    render json: current_tenant.menus.order(:id)
  end

  def show
    render json: menu
  end

  def create
    tenant_menu = current_tenant.menus.new(menu_params)

    if tenant_menu.save
      render json: tenant_menu, status: :created
    else
      render json: { errors: tenant_menu.errors.full_messages }, status: :unprocessable_entity
    end
  end

  def update
    if menu.update(menu_params)
      render json: menu
    else
      render json: { errors: menu.errors.full_messages }, status: :unprocessable_entity
    end
  end

  def destroy
    menu.destroy!
    head :no_content
  end

  private

  def menu
    @menu ||= current_tenant.menus.find(params[:id])
  end

  def current_tenant
    Current.tenant
  end

  def menu_params
    if params[:menu].present?
      params.require(:menu).permit(:name, :status)
    else
      params.permit(:name, :status)
    end
  end
end
