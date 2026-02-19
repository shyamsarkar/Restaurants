# frozen_string_literal: true

class Order < ApplicationRecord
  belongs_to :tenant
  belongs_to :user
  belongs_to :dining_table, optional: true
  has_many :order_items, dependent: :destroy

  enum :status, { pending: 0, preparing: 1, completed: 2, cancelled: 3 }

  validates :tenant_id, :user_id, :status, presence: true
  validates :total_price, numericality: { greater_than_or_equal_to: 0 }
  validates :discount, :tax, numericality: { greater_than_or_equal_to: 0 }, allow_nil: true
end
