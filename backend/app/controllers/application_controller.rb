# frozen_string_literal: true

# handle all loading and authorization
class ApplicationController < ActionController::Base
  include Clearance::Controller
  skip_before_action :verify_authenticity_token
  before_action :login_required
  load_and_authorize_resource

  private

  def login_required
    return if current_user

    render json: { error: 'Authentication required' }, status: :unauthorized
  end
end
