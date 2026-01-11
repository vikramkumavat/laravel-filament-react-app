import axios from "axios";
import React from "react";
import moment from "moment";
import api from "./api";

class AuctionNotification extends React.Component {
    componentDidMount() {
        this.interval = setInterval(() => {
            // Check permission and show notification if granted
            if (Notification.permission === "granted") {
                this.checkAuctionsAndNotify();
            } else if (Notification.permission === "default") {
                Notification.requestPermission().then((permission) => {
                    if (permission === "granted") {
                        this.checkAuctionsAndNotify();
                    }
                });
            }
        }, (window.AUCTION.NOTIFICATION_MIN || 1) * 60 * 1000); // every 1 minutes
    }

    componentWillUnmount() {
        // Clear interval when component is unmounted
        clearInterval(this.interval);
    }

    async checkAuctionsAndNotify() {
        const auctions = await this.fetchAuctions();
        const tomorrowAuctions = await this.getTomorrowAuctions(auctions);

        if (tomorrowAuctions.length > 0) {
            const lastNotificationTime = localStorage.getItem(
                "lastNotificationTime"
            );
            const now = new Date().getTime();

            // Check if an hour has passed since the last notification
            if (
                !lastNotificationTime ||
                now - lastNotificationTime >=
                    (window.AUCTION.NOTIFICATION_MIN || 1) * 60 * 1000
            ) {
                this.showNotification(tomorrowAuctions.length);
                localStorage.setItem("lastNotificationTime", now); // Store the time of the last notification
            }
        }
    }

    async fetchAuctions() {
        try {
            const response = await api.get("/getAuctionNotification", {
                params: { page: 1, per_page: 10 },
            });

            return response.data.data;
        } catch (error) {
            console.error("Error fetching auctions:", error);
            return [];
        }
    }

    async getTomorrowAuctions(auctions) {
        const tomorrowDate = moment().add(1, "day").format("YYYY-MM-DD");

        return auctions.filter((auction) => {
            const auctionDate = moment(auction.start_time).format("YYYY-MM-DD");
            return auctionDate === tomorrowDate;
        });
    }

    showNotification(count) {
        const notification = new Notification("Upcoming Auctions", {
            body: `You have ${count} auction(s) scheduled for tomorrow.`,
            // icon: `${window.AUCTION.APP_URL}/auction-icon.png`, // optional
            data: { url: `${window.AUCTION.APP_URL}/?vn=1` }, // Store the URL to be opened
        });

        // When the notification is clicked, navigate to the link
        notification.onclick = function (event) {
            event.preventDefault(); // Prevent the default behavior
            window.open(notification.data.url, "_blank"); // Open the URL in a new tab
        };
    }

    render() {
        return null; // this component doesn't render anything
    }
}

export default AuctionNotification;
