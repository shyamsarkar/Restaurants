class Item < ApplicationRecord
  belongs_to :menu, dependent: :destroy
  has_many :order_items, dependent: :destroy
end
