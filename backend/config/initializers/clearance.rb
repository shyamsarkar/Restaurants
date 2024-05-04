Clearance.configure do |config|
  config.mailer_sender = 'reply@example.com'
  config.rotate_csrf_on_sign_in = true
  # Add more parameters here
  config.redirect_url = '/dashboard' # Example: Redirect users after sign in
  config.cookie_domain = '.example.com' # Example: Configure cookie domain
  config.cookie_expiration = -> { 1.year.from_now.utc } # Example: Set cookie expiration
end
