import { useEffect, useState } from 'react';
import { RestaurantMenu as MenuIcon, Add as AddIcon, Delete, Edit } from '@mui/icons-material';
import IconButton from '@mui/material/IconButton';
import Grid from '@mui/material/Grid';
import Card from '@mui/material/Card';
import { createDiningTable, DiningTable, getDiningTables } from '@/services/api.service';

import { z } from 'zod';

const tableSchema = z.object({
  name: z.string().min(1, 'Table name is required'),
  description: z.string().optional(),
});

export const Tables = () => {

  const [tableName, setTableName] = useState('');
  const [description, setDescription] = useState('');
  const [tables, setTables] = useState<DiningTable[]>([]);

  const handleSubmit = async (e: React.FormEvent) => {
    e.preventDefault();

    const result = tableSchema.safeParse({
      name: tableName,
      description,
    });

    if (!result.success) {
      const errorMessage = result.error.errors.map(err => err.message).join(', ');
      alert(errorMessage);
      return;
    }

    try {
      const newTable = await createDiningTable(result.data);
      setTables(prev => [newTable, ...prev]);
      setTableName('');
      setDescription('');
    } catch (error) {
      console.error('Error creating table:', error);
      alert('Failed to create table');
    }

  };


  useEffect(() => {
    const fetchTabales = async () => {
      const tableData = await getDiningTables();
      setTables(tableData);
    }
    fetchTabales();
  }, []);

  return (
    <div className="space-y-8">
      <div>
        <h1 className="text-3xl font-bold text-gray-900 mb-2">Tables</h1>
      </div>
      <Grid container spacing={2}>
        <Grid size={4}>
          <div className="bg-white rounded-xl shadow-sm border border-gray-100 p-8">
            <div className="flex items-center gap-3 mb-6">
              <div className="w-10 h-10 bg-orange-100 rounded-lg flex items-center justify-center">
                <MenuIcon className="text-orange-600" fontSize="small" />
              </div>
              <div>
                <h2 className="text-xl font-semibold text-gray-900">
                  Add Tables
                </h2>
                <p className="text-sm text-gray-500">
                  Create a new table
                </p>
              </div>
            </div>

            <form onSubmit={handleSubmit} className="space-y-4">
              <div>
                <label htmlFor="menuName" className="block text-sm font-medium text-gray-700 mb-2">
                  Table Name *
                </label>
                <input
                  type="text"
                  id="tableName"
                  value={tableName}
                  onChange={(e) => setTableName(e.target.value)}
                  placeholder="Floor 1, Table 1, etc."
                  className="w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-all duration-200 outline-none placeholder-gray-400"
                  required
                />
              </div>

              <div>
                <label htmlFor="description" className="block text-sm font-medium text-gray-700 mb-2">
                  Description (Optional)
                </label>
                <input
                  type="text"
                  id="description"
                  value={description}
                  onChange={(e) => setDescription(e.target.value)}
                  placeholder="Brief description of this table..."
                  className="w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-all duration-200 outline-none placeholder-gray-400"
                />
              </div>

              <div className="flex gap-3">
                <button
                  type="submit"
                  className="flex-1 bg-orange-600 hover:bg-orange-700 disabled:bg-gray-300 disabled:cursor-not-allowed text-white font-medium py-3 px-6 rounded-lg transition-all duration-200 transform hover:scale-[1.02] active:scale-[0.98] flex items-center justify-center gap-2"
                >
                  <AddIcon fontSize="small" />
                  Create Table
                </button>
              </div>
            </form>
          </div>
        </Grid>
        <Grid size={8}>
          <Card className='p-4'>
            <div className="space-y-3">
              {tables.map((table) => (
                <div key={table.id} className="flex items-center justify-between p-2 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors duration-200 group">
                  <div className="flex items-center gap-3">
                    <div className="w-2 h-2 bg-blue-500 rounded-full"></div>
                    <div>
                      <span className="font-medium text-gray-900">{table.name}</span>
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
}
