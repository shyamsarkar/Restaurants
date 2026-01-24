# frozen_string_literal: true

class ApplicationController < ActionController::Base
  # For API-style backend
  skip_before_action :verify_authenticity_token

  # Devise authentication
  before_action :authenticate_user!

  # CanCanCan
  rescue_from CanCan::AccessDenied do |exception|
    render json: { error: exception.message }, status: :forbidden
  end

  protected

  # Optional: expose current ability explicitly (good practice)
  def current_ability
    @current_ability ||= Ability.new(current_user)
  end
end

