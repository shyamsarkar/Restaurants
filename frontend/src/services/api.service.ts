import api from '@/lib/axios';
import { AxiosError } from 'axios';

interface ApiRequestParams {
  method: 'get' | 'post' | 'put' | 'patch' | 'delete'
  url: string
  data?: unknown
  params?: unknown
}

export const apiClient = async <TResponse>({
  method,
  url,
  data,
  params
}: ApiRequestParams): Promise<TResponse> => {
  try {
    const response = await api.request<TResponse>({
      method,
      url,
      data,
      params
    })

    return response.data
  } catch (error) {
    const err = error as AxiosError<{ message?: string }>
    throw err
  }
}

export const loginUser = async (email: string, password: string) => {
  return apiClient<{ user: unknown }>({
    method: 'post',
    url: '/sign_in',
    data: {
      session: {
        email,
        password,
      },
    },
  });
};