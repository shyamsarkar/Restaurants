# frozen_string_literal: true

class Ability
  include CanCan::Ability

  def initialize(user, tenant)
    return unless user && tenant

    membership = user.memberships.find_by(tenant: tenant)
    return unless membership

    can :manage, Menu, tenant_id: tenant.id
    can :manage, Item, tenant_id: tenant.id
    can :manage, DiningTable, tenant_id: tenant.id

    if membership.admin?
      can :manage, User, memberships: { tenant_id: tenant.id }
    else
      can :read, User, memberships: { tenant_id: tenant.id }
    end
  end
end
