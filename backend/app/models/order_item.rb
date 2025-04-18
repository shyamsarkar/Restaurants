class OrderItem < ApplicationRecord
  belongs_to :dining_table
  belongs_to :user
  belongs_to :order, optional: true
  belongs_to :unit
  belongs_to :item
end
