set :stage, :staging

set :deploy_to, "/var/www/whatson.dev.opencity.io"

set :branch, :"develop"

server '178.62.80.64', user: 'deploy', roles: %w{web app db}

fetch(:default_env).merge!(wp_env: :staging)

