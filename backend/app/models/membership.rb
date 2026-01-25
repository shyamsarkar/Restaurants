# frozen_string_literal: true

class Membership < ApplicationRecord
  belongs_to :user
  belongs_to :tenant

  enum :role, { admin: 0, manager: 1, cashier: 2, waiter: 3 }

  validates :user_id, presence: true
  validates :role, presence: true
  validates :tenant_id, presence: true
  validates :user_id, uniqueness: { scope: :tenant_id }
end
