import Login from "../auth/Login";
import Register from "../auth/Register";
import AuctionList from "../pages/AuctionList";

export const guestRoutes = [
    {
        path: "/login",
        Component: Login,
    },
    // {
    //     path: "/register",
    //     Component: Register,
    // },
];

export const privateRoutes = [
    {
        path: "/",
        Component: AuctionList,
    },
];
