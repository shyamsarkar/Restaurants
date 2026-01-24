# app/models/role.rb
class Role < ApplicationRecord
  belongs_to :organization
  has_many :user_roles, dependent: :destroy
  has_many :users, through: :user_roles
end
