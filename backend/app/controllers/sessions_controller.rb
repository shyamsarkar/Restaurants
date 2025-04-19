# frozen_string_literal: true

class SessionsController < Clearance::SessionsController
  skip_load_and_authorize_resource

  def create
    @user = authenticate(params)
    return render json: { message: I18n.t('session.invalid_email') }, status: :bad_request unless @user

    sign_in(@user)
    if signed_in?
      render json: { message: I18n.t('session.success_login'), user: @user }, status: :ok
    else
      user.increment(:failed_login_attempt)
      render json: { message: I18n.t('session.invalid_credentials') }, status: :bad_request
    end
  end

  def destroy
    sign_out
    render json: { message: I18n.t('session.signed_out') }, status: :ok
  end
end
