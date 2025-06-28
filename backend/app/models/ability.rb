# frozen_string_literal: true

class Ability
  include CanCan::Ability

  def initialize(user)
    return if user.blank?

    can :manage, :all if user.super_admin?
    can :manage, User if user.present?
    can :manage, DiningTable
    can :manage, Menu
    can :manage, Item
  end
end
