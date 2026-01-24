# frozen_string_literal: true

class User < ApplicationRecord
  # Devise modules
  devise :database_authenticatable, :registerable,
         :recoverable, :rememberable, :validatable

  # Multi-tenancy
  belongs_to :organization
  belongs_to :branch, optional: true

  # Role management placeholder
  has_many :user_roles, dependent: :destroy
  has_many :roles, through: :user_roles

  # Super admin helper for CanCanCan
  def super_admin?
    roles.exists?(name: 'super_admin')
  end
end
