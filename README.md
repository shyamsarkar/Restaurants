Points To Address
1. Billing: Seat Select, Product Select, Create Order, Payment Button, Ordered Button, Show start-delivered Time
2. 


# Getting Started with Restaurenats

## Description
This project is aimed at creating a full-stack web application with separate folders for the backend using Rails (Ruby 3.3.0) and the frontend using ReactJS (Node.js 21.7.3).

## Installation
To get started with this project, follow these steps:

### Backend (Rails)
1. Navigate to the `backend` folder.
2. Install dependencies by running `bundle install`. (ensure you have Ruby version 3.3.0 installed)
3. Set up the database by running `rails db:create` followed by `rails db:migrate`.
4. Start the Rails server with `rails s`.
5. We suggest `rails db:full_reset` for default data migration.

### Frontend (ReactJS)
1. Navigate to the `frontend` folder.
2. Install dependencies by running `npm install` (ensure you have Node.js version 21.7.3 installed) or `yarn install`.
3. Start the development server with `npm start` or `yarn start`.

### Docker
To run the application using Docker, follow these steps:

1. Make sure you have Docker and Docker Compose installed on your system.
2. From the root directory, build the Docker images:

```bash
docker-compose build
```

3. Start the containers:

```bash
docker-compose up
```
This will start the backend (Rails) and frontend (React) containers.

4. The backend will be accessible at http://localhost:5000, and the frontend will be accessible at http://localhost:8000.
5. To stop the containers, press Ctrl+C and run:

```bash
docker-compose down
```

6. If you make changes to the code, you will need to rebuild the images and restart the containers:

```bash
docker-compose up --build
```

## Usage
- Once both the backend and frontend servers are running, you can access the application at `http://localhost:8000`.
- Use the frontend to interact with the application's user interface.
- The frontend communicates with the backend through API endpoints.
- Backend will be running at `http://localhost:5000`.


organizations
  └─ id
  └─ name
  └─ created_at
  └─ updated_at

users
  └─ id
  └─ email
  └─ encrypted_password
  └─ reset_password_token
  └─ reset_password_sent_at
  └─ remember_created_at
  └─ organization_id   <-- multi-tenancy link
  └─ created_at
  └─ updated_at


organizations
  └─ id
  └─ name
  └─ created_at
  └─ updated_at
  └─ has_many :users
  └─ has_many :branches
  └─ has_many :roles

users
  └─ id
  └─ email
  └─ encrypted_password
  └─ organization_id
  └─ created_at
  └─ updated_at
  └─ has_many :user_roles
  └─ has_many :roles, through: :user_roles
  └─ CanCanCan abilities per organization

roles
  └─ id
  └─ name                # admin / manager / waiter / cashier
  └─ organization_id
  └─ created_at
  └─ updated_at

user_roles
  └─ id
  └─ user_id
  └─ role_id
  └─ created_at
  └─ updated_at

branches
  └─ id
  └─ name
  └─ organization_id
  └─ created_at
  └─ updated_at
  └─ has_many :menus
  └─ has_many :orders

menus
  └─ id
  └─ name
  └─ branch_id
  └─ created_at
  └─ updated_at
  └─ has_many :items

items
  └─ id
  └─ name
  └─ price
  └─ menu_id
  └─ unit_id
  └─ created_at
  └─ updated_at

units
  └─ id
  └─ name              # e.g., pcs, kg, liter
  └─ created_at
  └─ updated_at

orders
  └─ id
  └─ branch_id
  └─ user_id            # who created the order
  └─ status             # pending / completed
  └─ total_price
  └─ created_at
  └─ updated_at
  └─ has_many :order_items

order_items
  └─ id
  └─ order_id
  └─ item_id
  └─ quantity
  └─ price              # at the time of order
  └─ created_at
  └─ updated_at
