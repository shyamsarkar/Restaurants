class Organization < ApplicationRecord
  has_many :users, dependent: :destroy

  # enum status: { active: 0, inactive: 1, pending: 2 }
end
