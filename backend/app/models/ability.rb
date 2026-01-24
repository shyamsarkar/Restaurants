# frozen_string_literal: true
class Ability
  include CanCan::Ability

  def initialize(user)
    return if user.blank?

    # Super admin can manage everything
    can :manage, :all if user.super_admin?

    # Users can only manage resources in their organization
    can :manage, User, organization_id: user.organization_id
    can :manage, Branch, organization_id: user.organization_id

    # Future models (menus, items, orders, tables) will also be scoped
    can :manage, Menu, branch: { organization_id: user.organization_id } if defined?(Menu)
    can :manage, Item, branch: { organization_id: user.organization_id } if defined?(Item)
    can :manage, DiningTable, branch: { organization_id: user.organization_id } if defined?(DiningTable)
  end
end
