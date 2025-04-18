class Order < ApplicationRecord
  belongs_to :dining_table
  belongs_to :user
  has_many :order_items, dependent: :destroy
end
