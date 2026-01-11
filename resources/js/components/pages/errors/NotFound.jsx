import { Link } from "react-router-dom";

const NotFound = () => {
    return (
        <div className="d-flex align-items-center justify-content-center m-auto">
            <div className="text-center">
                <h1 className="display-1 fw-bold text-danger">404</h1>
                <p className="fs-3">
                    {" "}
                    <span className="text-danger">Oops!</span> Page not found.
                </p>
                <p className="lead">
                    The page you’re looking for doesn’t exist or has been moved.
                </p>
                <Link to="/" className="btn btn-primary">
                    Go Home
                </Link>
            </div>
        </div>
    );
};

export default NotFound;
