import React, { useState, useEffect } from 'react';
import { styled } from "@mui/material/styles";
import MuiAppBar from "@mui/material/AppBar";
import Toolbar from "@mui/material/Toolbar";
import IconButton from "@mui/material/IconButton";
import Typography from "@mui/material/Typography";
import Box from "@mui/material/Box";
import Badge from "@mui/material/Badge";
import Menu from "@mui/material/Menu";
import Avatar from "@mui/material/Avatar";
import MenuItem from "@mui/material/MenuItem";
import bootstrap from "../../../assets/bootstrap.module.scss";
import MenuIcon from "@mui/icons-material/Menu";
import NotificationsIcon from "@mui/icons-material/Notifications";
import Alerts from "../../../pages/Dashboard/Alerts";
import { useSelector, useDispatch } from 'react-redux';

const NavBar = () => {
  const drawerWidth = 240;
  const [anchorElAlert, setAnchorElAlert] = useState(null);
  const [anchorElUser, setAnchorElUser] = useState(null);
  const settings = ["Profile", "Logout"];
  const dispatch = useDispatch();
  const hideSidebar = useSelector((state) => state.sideBar.hideSidebar);
  const expandSidebar = useSelector((state) => state.sideBar.expandSidebar);
  const openAlert = Boolean(anchorElAlert);
  const openUser = Boolean(anchorElUser);

  const toggleDrawer = () => {
    dispatch({ type: expandSidebar ? 'COLLAPSE_MENU' : 'EXPAND_MENU' })
  };

  const handleOpenAlert = (event) => {
    setAnchorElAlert(event.currentTarget);
  };

  const handleOpenUserMenu = (event) => {
    setAnchorElUser(event.currentTarget);
  };


  const handleCloseAlert = () => {
    setAnchorElAlert(null);
  };

  const handleCloseUserMenu = () => {
    setAnchorElUser(null);
  };

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

  return (
    <>
      {/* NavBar Start */}
      <AppBar
        position="absolute"
        className={`${hideSidebar ? bootstrap.w100 : ""}`}
        open={expandSidebar}
      >
        <Toolbar className={`${bootstrap.ps5}`}>
          <IconButton
            edge="start"
            color="inherit"
            aria-label="open drawer"
            onClick={toggleDrawer}
            sx={{ marginRight: "36px" }}
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
              open={openAlert}
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
              open={openUser}
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
    </>
  )
}

export default NavBar;