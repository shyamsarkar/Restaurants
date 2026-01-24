# frozen_string_literal: true

class Organization < ApplicationRecord
  has_many :users, dependent: :destroy
  has_many :branches, dependent: :destroy
  has_many :roles, dependent: :destroy

  enum :status, { active: 0, inactive: 1, pending: 2 }
end
