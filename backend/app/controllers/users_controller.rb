class UsersController < ApplicationController
  def create
    @user = User.new(user_params)
    if @user.save
      WelcomeMailerJob.perform_async(@user.id)
      redirect_to @user, notice: 'User was successfully created.'
    else
      render :new
    end
  end

  private

  def user_params
    params.require(:user).permit(:first_name, :last_name, :email, :is_active)
  end
end
