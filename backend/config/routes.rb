require 'sidekiq/web'

Rails.application.routes.draw do
  mount Sidekiq::Web => '/sidekiq'

  devise_for :users, defaults: { format: :json }

  namespace :api do
    namespace :v1 do
      resources :users, only: [:index, :show, :create, :update]
    end
  end
end
