import React from "react";
import { FontAwesomeIcon } from "@fortawesome/react-fontawesome";
import { faRotateRight } from "@fortawesome/free-solid-svg-icons";

const AuctionFilter = ({ filters, setFilters, resetFilters }) => {
    const handleChange = (e) => {
        const { name, value } = e.target;
        setFilters((prev) => ({
            ...prev,
            [name]: value,
        }));
    };

    return (
        <div className="mb-4">
            <div className="row g-3">
                {/* Title Filter */}
                <div className="col-md-4">
                    <input
                        type="text"
                        name="title"
                        value={filters.title}
                        onChange={handleChange}
                        className="form-control"
                        placeholder="Search by name, price, square footage, and auction location"
                    />
                </div>

                {/* Location Filter */}
                <div className="col-md-4">
                    <input
                        type="text"
                        name="location"
                        value={filters.location}
                        onChange={handleChange}
                        className="form-control"
                        placeholder="Search by property and auction location"
                    />
                </div>

                {/* Min and Max Price Filters */}
                <div className="col-md-3">
                    <div className="row">
                        <div className="col-6">
                            <input
                                type="number"
                                className="form-control"
                                name="min_price"
                                value={filters.min_price}
                                onChange={handleChange}
                                placeholder="Min Price"
                            />
                        </div>
                        <div className="col-6">
                            <input
                                type="number"
                                className="form-control"
                                name="max_price"
                                value={filters.max_price}
                                onChange={handleChange}
                                placeholder="Max Price"
                            />
                        </div>
                    </div>
                </div>

                {/* Reset Button */}
                <div className="col-md-1 d-flex justify-content-center align-items-center">
                    <button
                        type="button"
                        onClick={resetFilters}
                        className="btn btn-outline-secondary w-100"
                    >
                        <FontAwesomeIcon
                            icon={faRotateRight}
                            className="me-2"
                        />
                        {/* Reset Filters */}
                    </button>
                </div>
            </div>
        </div>
    );
};

export default AuctionFilter;
