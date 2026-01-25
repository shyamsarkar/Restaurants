# backend/app/controllers/api/v1/users/sessions_controller.rb
module Api
  module V1
    module Users
      class SessionsController < Devise::SessionsController
        respond_to :json
        skip_before_action :verify_authenticity_token, raise: false

        private

        def respond_with(resource, _opts = {})
          render json: {
            user: resource.slice(:id, :email, :first_name, :last_name, :is_active, :last_login_time),
            message: 'Signed in successfully'
          }, status: :ok
        end

        def respond_to_on_destroy
          render json: { message: 'Signed out successfully' }, status: :ok
        end
      end
    end
  end
end
