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
    update_column(:last_login_time, Time.current)
  end

  # Check if user has a specific role in a specific tenant
  def has_role?(role_name, tenant:)
    memberships.joins(:role).exists?(
      roles: { name: role_name.to_s },
      tenant_id: tenant.id
    )
  end
end
