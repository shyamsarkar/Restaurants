Points To Address
1. fix the role method
2. issue with ability which role to select according to tenant
3. 

# Getting Started with Restaurents

## Description
This project is aimed at creating a full-stack web application with separate folders for the backend using Rails (Ruby 4.0.1) and the frontend using ReactJS (Node.js 25.3.0).

## Usage
- Once both the backend and frontend servers are running, you can access the application at `http://localhost:5173`.
- Use the frontend to interact with the application's user interface.
- The frontend communicates with the backend through API endpoints.
- Backend will be running at `http://localhost:3000`.


Database Structure

tenants
  └─ id
  └─ name
  └─ status :integer   # enum: active = 0, inactive = 1, pending = 2
  └─ created_at
  └─ updated_at
  └─ has_many :memberships
  └─ has_many :users, through: :memberships

users (global)
  └─ id
  └─ email
  └─ encrypted_password
  └─ first_name (optional)
  └─ last_name (optional)
  └─ is_active :boolean, default: true
  └─ last_login_time
  └─ created_at
  └─ updated_at
  └─ has_many :memberships
  └─ has_many :roles, through: :memberships

memberships (connects user, tenant)
  └─ id
  └─ user_id
  └─ tenant_id
  └─ role           # enum
  └─ created_at
  └─ updated_at

menus
  └─ id
  └─ name
  └─ description (optional)
  └─ created_at
  └─ updated_at
  └─ has_many :items

items
  └─ id
  └─ name
  └─ price
  └─ menu_id
  └─ unit_id
  └─ description (optional)
  └─ created_at
  └─ updated_at

orders
  └─ id
  └─ tenant_id
  └─ user_id               # who created the order
  └─ status :integer       # enum: pending=0, preparing=1, completed=2, cancelled=3
  └─ total_price
  └─ discount (optional)
  └─ tax (optional)
  └─ created_at
  └─ updated_at
  └─ has_many :order_items

order_items
  └─ id
  └─ order_id
  └─ item_id
  └─ quantity
  └─ price                 # at the time of order
  └─ created_at
  └─ updated_at
