set :application, 'whatson.dev.opencity.io'
set :repo_url, 'git@github.com:opencityio/whatson.git'


# set :deploy_to, "/var/www/#{fetch(:application)}"

set :ssh_options, {
  keys: %w(~/.ssh/id_rsa.pub),
  forward_agent: true,
#  auth_methods: %w(password)
}


# Branch options
# Prompts for the branch name (defaults to current branch)
#ask :branch, proc { `git rev-parse --abbrev-ref HEAD`.chomp }

# Sets branch to current one
#set :branch, proc { `git rev-parse --abbrev-ref HEAD`.chomp }

# Hardcodes branch to always be master
# This could be overridden in a stage config file
set :branch, :develop

set :log_level, :debug

set :linked_files, %w{config/twit.json}
#config/db.php}
set :linked_dirs, %w{selfies feedback}

namespace :deploy do
  desc 'Restart application'
  task :restart do
    on roles(:app), in: :sequence, wait: 5 do
      # Your restart mechanism here, for example:
      execute :"sudo service php5-fpm restart"
      execute :service, :nginx, :reload
    end
  end
end

# The above restart task is not run by default
# Uncomment the following line to run it on deploys if needed
# after 'deploy:publishing', 'deploy:restart'

