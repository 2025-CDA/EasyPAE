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
import InternListPage from "./components/intern_list/InternListPage";
import FormInternPage from "./pages/intern/FormInternPage";

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
                            {(userData?.roles.includes("intern") ||
                                userData?.roles.includes("company")) && (
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
                                        path="/paeApplication"
                                        element={<FormInternPage />}
                                    />
                                    <Route
                                        path="/informationSheet"
                                        element={App}
                                    />
                                </>
                            )}

                            {["organization"].some((role) =>
                                [userData?.roles].includes(role)
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
                                        element={App}
                                    ></Route>
                                    <Route
                                        path="/interForm"
                                        element={App}
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
