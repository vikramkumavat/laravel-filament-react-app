// src/api.js
import axios from "axios";

const api = axios.create({
    baseURL: "/api",
    headers: {
        Authorization: `Bearer ${localStorage.getItem("token")}`,
    },
});

// Add interceptor for 401
api.interceptors.response.use(
    (response) => response,
    (error) => {
        if (error.response && error.response.status === 401) {
            localStorage.removeItem("token");
            localStorage.removeItem("user");
            alert("Session expired. Please log in again.");
            window.location.href = "/login";
        }
        return Promise.reject(error);
    }
);

export default api;
