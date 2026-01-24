require 'sidekiq/web'

Rails.application.routes.draw do
  mount Sidekiq::Web => '/sidekiq'

  devise_for :users, defaults: { format: :json }

  namespace :api do
    namespace :v1 do
      resources :organizations, only: [:index, :show, :create, :update]
      resources :branches, only: [:index, :show, :create, :update]
      resources :users, only: [:index, :show, :create, :update]
    end
  end
end
