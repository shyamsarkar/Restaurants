# frozen_string_literal: true
class Api::V1::MenusController < ApplicationController
  load_and_authorize_resource

  def index
    render json: @menus
  end

  def create
    if @menu.save
      render json: @menu, status: :created
    else
      render json: { errors: @menu.errors.full_messages }, status: :unprocessable_entity
    end
  end

  private

  def menu_params
    params.require(:menu).permit(:name, :status, :branch_id)
  end
end
