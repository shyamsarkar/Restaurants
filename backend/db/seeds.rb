# This file should contain all the record creation needed to seed the database with its default values.
# The data can then be loaded with the bin/rails db:seed command (or created alongside the database with db:setup).
#
# Examples:
#
#   movies = Movie.create([{ name: "Star Wars" }, { name: "Lord of the Rings" }])
#   Character.create(name: "Luke", movie: movies.first)
default_users = [
  { email: 'superadmin@restaurants.com', name: 'Super Admin' },
  { email: 'companyadmin1@restaurants.com', name: 'Company Admin1' },
  { email: 'companyadmin2@restaurants.com', name: 'Company Admin2' },
  { email: 'branchadmin1@restaurants.com', name: 'Branch Admin1' },
  { email: 'branchadmin2@restaurants.com', name: 'Branch Admin2' },
  { email: 'enduser1@restaurants.com', name: 'End User1' },
  { email: 'enduser2@restaurants.com', name: 'End User2' }
]

default_users.each do |user|
  User.create!(email: user[:email], password: 'Password123')
end
