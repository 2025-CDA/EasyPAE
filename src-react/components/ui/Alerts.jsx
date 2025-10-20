import React from "react";
import { TriangleAlert, CircleCheck, X, Info } from "lucide-react";

const Alerts = ({
    message,
    title,
    type, // "error", "success", "warning", "info"
    show = true,
}) => {
    if (!show) return null;
    // ------------------------- declarer les const pour les icon de chaque alert -----------------------------
    const icons = {
        error: (
            <X className=" rounded-full border-6 border-red-100 bg-red-200 text-red-800" />
        ),
        success: (
            <CircleCheck className=" rounded-full  border-6 border-teal-100 bg-teal-200 text-teal-800" />
        ),
        warning: (
            <TriangleAlert className=" w-4 text-yellow-800 bg-yellow-100  " />
        ),
        info: <Info className="w-4 text-gray-500" />,
    };

    // ----------------------- Style adapté selon le type d'alerte (exemple simple, CSS/Tailwind) ---------------------------
    const typeClasses = {
        error: "bg-red-100 border-s-3 border-red-500 rounded-lg p-4  text-red-800",
        success:
            "bg-teal-50 border-t-3 border-teal-500 rounded-lg p-4 text-teal-800 ",
        warning:
            "bg-yellow-100 border border-yellow-200 rounded-lg p-4 text-yellow-800 ",
        info: "bg-gray-50  border border-gray-200 rounded-lg shadow-lg p-4  text-gray-500 ",
    };
    // ----------------------- return ---------------------------
    return (
        <div
            className={`${typeClasses[type]}  p-4`}
            role="alert"
            tabIndex={0}
            aria-labelledby="alert-title"
        >
            <div className="flex">
                <div className="shrink-0 items-center justify-center">
                    {icons[type] || null}
                </div>
                <div className="ms-3">
                    <h5 id="alert-title" className="font-semibold">
                        {title}
                    </h5>
                    <span>{message}</span>
                </div>
            </div>
        </div>
    );
};

export default Alerts;
