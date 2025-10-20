import React from "react";

function Badge({ label, color = "red" }) {
    return (
        <span
            className={`inline-flex items-center gap-x-1.5 py-1.5 px-3 rounded-full text-xs font-medium bg-${color}-100 text-${color}-500 text-xs font-medium text-center`}
        >
            <span
                className={`size-1.5 inline-block rounded-full bg-${color}-500`}
            ></span>
            {label}
        </span>
    );
}

export default Badge;
