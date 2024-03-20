import axios from "axios";
import { defineStore } from "pinia";

export const useAuthStore = defineStore({
    id: "auth",
    state: () => ({
        user: null,
    }),
    getters: {
        isAuthenticated: (state) => !!state.user,
    },
    actions: {
        async login(credentials) {
            try {
                const res = await axios.post("/login", credentials, {
                    headers: {
                        "Content-Type": "application/json",
                    },
                    withCredentials: true,
                });
                if (res?.data?.user) this.user = res.data.user;
            } catch (error) {
                if (error.res) {
                    console.error("Login failed:", error.response.data);
                } else {
                    console.error("Login failed:", error.message);
                }
                throw new Error("Login failed");
            }
        },
        logout() {
            this.user = null;
        },
    },
});
