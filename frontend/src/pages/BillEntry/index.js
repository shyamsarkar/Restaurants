import React from 'react';
import NavBar from '../../components/NavBar'
import SideBar from '../../components/SideBar';
import { Grid } from '@mui/material';


export default function BillEntry() {
    return (
        <>
            <NavBar />
            <SideBar />
            <Grid container spacing={2}>
                {/* First container with 100% width */}
                <Grid item xs={12}>
                    <span>100%</span>
                </Grid>
                {/* Second container with 33% width */}
                <Grid item xs={4}>
                    <span>30%</span>
                </Grid>
                {/* Third container with 33% width */}
                <Grid item xs={4}>
                    {/* Your content for the third container */}
                </Grid>
                {/* Fourth container with 33% width */}
                <Grid item xs={4}>
                    {/* Your content for the fourth container */}
                </Grid>
            </Grid>
        </>
    );
};
