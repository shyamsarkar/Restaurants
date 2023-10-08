class User < ApplicationRecord
  include Clearance::User
  has_many :user_roles, dependent: :destroy
  has_many :roles, through: :user_roles
end
