import React, { useState} from 'react'
import { styled, createTheme, ThemeProvider } from "@mui/material/styles";
import MuiDrawer from "@mui/material/Drawer";
import bootstrap from "../../assets/bootstrap.module.scss";
import Toolbar from "@mui/material/Toolbar";
import Typography from "@mui/material/Typography";
import Divider from "@mui/material/Divider";
import List from "@mui/material/List";
import { mainListItems } from "../../pages/Dashboard/listItems";

function SideBar() {
  const drawerWidth = 240;
  const [hideSidebar, setHideSidebar] = useState(false);
  const [open, setOpen] = useState(true);

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

  return (
    <>
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
    </>
  )
}

export default SideBar