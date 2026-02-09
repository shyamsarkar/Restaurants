# frozen_string_literal: true

class Tenant < ApplicationRecord
  has_many :memberships, dependent: :destroy
  has_many :menus, dependent: :destroy
  has_many :users, through: :memberships
  has_many :orders, dependent: :destroy

  enum :status, { active: 0, inactive: 1, pending: 2 }

  validates :name, presence: true
end
