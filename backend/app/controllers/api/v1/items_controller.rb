# frozen_string_literal: true

class Api::V1::ItemsController < ApplicationController
  load_and_authorize_resource

  def index
    render json: @items
  end

  def create
    if @item.save
      render json: @item, status: :created
    else
      render json: { errors: @item.errors.full_messages }, status: :unprocessable_content
    end
  end

  private

  def item_params
    params.require(:item).permit(:name, :price, :is_available, :menu_id)
  end
end
