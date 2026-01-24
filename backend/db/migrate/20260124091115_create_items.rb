class CreateItems < ActiveRecord::Migration[8.0]
  def change
    create_table :items do |t|
      t.string :name, null: false
      t.decimal :price, precision: 10, scale: 2, null: false
      t.string :unit, null: false
      t.string :description
      t.boolean :is_available, null: false, default: true
      t.references :menu, null: false, foreign_key: true

      t.timestamps
    end

    add_index :items, [:menu_id, :name]
  end
end
