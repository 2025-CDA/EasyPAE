import React from "react";

export default function Container({ children, className, ...props }) {
    return (
        <div
            {...props}
            className={`flex rounded-lg  border border-[#B9B9B9] p-2 ${className}`}
        >
            {children}
        </div>
    );
}
