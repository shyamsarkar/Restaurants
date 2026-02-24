require 'sidekiq/web'

Rails.application.routes.draw do
  mount Sidekiq::Web => '/sidekiq'

  devise_for :users,
             controllers: {
               sessions: 'api/v1/users/sessions'
             },
             defaults: { format: :json }

  namespace :api do
    namespace :v1 do
      resources :tenants, only: %i[index show create update destroy]
      resources :users, only: %i[index show create update destroy]
      resources :menus
      resources :items
      resources :dining_tables
      resources :order_items, only: %i[index create destroy]
      resources :orders, only: %i[create] do
        resources :order_items, only: %i[update destroy]
        member do
          get :items
          post :add_item
        end
      end
    end
  end
end
