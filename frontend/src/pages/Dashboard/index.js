import { useState, useEffect } from "react";
import { styled, createTheme, ThemeProvider } from "@mui/material/styles";
import CssBaseline from "@mui/material/CssBaseline";
import MuiDrawer from "@mui/material/Drawer";
import Box from "@mui/material/Box";
import MuiAppBar from "@mui/material/AppBar";
import Toolbar from "@mui/material/Toolbar";
import List from "@mui/material/List";
import Typography from "@mui/material/Typography";
import Divider from "@mui/material/Divider";
import IconButton from "@mui/material/IconButton";
import Badge from "@mui/material/Badge";
import MenuIcon from "@mui/icons-material/Menu";
import NotificationsIcon from "@mui/icons-material/Notifications";
import { mainListItems } from "./listItems";
import DataTable from "./DataTable";
import bootstrap from "../../assets/bootstrap.module.scss";
import Avatar from "@mui/material/Avatar";
import Menu from "@mui/material/Menu";
import MenuItem from "@mui/material/MenuItem";
import Alerts from "./Alerts";
import NavBar from "../../components/NavBar";
import { Grid } from '@mui/material';
import Button from '@mui/material/Button';
import ButtonGroup from '@mui/material/ButtonGroup';
import FormControl from '@mui/material/FormControl';
import Select, { SelectChangeEvent } from '@mui/material/Select';
import InputLabel from '@mui/material/InputLabel';
import Paper from '@mui/material/Paper';
import InputBase from '@mui/material/InputBase';
import SearchIcon from '@mui/icons-material/Search';
import DirectionsIcon from '@mui/icons-material/Directions';
import ListItem from '@mui/material/ListItem';
import ListItemText from '@mui/material/ListItemText';
import ListItemAvatar from '@mui/material/ListItemAvatar';
import ImageIcon from '@mui/icons-material/Image';
import WorkIcon from '@mui/icons-material/Work';
import BeachAccessIcon from '@mui/icons-material/BeachAccess';
import RestaurantIcon from '@mui/icons-material/Restaurant';
import AddBoxIcon from '@mui/icons-material/AddBox';
import DeleteIcon from '@mui/icons-material/Delete';
import EditIcon from '@mui/icons-material/Edit';
import TextField from '@mui/material/TextField';
import Snackbar from '@mui/material/Snackbar';
import CloseIcon from '@mui/icons-material/Close';

const drawerWidth = 240;
const settings = ["Profile", "Logout"];

const AppBar = styled(MuiAppBar, {
  shouldForwardProp: (prop) => prop !== "open",
})(({ theme, open }) => ({
  zIndex: theme.zIndex.drawer + 1,
  transition: theme.transitions.create(["width", "margin"], {
    easing: theme.transitions.easing.sharp,
    duration: theme.transitions.duration.leavingScreen,
  }),
  ...(open && {
    marginLeft: drawerWidth,
    width: `calc(100% - ${drawerWidth}px)`,
    transition: theme.transitions.create(["width", "margin"], {
      easing: theme.transitions.easing.sharp,
      duration: theme.transitions.duration.enteringScreen,
    }),
  }),
}));

const Drawer = styled(MuiDrawer, {
  shouldForwardProp: (prop) => prop !== "open",
})(({ theme, open }) => ({
  "& .MuiDrawer-paper": {
    position: "relative",
    whiteSpace: "nowrap",
    width: drawerWidth,
    transition: theme.transitions.create("width", {
      easing: theme.transitions.easing.sharp,
      duration: theme.transitions.duration.enteringScreen,
    }),
    boxSizing: "border-box",
    ...(!open && {
      overflowX: "hidden",
      transition: theme.transitions.create("width", {
        easing: theme.transitions.easing.sharp,
        duration: theme.transitions.duration.leavingScreen,
      }),
      width: theme.spacing(7),
      [theme.breakpoints.up("sm")]: {
        width: theme.spacing(9),
      },
    }),
  },
}));

// TODO remove, this demo shouldn't need to reset the theme.
const defaultTheme = createTheme();

export default function Dashboard() {
  const [open, setOpen] = useState(true);
  const [openSnacks, setOpenSnacks] = useState(false);
  const [hideSidebar, setHideSidebar] = useState(false);
  const [itemQuantity, setItemQuantity] = useState(1);
  const itemTypes = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20];
  const toggleDrawer = () => {
    setOpen(!open);
  };
  const [anchorElUser, setAnchorElUser] = useState(null);
  const [anchorElAlert, setAnchorElAlert] = useState(null);

  const handleOpenUserMenu = (event) => {
    setAnchorElUser(event.currentTarget);
  };

  const handleOpenAlert = (event) => {
    setAnchorElAlert(event.currentTarget);
  };
  const handleCloseUserMenu = () => {
    setAnchorElUser(null);
  };

  const handleCloseAlert = () => {
    setAnchorElAlert(null);
  };

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

  useEffect(() => {
    const handleResize = () => {
      if (window.innerWidth < 600) {
        setHideSidebar(true);
      } else {
        setHideSidebar(false);
      }
    };

    window.addEventListener("resize", handleResize);

    return () => {
      window.removeEventListener("resize", handleResize);
    };
  }, []);

  return (
    <ThemeProvider theme={defaultTheme}>
      <Box className={`${bootstrap.dFlex}`}>
        <CssBaseline />
        {/* NavBar Start */}
        <AppBar
          position="absolute"
          className={`${hideSidebar ? bootstrap.w100 : ""}`}
          open={open}
        >
          <Toolbar className={`${bootstrap.ps5}`}>
            <IconButton
              edge="start"
              color="inherit"
              aria-label="open drawer"
              onClick={toggleDrawer}
              sx={{ marginRight: "36px", ...open }}
            >
              <MenuIcon />
            </IconButton>
            <Typography
              component="h1"
              variant="h6"
              color="inherit"
              noWrap
              sx={{ flexGrow: 1 }}
            >
              Dashboard
            </Typography>
            <Box className={`${bootstrap.mS3} `}>
              <IconButton onClick={handleOpenAlert} color="inherit">
                <Badge badgeContent={4} color="secondary">
                  <NotificationsIcon />
                </Badge>
              </IconButton>
              <Menu
                className={`${bootstrap.mT5}`}
                id="menu-appbar"
                anchorEl={anchorElAlert}
                anchorOrigin={{
                  vertical: "top",
                  horizontal: "right",
                }}
                keepMounted
                transformOrigin={{
                  vertical: "top",
                  horizontal: "right",
                }}
                open={Boolean(anchorElAlert)}
                onClose={handleCloseAlert}
              >
                <Alerts />
              </Menu>
            </Box>
            <Box className={`${bootstrap.mS3} `}>
              <IconButton onClick={handleOpenUserMenu}>
                <Avatar
                  alt="Remy Sharp"
                  src="https://mui.com/static/images/avatar/2.jpg"
                />
              </IconButton>
              <Menu
                className={`${bootstrap.mT5}`}
                id="menu-appbar"
                anchorEl={anchorElUser}
                anchorOrigin={{
                  vertical: "top",
                  horizontal: "right",
                }}
                keepMounted
                transformOrigin={{
                  vertical: "top",
                  horizontal: "right",
                }}
                open={Boolean(anchorElUser)}
                onClose={handleCloseUserMenu}
              >
                {settings.map((setting) => (
                  <MenuItem key={setting} onClick={handleCloseUserMenu}>
                    <Typography textAlign="center">{setting}</Typography>
                  </MenuItem>
                ))}
              </Menu>
            </Box>
          </Toolbar>
        </AppBar>
        {/* NavBar End */}
        {/* SideBar Start */}
        <Drawer
          className={`${hideSidebar && !open ? bootstrap.dNone : ""}`}
          variant="permanent"
          open={open}
        >
          <Toolbar
            sx={{
              display: "flex",
              alignItems: "center",
              justifyContent: "flex-end",
              px: [1],
            }}
          >
            <Typography
              className={`${bootstrap.textCenter} ${bootstrap.w100}`}
              variant="h5"
              component="h5"
            >
              Restaurant
            </Typography>
          </Toolbar>
          <Divider />
          <List component="nav">{mainListItems}</List>
        </Drawer>
        {/* SideBar End */}
        {/* Container Start */}
        <Box
          component="main"
          sx={{
            backgroundColor: (theme) =>
              theme.palette.mode === "light"
                ? theme.palette.grey[100]
                : theme.palette.grey[900],
            flexGrow: 1,
            height: "100vh",
            overflow: "auto",
          }}
        >
          <Toolbar />
          <Box className={`${bootstrap.pX4} ${bootstrap.mY4}`}>
            <Grid container spacing={2}>
              {/* First container with 100% width */}
              <Grid item xs={12}>
                <ButtonGroup variant="contained" style={{ overflowX: 'scroll', whiteSpace: 'nowrap', maxWidth: '100%' }} aria-label="Basic button group">
                  {itemTypes.map((elem) => (
                    <Button key={elem} color="success" style={{ minWidth: '200px' }}>Item Type {elem}</Button>
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
                  sx={{boxShadow: '0'}}
                >
                  <Button sx={{ my: 1 }} color="secondary" key={'secondary_button'}>Table Occupied</Button>
                  {[1, 2, 3, 4, 5].map((data, index) => (
                    <Button sx={{ my: 1 }} color="success" key={index}>Table {data}</Button>
                  ))}
                  {[4, 5, 6, 7, 8, 9, 10].map((data, index) => (
                    <Button sx={{ my: 1 }} color="primary" key={index}>Table {data}</Button>
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
                    {/* <Divider sx={{ height: 28, m: 0.5 }} orientation="vertical" /> */}
                  </Paper>
                  <Divider sx={{ marginTop: '20px' }} />
                  <List sx={{ width: '100%', width: '100%', bgcolor: 'background.paper' }}>
                    {['Chilli Chicken', 'Chicken Masala', 'Chicken Tandoori', 'Prawn Fry', 'Prawn Masala', 'Fish'].map((data) => (
                      <ListItem>
                        <ListItemAvatar>
                          <Avatar sx={{ backgroundColor: 'rebeccapurple' }}>
                            {/* <BeachAccessIcon /> */}
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
                  <List sx={{ width: '100%', width: '100%', bgcolor: 'background.paper', paddingBlock: 0 }}>
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
              </Grid>
            </Grid>
            <DataTable />
          </Box>
        </Box>
        {/* Container End */}
      </Box>
    </ThemeProvider>
  );
}
