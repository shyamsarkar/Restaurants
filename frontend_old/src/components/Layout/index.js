import React from 'react'
import { createTheme, ThemeProvider } from "@mui/material/styles";
import Box from "@mui/material/Box";
import bootstrap from "../../assets/bootstrap.module.scss";
import CssBaseline from "@mui/material/CssBaseline";
import NavBar from './NavBar';
import SideBar from './SideBar';

const Layout = (props) => {
    // TODO remove, this demo shouldn't need to reset the theme.
    const defaultTheme = createTheme();
    return (
        <ThemeProvider theme={defaultTheme}>
            <Box className={`${bootstrap.dFlex}`}>
                <CssBaseline />
                <NavBar />
                <SideBar />
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
                        overflow: "hidden",
                    }}
                >
                    {props.children}
                </Box>
                {/* Container End */}
            </Box>
        </ThemeProvider>
    )
}

export default Layout;