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
import { ToastContainer } from "react-toastify";
import InternDashboardPage from "./pages/intern/InternDashboardPage";
import FicheStagiaire from "./pages/intern/FicheStagiaire";
import InternListPage from "./components/intern_list/InternListPage";
import FormInternPage from "./pages/intern/FormInternPage";
import InformationSheetPage from "./pages/company/InformationSheetPage";

export default function App() {
    const { token, userData, getUser, loadingUser } = useAuthContext();

    useEffect(() => {
        !token && getUser();
    }, [token]);

    // console.log(data[0])
    return (
        <>
            {loadingUser ? (
                <LoadingModal />
            ) : (
                <>
                    {!token && (
                        <Routes>
                            <Route
                                index
                                path="/"
                                element={<LoginPage />}
                            ></Route>
                            <Route path="*" element={<ErrorPage />} />
                        </Routes>
                    )}
                    {token && (
                        <Routes>
                            {userData?.roles.includes("intern") && (
                                <>
                                    <Route
                                        path="/"
                                        element={<InternDashboardPage />}
                                    />
                                    <Route
                                        path="/:infoFormId"
                                        element={<InternDashboardPage />}
                                    />
                                    <Route
                                        path="/paeApplication/:infoFormId"
                                        element={<FormInternPage />}
                                    />
                                </>
                            )}
                            {userData?.roles.includes("company") && (
                                <>
                                    <Route
                                        path="/"
                                        element={<InternDashboardPage />}
                                    />
                                    <Route
                                        path="/:infoFormId"
                                        element={<InternDashboardPage />}
                                    />

                                    <Route
                                        path="/informationSheet/:infoFormId"
                                        element={<InformationSheetPage />}
                                    />
                                </>
                            )}

                            {!(
                                userData?.roles.includes("intern") ||
                                userData?.roles.includes("company")
                            ) && (
                                <>
                                    <Route
                                        index
                                        path="/"
                                        element={<Dashboard />}
                                    ></Route>
                                    <Route
                                        path="/listInterns/:id"
                                        element={<InternListPage />}
                                    ></Route>
                                    <Route
                                        path="/formIntern"
                                        element={App}
                                    ></Route>
                                    <Route
                                        path="/paeCalendar"
                                        element={<CalendarPage />}
                                    ></Route>
                                    <Route
                                        path="/interForm/:id"
                                        element={<FicheStagiaire />}
                                    ></Route>
                                    {[userData?.roles].includes(
                                        "SuperAdmin"
                                    ) && (
                                        <Route
                                            path="/superAdmin"
                                            element={App}
                                        ></Route>
                                    )}
                                </>
                            )}
                            <Route
                                path="/notifications"
                                element={<NotificationsPage />}
                            ></Route>
                            <Route path="/help" element={<HelpPage />}></Route>
                            <Route
                                path="/profile"
                                element={<ProfilePage />}
                            ></Route>
                            <Route path="*" element={<ErrorPage />}></Route>
                        </Routes>
                    )}
                </>
            )}
            <ToastContainer position="top-center" />
        </>
    );
}
