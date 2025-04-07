import axios from "axios";
const backendUrl = process.env.REACT_APP_BACKEND_URL;

const axiosApi = axios.create({
    baseURL: backendUrl, // Replace with your base URL
    timeout: 5000, // Set the timeout for requests (optional)
});
// headers: {
//     'Authorization': `Bearer ${yourAccessToken}`, // Replace with your actual token
// },

(() => {
    const token = "";
    token ? axiosApi.defaults.headers.common['Authorization'] = `Bearer ${token}` : delete axiosApi.defaults.headers.common['Authorization'];
})();

export const get = async (url, kwargs = {}) => {
    return await axiosApi.get(url, { ...kwargs }).then((resp) => resp.data);
};

export const post = async (url, data, kwargs = {}) => {
    return await axiosApi.post(url, { ...data }, { ...kwargs }).then((resp) => resp.data);
}

export const patch = async (url, data, kwargs = {}) => {
    return await axiosApi.patch(url, { ...data }, { ...kwargs }).then((resp) => resp.data);
}

export const put = async (url, data, kwargs = {}) => {
    return await axiosApi.put(url, { ...data }, { ...kwargs }).then((resp) => resp.data);
}

export const del = async (url, kwargs = {}) => {
    return await axiosApi.delete(url, { ...kwargs }).then((resp) => resp.data);
}
