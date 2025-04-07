import React from "react";
import { Grid, Typography, Button, Box } from "@mui/material";
import styles from "./index.module.scss";

const AboutUs = () => {
  return (
    <Box className={styles.aboutUsContainer}>
      <Grid container spacing={6} className={styles.gridContainer}>
        <Grid item xs={12} md={5}>
          <img
            src={"https://source.unsplash.com/random/600x400"}
            alt="My Team"
            className={styles.largeImage}
          />
        </Grid>

        <Grid item xs={12} md={6}>
          <Typography variant="h3" fontWeight={700} className={styles.title}>
            We build, We revive
          </Typography>
          <Typography className={styles.aboutUsSubtitle}>
            Your business needs to be in safe hands at all times. We ensure you
            never run out of customers and not run at loss. We are trusted by
            over 500+ companies to deliver quality marketing campaigns using
            Digital marketing & Offline marketing channels.
          </Typography>
          <Button
            variant="contained"
            color="primary"
            sx={{ width: "200px", fontSize: "16px" }}
          >
            CONTACT US
          </Button>
        </Grid>
      </Grid>
    </Box>
  );
};

export default AboutUs;
