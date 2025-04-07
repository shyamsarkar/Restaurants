import { createBrowserRouter } from "react-router-dom";
import Landing from "./pages/Landing";
import Login from "./pages/Login";
import Dashboard from "./pages/Dashboard";
import PageNotFound from "./pages/PageNotFound";
import BillEntry from "./pages/BillEntry";
import ExampleComponent from "./components/ExampleComponent";
import Layout from './components/Layout'

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
    element: (
      <Layout>
        <Dashboard />
      </Layout>
    ),
  },
  {
    path: "bill-entry",
    element: (
      <Layout>
        <BillEntry />
      </Layout>
    ),
  },
  {
    path: "example",
    element: <ExampleComponent />,
  },
  {
    path: "*",
    element: <PageNotFound />,
  },
]);

export default router;
