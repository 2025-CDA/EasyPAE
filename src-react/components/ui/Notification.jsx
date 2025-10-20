import { useState } from "react";
import { CircleX, CircleCheck, X, Info, CloudUpload } from "lucide-react";

const Notification = ({
    message,
    title,
    type, // "error", "success", "warning", "info"
    show: showProp = true,
    onClose,
}) => {
    const [show, setShow] = useState(showProp);

    if (!show) return null;

    // ------------------------- declarer les const pour les icon de chaque alert -----------------------------
    const icons = {
        error: (
            <CircleX className=" rounded-full border-6 border-red-100 text-red-800" />
        ),
        success: (
            <CircleCheck className=" rounded-full  border-6 border-teal-100 bg-teal-200 text-teal-800" />
        ),
        action: <Info className=" w-4  text-gray-600  " />,
        info: <Info className="w-4 text-primary" />,
        uploadSuccess: (
            <span className="w-5 h-5 flex items-center justify-center rounded-full bg-gray-50">
                <CloudUpload className="w-3 h-3 text-primary" />
            </span>
        ),
    };

    // ----------------------- Style adapté selon le type d'alerte (exemple simple, CSS/Tailwind) ---------------------------
    const typeClasses = {
        error: "bg-red-100 border border-red-200 rounded-lg p-4  text-red-800",
        success:
            "bg-teal-100 border border-teal-200 rounded-lg p-4 text-teal-800 ",
        action: "bg-blue-100 border border-blue-200 rounded-lg p-4 text-gray-800  ",
        info: "bg-gray-50  border border-gray-200 rounded-lg shadow-lg p-4  text-gray-500 ",
        uploadSuccess:
            "bg-primary text-white  border border-gray-200 rounded-lg shadow-lg p-4  text-gray-500 ",
    };
    // ----------------------- return ---------------------------
    return (
        <div
            className={`${typeClasses[type]} p-4 relative`}
            role="notification"
            tabIndex={0}
            aria-labelledby="notification-title"
        >
            <div className="flex mr-7">
                <div className="shrink-0 flex">{icons[type] || null}</div>
                <div className="ms-3 pt-1">
                    <h5 id="alert-title" className="font-semibold">
                        {title}
                    </h5>
                    <ul className="">
                        <li>
                            <span>{message}</span>
                        </li>
                    </ul>
                </div>
            </div>
            {/*----- condition pour affiche le bouton close que sur la notification success---- */}
            {(type === "success" || type === "uploadSuccess") && (
                <button
                    className="absolute top-2 right-2 p-1"
                    aria-label="Fermer"
                    onClick={() => {
                        setShow(false);
                        if (onClose) onClose();
                    }}
                >
                    <X className="w-3 text-current" />
                </button>
            )}
            {/*----- condition pour affiche "allow" et "don't allow" sur la notification Action---- */}
            {type === "action" && (
                <div class="flex gap-x-3 ml-7 mt-2">
                    <button
                        type="button"
                        class="inline-flex items-center gap-x-2 text-xs font-semibold   text-primary hover:text-blue-800  focus:text-blue-800 disabled:pointer-events-none"
                    >
                        Don't allow
                    </button>
                    <button
                        type="button"
                        class="inline-flex  items-center gap-x-2 text-xs font-semibold  text-primary hover:text-blue-800  focus:text-blue-800  disabled:pointer-events-none "
                    >
                        Allow
                    </button>
                </div>
            )}
        </div>
    );
};

export default Notification;
