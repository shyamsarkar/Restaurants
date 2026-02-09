module Api
  module V1
    class UsersController < ApplicationController
      load_and_authorize_resource

      def index
        render json: @users
      end

      def show
        render json: @user
      end

      def create
        if @user.save
          render json: @user, status: :created
        else
          render json: { errors: @user.errors.full_messages }, status: :unprocessable_content
        end
      end

      def update
        if @user.update(user_params)
          render json: @user
        else
          render json: { errors: @user.errors.full_messages }, status: :unprocessable_content
        end
      end

      private

      def user_params
        params.require(:user).permit(:email, :first_name, :last_name, :is_active, :role)
      end
    end
  end
end
