import React from "react";
import ReactDOM from "react-dom/client";
import "./index.css";
import reportWebVitals from "./reportWebVitals";
import { RouterProvider } from "react-router-dom";
import router from "./routes";
import {store,persistor} from "./store/store";
import { PersistGate } from 'redux-persist/integration/react';
import { Provider } from 'react-redux';


const root = ReactDOM.createRoot(document.getElementById("root"));
root.render(
  <React.StrictMode>
    <Provider store={store}>
    {/* <PersistGate persistor={persistor}> */}
      <RouterProvider router={router} />
    {/* </PersistGate> */}
    </Provider>
  </React.StrictMode>
);

reportWebVitals();
