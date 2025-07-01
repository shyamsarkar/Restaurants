import api from '@/lib/axios';
import { AuthUser } from '@/stores/auth.store';
import { AxiosError } from 'axios';

interface ApiRequestParams {
  method: 'get' | 'post' | 'put' | 'patch' | 'delete'
  url: string
  data?: unknown
  params?: unknown
}

export interface DiningTable {
  id: number
  name: string
}

export interface MenuItem {
  id: number
  name: string
  price: number
  menu_id: number
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
  return apiClient<{ user: AuthUser }>({
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

export const logoutUser = async () => {
  return apiClient<void>({
    method: 'delete',
    url: '/sign_out',
  });
};

export const getDashboardData = async () => {
  return apiClient<void>({
    method: 'get',
    url: '/api/dashboard',
  });
}

export const getDiningTables = async () => {
  return apiClient<DiningTable[]>({
    method: 'get',
    url: '/api/dining_tables',
  });
}

export const createDiningTable = async (data: { name: string, description?: string }) => {
  return apiClient<DiningTable>({
    method: 'post',
    url: '/api/dining_tables',
    data,
  });
}

export const getMenuItems = async () => {
  return apiClient<MenuItem[]>({
    method: 'get',
    url: '/api/items',
  });
}

export const addMenuItem = async (diningTableId: number|string, itemId: number|string) => {
  return apiClient<MenuItem>({
    method: 'post',
    url: '/api/items',
    data: {
      dining_table_id: diningTableId,
      item_id: itemId,
    },
  });
}

export const createOrder = async (diningTableId: number) => {
  return apiClient<{ orderId: number }>({
    method: 'post',
    url: '/api/orders',
    data: {
      dining_table_id: diningTableId,
    },
  });
}