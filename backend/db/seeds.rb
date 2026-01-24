# Create a demo organization
org = Organization.create!(name: 'Demo Restaurant')

# Create a demo branch
branch = Branch.create!(name: 'Main Branch', organization: org)

# Create an admin user for this org
User.create!(
  first_name: 'Admin',
  last_name: 'User',
  email: 'admin@demo.com',
  password: 'password',
  password_confirmation: 'password',
  organization: org,
  branch: branch
)
