namespace :db do
  desc 'Full Reset to generate new demo data'
  task full_reset: :environment do
    truncate_database
    create_users
    create_roles
    create_dining_tables
    create_menus
    create_items
    Rake::Task['db:seed'].invoke
  end

  def truncate_database
    # Rake::Task['db:drop'].invoke
    # Rake::Task['db:create'].invoke
    Rake::Task['db:migrate'].invoke
  end

  def create_users
    p '---------creating users---------'
    10.times do
      User.create!(email: Faker::Internet.email, password: Faker::Alphanumeric.alpha(number: 10))
    end
  end

  def create_roles
    p '---------creating roles---------'
    Role::ALL_ROLES.each do |role|
      Role.create!(name: role)
    end
  end

  def create_dining_tables
    p '---------creating dining tables---------'
  end

  def create_menus
    p '---------creating menus---------'
  end

  def create_items
    p '---------creating items---------'
  end
end
