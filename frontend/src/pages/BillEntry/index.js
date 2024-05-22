import React from 'react';
import { Grid } from '@mui/material';
import { useState } from "react";
import Box from "@mui/material/Box";
import Toolbar from "@mui/material/Toolbar";
import List from "@mui/material/List";
import Typography from "@mui/material/Typography";
import Divider from "@mui/material/Divider";
import IconButton from "@mui/material/IconButton";
import bootstrap from "../../assets/bootstrap.module.scss";
import Avatar from "@mui/material/Avatar";
import MenuItem from "@mui/material/MenuItem";
import Button from '@mui/material/Button';
import ButtonGroup from '@mui/material/ButtonGroup';
import FormControl from '@mui/material/FormControl';
import Select from '@mui/material/Select';
import InputLabel from '@mui/material/InputLabel';
import Paper from '@mui/material/Paper';
import InputBase from '@mui/material/InputBase';
import SearchIcon from '@mui/icons-material/Search';
import ListItem from '@mui/material/ListItem';
import ListItemText from '@mui/material/ListItemText';
import ListItemAvatar from '@mui/material/ListItemAvatar';
import RestaurantIcon from '@mui/icons-material/Restaurant';
import AddBoxIcon from '@mui/icons-material/AddBox';
import DeleteIcon from '@mui/icons-material/Delete';
import EditIcon from '@mui/icons-material/Edit';
import TextField from '@mui/material/TextField';
import Snackbar from '@mui/material/Snackbar';
import CloseIcon from '@mui/icons-material/Close';
import Stack from '@mui/material/Stack';


export default function BillEntry() {
  const itemTypes = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20];
  const [itemQuantity, setItemQuantity] = useState(1);
  const [openSnacks, setOpenSnacks] = useState(false);
  const handleKeyUp = (event, itemName) => {
    setItemQuantity(`${event.target.value}: ${itemName}`);
    setOpenSnacks(true);
  };

  const handleSnacksClose = (reason) => {
    if (reason === 'clickaway') {
      return;
    }
    setOpenSnacks(false);
  };
  const action = (
    <>
      <Button color="secondary" size="small" onClick={handleSnacksClose}>
        UNDO
      </Button>
      <IconButton
        size="small"
        aria-label="close"
        color="inherit"
        onClick={handleSnacksClose}
      >
        <CloseIcon fontSize="small" />
      </IconButton>
    </>
  );

  return (
    <>
      <Toolbar />
      <Box className={`${bootstrap.pX4} ${bootstrap.mY4}`}>
        <Grid container spacing={2}>
          {/* First container with 100% width */}
          <Grid item xs={12}>
            <ButtonGroup variant="contained" style={{ overflowX: 'scroll', whiteSpace: 'nowrap', maxWidth: '100%' }} aria-label="Basic button group">
              {itemTypes.map((elem) => (
                <Button key={elem + "newdata"} color="success" style={{ minWidth: '200px' }}>Item Type {elem}</Button>
              ))}
            </ButtonGroup>
          </Grid>
          {/* Second container with 33% width */}
          <Grid item xs={2} sx={{ backgroundColor: '#95dbc1', px: '10px', textAlign: 'center' }}>
            <FormControl sx={{ m: 1, minWidth: '80%' }} size="small">
              <InputLabel id="demo-simple-select-autowidth-label">Floor</InputLabel>
              <Select
                labelId="demo-simple-select-autowidth-label"
                id="demo-simple-select-autowidth"
                value={0}
                onChange={null}
                autoWidth
                label="Age"
              >
                <MenuItem value={0}>-------select-------</MenuItem>
                <MenuItem value={10}>Ground Floor</MenuItem>
                <MenuItem value={21}>First Floor</MenuItem>
                <MenuItem value={22}>Second Floor</MenuItem>
              </Select>
            </FormControl>
            <ButtonGroup
              orientation="vertical"
              aria-label="Vertical button group"
              variant="contained"
              sx={{ boxShadow: '0' }}
            >
              <Button sx={{ my: 1 }} color="secondary" key={'secondary_button'}>Table Occupied</Button>
              {[1, 2, 3, 4, 5].map((data, index) => (
                <Button sx={{ my: 1 }} color="success" key={index + 100}>Table {data}</Button>
              ))}
              {[4, 5, 6, 7, 8, 9, 10].map((data, index) => (
                <Button sx={{ my: 1 }} color="primary" key={index + 150}>Table {data}</Button>
              ))}
            </ButtonGroup>
          </Grid>
          {/* Third container with 33% width */}
          <Grid item xs={4} sx={{ px: '10px' }}>
            <>
              <Paper
                component="form"
                sx={{ p: '2px 4px', display: 'flex', alignItems: 'center' }}
              >
                <InputBase
                  sx={{ ml: 1, flex: 1 }}
                  placeholder="Search Item"
                  inputProps={{ 'aria-label': 'search item' }}
                />
                <IconButton type="button" sx={{ p: '10px' }} aria-label="search">
                  <SearchIcon />
                </IconButton>
              </Paper>
              <Divider sx={{ marginTop: '20px' }} />
              <List sx={{ width: '100%', width: '100%', bgcolor: 'background.paper' }}>
                {['Chilli Chicken', 'Chicken Masala', 'Chicken Tandoori', 'Prawn Fry', 'Prawn Masala', 'Fish'].map((data) => (
                  <ListItem key={data}>
                    <ListItemAvatar>
                      <Avatar sx={{ backgroundColor: 'rebeccapurple' }}>
                        <RestaurantIcon />
                      </Avatar>
                    </ListItemAvatar>
                    <ListItemText primary={data} secondary="500/Pcs" />
                    <IconButton color="primary" aria-label="Add" size="large">
                      <AddBoxIcon />
                    </IconButton>
                  </ListItem>
                ))}
              </List>
            </>
          </Grid>
          {/* Fourth container with 33% width */}
          <Grid item xs={6} sx={{ backgroundColor: '#95dbc1', px: '10px' }}>
            <Typography variant="h6" gutterBottom>Table : {"Table Occupied"}</Typography>
            {[1, 2, 3, 4, 5].map(data => (
              <List key={data + 50} sx={{ width: '100%', width: '100%', bgcolor: 'background.paper', paddingBlock: 0 }}>
                <ListItem>
                  <TextField
                    hiddenLabel
                    id="filled-hidden-label-small"
                    defaultValue="1"
                    variant="filled"
                    size="small"
                    sx={{ width: 50 }}
                    onKeyUp={(e) => handleKeyUp(e, 'Chicken Prawn Masala')}
                  />
                  <Snackbar
                    open={openSnacks}
                    autoHideDuration={6000}
                    onClose={handleSnacksClose}
                    message={itemQuantity}
                    action={action}
                  />
                  <ListItemText
                    primary=" Chicken Prawn Masala"
                    secondary=" X 500/Pcs"
                    sx={{ ml: 1 }}
                  />
                  <IconButton edge="end" aria-label="edit">
                    <EditIcon />
                  </IconButton>
                  <IconButton edge="end" aria-label="delete">
                    <DeleteIcon />
                  </IconButton>
                </ListItem>
              </List>
            ))}


            <Grid item md={12} sx={{ bgcolor: 'background.paper', px: '10px', pb: '10px' }}>
              <Typography sx={{ mt: 1, mb: 2 }} variant="h6" component="div">
                Text only
              </Typography>
              <Typography sx={{ textAlign: 'right' }} variant="subtitle1" gutterBottom>
                Total Food :
              </Typography>
              <Typography sx={{ textAlign: 'right' }} variant="subtitle1" gutterBottom>
                Total Beverages :
              </Typography>
              <Typography sx={{ textAlign: 'right' }} variant="subtitle1" gutterBottom>
                Grand Total :
              </Typography>
            </Grid>

            <Grid item md={12} sx={{ bgcolor: 'background.paper', px: '10px', py: '10px', mt: '10px' }}>
              <Stack direction="row" spacing={2}>
                <Button variant="contained" sx={{ minWidth: '105px' }} color="success">Save Bill</Button>
                <Button variant="contained" sx={{ minWidth: '105px' }}>KOT</Button>
                <Button variant="contained" sx={{ minWidth: '105px' }} color='error'>Delete</Button>
              </Stack>
            </Grid>
          </Grid>
        </Grid>

      </Box>
    </>
  );
};
