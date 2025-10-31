import { StrictMode } from "react";
import { createRoot } from "react-dom/client";
import { BrowserRouter, Route } from "react-router";

import "./index.css";
import App from "./App.jsx";
import AuthContextProvider from "./store/auth_context/AuthContextProvider.jsx";

createRoot(document.getElementById("root")).render(
    <StrictMode>
        <AuthContextProvider>
            <BrowserRouter>
                <App />
            </BrowserRouter>
        </AuthContextProvider>
    </StrictMode>
);
