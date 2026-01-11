import React, { useState } from "react";
import PropTypes from "prop-types";
import { CiLogout } from "react-icons/ci";
import api from "../utils/api";

// Example Logout button
const Logout = (props) => {
    const { className } = props; // Destructure className from props

    const [loading, setLoading] = useState(false); // Track loading state

    const handleLogout = async (e) => {
        e.preventDefault(); // Prevents the default anchor behavior
        setLoading(true); // Set loading state to true when logout starts

        try {
            const response = await api.get("/logout");

            // Clear token and user data from localStorage
            localStorage.removeItem("token");
            localStorage.removeItem("user");

            // Redirect to the login page (or home page)
            setTimeout(() => {
                window.location.href = "/login"; // or use your routing library's navigate method
            }, 0);
        } catch (error) {
            console.error("Logout error:", error);
        }
    };

    return (
        <button
            disabled={loading} // Disable button when loading
            className={`${className}`} // Apply className from props
            onClick={handleLogout}
        >
            <CiLogout className="mb-1" style={{ fontSize: "1.1rem" }} />{" "}
            {loading ? "Logging out..." : "Logout"}
        </button>
    );
};

Logout.propsTypes = {
    className: PropTypes.string, // Define prop types
};

Logout.defaultProps = {
    className: "dropdown-item", // Default className
};

export default Logout;
