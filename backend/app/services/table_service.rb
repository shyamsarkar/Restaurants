class TableService
  def self.open_table!(table:, user:)
    DiningTable.transaction do
      table.lock!

      existing_order = table.orders.find_by(status: :open)
      return existing_order if existing_order

      order = table.orders.create!(
        tenant: table.tenant,
        user: user,
        status: :open
      )

      table.update!(status: :occupied)

      order
    end
  end
end
