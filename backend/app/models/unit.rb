class Unit < ApplicationRecord
  belongs_to :user
  default_scope { where(is_deleted: false) }
end
