class CreateBranches < ActiveRecord::Migration[8.0]
  def change
    create_table :branches do |t|
      t.string :name, null: false
      t.integer :status, null: false, default: 0
      t.references :organization, null: false, foreign_key: true
      t.timestamps
    end
  end
end
