const apiClient = {
    async get(url, options = {}) {
        const defaultOptions = {
            method: "GET",
            credentials: "include",
            headers: {
                "X-Requested-With": "XMLHttpRequest",
                "X-XSRF-TOKEN": document.cookie
                    .split("; ")
                    .find((row) => row.startsWith("XSRF-TOKEN"))
                    .split("=")[1],
            },
        };

        const mergedOptions = { ...defaultOptions, ...options };

        try {
            const res = await axios(url, mergedOptions);
            return res.data;
        } catch (error) {
            throw new Error(`API request failed: ${error.message}`);
        }
    },
};

export default apiClient;
