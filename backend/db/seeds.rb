# frozen_string_literal: true

# Clear Existing Data
if Rails.env.development?
  puts "Cleaning database..."
  OrderItem.destroy_all
  Order.destroy_all
  Item.destroy_all
  Menu.destroy_all
  Membership.destroy_all
  Tenant.destroy_all
  User.destroy_all
  
  puts "Database cleaned!"
end

puts "Creating users..."

# Create admin user
admin = User.create!(
  email: 'admin@example.com',
  password: 'password123',
  password_confirmation: 'password123',
  first_name: 'Admin',
  last_name: 'User',
  is_active: true
)

# Create regular users
users = []
5.times do |i|
  users << User.create!(
    email: "user#{i + 1}@example.com",
    password: 'password123',
    password_confirmation: 'password123',
    first_name: "User#{i + 1}",
    last_name: "Test",
    is_active: true
  )
end

puts "Created #{User.count} users"

puts "Creating tenants..."

# Create tenants
tenant1 = Tenant.create!(
  name: 'Spice Garden Restaurant',
  status: :active
)

tenant2 = Tenant.create!(
  name: 'Urban Eats Cafe',
  status: :active
)

tenant3 = Tenant.create!(
  name: 'Coastal Bistro',
  status: :pending
)

puts "Created #{Tenant.count} tenants"

puts "Creating memberships..."

# Create memberships for tenant1
Membership.create!(user: admin, tenant: tenant1, role: :admin)
Membership.create!(user: users[0], tenant: tenant1, role: :manager)
Membership.create!(user: users[1], tenant: tenant1, role: :waiter)
Membership.create!(user: users[2], tenant: tenant1, role: :cashier)

# Create memberships for tenant2
Membership.create!(user: admin, tenant: tenant2, role: :admin)
Membership.create!(user: users[3], tenant: tenant2, role: :manager)
Membership.create!(user: users[4], tenant: tenant2, role: :waiter)

# User can have different roles in different tenants
Membership.create!(user: users[0], tenant: tenant2, role: :waiter)

puts "Created #{Membership.count} memberships"

puts "Creating menus..."

# Menus for tenant1
breakfast_menu = Menu.create!(
  name: 'Breakfast Menu',
  tenant: tenant1,
  status: :active
)

lunch_menu = Menu.create!(
  name: 'Lunch Menu',
  tenant: tenant1,
  status: :active
)

dinner_menu = Menu.create!(
  name: 'Dinner Menu',
  tenant: tenant1,
  status: :active
)

# Menus for tenant2
cafe_menu = Menu.create!(
  name: 'All Day Menu',
  tenant: tenant2,
  status: :active
)

beverages_menu = Menu.create!(
  name: 'Beverages',
  tenant: tenant2,
  status: :active
)

puts "Created #{Menu.count} menus"

puts "Creating items..."

# Breakfast items for tenant1
Item.create!(
  name: 'Masala Dosa',
  price: 120.00,
  unit: 'piece',
  description: 'Crispy rice crepe with spiced potato filling',
  menu: breakfast_menu,
  is_available: true
)

Item.create!(
  name: 'Idli Sambar',
  price: 80.00,
  unit: 'plate',
  description: 'Steamed rice cakes with lentil soup',
  menu: breakfast_menu,
  is_available: true
)

Item.create!(
  name: 'Poha',
  price: 60.00,
  unit: 'plate',
  description: 'Flattened rice with vegetables',
  menu: breakfast_menu,
  is_available: true
)

# Lunch items for tenant1
Item.create!(
  name: 'Chicken Biryani',
  price: 250.00,
  unit: 'plate',
  description: 'Aromatic basmati rice with tender chicken',
  menu: lunch_menu,
  is_available: true
)

Item.create!(
  name: 'Paneer Butter Masala',
  price: 200.00,
  unit: 'bowl',
  description: 'Cottage cheese in rich tomato gravy',
  menu: lunch_menu,
  is_available: true
)

Item.create!(
  name: 'Dal Tadka',
  price: 120.00,
  unit: 'bowl',
  description: 'Yellow lentils tempered with spices',
  menu: lunch_menu,
  is_available: true
)

Item.create!(
  name: 'Naan',
  price: 40.00,
  unit: 'piece',
  description: 'Traditional Indian flatbread',
  menu: lunch_menu,
  is_available: true
)

# Dinner items for tenant1
Item.create!(
  name: 'Tandoori Chicken',
  price: 350.00,
  unit: 'plate',
  description: 'Grilled chicken marinated in yogurt and spices',
  menu: dinner_menu,
  is_available: true
)

Item.create!(
  name: 'Fish Curry',
  price: 280.00,
  unit: 'bowl',
  description: 'Fresh fish in coconut curry sauce',
  menu: dinner_menu,
  is_available: true
)

# Cafe items for tenant2
Item.create!(
  name: 'Caesar Salad',
  price: 180.00,
  unit: 'bowl',
  description: 'Romaine lettuce with Caesar dressing',
  menu: cafe_menu,
  is_available: true
)

Item.create!(
  name: 'Margherita Pizza',
  price: 320.00,
  unit: 'piece',
  description: 'Classic pizza with tomato, mozzarella, and basil',
  menu: cafe_menu,
  is_available: true
)

Item.create!(
  name: 'Pasta Alfredo',
  price: 250.00,
  unit: 'plate',
  description: 'Creamy white sauce pasta',
  menu: cafe_menu,
  is_available: true
)

# Beverages for tenant2
Item.create!(
  name: 'Cappuccino',
  price: 120.00,
  unit: 'piece',
  description: 'Espresso with steamed milk foam',
  menu: beverages_menu,
  is_available: true
)

Item.create!(
  name: 'Fresh Orange Juice',
  price: 80.00,
  unit: 'ml',
  description: 'Freshly squeezed orange juice',
  menu: beverages_menu,
  is_available: true
)

Item.create!(
  name: 'Masala Chai',
  price: 40.00,
  unit: 'piece',
  description: 'Indian spiced tea',
  menu: beverages_menu,
  is_available: true
)

puts "Created #{Item.count} items"

puts "Creating orders..."

# Create orders for tenant1
order1 = Order.create!(
  tenant: tenant1,
  user: users[1], # waiter
  status: :completed,
  total_price: 0,
  discount: 20.00,
  tax: 35.00
)

OrderItem.create!(order: order1, item: Item.find_by(name: 'Chicken Biryani'), quantity: 2, price: 250.00)
OrderItem.create!(order: order1, item: Item.find_by(name: 'Naan'), quantity: 4, price: 40.00)
OrderItem.create!(order: order1, item: Item.find_by(name: 'Dal Tadka'), quantity: 1, price: 120.00)

# order1.update!(total_price: order1.calculate_total)

order2 = Order.create!(
  tenant: tenant1,
  user: users[1],
  status: :preparing,
  total_price: 0,
  tax: 18.00
)

OrderItem.create!(order: order2, item: Item.find_by(name: 'Masala Dosa'), quantity: 3, price: 120.00)
OrderItem.create!(order: order2, item: Item.find_by(name: 'Idli Sambar'), quantity: 2, price: 80.00)

# order2.update!(total_price: order2.calculate_total)

# Create orders for tenant2
order3 = Order.create!(
  tenant: tenant2,
  user: users[4], # waiter
  status: :completed,
  total_price: 0,
  discount: 50.00,
  tax: 40.00
)

OrderItem.create!(order: order3, item: Item.find_by(name: 'Margherita Pizza'), quantity: 1, price: 320.00)
OrderItem.create!(order: order3, item: Item.find_by(name: 'Cappuccino'), quantity: 2, price: 120.00)

# order3.update!(total_price: order3.calculate_total)

order4 = Order.create!(
  tenant: tenant2,
  user: users[4],
  status: :pending,
  total_price: 0,
  tax: 15.00
)

OrderItem.create!(order: order4, item: Item.find_by(name: 'Caesar Salad'), quantity: 1, price: 180.00)
OrderItem.create!(order: order4, item: Item.find_by(name: 'Fresh Orange Juice'), quantity: 1, price: 80.00)

# order4.update!(total_price: order4.calculate_total)

puts "Created #{Order.count} orders with #{OrderItem.count} order items"

puts "\n" + "="*50
puts "SEED DATA SUMMARY"
puts "="*50
puts "Users: #{User.count}"
puts "Tenants: #{Tenant.count}"
puts "Memberships: #{Membership.count}"
puts "Menus: #{Menu.count}"
puts "Items: #{Item.count}"
puts "Orders: #{Order.count}"
puts "Order Items: #{OrderItem.count}"
puts "="*50

puts "\nLogin credentials:"
puts "Admin: admin@example.com / password123"
puts "Users: user1@example.com to user5@example.com / password123"
puts "\nSeeding completed successfully! 🎉"