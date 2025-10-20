import React from "react";
import Notification from "./Notification";
import Alerts from "./Alerts";

function NotificationsList({
    notifications = [
        { message: "I am a notification", title: "I am a title", type: "info" },
        {
            message: "I am a notification",
            title: "I am a title",
            type: "success",
        },
        {
            message: "I am a notification",
            title: "I am a title",
            type: "error",
        },
    ],
    alerts = [
        { message: "I am a notification", title: "I am a title", type: "info" },
        {
            message: "I am a notification",
            title: "I am a title",
            type: "success",
        },
        {
            message: "I am a notification",
            title: "I am a title",
            type: "error",
        },
    ],
}) {
    return (
        <div className="flex - flex-col gap-5 md:bg-primary md:max-w-[455px] md:p-5 p-8 w-full h-full overflow-y-scroll">
            <h1 className="md:text-white text-center md:text-left font-semibold">
                Notifications
            </h1>
            {alerts.map((not, i) => (
                <Alerts
                    key={i}
                    message={not.message}
                    title={not.title}
                    type={not.type}
                    show={true}
                    onClose={() => console.log("test")}
                ></Alerts>
            ))}
            {notifications.map((not, i) => (
                <Notification
                    key={i}
                    message={not.message}
                    title={not.title}
                    type={not.type}
                    show={true}
                    onClose={() => console.log("test")}
                ></Notification>
            ))}
        </div>
    );
}

export default NotificationsList;
