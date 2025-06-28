json.array! @items do |item|
    json.id item.id
    json.name item.name
    json.price item.price
    json.menu_id item.menu_id
end