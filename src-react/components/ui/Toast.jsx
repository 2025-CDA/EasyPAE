import { CircleAlert, CircleCheck, CircleX } from "lucide-react";
import React, { useEffect, useState } from "react";

function Toast({ message, type }) {
    const [show, setShow] = useState[false];
    useEffect(() => {
        setTimeout(() => {
            setShow(false);
        }, 3000);
    }, [message]);




    return (
        <div
            className=" max-w-xs bg-white border border-gray-200 rounded-xl shadow-lg dark:bg-neutral-800 dark:border-neutral-700"
            role="alert"
            tabindex="-1"
            aria-labelledby="hs-toast-normal-example-label"
        >
            <div className={` p-4 ${show ? "flex" : "hidden"}`}>
                <div className="shrink-0">
                    {type === "info" ? (
                        <CircleAlert className="text-blue-700" />
                    ) : type === "error" ? (
                        <CircleX className="text-red-700" />
                    ) : type === "warning" ? (
                        <CircleAlert className="text-yellow-500" />
                    ) : (
                        <CircleCheck className="text-green-600" />
                    )}
                </div>
                <div className="ms-3">
                    <p
                        id="hs-toast-normal-example-label"
                        className="text-sm text-gray-700 dark:text-neutral-400"
                    >
                        {message}
                    </p>
                </div>
            </div>
        </div>
    );
}

export default Toast;
