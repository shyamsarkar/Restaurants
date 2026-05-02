set :application, "myapp"
set :repo_url, "git@github.com:shyamsarkar/myapp.git"

set :deploy_to, "/home/ubuntu/apps/myapp"

set :rbenv_type, :user
set :rbenv_ruby, "4.0.3"

append :linked_files, "config/master.key"
append :linked_dirs, "log", "tmp/pids", "tmp/cache", "tmp/sockets"
set :branch, "main"
