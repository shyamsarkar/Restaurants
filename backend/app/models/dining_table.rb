class DiningTable < ApplicationRecord
  belongs_to :tenant
  has_many :orders, dependent: :restrict_with_exception

  enum :status, {
    available: 0,
    occupied: 1,
    reserved: 2,
    cleaning: 3
  }
  validates :name, presence: true, uniqueness: { scope: :tenant_id }
end
