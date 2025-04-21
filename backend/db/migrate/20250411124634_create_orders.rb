class CreateOrders < ActiveRecord::Migration[8.0]
  def change
    create_table :orders, id: :uuid do |t|
      t.string :order_number, null: false
      t.decimal :total_amount, precision: 10, scale: 2, null: false
      t.decimal :total_discount, precision: 10, scale: 2, null: false
      t.decimal :total_tax, precision: 10, scale: 2, null: false
      t.decimal :payable_amount, precision: 10, scale: 2, null: false
      t.integer :status, null: false, default: 0
      t.references :dining_table, null: false, foreign_key: true
      t.references :user, null: false, foreign_key: true
      t.timestamps
    end
  end
end
