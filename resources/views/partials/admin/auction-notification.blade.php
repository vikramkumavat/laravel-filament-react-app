<script>
    document.addEventListener("DOMContentLoaded", function () {

        const auctionConfig = @json($auctionConfig);

        const NOTIFICATION_MINUTES = parseFloat(auctionConfig.NOTIFICATION_MIN) || 5;
        const APP_URL = auctionConfig.APP_URL;

        function showNotification(count) {
            const notification = new Notification("Upcoming Auctions", {
                body: `You have ${count} auction(s) scheduled for tomorrow.`,
                // icon: "/auction-icon.png", // update to your icon
                data: {
                    url: APP_URL + "/?vn=1"
                },
            });

            notification.onclick = function (event) {
                event.preventDefault();
                window.open(notification.data.url, "_blank");
                notification.close();
            };
        }

        function getTomorrowAuctions() {
            fetch("/api/getAuctionNotification")
                .then(res => res.json())
                .then(data => {
                    const tomorrow = new Date();
                    tomorrow.setDate(tomorrow.getDate() + 1);
                    const tomorrowStr = tomorrow.toISOString().split("T")[0];

                    const auctions = data?.data || [];
                    const upcoming = auctions.filter(a => {
                        return a.start_time?.startsWith(tomorrowStr);
                    });

                    if (upcoming.length > 0) {
                        const lastTime = localStorage.getItem("lastNotificationTime");
                        const now = Date.now();

                        if (!lastTime || now - lastTime > (NOTIFICATION_MINUTES * 60 * 1000)) {
                            showNotification(upcoming.length);
                            localStorage.setItem("lastNotificationTime", now);
                        }
                    }
                })
                .catch(err => console.error("Notification error:", err));
        }

        function startAuctionNotifier() {
            if (!("Notification" in window)) return;

            if (Notification.permission === "granted") {
                getTomorrowAuctions();
            } else if (Notification.permission === "default") {
                Notification.requestPermission().then(permission => {
                    if (permission === "granted") {
                        getTomorrowAuctions();
                    }
                });
            }
        }

        setInterval(startAuctionNotifier, (NOTIFICATION_MINUTES * 60 * 1000));
        startAuctionNotifier();
    });
</script>
