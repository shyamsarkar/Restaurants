class CreateUsers < ActiveRecord::Migration[8.0]
  def change
    create_table :users do |t|
      ## Devise Required
      t.string :email, null: false, default: ''
      t.string :encrypted_password, null: false, default: ''

      ## Optional Devise modules
      t.string   :reset_password_token
      t.datetime :reset_password_sent_at
      t.datetime :remember_created_at

      ## Custom fields
      t.string :first_name
      t.string :last_name
      t.boolean :is_active, null: false, default: true
      t.datetime :last_login_time

      t.timestamps
    end

    add_index :users, :email,                unique: true
    add_index :users, :reset_password_token, unique: true
  end
end
