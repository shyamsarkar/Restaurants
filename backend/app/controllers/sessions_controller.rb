# frozen_string_literal: true

# handle login and logout
class SessionsController < Clearance::SessionsController
  skip_load_and_authorize_resource

  def create
    @user = authenticate(params)
    return render_error('session.invalid_email') unless @user
    return render_error('session.failed_limit_reached') if @user.failed_limit_reached?

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

  private

  def render_error(key, status: :bad_request)
    render json: { message: I18n.t(key) }, status: status
  end
end
