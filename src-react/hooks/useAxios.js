import { useState } from "react";
import axios from "axios";

export default function useAxios() {
    const [data, setData] = useState(null);
    const [loading, setLoading] = useState(false);
    const [error, setError] = useState(null);

    const baseUrl = import.meta.env.VITE_DB_URL;

    const fetchData = async (
        method = "GET",
        url,
        requestData = null,
        options = {}
    ) => {
        setLoading(true);
        setError(null);
        try {
            const response = await axios({
                method,
                url: `${baseUrl}/api/${url}`,
                data: requestData,
                ...options,
            });

            setData(response.data);
            return { success: true, data: response.data };
        } catch (err) {
            setError(err);
            return { success: false, error: err };
        } finally {
            setLoading(false);
        }
    };

    return { data, loading, error, fetchData };
}
