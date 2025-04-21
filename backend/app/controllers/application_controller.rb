# frozen_string_literal: true

# handle all loading and authorization
class ApplicationController < ActionController::Base
  include Clearance::Controller
  skip_before_action :verify_authenticity_token
  load_and_authorize_resource
end
