class CreateTenants < ActiveRecord::Migration[8.0]
  def change
    create_table :tenants do |t|
      t.string :name, null: false
      t.integer :status, null: false, default: 0 # optional if you want active/inactive
      t.timestamps
    end
  end
end
