# backend/app/controllers/api/v1/users/sessions_controller.rb

module Api
  module V1
    module Users
      class SessionsController < Devise::SessionsController
        respond_to :json
        skip_before_action :verify_authenticity_token, raise: false
        skip_before_action :set_current_context, only: [:create, :destroy]

        private

        def respond_with(resource, _opts = {})
          resource.update_column(:last_login_time, Time.current)

          render json: {
            user: resource.slice(:id, :email, :first_name, :last_name, :is_active, :last_login_time),
            tenant: resource.tenants.first,
            message: 'Signed in successfully'
          }, status: :ok
        end

        def respond_to_on_destroy(*_args, **_opts)
          render json: { message: 'Signed out successfully' }, status: :ok
        end
      end
    end
  end
end
