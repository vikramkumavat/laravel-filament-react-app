import React from "react";

const Footer = () => {
    return (
        <footer className="bg-light text-center py-3 mt-5 border-top">
            <div className="container">
                <p className="mb-0 text-muted">
                    © {new Date().getFullYear()}{" "}
                    {window.AUCTION.APP_NAME || "App Name"}. All rights
                    reserved.
                </p>
            </div>
        </footer>
    );
};

export default Footer;
