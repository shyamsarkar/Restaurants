# frozen_string_literal: true

class Tenant < ApplicationRecord
  has_many :items, dependent: :destroy
  has_many :memberships, dependent: :destroy
  has_many :menus, dependent: :destroy
  has_many :orders, dependent: :destroy
  has_many :dining_tables, dependent: :destroy
  has_many :users, through: :memberships

  enum :status, { active: 0, inactive: 1, pending: 2 }

  validates :name, presence: true
end
