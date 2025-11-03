import React from "react";
import Notification from "../components/ui/Notification";
import Alerts from "../components/ui/Alerts";
import MainLayout from "../components/layout/MainLayout";

function NotificationsPage({
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
        <MainLayout withFooter={false} withMainHeader={false}>
            <div className="flex flex-col gap-5 md:bg-primary md:max-w-[455px] md:p-5 p-8 w-full h-full overflow-y-scroll border border-l-amber-50">
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
        </MainLayout>
    );
}

export default NotificationsPage;
