# frozen_string_literal: true

class Branch < ApplicationRecord
  belongs_to :organization, optional: false
  has_many :users, dependent: :destroy

  enum :status, { active: 0, inactive: 1, pending: 2 }
end
