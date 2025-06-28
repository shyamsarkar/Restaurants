import { useEffect, useRef, useState } from 'react';
import {
  Box,
  Button,
  Card,
  CardContent,
  TextField,
  Avatar,
  Divider,
  Typography,
  Grid,
  InputAdornment,
  IconButton,
  Paper,
  Chip
} from '@mui/material';
import { Add, Construction, Delete, Description, Edit, Save, Search } from '@mui/icons-material';
import { DiningTable, getDiningTables, getMenuItems, MenuItem } from '@/services/api.service';

export const Order = () => {
  const [selectedTable, setSelectedTable] = useState('Table 1');
  const [diningTables, setDiningTables] = useState<DiningTable[]>([])
  const [menuItems, setMenuItems] = useState<MenuItem[]>([]);
  const [searchQuery, setSearchQuery] = useState('');
  const searchInputRef = useRef<HTMLInputElement>(null);

  const fetchDiningTables = async () => {
    const tables = await getDiningTables();
    setDiningTables(tables);
  };

  const fetchMenuItems = async () => {
    const items = await getMenuItems();
    setMenuItems(items);
  };

  const handleFocus = () => {
    if (searchInputRef.current) {
      searchInputRef.current.focus();
    }
  };

  const addMenuItemToOrder = (itemId: number) => {
    console.log(`table ${selectedTable} - ItemId: ${itemId} `);
    handleFocus();
  };

  useEffect(() => {
    fetchDiningTables();
    fetchMenuItems();
    searchInputRef.current?.focus()
  }, []);


  // const menuItems = Array.from({ length: 10 }, (_, i) => ({
  //   id: i + 1,
  //   name: `${['Chicken', 'Prawn', 'Fish', 'Mutton', 'Vegetable'][i % 5]} ${['Masala', 'Curry', 'Fry', 'Biryani', 'Tikka'][Math.floor(i / 2) % 5]}`,
  //   price: `${400 + (i * 50)}/Pcs`,
  //   variant: i % 2 === 0 ? 'Full/Half' : 'Regular'
  // }));

  const orderItems = Array.from({ length: 20 }, (_, i) => ({
    id: i + 1,
    name: `${['Prawn', 'Chicken', 'Fish', 'Mutton'][i % 4]} ${['Masala', 'Curry', 'Fry', 'Biryani'][i % 4]}`,
    quantity: Math.floor(Math.random() * 5) + 1,
    price: 500,
    total: (Math.floor(Math.random() * 5) + 1) * 500
  }));

  const setItemQuantity = (numb: number|string) => {
    console.log(numb);
  }

  return (
    <Box sx={{ height: 'calc(100vh - 30px)' }}>
      <Grid container sx={{ height: '100%' }}>
        {/* Tables Sidebar */}
        <Grid size={2}>
          <Paper
            sx={{
              height: 'calc(100vh - 30px)',
              bgcolor: '#e8f5e8',
              borderRight: 1,
              borderColor: '#4caf50',
              borderRadius: 0,
              p: 2,
              overflowY: 'auto'
            }}
          >
            <Box sx={{ display: 'flex', flexDirection: 'column', gap: 1 }}>
              {diningTables.map((table) => (
                <Button
                  key={table.id}
                  variant={'contained'}
                  color={'primary'}
                  fullWidth
                  size="small"
                  sx={{
                    py: 1.5,
                    fontWeight: 'medium',
                    transition: 'all 0.2s ease-in-out',
                    '&:hover': {
                      transform: 'scale(1.05)',
                    }
                  }}
                  onClick={() => setSelectedTable(table.id.toString())}
                >
                  {table.name}
                </Button>
              ))}
            </Box>
          </Paper>
        </Grid>

        {/* Menu Items */}
        <Grid size={4}>
          <Box sx={{ height: 'calc(100vh - 10px)', p: 2, display: 'flex', flexDirection: 'column', overflowY: 'auto' }}>
            {/* Search Bar */}
            <Card sx={{ mb: 2, borderTop: 1, borderTopColor: '#64748b' }}>
              <CardContent sx={{ p: 0, pb: '0 !important' }}>
                <TextField
                  fullWidth
                  ref={searchInputRef}
                  placeholder="Search Item"
                  value={searchQuery}
                  onChange={(e) => setSearchQuery(e.target.value)}
                  variant="outlined"
                  size="small"
                  slotProps={{
                    input: {
                      startAdornment: (
                        <InputAdornment position="start">
                          <Search fontSize="medium" />
                        </InputAdornment>
                      ),
                      sx: {
                        '& .MuiOutlinedInput-notchedOutline': { border: 'none' },
                        fontSize: '1rem'
                      }
                    }
                  }}
                />
              </CardContent>
            </Card>

            <Divider sx={{ mb: 2 }} />

            {/* Menu Items List */}
            <Box sx={{ flex: 1, overflowY: 'auto' }}>
              <Box sx={{ display: 'flex', flexDirection: 'column', gap: 1 }}>
                {menuItems
                  .filter(item =>
                    item.name.toLowerCase().includes(searchQuery.toLowerCase())
                  )
                  .map((item) => (
                    <Card
                      key={item.id}
                      sx={{
                        transition: 'box-shadow 0.2s ease-in-out',
                        '&:hover': { boxShadow: 3 }
                      }}
                    >
                      <CardContent sx={{ p: 1, pb: '8px !important' }}>
                        <Box sx={{ display: 'flex', alignItems: 'center' }}>
                          <Avatar sx={{ bgcolor: '#7c3aed', width: 36, height: 36 }}>
                            <Construction fontSize='medium' />
                          </Avatar>
                          <Box sx={{ flex: 1, ml: 2 }}>
                            <Typography variant="body1" fontWeight="medium" color="text.primary">
                              {item.name}
                            </Typography>
                            <Typography variant="body2" color="text.secondary">
                              {item.price}
                            </Typography>
                          </Box>
                          <IconButton
                            onClick={() => addMenuItemToOrder(item.id)}
                            size="small"
                            sx={{
                              bgcolor: '#2563eb',
                              color: 'white',
                              width: 32,
                              height: 32,
                              '&:hover': {
                                bgcolor: '#1d4ed8',
                              }
                            }}
                          >
                            <Add />
                          </IconButton>
                        </Box>
                      </CardContent>
                    </Card>
                  ))}
              </Box>
            </Box>
          </Box>
        </Grid>

        {/* Order Details */}
        <Grid size={6}>
          <Box sx={{
            height: 'calc(100vh - 30px)',
            bgcolor: '#e8f5e8',
            p: 2,
            display: 'flex',
            flexDirection: 'column'
          }}>
            <Box sx={{ mb: 2 }}>
              <Typography variant="h5" fontWeight="semibold" color="text.primary">
                Table: {selectedTable}
              </Typography>
            </Box>

            {/* Order Items List */}
            <Card sx={{ flex: 1, mb: 2, overflow: 'hidden' }}>
              <Box sx={{ height: '100%', overflowY: 'auto' }}>
                {orderItems.map((item, index) => (
                  <Box key={item.id}>
                    <Box sx={{
                      display: 'flex',
                      alignItems: 'center',
                      p: 1.5,
                      '&:hover': { bgcolor: '#f9fafb' }
                    }}>
                      <TextField
                        type="text"
                        value={item.quantity}
                        size="small"
                        onChange={(e) => {
                          const val = e.target.value;
                          // Allow only digits and ensure >= 1
                          if (/^\d*$/.test(val)) {
                            const num = parseInt(val, 10);
                            if (val === '' || num >= 1) {
                              // Update your state or call a function here
                              setItemQuantity(num || ''); // handle '' as empty or reset
                            }
                          }
                        }}
                        sx={{
                          width: 64,
                          '& .MuiOutlinedInput-root': {
                            bgcolor: '#f3f4f6',
                            '& input': { py: 0.5 }
                          }
                        }}
                        slotProps={{
                          input: { style: { textAlign: 'center' }}
                        }}
                      />
                      <Box sx={{ flex: 1, ml: 1.5 }}>
                        <Typography variant="body2" fontWeight="medium" color="text.primary">
                          {item.name}
                        </Typography>
                        <Typography variant="caption" color="text.secondary">
                          X {item.price}/Pcs
                        </Typography>
                      </Box>
                      <Chip
                        label={`₹${item.total.toLocaleString()}`}
                        sx={{
                          bgcolor: '#e5e7eb',
                          color: '#374151',
                          fontWeight: 'medium',
                          minWidth: 80
                        }}
                      />
                      <Box sx={{ display: 'flex', ml: 1, gap: 0.5 }}>
                        <IconButton
                          size="small"
                          sx={{
                            width: 32,
                            height: 32,
                            '&:hover': { bgcolor: '#dbeafe', color: '#2563eb' }
                          }}
                        >
                          <Edit />
                        </IconButton>
                        <IconButton
                          size="small"
                          sx={{
                            width: 32,
                            height: 32,
                            '&:hover': { bgcolor: '#fee2e2', color: '#dc2626' }
                          }}
                        >
                          <Delete />
                        </IconButton>
                      </Box>
                    </Box>
                    {index < orderItems.length - 1 && <Divider />}
                  </Box>
                ))}
              </Box>
            </Card>

            {/* Totals */}
            <Card sx={{ mb: 2, bgcolor: 'white' }}>
              <CardContent sx={{ p: 2 }}>
                <Grid container spacing={2} textAlign="center">
                  <Grid size={4}>
                    <Typography variant="body2" color="text.secondary">
                      Food
                    </Typography>
                    <Typography variant="h6" fontWeight="semibold">
                      ₹15,480
                    </Typography>
                  </Grid>
                  <Grid size={4}>
                    <Typography variant="body2" color="text.secondary">
                      Beverages
                    </Typography>
                    <Typography variant="h6" fontWeight="semibold">
                      ₹2,250
                    </Typography>
                  </Grid>
                  <Grid size={4}>
                    <Typography variant="body2" color="text.secondary">
                      Grand Total
                    </Typography>
                    <Typography variant="h5" fontWeight="bold" color="#16a34a">
                      ₹17,730
                    </Typography>
                  </Grid>
                </Grid>
              </CardContent>
            </Card>

            {/* Action Buttons */}
            <Card sx={{ bgcolor: 'white' }}>
              <CardContent sx={{ p: 2 }}>
                <Grid container spacing={1.5}>
                  <Grid>
                    <Button
                      fullWidth
                      variant="contained"
                      startIcon={<Save />}
                      sx={{
                        bgcolor: '#2563eb',
                        '&:hover': { bgcolor: '#1d4ed8' }
                      }}
                    >
                      Save Bill
                    </Button>
                  </Grid>
                  <Grid>
                    <Button
                      fullWidth
                      variant="outlined"
                      startIcon={<Description />}
                      color="secondary"
                    >
                      Get KOT
                    </Button>
                  </Grid>
                  <Grid>
                    <Button
                      fullWidth
                      variant="contained"
                      startIcon={<Delete />}
                      color="error"
                    >
                      Delete
                    </Button>
                  </Grid>
                </Grid>
              </CardContent>
            </Card>
          </Box>
        </Grid>
      </Grid>
    </Box>
  );
};