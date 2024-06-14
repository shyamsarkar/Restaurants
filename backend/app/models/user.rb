class User < ApplicationRecord
  include Clearance::User
  has_many :user_roles, dependent: :destroy
  has_many :roles, through: :user_roles

  LOGIN_LIMIT = 8

  def full_name
    Honeybadger.notify("#{first_name} #{last_name} #{Faker::Name.name}")
    "#{first_name} #{last_name}"
  end

  def super_admin?
    roles.any? { |role| role.name == Role::SUPER_ADMIN }
  end

  def company_admin?
    roles.any? { |role| role.name == Role::COMPANY_ADMIN }
  end

  def branch_admin?
    roles.any? { |role| role.name == Role::BRANCH_ADMIN }
  end

  def end_user?
    roles.any? { |role| role.name == Role::END_USER }
  end

  # def increment_failed_login_attempts!
  #   failed_login_attempts ||= 0
  #   failed_login_attempts += 1
  #   last_failed_login_at = Time.zone.now
  #   save!
  # end

  # def reset_failed_login_attempts!
  #   failed_login_attempts = 0
  #   last_failed_login_at = nil
  #   save!
  # end

  def generate_remember_token
    new_token = SecureRandom.urlsafe_base64
    update(remember_token: Digest::SHA1.hexdigest(new_token))
  end

  # def login_limit_reached?
  #   failed_login_attempt >= LOGIN_LIMIT
  # end
end