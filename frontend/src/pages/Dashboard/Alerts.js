import * as React from "react";
import Box from "@mui/material/Box";
import ListItem from "@mui/material/ListItem";
import ListItemButton from "@mui/material/ListItemButton";
import bootstrap from "../../assets/bootstrap.module.scss";
import styles from "./styles.module.scss";
import { Alert } from "@mui/material";

const totalMessages = [1, 2, 3, 4, 5, 6];

export default function Alerts() {
  return (
    <Box className={`${bootstrap.w100} ${styles.alertModal}`}>
      {totalMessages.map((key) => (
        <ListItem key={key} component="div" disablePadding>
          <ListItemButton>
            <Alert severity="success" onClose={() => {}}>
              This is a success alert — check it out!
            </Alert>
          </ListItemButton>
        </ListItem>
      ))}
    </Box>
  );
}
