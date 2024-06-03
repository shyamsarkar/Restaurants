# frozen_string_literal: true

# Controller to handle Login(signin)(sign_in), logout(signout)(sign_out)
class SessionsController < Clearance::SessionsController
  def create
    email = params[:session][:email]
    user = User.find_by(email:)
    if user.present?
      @user = authenticate(params)
      sign_in @user
      render json: { message: I18n.t('session.success_login'), user: @user }, status: :ok
    else
      render json: { message: I18n.t('session.invalid_credentials') }, status: :bad_request
    end
  end

  def destroy
    sign_out
    render json: { message: 'Signed out successfully.' }, status: :ok
  end
end
