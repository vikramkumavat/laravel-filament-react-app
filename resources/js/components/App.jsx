import React, { Component } from "react";
import { BrowserRouter as Router, Routes, Route } from "react-router-dom";
import Header from "./Header"; // Assuming Header is a separate component
import Footer from "./Footer"; // Assuming Footer is a separate component
import GuestRoute from "./routes/GuestRoute";
import PrivateRoute from "./routes/PrivateRoute";
// import AuctionList from "./AuctionList"; // Assuming AuctionList is one of your components
import { guestRoutes, privateRoutes } from "./routes/routes";
import AuctionNotification from "./utils/AuctionNotification";
import NotFound from "./pages/errors/NotFound";

class App extends Component {
    // State initialization if needed
    constructor(props) {
        super(props);
        this.state = {
            guestRoutes,
            privateRoutes,
        };
    }

    componentDidMount() {
        if (Notification.permission === "default") {
            Notification.requestPermission();
        }
    }

    render() {
        const { guestRoutes, privateRoutes } = this.state;

        return (
            <div className="d-flex flex-column min-vh-100">
                <Router>
                    <Header />

                    <main className="flex-grow-1">
                        <Routes>
                            {/* Guest Only Routes */}
                            {guestRoutes.map(({ path, Component }) => (
                                <Route
                                    key={path}
                                    path={path}
                                    element={
                                        <GuestRoute>
                                            <Component />
                                        </GuestRoute>
                                    }
                                />
                            ))}

                            {/* Private only */}
                            {privateRoutes.map(({ path, Component }) => (
                                <Route
                                    key={path}
                                    path={path}
                                    element={
                                        <PrivateRoute>
                                            <Component />
                                            {["", "/"].includes(path) && (
                                                <AuctionNotification />
                                            )}
                                        </PrivateRoute>
                                    }
                                />
                            ))}

                            {/* Catch-All Route for 404 */}
                            <Route path="*" element={<NotFound />} />
                        </Routes>
                    </main>
                    <Footer />
                </Router>
            </div>
        );
    }
}

export default App;
