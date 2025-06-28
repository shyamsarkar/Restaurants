# frozen_string_literal: true

json.total_sales @total_sales
json.order_count @order_count

json.top_items @top_items do |item_name, quantity|
  json.item_name item_name
  json.quantity quantity
end

json.table_summary @table_summary do |table_number, total|
  json.table_number table_number
  json.total_amount total
end