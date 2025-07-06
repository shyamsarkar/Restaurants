class Api::ItemsController < ApplicationController
  skip_load_and_authorize_resource only: :create

  def index; end

  def create
    item = Item.new(item_params)
    item.unit_id = Unit.first.id
    item.save!
    head :created
  end

  def update
    @item.update(item_params)
    head :no_content
  end

  def destroy
    @item.update(is_deleted: true)
    head :no_content
  end

  private

  def item_params
    params.require(:item).permit(:name, :price, :menu_id, :unit_id)
  end
end
