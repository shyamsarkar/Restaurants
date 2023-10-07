import React from "react";
import { createTheme, ThemeProvider } from "@mui/material/styles";
import Header from "./Header";
import Hero from "./Hero";
import Section from "./Section";
import AboutUs from "./AboutUs";
import Testimonial from "./Testimonial";
import ContactUs from "./ContactUs";
// import Footer from "./Footer";
import Pricing from "./Pricing";
import StickyFooter from "./StickyFooter";
import Album from "./Album";

const theme = createTheme({
  typography: {
    fontFamily: ["Poppins", "sans-serif"].join(","),
  },
});

function Landing() {
  return (
    <ThemeProvider theme={theme}>
      <Header />
      <Section />
      <Hero />
      <AboutUs />
      <Testimonial />
      <ContactUs />
      <Pricing />
      <Album />
      {/* <Footer /> */}
      <StickyFooter />
    </ThemeProvider>
  );
}

export default Landing;
