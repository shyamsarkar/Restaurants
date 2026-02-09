# frozen_string_literal: true

class User < ApplicationRecord
  # Devise modules
  devise :database_authenticatable, :registerable,
         :recoverable, :rememberable, :validatable

  # Multi-tenancy associations
  has_many :memberships, dependent: :destroy
  has_many :tenants, through: :memberships
  has_many :orders, dependent: :nullify

  validates :email, presence: true, uniqueness: true

  # Track last login
  def update_last_login!
    update!(last_login_time: Time.current)
  end

  def role?(role_name, tenant:)
    memberships.exists?(tenant: tenant, role: role_name)
  end
end
