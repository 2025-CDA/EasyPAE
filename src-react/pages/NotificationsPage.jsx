import React from "react";
import  { useState, useEffect } from "react";
import Notification from "../components/ui/Notification";
import Alerts from "../components/ui/Alerts";
import MainLayout from "../components/layout/MainLayout";
import { useAuthContext } from "../store/auth_context/authContext";
import useAxios from "../hooks/useAxios";


function NotificationsPage() {
//---------------------------------- States et Context ---------------------------------------------
    const [notifications, setNotifications] = useState([]);
    const [alerts, setAlerts] = useState([]);
    const { userData,  } = useAuthContext();
    const { fetchData } = useAxios();
    

    const idtest = userData['@id'].split('/')[3];

//---------------------------------- Fetch Notifications ---------------------------------------------    
    useEffect(() => {
        const fetchDataNotif = async ()  => {
          try {
            // Fetch notifications from API
            const response = await fetchData('GET','notifications/user/'+idtest);
            setNotifications(response.data.notifications);
            console.log("🚀 ~ fetchDataNotif ~ response:", response.data.notifications)

            // Extract alerts from notifications
            const alertsFromNotifications = response.data.notifications.map(not => {
            return {
                message: not.message,
                title: not.title,  
              };
            });
            setAlerts(alertsFromNotifications);


          } catch (error) {
            console.error("Erreur lors du chargement des données :", error);
          } 
        };
        fetchDataNotif();
      }, []);

    
//---------------------------------- Return ---------------------------------------------
    return (
        <MainLayout withFooter={false} withMainHeader={false}>
            <div className="flex flex-col gap-5 md:bg-primary md:max-w-[455px] md:p-5 p-8 w-full h-full overflow-y-scroll border border-l-amber-50">
                <h1 className="md:text-white text-center md:text-left font-semibold">
                    Notifications
                </h1>

                {alerts.map((alert, i) => (
                    <Alerts
                        key={i}
                        message={alert.message}
                        title={alert.title}
                        type={"success"}
                        show={true}
                        onClose={() => console.log("test")}
                    ></Alerts>
                ))}

                {notifications.map((not, i) => (
                    <Notification
                        key={i}
                        message={not.message}
                        title={not.title}
                        type={"action"}
                        show={true}
                        onClose={() => console.log("test")}
                    ></Notification>
                ))}

            </div>
        </MainLayout>
    );
}

export default NotificationsPage;
