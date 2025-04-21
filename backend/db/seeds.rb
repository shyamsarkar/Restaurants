default_users = [
  { email: 'superadmin@khaobhai.co.in', name: 'Super Admin' },
  { email: 'companyadmin1@khaobhai.co.in', name: 'Company Admin1' },
  { email: 'companyadmin2@khaobhai.co.in', name: 'Company Admin2' },
  { email: 'branchadmin1@khaobhai.co.in', name: 'Branch Admin1' },
  { email: 'branchadmin2@khaobhai.co.in', name: 'Branch Admin2' },
  { email: 'enduser1@khaobhai.co.in', name: 'End User1' },
  { email: 'enduser2@khaobhai.co.in', name: 'End User2' }
]

default_users.each do |user|
  User.create!(email: user[:email], password: 'Password123', branch: Branch.all.sample)
end
