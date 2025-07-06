json.array! @units do |unit|
    json.id unit.id
    json.name unit.name
    json.created_at unit.created_at
end