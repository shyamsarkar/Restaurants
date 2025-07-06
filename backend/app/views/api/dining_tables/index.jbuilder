json.array! @dining_tables do |dining_table|
    json.id dining_table.id
    json.name dining_table.name
    json.created_at dining_table.created_at
end