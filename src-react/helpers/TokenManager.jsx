export class TokenManager {
    constructor() {
        this.token = null;
    }
    setToken(token) {
        if (typeof token != "string") {
            throw new Error("Token must be a string!");
        }
        localStorage.setItem("easyPAEToken", token);
        this.token = token;
        return token;
    }

    getToken() {
        if (this.token) return this.token;
        this.token = localStorage.getItem("easyPAEToken");
        return this.token;
    }

    clearToken() {
        localStorage.removeItem("easyPAEToken");
        this.token = null;
    }

    decodeToken(token) {
        const [, payloadB64] = token.split(".");
        const payloadJson = atob(
            payloadB64.replace(/-/g, "+").replace(/_/g, "/")
        );
        return JSON.parse(decodeURIComponent(escape(payloadJson)));
    }
}
