import React, { useEffect, useState } from 'react';
import { Add as AddIcon, Delete, Edit } from '@mui/icons-material';

import Grid from '@mui/material/Grid';
import IconButton from '@mui/material/IconButton';

type Menu = {
  id: string;
  name: string;
  description?: string;
};
import { Card } from '@mui/material';


export const Items: React.FC = () => {
  const [itemName, setItemName] = useState('');
  const [selectedMenuId, setSelectedMenuId] = useState('');
  const [menus, setMenus] = useState<Menu[]>([]);
  const menuItems = [
    { id: '1', name: 'Spring Rolls', menuId: '1', addedAt: new Date('2023-10-01T12:00:00Z') },
    { id: '2', name: 'Caesar Salad', menuId: '1', addedAt: new Date('2023-10-02T14:30:00Z') },
    { id: '3', name: 'Grilled Salmon', menuId: '2', addedAt: new Date('2023-10-03T16:45:00Z') },
    { id: '4', name: 'Chocolate Cake', menuId: '3', addedAt: new Date('2023-10-04T18:15:00Z') },
  ];

  const handleSubmit = (e: React.FormEvent) => {
    e.preventDefault();
  };

  useEffect(() => {
    setMenus([
      { id: '1', name: 'Appetizers', description: 'Starters and small plates' },
      { id: '2', name: 'Main Courses', description: 'Main dishes and entrees' },
      { id: '3', name: 'Desserts', description: 'Sweet treats and desserts' },
      { id: '4', name: 'Beverages', description: 'Drinks and refreshments' },
    ]);
  }, []);

  return (
    <div className="bg-white rounded-xl shadow-sm border border-gray-100 p-8">


      <Grid container spacing={2}>
        <Grid size={4}>

          <div className="flex items-center gap-3 mb-6">
            <div className="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
              <AddIcon className="text-blue-600" fontSize="small" />
            </div>
            <div>
              <h2 className="text-xl font-semibold text-gray-900">Add New Item</h2>
              <p className="text-sm text-gray-500">Add an item to one of your menus</p>
            </div>
          </div>

          <form onSubmit={handleSubmit} className="space-y-6">
            <div>
              <label htmlFor="itemName" className="block text-sm font-medium text-gray-700 mb-2">
                Item Name
              </label>
              <input
                type="text"
                id="itemName"
                value={itemName}
                onChange={(e) => setItemName(e.target.value)}
                placeholder="Enter item name..."
                className="w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 outline-none placeholder-gray-400"
                required
              />
            </div>

            <div>
              <label htmlFor="menuSelect" className="block text-sm font-medium text-gray-700 mb-2">
                Select Menu
              </label>
              <select
                id="menuSelect"
                value={selectedMenuId}
                onChange={(e) => setSelectedMenuId(e.target.value)}
                className="w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 outline-none bg-white"
                required
              >
                <option value="">Choose a menu...</option>
                {menus.map((menu) => (
                  <option key={menu.id} value={menu.id}>
                    {menu.name}
                  </option>
                ))}
              </select>
            </div>

            <button
              type="submit"
              disabled={!itemName.trim() || !selectedMenuId}
              className="w-full bg-blue-600 hover:bg-blue-700 disabled:bg-gray-300 disabled:cursor-not-allowed text-white font-medium py-3 px-6 rounded-lg transition-all duration-200 transform hover:scale-[1.02] active:scale-[0.98] flex items-center justify-center gap-2"
            >
              <AddIcon fontSize="small" />
              Add Item
            </button>
          </form>
        </Grid>
        <Grid size={8}>
          <Card className='p-4'>
            <div className="space-y-3">
              {menuItems.map((item) => (
                <div key={item.id} className="flex items-center justify-between p-2 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors duration-200 group">
                  <div className="flex items-center gap-3">
                    <div className="w-2 h-2 bg-blue-500 rounded-full"></div>
                    <div>
                      <span className="font-medium text-gray-900">{item.name}</span>
                      <p className="text-xs text-gray-500 mt-1">
                        Added at 10/10/2023 12:00 PM
                      </p>
                    </div>
                  </div>
                  <div>
                    <IconButton aria-label="comment">
                      <Edit />
                    </IconButton>
                    <IconButton aria-label="comment">
                      <Delete />
                    </IconButton>
                  </div>
                </div>
              ))}
            </div>
          </Card>
        </Grid>
      </Grid>
    </div>
  );
};