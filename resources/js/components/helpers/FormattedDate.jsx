import React from "react";
import moment from "moment";

const FormattedDate = ({ date }) => {
    if (!date) return <span>-</span>;

    // const isToday = moment(date).isSame(moment(), "day");
    const isToday = moment(date).isSame(moment(), "day"); // true if today is April 26, 2025
    const isTomorrow = moment(date).isSame(moment().add(1, "day"), "day"); // true if today is April 26, 2025 + 1 day
    const diff = moment(date).toNow(true); // removes "ago"
    const label = isToday ? (
        <span className="text-danger fw-semibold">ends soon in ({diff})</span>
    ) : (
        <span
            className={`${
                isTomorrow ? "text-danger" : "text-secondary"
            } fw-semibold`}
        >
            {moment(date).format("MMM D, YYYY")}
        </span>
    );

    return <span>{label}</span>;
};

export default FormattedDate;
