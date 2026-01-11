import axios from "axios";
import React, { useState } from "react";
import { FaEnvelope, FaLock } from "react-icons/fa"; // Adding icons for email and password
import { LuLogIn } from "react-icons/lu";

const Login = () => {
    const [email, setEmail] = useState("");
    const [password, setPassword] = useState("");
    const [errors, setErrors] = useState({});
    const [generalError, setGeneralError] = useState("");
    const [loading, setLoading] = useState(false); // Track loading state

    const handleSubmit = async (e) => {
        e.preventDefault();
        setErrors({});
        setGeneralError(""); // Clear any previous errors
        setLoading(true); // Set loading state to true when logout starts

        try {
            const res = await axios.post("/api/login", { email, password });
            // Store token and optionally user info
            localStorage.setItem("token", res.data.token);
            localStorage.setItem("user", JSON.stringify(res.data.user));

            setTimeout(() => {
                window.location.href = "/"; // Redirect to homepage
            }, 0);
        } catch (err) {
            console.error(err);
            if (err.response?.status === 422 && err.response.data.errors) {
                setErrors(err.response.data.errors); // Validation errors
            } else {
                setGeneralError("Invalid email or password."); // General error
            }
            setLoading(false); // Reset loading state
        }
    };

    return (
        <div className="d-flex justify-content-center align-items-center">
            <div
                className="card shadow-sm w-100 mb-5"
                style={{ maxWidth: "500px", marginTop: "70px" }}
            >
                <div className="card-header text-center text-black p-3">
                    <LuLogIn className="me-2" style={{ fontSize: "1.5rem" }} />
                    <h4>Login to your account</h4>
                    <p className="small text-black mb-0">
                        Enter your email and password to login
                    </p>
                </div>
                <div className="card-body">
                    {generalError && (
                        <div className="alert alert-danger text-center">
                            {generalError}
                        </div>
                    )}
                    <form onSubmit={handleSubmit}>
                        {/* Email Input */}
                        <div className="mb-3">
                            <label htmlFor="email" className="form-label">
                                Email
                            </label>
                            <div className="input-group">
                                <span className="input-group-text">
                                    <FaEnvelope />
                                </span>
                                <input
                                    id="email"
                                    type="email"
                                    className="form-control"
                                    value={email}
                                    onChange={(e) => setEmail(e.target.value)}
                                    placeholder="email@example.com"
                                />
                            </div>
                            {errors.email && (
                                <div className="text-danger mt-1">
                                    {errors.email}
                                </div>
                            )}
                        </div>

                        {/* Password Input */}
                        <div className="mb-3">
                            <label htmlFor="password" className="form-label">
                                Password
                            </label>
                            <div className="input-group">
                                <span className="input-group-text">
                                    <FaLock />
                                </span>
                                <input
                                    id="password"
                                    type="password"
                                    className="form-control"
                                    value={password}
                                    onChange={(e) =>
                                        setPassword(e.target.value)
                                    }
                                    placeholder="••••••••"
                                />
                            </div>
                            {errors.password && (
                                <div className="text-danger mt-1">
                                    {errors.password}
                                </div>
                            )}
                        </div>

                        {/* Submit Button */}
                        <button
                            type="submit"
                            disabled={loading} // Disable button when loading
                            className="btn btn-primary w-100"
                        >
                            {loading ? "Loging..." : "Login"}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    );
};

export default Login;
