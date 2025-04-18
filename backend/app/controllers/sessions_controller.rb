# frozen_string_literal: true

class SessionsController < Clearance::SessionsController

  def create
    email = params[:session][:email].downcase
    user = User.find_by(email: email)
    if user.present?
      @user = authenticate(params)
      sign_in @user
      if signed_in?
        render json: { message: I18n.t('session.success_login'), user: @user }, status: :ok
      else
        user.failed_login_attempt = user.failed_login_attempt + 1
        user.increment(:failed_login_attempt).save
        render json: { message: I18n.t('session.invalid_credentials') }, status: :bad_request
      end
    else
      render json: { message: I18n.t('session.invalid_email') }, status: :bad_request
    end
  end

  def destroy
    sign_out
    render json: { message: 'Signed out successfully.' }, status: :ok
  end
end
