class CreateOrderItems < ActiveRecord::Migration[8.0]
  def change
    create_table :order_items do |t|
      t.integer :quantity, null: false, default: 1
      t.decimal :price, precision: 10, scale: 2, null: false
      t.decimal :total, precision: 10, scale: 2, null: false
      t.decimal :discount, precision: 10, scale: 2, null: false, default: 0.0
      t.decimal :tax, precision: 10, scale: 2, null: false, default: 0.0
      t.references :order, foreign_key: true
      t.references :unit, null: false, foreign_key: true
      t.references :item, null: false, foreign_key: true
      t.references :dining_table, null: false, foreign_key: true
      t.references :user, null: false, foreign_key: true, type: :uuid
      t.timestamps
    end
  end
end
