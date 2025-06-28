class Api::DashboardController < ApplicationController
  skip_load_and_authorize_resource

  def index
    @total_sales = 1000
    @order_count = 50
    @top_items = { "Pizza" => 20, "Burger" => 15, "Pasta" => 10 }
    @table_summary = { "Table 1" => 300, "Table 2" => 200, "Table 3" => 500 }
  end
end
