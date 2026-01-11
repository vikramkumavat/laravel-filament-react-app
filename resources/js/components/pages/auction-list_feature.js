import { useState } from "react";
import {
    Card,
    CardContent,
    CardFooter,
    CardHeader,
    CardTitle,
} from "/components/ui/card";
import { Input } from "/components/ui/input";
import { Button } from "/components/ui/button";
import {
    Select,
    SelectContent,
    SelectItem,
    SelectTrigger,
    SelectValue,
} from "/components/ui/select";
import { Clock, ArrowRight } from "lucide-react";

// Sample auction data
const auctions = [
    {
        id: 1,
        name: "Vintage Rolex Watch",
        currentBid: 1250,
        startingPrice: 500,
        endTime: "2023-12-15T18:00:00",
        bids: 12,
        image: "/watch.jpg",
    },
    {
        id: 2,
        name: "Rare First Edition Book",
        currentBid: 320,
        startingPrice: 100,
        endTime: "2023-12-10T14:30:00",
        bids: 8,
        image: "/book.jpg",
    },
    {
        id: 3,
        name: "Antique Wooden Chair",
        currentBid: 450,
        startingPrice: 200,
        endTime: "2023-12-20T12:00:00",
        bids: 5,
        image: "/chair.jpg",
    },
    {
        id: 4,
        name: "Modern Art Painting",
        currentBid: 2800,
        startingPrice: 1000,
        endTime: "2023-12-25T20:00:00",
        bids: 15,
        image: "/painting.jpg",
    },
    {
        id: 5,
        name: "Collectible Coin Set",
        currentBid: 175,
        startingPrice: 50,
        endTime: "2023-12-12T10:00:00",
        bids: 6,
        image: "/coins.jpg",
    },
    {
        id: 6,
        name: "Vintage Camera",
        currentBid: 620,
        startingPrice: 300,
        endTime: "2023-12-18T16:45:00",
        bids: 9,
        image: "/camera.jpg",
    },
];

export default function AuctionList() {
    const [searchTerm, setSearchTerm] = useState("");
    const [sortBy, setSortBy] = useState("name");

    // Calculate time remaining for each auction
    const auctionsWithTimeRemaining = auctions.map((auction) => {
        const endTime = new Date(auction.endTime).getTime();
        const now = new Date().getTime();
        const timeRemaining = endTime - now;

        return {
            ...auction,
            timeRemaining: timeRemaining > 0 ? timeRemaining : 0,
        };
    });

    // Filter auctions based on search term
    const filteredAuctions = auctionsWithTimeRemaining.filter((auction) =>
        auction.name.toLowerCase().includes(searchTerm.toLowerCase())
    );

    // Sort auctions based on selected option
    const sortedAuctions = [...filteredAuctions].sort((a, b) => {
        switch (sortBy) {
            case "name":
                return a.name.localeCompare(b.name);
            case "currentBid":
                return b.currentBid - a.currentBid;
            case "timeRemaining":
                return a.timeRemaining - b.timeRemaining;
            default:
                return 0;
        }
    });

    // Format time remaining
    const formatTimeRemaining = (ms: number) => {
        if (ms <= 0) return "Ended";

        const days = Math.floor(ms / (1000 * 60 * 60 * 24));
        const hours = Math.floor(
            (ms % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60)
        );
        const minutes = Math.floor((ms % (1000 * 60 * 60)) / (1000 * 60));

        return `${days}d ${hours}h ${minutes}m`;
    };

    return (
        <div className="container mx-auto px-4 py-8">
            <h1 className="text-3xl font-bold mb-8">Live Auctions</h1>

            {/* Search and Sort Controls */}
            <div className="flex flex-col md:flex-row gap-4 mb-8">
                <Input
                    placeholder="Search auctions..."
                    value={searchTerm}
                    onChange={(e) => setSearchTerm(e.target.value)}
                    className="flex-1"
                />

                <div className="flex items-center gap-2">
                    <span className="text-sm text-muted-foreground">
                        Sort by:
                    </span>
                    <Select value={sortBy} onValueChange={setSortBy}>
                        <SelectTrigger className="w-[180px]">
                            <SelectValue placeholder="Sort by" />
                        </SelectTrigger>
                        <SelectContent>
                            <SelectItem value="name">Name (A-Z)</SelectItem>
                            <SelectItem value="currentBid">
                                Highest Bid
                            </SelectItem>
                            <SelectItem value="timeRemaining">
                                Ending Soonest
                            </SelectItem>
                        </SelectContent>
                    </Select>
                </div>
            </div>

            {/* Auction List */}
            <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                {sortedAuctions.map((auction) => (
                    <Card
                        key={auction.id}
                        className="hover:shadow-lg transition-shadow"
                    >
                        <CardHeader>
                            <div className="bg-gray-200 border-2 border-dashed rounded-xl w-full h-48" />
                        </CardHeader>
                        <CardContent>
                            <CardTitle className="text-xl mb-2">
                                {auction.name}
                            </CardTitle>

                            <div className="flex justify-between items-center mb-2">
                                <span className="text-sm text-muted-foreground">
                                    Current Bid:
                                </span>
                                <span className="font-bold">
                                    ${auction.currentBid.toLocaleString()}
                                </span>
                            </div>

                            <div className="flex justify-between items-center mb-2">
                                <span className="text-sm text-muted-foreground">
                                    Starting Price:
                                </span>
                                <span className="text-sm">
                                    ${auction.startingPrice.toLocaleString()}
                                </span>
                            </div>

                            <div className="flex justify-between items-center mb-2">
                                <span className="text-sm text-muted-foreground">
                                    Bids:
                                </span>
                                <span className="text-sm">{auction.bids}</span>
                            </div>

                            <div className="flex items-center gap-2 mt-4 text-sm">
                                <Clock className="h-4 w-4 text-muted-foreground" />
                                <span
                                    className={
                                        auction.timeRemaining <= 0
                                            ? "text-destructive"
                                            : ""
                                    }
                                >
                                    {formatTimeRemaining(auction.timeRemaining)}
                                </span>
                            </div>
                        </CardContent>
                        <CardFooter className="flex justify-end">
                            <Button variant="outline">
                                View Details{" "}
                                <ArrowRight className="ml-2 h-4 w-4" />
                            </Button>
                        </CardFooter>
                    </Card>
                ))}
            </div>

            {sortedAuctions.length === 0 && (
                <div className="text-center py-12">
                    <p className="text-muted-foreground">
                        No auctions found matching your search.
                    </p>
                </div>
            )}
        </div>
    );
}
