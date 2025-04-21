class CreateUsers < ActiveRecord::Migration[8.0]
  def change
    create_table :users do |t|
      t.string :first_name
      t.string :last_name
      t.string :email, null: false
      t.string :encrypted_password, limit: 128, null: false
      t.string :confirmation_token, limit: 128
      t.string :remember_token, limit: 128, null: false
      t.boolean :is_active, null: false, default: true
      t.datetime :last_login_time
      t.integer :failed_login_attempts, default: 0
      t.references :branch, null: false, foreign_key: true
      t.datetime :last_failed_login_at
      t.timestamps
    end

    add_index :users, :email
    add_index :users, :confirmation_token, unique: true
    add_index :users, :remember_token, unique: true
  end
end
