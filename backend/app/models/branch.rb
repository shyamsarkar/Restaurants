# frozen_string_literal: true

class Branch < ApplicationRecord
  belongs_to :organization
  has_many :users, dependent: :nullify
  has_many :menus, dependent: :destroy # future
  has_many :orders, dependent: :destroy # future
end
