import { createContext, useContext } from "react";

export const AuthContext = createContext({
    token: null,
    userData: {},
    loadingUser: true,
    error: null,
    signIn: () => {},
    signUp: () => {},
    signOut: () => {},
    getUser: () => {},
});

export const useAuthContext = () => {
    return useContext(AuthContext);
};
