// src/routes/GuestRoute.jsx
import { Navigate } from "react-router-dom";
import isAuthenticated from "../helpers/isAuthenticated";

const GuestRoute = ({ children }) => {
    return isAuthenticated() ? <Navigate to="/" /> : children;
};

export default GuestRoute;
