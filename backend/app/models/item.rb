# app/models/item.rb
class Item < ApplicationRecord
  belongs_to :menu

  UNITS = ['piece', 'kg', 'gram', 'liter', 'ml', 'plate', 'bowl', 'serving', 'dozen'].freeze

  validates :name, :price, presence: true
end
