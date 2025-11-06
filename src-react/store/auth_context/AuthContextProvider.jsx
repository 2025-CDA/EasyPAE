import { useState } from "react";
import { AuthContext } from "./authContext";
import useAxios from "../../hooks/useAxios";
import { TokenManager } from "../../helpers/TokenManager";
import { toast } from "react-toastify";

export default function AuthContextProvider({ children }) {
    const [token, setToken] = useState(null);
    const [userData, setUserData] = useState(null);
    const [loadingUser, setLoadingUser] = useState(false);
    const { error, fetchData } = useAxios();
    const tokenManager = new TokenManager();

    const signIn = async (userName, password) => {
        setLoadingUser(true);
        try {
            const res = await fetchData("POST", "login", {
                username: userName,
                password: password,
            });
            setToken(res.data.token);
            tokenManager.setToken(res.data.token);
            await getUser();
            setLoadingUser(false);
        } catch (error) {
            setLoadingUser(false);
            toast.error("Nom d'utilisateur ou mot de passe incorrect !");
            return error;
        }
    };

    const signOut = () => {
        setLoadingUser(true);
        if (tokenManager.getToken()) {
            tokenManager.clearToken();
            setToken(null);
            setUserData(null);
            setLoadingUser(false);
        } else {
            setLoadingUser(false);
            return new Error("You are not signed in!");
        }
        window.location.href = "/";
    };

    const getUser = async () => {
        setLoadingUser(true);
        const token = tokenManager.getToken();
        if (token) {
            const decodedToken = tokenManager.decodeToken(token);
            const res = await fetchData("GET", `user/${decodedToken.id}`);
            const updatedData = {
                ...res.data,
                id: res.data["@id"].split("/")[3],
                internId: decodedToken.intern_member_id,
                organizationMemberId: decodedToken.organization_member_id,
                companyMemberId: decodedToken.company_member_id,
            };
            setToken(token);
            setUserData(updatedData);
            setLoadingUser(false);
        } else {
            setLoadingUser(false);
            return new Error("There is no signed in users!");
        }
    };

    const value = {
        token: token,
        userData: userData,
        loadingUser: loadingUser,
        error: error,
        signIn: signIn,
        signOut: signOut,
        getUser: getUser,
    };
    return (
        <AuthContext.Provider value={value}>{children}</AuthContext.Provider>
    );
}
