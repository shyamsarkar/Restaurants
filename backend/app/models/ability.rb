# frozen_string_literal: true

class Ability
  include CanCan::Ability

  def initialize(user)
    return unless user

    # 🔑 Super Admin
    if user.has_role?(:super_admin)
      can :manage, :all
      return
    end

    # 🏢 Tenant scoped permissions
    can :manage, User, tenant_id: user.tenant_id
    can :manage, Branch, tenant_id: user.tenant_id

    # 🍽 Future models — add ONLY when they exist
    can :manage, Menu, branch: { tenant_id: user.tenant_id } if defined?(Menu)
    can :manage, Item, branch: { tenant_id: user.tenant_id } if defined?(Item)

    # Self access
    can :read, User, id: user.id
  end
end
