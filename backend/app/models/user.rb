class User < ApplicationRecord
  include Clearance::User
  has_many :user_roles, dependent: :destroy
  has_many :roles, through: :user_roles

  def full_name
    Honeybadger.notify("#{first_name} #{last_name} #{Faker::Name.name}")
    "#{first_name} #{last_name}"
  end
end
