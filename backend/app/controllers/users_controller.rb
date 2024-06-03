class UsersController < ApplicationController
  before_action :verify_auth_token
  load_resource

  def index
    render json: @users, status: :ok
  end

  def create
    @user = User.new(user_params)
    if @user.save
      WelcomeMailerJob.perform_async(@user.id)
      redirect_to @user, notice: I18n.t('users.create_success')
    else
      render :new
    end
  end

  private

  def user_params
    params.require(:user).permit(:first_name, :last_name, :email, :is_active)
  end
end
