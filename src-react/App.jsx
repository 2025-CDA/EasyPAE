import { useEffect } from "react";
import { Route, Routes } from "react-router";
import { useAuthContext } from "./store/auth_context/authContext";
import LoginPage from "./pages/security/LoginPage";
import LoadingModal from "./pages/security/LoadingModal";
import ErrorPage from "./pages/security/ErrorPage";
import Dashboard from "./pages/Dashboard";
import ProfilePage from "./pages/profile/ProfilePage";
import HelpPage from "./pages/help/HelpPage";
import NotificationsPage from "./pages/NotificationsPage";

export default function App() {
    const { token, userData, getUser, loadingUser } = useAuthContext();

    useEffect(() => {
        !token && getUser();
    }, [token]);

    // console.log(data[0])

    return <div className="w-full">
        {/* <AssistantPage /> 
        <AssistantFicheRenseignement /> 
        <DemandePae />  */}
        {/* <CalendarSimpleGet justToday={true} /> */}
        
    </div>;
}
