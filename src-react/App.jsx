import { useEffect } from "react";
import { Route, Routes } from "react-router";
import { useAuthContext } from "./store/auth_context/authContext";
import LoginPage from "./pages/security/LoginPage";
import LoadingModal from "./pages/security/LoadingModal";
import ErrorPage from "./pages/security/ErrorPage";
import Dashboard from "./pages/Dashboard";

export default function App() {
    const { signOut, token, userData, getUser, loadingUser } = useAuthContext();

    useEffect(() => {
        getUser();
        // signOut();
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
                            {["company", "intern"].some((role) =>
                                userData?.roles.includes(role)
                            ) && (
                                <>
                                    <Route
                                        path="/dashboardIntern"
                                        element={App}
                                    ></Route>
                                    <Route
                                        path="/paeApplication"
                                        element={App}
                                    ></Route>
                                    <Route
                                        path="/informationSheet"
                                        element={App}
                                    ></Route>
                                </>
                            )}
                            {["company", "intern"].some(
                                (role) => !userData?.roles.includes(role)
                            ) && (
                                <>
                                    <Route
                                        index
                                        path="/"
                                        element={<Dashboard />}
                                    ></Route>
                                    <Route
                                        path="/listInterns"
                                        element={App}
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
                                    {userData?.roles.includes("SuperAdmin") && (
                                        <Route
                                            path="/superAdmin"
                                            element={App}
                                        ></Route>
                                    )}
                                </>
                            )}
                            <Route path="/notifications" element={App}></Route>
                            <Route path="/help" element={App}></Route>
                            <Route path="/myAccount" element={App}></Route>
                            <Route path="*" element={<ErrorPage />}></Route>
                        </Routes>
                    )}
                </>
            )}
        </>
    );
}
