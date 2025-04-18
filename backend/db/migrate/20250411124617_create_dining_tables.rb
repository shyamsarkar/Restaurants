class CreateDiningTables < ActiveRecord::Migration[8.0]
  def change
    create_table :dining_tables do |t|
      t.string :name, null: false
      t.boolean :is_deleted, null: false, default: false
      t.references :user, null: false, foreign_key: true
      t.timestamps
    end
  end
end
