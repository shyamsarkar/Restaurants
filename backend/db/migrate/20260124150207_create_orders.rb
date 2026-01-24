class CreateOrders < ActiveRecord::Migration[8.0]
  def change
    create_table :orders do |t|
      t.references :tenant, null: false, foreign_key: true
      t.references :user, null: false, foreign_key: true
      t.integer :status, null: false, default: 0
      t.decimal :total_price, precision: 10, scale: 2, null: false
      t.decimal :discount, precision: 10, scale: 2
      t.decimal :tax, precision: 10, scale: 2

      t.timestamps
    end

    add_index :orders, [:tenant_id, :created_at]
    add_index :orders, :status
  end
end