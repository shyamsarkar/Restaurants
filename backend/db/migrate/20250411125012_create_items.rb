class CreateItems < ActiveRecord::Migration[8.0]
  def change
    create_table :items, id: :uuid do |t|
      t.string :name, null: false
      t.decimal :price, precision: 10, scale: 2, null: false
      t.boolean :is_deleted, null: false, default: false
      t.references :menu, type: :uuid, null: false, foreign_key: true
      t.timestamps
    end
  end
end
