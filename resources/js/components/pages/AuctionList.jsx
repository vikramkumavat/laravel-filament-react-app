import React, { useEffect, useState, useRef } from "react"; // 🔥 Add useRef
import axios from "axios";
import AuctionCard from "./auctions/AuctionCard";
import AuctionSkeleton from "./auctions/AuctionSkeleton";
import AuctionFilter from "./auctions/AuctionFilter";
import api from "../utils/api";

const AuctionList = () => {
    const perPage = window.AUCTION.PER_PAGE || 10;
    const auctionListRef = useRef(); // 👈 Create a reference to the auction list

    const initialFilters = {
        title: "",
        status: "",
        location: "",
        min_price: "",
        max_price: "",
    };

    const [auctions, setAuctions] = useState([]);
    const [isLoading, setIsLoading] = useState(false);
    const [page, setPage] = useState(1);
    const [hasMore, setHasMore] = useState(true);
    const [filters, setFilters] = useState(initialFilters);

    const fetchAuctions = async (pageNum = 1, applyFilters = filters) => {
        if (isLoading) return;
        const nv = window.AUCTION?.NOTIFICATION_VISITED || false;

        setIsLoading(true);
        try {
            const res = await api
                .get("/auctions", {
                    params: {
                        page: pageNum,
                        per_page: perPage,
                        nv,
                        ...applyFilters,
                    },
                })
                .then((res) => {
                    const newAuctions = res.data.data;
                    if (pageNum === 1) {
                        setAuctions(newAuctions);
                    } else {
                        setAuctions((prev) => [...prev, ...newAuctions]);
                    }
                    setHasMore(res.data.current_page < res.data.last_page);
                    // use newAuctions here
                })
                .catch((err) => {
                    console.error("Error fetching auctions", err);
                    setHasMore(false);
                });
        } catch (err) {
            console.error("Error fetching auctions", err);
        } finally {
            setIsLoading(false);
        }
    };

    // Initial fetch or when filters or page number change
    useEffect(() => {
        fetchAuctions(page, filters); // Fetch auctions based on current page and filters
    }, [filters, page]); // Trigger when either filters or page change

    const handleLoadMore = () => {
        const nextPage = page + 1;
        setPage(nextPage);
        fetchAuctions(nextPage);
    };

    const resetFilters = () => {
        setPage(1);
        setFilters(initialFilters); // Reset filters and fetch auctions for page 1
    };

    // const handlePrint = () => {
    //     const originalContents = document.body.innerHTML;
    //     const printContents = auctionListRef.current.innerHTML;
    //     document.body.innerHTML = printContents;
    //     window.print();
    //     document.body.innerHTML = originalContents;
    //     window.location.reload(); // reload after print to restore page
    // };

    return (
        <div className="container my-4 auction-print-container">
            {/* <h1 className="mb-4 d-flex justify-content-between align-items-center">
                Upcoming Auctions
                <button className="btn btn-primary" onClick={handlePrint}>
                    Print List
                </button>
            </h1> */}

            <AuctionFilter
                filters={filters}
                setFilters={setFilters}
                resetFilters={resetFilters}
            />

            <div className="row auction-print-list" ref={auctionListRef}>
                {isLoading && page === 1 ? (
                    [...Array(3)].map((_, idx) => <AuctionSkeleton key={idx} />)
                ) : auctions.length === 0 ? (
                    <div className="col-12 text-center py-5">
                        <h5 className="text-muted">
                            No upcoming auctions available.
                        </h5>
                    </div>
                ) : (
                    auctions.map((auction) => (
                        <div
                            key={`auction-div-${auction.id}`}
                            className="col-12 auction-item"
                        >
                            <AuctionCard key={auction.id} auction={auction} />
                        </div>
                    ))
                )}
            </div>

            {hasMore && (
                <div className="text-center mt-4">
                    <button
                        className="btn btn-outline-secondary"
                        onClick={handleLoadMore}
                        disabled={isLoading}
                    >
                        {isLoading ? "Loading..." : "Load More"}
                    </button>
                </div>
            )}
        </div>
    );
};

export default AuctionList;
