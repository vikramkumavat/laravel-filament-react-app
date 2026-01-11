import { createRoot } from "react-dom/client";
import App from "./components/App.jsx";
import "bootstrap/dist/css/bootstrap.min.css";
import "bootstrap/dist/js/bootstrap.bundle.min";
import { UserProvider } from "./components/contexts/UserContext.js";

const container = document.getElementById("app");

if (container) {
    const root = createRoot(container);
    root.render(
        <UserProvider>
            <App />
        </UserProvider>
    );
} else {
    console.error("React root container not found");
}
