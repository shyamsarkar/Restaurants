class DiningTable < ApplicationRecord
  belongs_to :user
  has_many :orders, dependent: :nullify
  default_scope { where(is_deleted: false) }

  validates :name, presence: true
  validate :unique_name_among_active

  private

  def unique_name_among_active
    existing = DiningTable.where(name: name, is_deleted: false).where.not(id: id)

    return unless existing.exists?

    errors.add(:name, 'has already been taken')
  end
end
