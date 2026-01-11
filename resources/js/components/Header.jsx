import React, { useContext, useEffect, useState } from "react";
import { FontAwesomeIcon } from "@fortawesome/react-fontawesome";
import { faGavel, faHome } from "@fortawesome/free-solid-svg-icons";
import { LuLogIn } from "react-icons/lu";
import { PiUserPlusDuotone } from "react-icons/pi";
import isAuthenticated from "./helpers/isAuthenticated";
import Logout from "./auth/Logout";
import { Link } from "react-router-dom";
import { UserContext } from "./contexts/UserContext";
import getUserInitial from "./helpers/getUserInitial";
// import isAuthenticated from "./helpers/isAuthenticated";

const Header = () => {
    const { user } = useContext(UserContext);

    return (
        <header className="bg-light py-3 border-bottom">
            <div className="container d-flex justify-content-between align-items-center">
                <h3 className="mb-0">
                    <FontAwesomeIcon icon={faGavel} className="me-2" />
                    {window.AUCTION.APP_NAME || "App Name"}
                </h3>
                <nav>
                    {isAuthenticated() && (
                        <div className="btn-group">
                            <img
                                src={`https://ui-avatars.com/api/?name=${getUserInitial(
                                    user
                                )}&color=FFFFFF&background=09090b`}
                                alt="User Avatar"
                                className="rounded-circle me-2 dropdown-toggle"
                                data-bs-toggle="dropdown"
                                aria-expanded="false"
                                style={{
                                    width: "30px",
                                    height: "30px",
                                    cursor: "pointer",
                                }}
                            />

                            <ul className="dropdown-menu">
                                <li>
                                    <Link to="/" className="dropdown-item">
                                        <FontAwesomeIcon
                                            icon={faHome}
                                            className="me-1"
                                        />
                                        Home
                                    </Link>
                                </li>

                                <li>
                                    <Logout className="dropdown-item" />
                                </li>
                            </ul>
                        </div>
                    )}

                    {!isAuthenticated() && (
                        <Link to="/login" className="text-decoration-none mx-2">
                            Login&nbsp;
                            <LuLogIn />
                        </Link>
                    )}
                </nav>
            </div>
        </header>
    );
};

export default Header;
