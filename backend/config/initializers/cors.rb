Rails.application.config.middleware.insert_before 0, Rack::Cors do
  allow do
    origins ENV.fetch('CORS_ORIGINS', 'localhost:8080').split(',').map(&:strip).reject(&:blank?)

    resource '*',
             headers: :any,
             methods: %i[get post patch put delete options],
             credentials: true
  end
end
