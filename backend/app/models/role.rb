class Role < ApplicationRecord
  has_many :user_roles, dependent: :destroy
  has_many :users, through: :user_roles

  SUPER_ADMIN = 'super_admin'.freeze
  COMPANY_ADMIN = 'company_admin'.freeze
  BRANCH_ADMIN = 'branch_admin'.freeze
  EMPLOYEE = 'employee'.freeze
  ALL_ROLES = [SUPER_ADMIN, COMPANY_ADMIN, BRANCH_ADMIN, EMPLOYEE].freeze
end
