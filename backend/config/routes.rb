require 'sidekiq/web'

Rails.application.routes.draw do
  mount Sidekiq::Web => '/sidekiq'
  resources :users, only: %i[index new create]
  post '/sign_in',  to: 'sessions#create', as: 'sign_in'
  delete '/sign_out', to: 'sessions#destroy', as: 'sign_out'
end
