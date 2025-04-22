# frozen_string_literal: true

module Api
  # handle only units apis
  class UnitsController < ApplicationController
    skip_load_and_authorize_resource only: :create
    def create
      unit = Unit.new(unit_params)
      unit.user = current_user
      unit.save!
      head :created
    end

    def update
      @unit.update(unit_params)
      head :no_content
    end

    def destroy
      @unit.update(is_deleted: true)
      head :no_content
    end

    private

    def unit_params
      params.require(:unit).permit(:name)
    end
  end
end
