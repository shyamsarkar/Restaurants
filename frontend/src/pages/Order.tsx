import PageContainer from '@/pages/PageContainer';
import { useState } from 'react';
import { Button } from '@/components/ui/button';
import { Card } from '@/components/ui/card';
import { Input } from '@/components/ui/input';
import { Avatar, AvatarFallback } from '@/components/ui/avatar';
import { Separator } from '@/components/ui/separator';
import { 
  Search, 
  Plus, 
  UtensilsCrossed, 
  Edit2, 
  Trash2,
  Save,
  FileText,
} from 'lucide-react';

export const Order = () => {
  const [selectedTable, setSelectedTable] = useState('Table 1');
  const [searchQuery, setSearchQuery] = useState('');

  const tableStatuses = [
    { id: 'occupied', label: 'Table Occupied', status: 'occupied', variant: 'outline' as const },
    { id: 'table1', label: 'Table 1', status: 'active', variant: 'default' as const },
    { id: 'table2', label: 'Table 2', status: 'warning', variant: 'destructive' as const },
    { id: 'table3', label: 'Table 3', status: 'error', variant: 'destructive' as const },
    ...Array.from({ length: 10 }, (_, i) => ({
      id: `table${i + 4}`,
      label: `Table ${i + 4}`,
      status: 'available',
      variant: 'secondary' as const
    }))
  ];

  const menuItems = Array.from({ length: 10 }, (_, i) => ({
    id: i + 1,
    name: `${['Chicken', 'Prawn', 'Fish', 'Mutton', 'Vegetable'][i % 5]} ${['Masala', 'Curry', 'Fry', 'Biryani', 'Tikka'][Math.floor(i / 2) % 5]}`,
    price: `${400 + (i * 50)}/Pcs`,
    variant: i % 2 === 0 ? 'Full/Half' : 'Regular'
  }));

  const orderItems = Array.from({ length: 20 }, (_, i) => ({
    id: i + 1,
    name: `${['Prawn', 'Chicken', 'Fish', 'Mutton'][i % 4]} ${['Masala', 'Curry', 'Fry', 'Biryani'][i % 4]}`,
    quantity: Math.floor(Math.random() * 5) + 1,
    price: 500,
    total: (Math.floor(Math.random() * 5) + 1) * 500
  }));

  return (
    <PageContainer title="Orders" description="Add all the items and calculate the total">
      <div className="h-screen bg-gray-50">
        <div className="grid grid-cols-12 h-full">
          {/* Tables Sidebar */}
          <div className="col-span-2 bg-green-50 border-r border-green-200 p-4">
            <div className="space-y-2 h-full overflow-y-auto">
              {tableStatuses.map((table) => (
                <Button
                  key={table.id}
                  variant={selectedTable === table.label ? 'default' : table.variant}
                  className="w-full justify-center text-sm font-medium transition-all hover:scale-105"
                  onClick={() => setSelectedTable(table.label)}
                >
                  {table.label}
                </Button>
              ))}
            </div>
          </div>

          {/* Menu Items */}
          <div className="col-span-4 p-4 flex flex-col">
            {/* Search Bar */}
            <Card className="mb-4 shadow-sm border-t-2 border-t-slate-600">
              <div className="flex items-center p-3">
                <Search className="h-5 w-5 text-gray-400 mr-3" />
                <Input
                  placeholder="Search Item"
                  value={searchQuery}
                  onChange={(e) => setSearchQuery(e.target.value)}
                  className="border-0 focus-visible:ring-0 text-base"
                />
              </div>
            </Card>

            <Separator className="mb-4" />

            {/* Menu Items List */}
            <div className="flex-1 overflow-y-auto">
              <div className="space-y-2">
                {menuItems
                  .filter(item => 
                    item.name.toLowerCase().includes(searchQuery.toLowerCase())
                  )
                  .map((item) => (
                  <Card key={item.id} className="hover:shadow-md transition-shadow">
                    <div className="flex items-center p-4">
                      <Avatar className="h-12 w-12 bg-purple-600">
                        <AvatarFallback className="bg-purple-600 text-white">
                          <UtensilsCrossed className="h-6 w-6" />
                        </AvatarFallback>
                      </Avatar>
                      <div className="flex-1 ml-4">
                        <h3 className="font-medium text-gray-900">
                          {item.name} {item.variant}
                        </h3>
                        <p className="text-sm text-gray-600">{item.price}</p>
                      </div>
                      <Button
                        size="sm"
                        className="rounded-full h-8 w-8 p-0 bg-blue-600 hover:bg-blue-700"
                      >
                        <Plus className="h-4 w-4" />
                      </Button>
                    </div>
                  </Card>
                ))}
              </div>
            </div>
          </div>

          {/* Order Details */}
          <div className="col-span-6 bg-green-50 p-4 flex flex-col">
            <div className="mb-4">
              <h2 className="text-xl font-semibold text-gray-900">
                Table: {selectedTable}
              </h2>
            </div>

            {/* Order Items List */}
            <Card className="flex-1 mb-4 overflow-hidden">
              <div className="h-full overflow-y-auto p-0">
                <div className="space-y-0">
                  {orderItems.map((item) => (
                    <div key={item.id} className="flex items-center p-3 border-b border-gray-100 hover:bg-gray-50">
                      <Input
                        type="number"
                        defaultValue={item.quantity}
                        className="w-16 h-8 text-center text-sm bg-gray-100 border-gray-300"
                        min="1"
                      />
                      <div className="flex-1 ml-3">
                        <p className="font-medium text-gray-900">{item.name}</p>
                        <p className="text-sm text-gray-600">X {item.price}/Pcs</p>
                      </div>
                      <div className="bg-gray-200 text-gray-700 px-3 py-1 rounded text-sm font-medium min-w-[80px] text-center">
                        ₹{item.total.toLocaleString()}
                      </div>
                      <div className="flex ml-2 space-x-1">
                        <Button variant="ghost" size="sm" className="h-8 w-8 p-0 hover:bg-blue-100">
                          <Edit2 className="h-4 w-4 text-blue-600" />
                        </Button>
                        <Button variant="ghost" size="sm" className="h-8 w-8 p-0 hover:bg-red-100">
                          <Trash2 className="h-4 w-4 text-red-600" />
                        </Button>
                      </div>
                    </div>
                  ))}
                </div>
              </div>
            </Card>

            <Separator className="mb-4" />

            {/* Totals */}
            <Card className="mb-4 bg-white">
              <div className="p-4">
                <div className="grid grid-cols-3 gap-4 text-center">
                  <div>
                    <p className="text-sm text-gray-600">Food</p>
                    <p className="font-semibold text-lg">₹15,480</p>
                  </div>
                  <div>
                    <p className="text-sm text-gray-600">Beverages</p>
                    <p className="font-semibold text-lg">₹2,250</p>
                  </div>
                  <div>
                    <p className="text-sm text-gray-600">Grand Total</p>
                    <p className="font-bold text-xl text-green-600">₹17,730</p>
                  </div>
                </div>
              </div>
            </Card>

            <Separator className="mb-4" />

            {/* Action Buttons */}
            <Card className="bg-white">
              <div className="p-4">
                <div className="flex space-x-3">
                  <Button className="flex-1 bg-blue-600 hover:bg-blue-700">
                    <Save className="h-4 w-4 mr-2" />
                    Save Bill
                  </Button>
                  <Button variant="secondary" className="flex-1">
                    <FileText className="h-4 w-4 mr-2" />
                    Get KOT
                  </Button>
                  <Button variant="destructive" className="flex-1">
                    <Trash2 className="h-4 w-4 mr-2" />
                    Delete
                  </Button>
                </div>
              </div>
            </Card>
          </div>
        </div>
      </div>
    </PageContainer>
  );
};
