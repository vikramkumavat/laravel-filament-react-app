import PropTypes from "prop-types";
import { FontAwesomeIcon } from "@fortawesome/react-fontawesome";
import {
    faCalendarCheck,
    faIndianRupee,
    faMapMarkerAlt,
    faSquarePlus,
    faUserAlt,
} from "@fortawesome/free-solid-svg-icons";
import FormattedDate from "../../helpers/FormattedDate";
import moment from "moment";

const AuctionCard = ({ auction }) => {
    return (
        <div className="col-md-12 col-lg-12 mb-3">
            <div className="card h-100 shadow-sm border-0">
                {/* Header Section with background */}
                <div className="bg-primary text-white p-3 rounded-top position-relative">
                    {auction?.property?.type?.name && (
                        <span className="badge bg-light text-dark fw-semibold position-absolute top-0 end-0 m-2">
                            {auction.property.type.name}
                        </span>
                    )}
                    <div>
                        <span className="h5">Auction #{auction?.id} </span>
                        {auction?.description &&
                            ` - ${auction.description}`}{" "}
                    </div>
                    {/* {auction?.description && (
                        <p className="mb-0 small text-white-50">
                            {auction.description}
                        </p>
                    )} */}
                </div>

                {/* Card Body */}
                <div className="card-body">
                    <ul className="list-unstyled row row-cols-2 gx-3 gy-2 small mb-3">
                        {auction?.property?.owner_name && (
                            <li className="col d-flex align-items-center">
                                <FontAwesomeIcon
                                    icon={faUserAlt}
                                    className="me-2 text-secondary"
                                />
                                <span>
                                    <strong>Borrower:</strong>{" "}
                                    {auction.property.owner_name}
                                </span>
                            </li>
                        )}

                        {auction?.location && (
                            <li className="col d-flex align-items-center">
                                <FontAwesomeIcon
                                    icon={faMapMarkerAlt}
                                    className="me-2 text-danger"
                                />
                                <span>
                                    <strong>Location:</strong>{" "}
                                    {auction.location}
                                </span>
                            </li>
                        )}

                        {auction?.property?.price && (
                            <li className="col d-flex align-items-center">
                                <FontAwesomeIcon
                                    icon={faIndianRupee}
                                    className="me-2 text-success"
                                />
                                <span>
                                    <strong>Price:</strong> ₹
                                    {auction.property.price}
                                </span>
                            </li>
                        )}

                        {auction?.property?.sq_ft && (
                            <li className="col d-flex align-items-center">
                                <FontAwesomeIcon
                                    icon={faSquarePlus}
                                    className="me-2 text-info"
                                />
                                <span>
                                    <strong>Area:</strong>{" "}
                                    {auction.property.sq_ft} sq ft
                                </span>
                            </li>
                        )}
                    </ul>

                    {auction?.start_time && (
                        <div className="pt-2 border-top small text-muted d-flex align-items-center">
                            <FontAwesomeIcon
                                icon={faCalendarCheck}
                                className={`me-2 text-warning ${
                                    moment(auction.start_time).isSame(
                                        moment().add(1, "day"),
                                        "day"
                                    )
                                        ? "shake"
                                        : ""
                                }`}
                            />
                            <span>
                                <strong>Starts:</strong>{" "}
                                <FormattedDate date={auction.start_time} />
                            </span>
                        </div>
                    )}
                </div>
            </div>
        </div>
    );
};

AuctionCard.defaultProps = {
    auction: {},
};

AuctionCard.propTypes = {
    auction: PropTypes.object,
};

export default AuctionCard;
