import Box from "@mui/material/Box";
import Toolbar from "@mui/material/Toolbar";
import DataTable from "./DataTable";
import bootstrap from "../../assets/bootstrap.module.scss";

export default function Dashboard() {

  return (<>
    <Toolbar />
    <Box className={`${bootstrap.pX4} ${bootstrap.mY4}`}>
      <DataTable />
    </Box>
  </>
  );
}
