import React from "react";
import { Grid, Typography, Button, Box } from "@mui/material";
import styles from "./index.module.scss";

const Hero = () => {
  return (
    <Box className={styles.heroBox}>
      <Grid container spacing={6} className={styles.gridContainer}>
        <Grid item xs={12} md={7}>
          <Typography variant="h3" fontWeight={700} className={styles.title}>
            Let's scale your business
          </Typography>
          <Typography variant="h6" className={styles.subtitle}>
            Hire professionals who will help your business make 10X your
            previous income. With over 5years experience in Marketing & Business
            strategy, we are your best client.
          </Typography>
          <Button
            variant="contained"
            color="primary"
            sx={{ width: "200px", fontSize: "16px" }}
          >
            HIRE US
          </Button>
        </Grid>
        <Grid item xs={12} md={5}>
          <img
            src={"https://source.unsplash.com/random/600x400"}
            alt="My Team"
            className={styles.largeImage}
          />
        </Grid>
      </Grid>
    </Box>
  );
};

export default Hero;
