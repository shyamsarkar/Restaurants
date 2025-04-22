'use client';
import PageContainer from '@/app/(DashboardLayout)/components/container/PageContainer';
import Grid from '@mui/material/Grid';

import { useState } from 'react';
import { SelectChangeEvent } from '@mui/material/Select';
import { ButtonGroup, InputLabel, MenuItem, FormControl, Select, Button, Divider, List, ListItem, ListItemAvatar, Avatar, ListItemText, Typography, TextField, Stack } from '@mui/material';
import SearchIcon from '@mui/icons-material/Search';
import InputBase from '@mui/material/InputBase';
import Paper from '@mui/material/Paper';
import IconButton from "@mui/material/IconButton";
import AddBoxIcon from '@mui/icons-material/AddBox';
import RestaurantIcon from '@mui/icons-material/Restaurant';
import EditIcon from '@mui/icons-material/Edit';
import DeleteIcon from '@mui/icons-material/Delete';
import Fab from '@mui/material/Fab';
import AddIcon from '@mui/icons-material/Add';
import { styled } from '@mui/material/styles';

const Item = styled(Paper)(({ theme }) => {
  console.log(theme)
  return {
  backgroundColor: theme.palette.grey[200],
  ...theme.typography.body2,
  padding: theme.spacing(1),
  textAlign: 'center',
  fontWeight: theme.typography.fontWeightMedium,
  color: theme.palette.text.secondary,
  ...theme.applyStyles('dark', {
    backgroundColor: '#1A2027',
  }),
}});


const OrdersPage = () => {
  const [floorNumber, setFloorNumber] = useState('0');
  const handleChange = (event: SelectChangeEvent) => {
    console.log(event.target.value);

    setFloorNumber(event.target.value as string);
  };

  return (
    <PageContainer title="Orders" description="Add all the items and calculate the total">
      <Grid container>
        <Grid className='success' sx={{ pt: '10px', maxHeight: '85vh', overflow: 'auto', backgroundColor: 'success.main', textAlign: 'center' }} item xs={2}>
          <ButtonGroup
            orientation="vertical"
            aria-label="Vertical button group"
            variant="contained"
            sx={{ boxShadow: '0', overflowY: 'auto' }}
          >
            <Button sx={{ my: 1 }} color="inherit">Table Occupied</Button>
            <Button sx={{ my: 1 }} color="primary">Table 1</Button>
            <Button sx={{ my: 1 }} color="warning">Table 2</Button>
            <Button sx={{ my: 1 }} color="error">Table 3</Button>
            <Button sx={{ my: 1 }} color="primary">Table #</Button>
            <Button sx={{ my: 1 }} color="primary">Table #</Button>
            <Button sx={{ my: 1 }} color="primary">Table #</Button>
            <Button sx={{ my: 1 }} color="primary">Table #</Button>
            <Button sx={{ my: 1 }} color="primary">Table #</Button>
            <Button sx={{ my: 1 }} color="primary">Table #</Button>
            <Button sx={{ my: 1 }} color="primary">Table #</Button>
            <Button sx={{ my: 1 }} color="primary">Table #</Button>
            <Button sx={{ my: 1 }} color="primary">Table #</Button>
            <Button sx={{ my: 1 }} color="primary">Table #</Button>
          </ButtonGroup>
        </Grid>
        <Grid item xs={4} sx={{ pt: '10px', px: '10px', maxHeight: '85vh' }}>
          <Paper
            component="form"
            sx={{ p: '3px 4px', display: 'flex', alignItems: 'center', borderTop: '0.5px solid black' }}
          >
            <InputBase
              sx={{ ml: 1, flex: 1 }}
              placeholder="Search Item"
              inputProps={{ 'aria-label': 'search item' }}
            />
            <SearchIcon />
          </Paper>
          <Divider sx={{ marginTop: '10px' }} />
          <List sx={{ width: '100%', bgcolor: 'background.paper', overflowY: "auto", maxHeight: '76vh', overflow: 'auto', }}>
            {[1, 2, 3, 4, 5, 6, 7, 8, 9, 10].map((data) => (
              <ListItem key={data}>
                <ListItemAvatar>
                  <Avatar sx={{ backgroundColor: 'rebeccapurple' }}>
                    <RestaurantIcon />
                  </Avatar>
                </ListItemAvatar>
                <ListItemText primary={'Chicken Masala Full/Half'} secondary="500/Pcs" />
                <Fab size="small" color="primary" aria-label="add">
                  <AddIcon />
                </Fab>
                {/* <IconButton color="primary" aria-label="Add" size="large">
                  <AddBoxIcon />
                </IconButton> */}
              </ListItem>
            ))}
          </List>
        </Grid>
        <Grid sx={{ pt: '10px', px: '10px', backgroundColor: 'success.main' }} item xs={6}>
          <Typography variant="h6" gutterBottom>Table : {"Table Number 1"}</Typography>
          <List sx={{ width: '100%', bgcolor: 'background.paper', paddingBlock: 0, height: '60vh', overflow: 'auto', }}>
            {[1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20].map(data => (
              <ListItem key={data} sx={{ paddingBlock: 0 }}>
                <TextField
                  hiddenLabel
                  id="filled-hidden-label-small"
                  defaultValue="1"
                  variant="filled"
                  size="small"
                  sx={{ width: 50 }}
                />
                <ListItemText
                  primary="Prawn Masala"
                  secondary=" X 500/Pcs"
                  sx={{ ml: 1 }}
                />
                  <Item>357284</Item>
                <IconButton edge="end" aria-label="edit">
                  <EditIcon />
                </IconButton>
                <IconButton edge="end" aria-label="delete">
                  <DeleteIcon />
                </IconButton>
              </ListItem>
            ))}
          </List>
          <Divider sx={{ marginTop: '10px' }} />
          <Grid item md={12} sx={{ bgcolor: 'background.paper', px: '10px', pb: '10px', display: 'flex' }}>
            <Grid item xs={6} md={3}>Food : </Grid>
            <Grid item xs={6} md={3}>Beverages :</Grid>
            <Grid item xs={6} md={3}>Grand Total :</Grid>
          </Grid>
          <Divider sx={{ marginTop: '10px' }} />

          <Grid item md={12} sx={{ bgcolor: 'background.paper', p: '10px' }}>
            <Stack direction="row" spacing={2}>
              <Button variant='contained' color="primary">Save Bill</Button>
              <Button variant='contained' color="info">Get KOT</Button>
              <Button variant='contained' color="error">Delete</Button>
            </Stack>
          </Grid>
        </Grid>
      </Grid>
    </PageContainer>
  );
};

export default OrdersPage;

