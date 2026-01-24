# app/models/menu.rb
class Menu < ApplicationRecord
  # Will Have default menus - will have default_menu_id optional
  belongs_to :tenant
  has_many :items, dependent: :destroy

  enum :status, { active: 0, inactive: 1 }

  validates :name, presence: true
  validates :name, uniqueness: { scope: :tenant_id, case_sensitive: false }
  validates :tenant_id, presence: true
end
