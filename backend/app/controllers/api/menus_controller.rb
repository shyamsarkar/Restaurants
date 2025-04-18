class Api::MenusController < ApplicationController
  skip_load_and_authorize_resource only: :create
  def create
    menu = Menu.new(menu_params)
    menu.save
    head :created
  end

  def update
    @menu.update(menu_params)
    head :no_content
  end

  def destroy
    @menu.update(is_deleted: true)
    head :no_content
  end

  private

  def menu_params
    params.require(:menu).permit(:name)
  end
end
