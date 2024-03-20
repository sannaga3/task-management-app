import apiClient from "@/lib.js";
import { defineStore } from "pinia";

export const useAggregateStore = defineStore({
    id: "aggregate",
    state: () => ({
        aggregate: {},
    }),
    getters: {
        getAggregate: (state) => state.aggregate,
    },
    actions: {
        async searchAggregate() {
            try {
                const res = await apiClient.get("/api/search_aggregate");
                if (res?.aggregate) this.aggregate = res.aggregate;
            } catch (error) {
                if (error.res) {
                    console.error("failed:", error.response.data);
                } else {
                    console.error("failed:", error.message);
                }
                throw new Error("failed");
            }
        },
    },
});
