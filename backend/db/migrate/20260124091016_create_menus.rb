class CreateMenus < ActiveRecord::Migration[8.0]
  def change
    create_table :menus do |t|
      t.string :name, null: false
      t.integer :status, null: false, default: 0
      t.references :tenant, null: false, foreign_key: true

      t.timestamps
    end

    add_index :menus, [:tenant_id, :name], unique: true
  end
end