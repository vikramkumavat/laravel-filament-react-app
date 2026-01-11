import React from "react";

const AuctionSkeleton = () => {
    const loaderColor = "rgba(138, 189, 240, 0.75)";

    return (
        <div className="col-md-12 col-lg-12 mt-2">
            <div className="card h-100 shadow-sm">
                <div className="card-body">
                    <h5 className="card-title placeholder-glow">
                        <span
                            className="placeholder col-6"
                            style={{ color: loaderColor }}
                        ></span>
                    </h5>
                    <p className="card-text placeholder-glow">
                        <span
                            className="placeholder col-7"
                            style={{ color: loaderColor }}
                        ></span>
                        <span
                            className="placeholder col-4"
                            style={{ color: loaderColor }}
                        ></span>
                    </p>
                    <ul className="list-unstyled small placeholder-glow">
                        <li>
                            <span
                                className="placeholder col-4"
                                style={{ color: loaderColor }}
                            ></span>
                        </li>
                        <li>
                            <span
                                className="placeholder col-5"
                                style={{ color: loaderColor }}
                            ></span>
                        </li>
                        <li>
                            <span
                                className="placeholder col-6"
                                style={{ color: loaderColor }}
                            ></span>
                        </li>
                        <li>
                            <span
                                className="placeholder col-4"
                                style={{ color: loaderColor }}
                            ></span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    );
};

export default AuctionSkeleton;
