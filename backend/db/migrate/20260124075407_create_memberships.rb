class CreateMemberships < ActiveRecord::Migration[8.0]
  def change
    create_table :memberships do |t|
      t.references :user, null: false, foreign_key: true
      t.references :tenant, null: false, foreign_key: true
      t.integer :role, null: false, default: 3

      t.timestamps
    end

    add_index :memberships, %i[user_id tenant_id], unique: true
  end
end
