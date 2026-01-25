Rails.application.config.middleware.insert_before 0, Rack::Cors do
  allow do
    origins ENV['CORS_ORIGINS'].split(',')

    resource '*',
             headers: :any,
             methods: %i[get post patch put delete options],
             credentials: true
  end
end
