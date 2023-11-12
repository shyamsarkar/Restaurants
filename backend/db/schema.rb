ActiveRecord::Schema[7.0].define(version: 20_231_008_105_301) do
  # These are extensions that must be enabled in order to support this database
  enable_extension 'plpgsql'

  create_table 'roles', id: :uuid, default: -> { 'gen_random_uuid()' }, force: :cascade do |t|
    t.string 'name', null: false
    t.datetime 'created_at', null: false
    t.datetime 'updated_at', null: false
  end

  create_table 'user_roles', id: :uuid, default: -> { 'gen_random_uuid()' }, force: :cascade do |t|
    t.uuid 'user_id', null: false
    t.uuid 'role_id', null: false
    t.datetime 'created_at', null: false
    t.datetime 'updated_at', null: false
    t.index ['role_id'], name: 'index_user_roles_on_role_id'
    t.index ['user_id'], name: 'index_user_roles_on_user_id'
  end

  create_table 'users', id: :uuid, default: -> { 'gen_random_uuid()' }, force: :cascade do |t|
    t.string 'first_name'
    t.string 'last_name'
    t.string 'email', null: false
    t.string 'encrypted_password', limit: 128, null: false
    t.string 'confirmation_token', limit: 128
    t.string 'remember_token', limit: 128, null: false
    t.boolean 'is_active', default: true, null: false
    t.datetime 'last_login_time'
    t.integer 'failed_login_attempt', default: 0
    t.datetime 'created_at', null: false
    t.datetime 'updated_at', null: false
    t.index ['confirmation_token'], name: 'index_users_on_confirmation_token', unique: true
    t.index ['email'], name: 'index_users_on_email'
    t.index ['remember_token'], name: 'index_users_on_remember_token', unique: true
  end

  add_foreign_key 'user_roles', 'roles'
  add_foreign_key 'user_roles', 'users'
end
