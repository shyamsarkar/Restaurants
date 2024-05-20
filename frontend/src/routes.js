import { createBrowserRouter } from "react-router-dom";
import Landing from "./pages/Landing";
import Login from "./pages/Login";
import Dashboard from "./pages/Dashboard";
import PageNotFound from "./pages/PageNotFound";
import BillEntry from "./pages/BillEntry";

const router = createBrowserRouter([
  {
    path: "/",
    element: <Landing />,
  },
  {
    path: "/login",
    element: <Login />,
  },
  {
    path: "dashboard",
    element: <Dashboard />,
  },
  {
    path: "bill-entry",
    element: <BillEntry />,
  },
  {
    path: "*",
    element: <PageNotFound />,
  },
]);

export default router;
