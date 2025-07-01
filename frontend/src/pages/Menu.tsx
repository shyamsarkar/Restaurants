import React from 'react';
import { Restaurant as MenuIcon, Delete as DeleteIcon } from '@mui/icons-material';

export const Menu: React.FC = () => {
  const menus = [
    { id: '1', name: 'Appetizers', description: 'Starters and small plates' },
    { id: '2', name: 'Main Courses', description: 'Main dishes and entrees' },
    { id: '3', name: 'Desserts', description: 'Sweet treats and desserts' },
    { id: '4', name: 'Beverages', description: 'Drinks and refreshments' }
  ];
  const getItemsForMenu = (menuId: string) => {
    return [
      { id: '1', name: 'Spring Rolls', menuId, addedAt: new Date('2023-10-01T12:00:00Z') },
      { id: '2', name: 'Caesar Salad', menuId, addedAt: new Date('2023-10-02T14:30:00Z') },
      { id: '3', name: 'Grilled Salmon', menuId, addedAt: new Date('2023-10-03T16:45:00Z') },
      { id: '4', name: 'Chocolate Cake', menuId, addedAt: new Date('2023-10-04T18:15:00Z') }
    ]
  };

  const formatTime = (date: Date) => {
    return date.toLocaleTimeString('en-US', { 
      hour: '2-digit', 
      minute: '2-digit',
      hour12: true 
    });
  };

  const onDeleteItem = (itemId: string) => {
    console.log(`Delete item with ID: ${itemId}`);
    // Implement deletion logic here
  };

  return (
    <div className="space-y-6">
      <div className="flex items-center gap-3 mb-8">
        <div className="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
          <MenuIcon className="text-green-600" fontSize="small" />
        </div>
        <div>
          <h2 className="text-xl font-semibold text-gray-900">Menus & Items</h2>
          <p className="text-sm text-gray-500">Overview of all items in your menus</p>
        </div>
      </div>

      {menus.length === 0 ? (
        <div className="text-center py-12 bg-gray-50 rounded-xl border-2 border-dashed border-gray-200">
          <MenuIcon className="mx-auto text-gray-400 mb-4" fontSize="large" />
          <p className="text-gray-500 text-lg font-medium">No menus available</p>
          <p className="text-gray-400 text-sm">Create some menus to start adding items</p>
        </div>
      ) : (
        <div className="grid gap-6">
          {menus.map((menu) => {
            const menuItems = getItemsForMenu(menu.id);
            return (
              <div key={menu.id} className="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div className="bg-gradient-to-r from-slate-50 to-slate-100 px-6 py-4 border-b border-gray-100">
                  <div className="flex items-center justify-between">
                    <div>
                      <h3 className="text-lg font-semibold text-gray-900">{menu.name}</h3>
                      {menu.description && (
                        <p className="text-sm text-gray-600 mt-1">{menu.description}</p>
                      )}
                    </div>
                    <div className="text-right">
                      <span className="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                        {menuItems.length} {menuItems.length === 1 ? 'item' : 'items'}
                      </span>
                    </div>
                  </div>
                </div>

                <div className="p-6">
                  {menuItems.length === 0 ? (
                    <div className="text-center py-8">
                      <p className="text-gray-500">No items in this menu yet</p>
                      <p className="text-gray-400 text-sm mt-1">Add your first item above</p>
                    </div>
                  ) : (
                    <div className="space-y-3">
                      {menuItems.map((item) => (
                        <div key={item.id} className="flex items-center justify-between p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors duration-200 group">
                          <div className="flex items-center gap-3">
                            <div className="w-2 h-2 bg-blue-500 rounded-full"></div>
                            <div>
                              <span className="font-medium text-gray-900">{item.name}</span>
                              <p className="text-xs text-gray-500 mt-1">
                                Added at {formatTime(item.addedAt)}
                              </p>
                            </div>
                          </div>
                          <button
                            onClick={() => onDeleteItem(item.id)}
                            className="opacity-0 group-hover:opacity-100 p-2 text-gray-400 hover:text-red-500 hover:bg-red-50 rounded-lg transition-all duration-200"
                            title="Delete item"
                          >
                            <DeleteIcon fontSize="small" />
                          </button>
                        </div>
                      ))}
                    </div>
                  )}
                </div>
              </div>
            );
          })}
        </div>
      )}
    </div>
  );
};