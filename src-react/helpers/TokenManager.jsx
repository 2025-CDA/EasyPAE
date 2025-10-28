export class TokenManager {
    constructor() {
        this.token = null;
    }
    setToken(token) {
        if (typeof token != "string") {
            throw new Error("Token must be a string");
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

    hasToken() {
        const token = this.getToken();
        return token ? true : false;
    }
}
