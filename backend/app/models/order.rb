class Order < ApplicationRecord
  belongs_to :dining_table
  belongs_to :user
  has_many :order_items, dependent: :destroy

  enum :status, { pending: 0, preparing: 1, ready: 2, cancelled: 3, delivered: 4 }
end
