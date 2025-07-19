import React from "react";
import ReactDOM from "react-dom/client";
import router from "./routes";
import "./index.css";
import { RouterProvider } from "react-router-dom";
import toast, { Toaster } from 'react-hot-toast';

ReactDOM.createRoot(document.getElementById("root")).render(
  <>
    <Toaster position="top-right" />
      <React.StrictMode>
      <RouterProvider router={router} />
    </React.StrictMode>
  </>
);
