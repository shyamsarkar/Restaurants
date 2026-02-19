class CreateDiningTables < ActiveRecord::Migration[7.0]
  def change
    create_table :dining_tables do |t|
      t.references :tenant, null: false, foreign_key: true
      t.string :name, null: false
      t.integer :status, null: false, default: 0

      t.timestamps
    end

    add_index :dining_tables, %i[tenant_id name], unique: true
  end
end
