require 'sidekiq/web'

Rails.application.routes.draw do
  mount Sidekiq::Web => '/sidekiq'
  resources :users, only: %i[index new create]
  post '/sign_in',  to: 'sessions#create', as: 'sign_in'
  delete '/sign_out', to: 'sessions#destroy', as: 'sign_out'
  namespace :api do
    resources :dining_tables, only: %i[index create update destroy]
    resources :orders, only: %i[index show create update destroy]
    resources :units, only: %i[index show create update destroy]
    resources :menus, only: %i[index show create update destroy]
    resources :items, only: %i[index show create update destroy]
    resources :order_items, only: %i[index show create update destroy]
  end
end
