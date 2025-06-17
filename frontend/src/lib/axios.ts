import { useAuthStore } from '@/stores/auth.store';
import axios, { AxiosError } from 'axios';

const api = axios.create({
  baseURL: import.meta.env.VITE_API_BASE_URL,
  headers: {
    'Content-Type': 'application/json',
    'Accept': 'application/json',
  },
  withCredentials: true,
});

api.interceptors.request.use(
  (response) => response,
  (error: AxiosError) => {
    const status = error.response?.status;

    if (status === 401) {
      useAuthStore.getState().setUser(null);
      window.location.href = '/login';
    }

    if (status === 403) {
      window.history.back();
    }

    return Promise.reject(error);
  }
);



export default api;
