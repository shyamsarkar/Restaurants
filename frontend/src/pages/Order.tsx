import { useState } from 'react';
import PageContainer from './PageContainer';
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
import { Add, Construction, Delete, Description, Edit, Recycling, Save, Search } from '@mui/icons-material';

export const Order = () => {
  const [selectedTable, setSelectedTable] = useState('Table 1');
  const [searchQuery, setSearchQuery] = useState('');

  const tableStatuses = [
    { id: 'occupied', label: 'Table Occupied', status: 'occupied', color: 'secondary' as const },
    { id: 'table1', label: 'Table 1', status: 'active', color: 'primary' as const },
    { id: 'table2', label: 'Table 2', status: 'warning', color: 'warning' as const },
    { id: 'table3', label: 'Table 3', status: 'error', color: 'error' as const },
    ...Array.from({ length: 10 }, (_, i) => ({
      id: `table${i + 4}`,
      label: `Table ${i + 4}`,
      status: 'available',
      color: 'secondary' as const
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
      <Box sx={{ height: 'calc(100vh - 120px)' }}>
        <Grid container sx={{ height: '100%' }}>
          {/* Tables Sidebar */}
          <Grid item xs={2}>
            <Paper 
              sx={{ 
                height: '100%', 
                bgcolor: '#e8f5e8', 
                borderRight: 1,
                borderColor: '#4caf50',
                borderRadius: 0,
                p: 2,
                overflowY: 'auto'
              }}
            >
              <Box sx={{ display: 'flex', flexDirection: 'column', gap: 1 }}>
                {tableStatuses.map((table) => (
                  <Button
                    key={table.id}
                    variant={selectedTable === table.label ? 'contained' : 'outlined'}
                    color={selectedTable === table.label ? 'primary' : table.color}
                    fullWidth
                    sx={{
                      py: 1.5,
                      fontWeight: 'medium',
                      transition: 'all 0.2s ease-in-out',
                      '&:hover': {
                        transform: 'scale(1.05)',
                      }
                    }}
                    onClick={() => setSelectedTable(table.label)}
                  >
                    {table.label}
                  </Button>
                ))}
              </Box>
            </Paper>
          </Grid>

          {/* Menu Items */}
          <Grid size={4}>
            <Box sx={{ p: 2, height: '100%', display: 'flex', flexDirection: 'column' }}>
              {/* Search Bar */}
              <Card sx={{ mb: 2, boxShadow: 2, borderTop: 3, borderTopColor: '#64748b' }}>
                <CardContent sx={{ p: 2 }}>
                  <TextField
                    fullWidth
                    placeholder="Search Item"
                    value={searchQuery}
                    onChange={(e) => setSearchQuery(e.target.value)}
                    variant="outlined"
                    size="small"
                    InputProps={{
                      startAdornment: (
                        <InputAdornment position="start">
                          <Search />
                        </InputAdornment>
                      ),
                      sx: { 
                        '& .MuiOutlinedInput-notchedOutline': { border: 'none' },
                        fontSize: '1rem'
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
                      <CardContent sx={{ p: 2 }}>
                        <Box sx={{ display: 'flex', alignItems: 'center' }}>
                          <Avatar sx={{ bgcolor: '#7c3aed', width: 48, height: 48 }}>
                            <Construction  />
                          </Avatar>
                          <Box sx={{ flex: 1, ml: 2 }}>
                            <Typography variant="body1" fontWeight="medium" color="text.primary">
                              {item.name} {item.variant}
                            </Typography>
                            <Typography variant="body2" color="text.secondary">
                              {item.price}
                            </Typography>
                          </Box>
                          <IconButton
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
          <Grid item xs={6}>
            <Box sx={{ 
              height: '100%', 
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
                          type="number"
                          defaultValue={item.quantity}
                          size="small"
                          inputProps={{ min: 1, style: { textAlign: 'center' } }}
                          sx={{ 
                            width: 64,
                            '& .MuiOutlinedInput-root': {
                              bgcolor: '#f3f4f6',
                              '& input': { py: 0.5 }
                            }
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
                            <Recycling />
                          </IconButton>
                        </Box>
                      </Box>
                      {index < orderItems.length - 1 && <Divider />}
                    </Box>
                  ))}
                </Box>
              </Card>

              <Divider sx={{ mb: 2 }} />

              {/* Totals */}
              <Card sx={{ mb: 2, bgcolor: 'white' }}>
                <CardContent sx={{ p: 2 }}>
                  <Grid container spacing={2} textAlign="center">
                    <Grid item xs={4}>
                      <Typography variant="body2" color="text.secondary">
                        Food
                      </Typography>
                      <Typography variant="h6" fontWeight="semibold">
                        ₹15,480
                      </Typography>
                    </Grid>
                    <Grid item xs={4}>
                      <Typography variant="body2" color="text.secondary">
                        Beverages
                      </Typography>
                      <Typography variant="h6" fontWeight="semibold">
                        ₹2,250
                      </Typography>
                    </Grid>
                    <Grid item xs={4}>
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

              <Divider sx={{ mb: 2 }} />

              {/* Action Buttons */}
              <Card sx={{ bgcolor: 'white' }}>
                <CardContent sx={{ p: 2 }}>
                  <Grid container spacing={1.5}>
                    <Grid item xs={4}>
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
                    <Grid item xs={4}>
                      <Button
                        fullWidth
                        variant="outlined"
                        startIcon={<Description />}
                        color="secondary"
                      >
                        Get KOT
                      </Button>
                    </Grid>
                    <Grid item xs={4}>
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
    </PageContainer>
  );
};