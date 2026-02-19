import api from "@/lib/axios";
import { AuthUser } from "@/stores/auth.store";
import { AxiosError } from "axios";

interface ApiRequestParams {
  method: "get" | "post" | "put" | "patch" | "delete";
  url: string;
  data?: unknown;
  params?: unknown;
}
export interface User {
  id: number;
  name: string;
  email: string;
  role: string;
  status: string;
  avatar: string;
}

export interface DiningTable {
  id: number;
  name: string;
  created_at: string;
}
export interface Menu {
  id: number;
  name: string;
  created_at: string;
}

export interface MenuItem {
  id: number;
  name: string;
  price: number;
  menu_id: string;
}

type CreateMenuItemDto = {
  name: string;
  price: number;
  menu_id: string;
};

export const apiClient = async <TResponse>({
  method,
  url,
  data,
  params,
}: ApiRequestParams): Promise<TResponse> => {
  try {
    const response = await api.request<TResponse>({
      method,
      url,
      data,
      params,
    });

    return response.data;
  } catch (error) {
    const err = error as AxiosError<{ message?: string }>;
    throw err;
  }
};

export const loginUser = async (email: string, password: string) => {
  return apiClient<{ user: AuthUser, tenant: { id: string, name: string } }>({
    method: "post",
    url: "/users/sign_in",
    data: {
      user: {
        email,
        password,
      },
    },
  });
};

export const logoutUser = async () => {
  return apiClient<void>({
    method: "delete",
    url: "/users/sign_out",
  });
};

export const getUsers = async () => {
  return apiClient<User[]>({
    method: "get",
    url: "/api/v1/users",
  })
}

export const getTenants = async () => {
  return apiClient<{ id: string, name: string }[]>({
    method: "get",
    url: "/api/v1/tenants",
  })
}

export const getDashboardData = async () => {
  return apiClient<void>({
    method: "get",
    url: "/api/dashboard",
  });
};

export const getDiningTables = async () => {
  return apiClient<DiningTable[]>({
    method: "get",
    url: "/api/v1/dining_tables",
  });
};

export const createDiningTable = async (data: { name: string }) => {
  return apiClient<DiningTable>({
    method: "post",
    url: "/api/v1/dining_tables",
    data,
  });
};

export const updateDiningTable = async (
  table_id: number | string,
  data: { name: string }
) => {
  return apiClient<DiningTable>({
    method: "patch",
    url: `/api/dining_tables/${table_id}`,
    data,
  });
};

export const deleteDiningTable = async (table_id: number | string) => {
  return apiClient<DiningTable>({
    method: "delete",
    url: `/api/dining_tables/${table_id}`,
  });
};

export const getMenus = async () => {
  return apiClient<Menu[]>({
    method: "get",
    url: "/api/v1/menus",
  });
};

export const createMenu = async (data: { name: string }) => {
  return apiClient<Menu>({
    method: "post",
    url: "/api/menus",
    data,
  });
};

export const updateMenu = async (
  table_id: number | string,
  data: { name: string }
) => {
  return apiClient<Menu>({
    method: "patch",
    url: `/api/menus/${table_id}`,
    data,
  });
};

export const deleteMenu = async (table_id: number | string) => {
  return apiClient<Menu>({
    method: "delete",
    url: `/api/menus/${table_id}`,
  });
};

export const getMenuItems = async () => {
  return apiClient<MenuItem[]>({
    method: "get",
    url: "/api/v1/items",
  });
};

export const createMenuItem = async (data: CreateMenuItemDto) => {
  return apiClient<MenuItem>({
    method: "post",
    url: "/api/items",
    data,
  });
};

export const updateMenuItem = async (
  table_id: number | string,
  data: { name: string }
) => {
  return apiClient<MenuItem>({
    method: "patch",
    url: `/api/items/${table_id}`,
    data,
  });
};

export const deleteMenuItem = async (table_id: number | string) => {
  return apiClient<MenuItem>({
    method: "delete",
    url: `/api/items/${table_id}`,
  });
};

export const createOrder = async (diningTableId: number) => {
  return apiClient<{ orderId: number }>({
    method: "post",
    url: "/api/orders",
    data: {
      dining_table_id: diningTableId,
    },
  });
};
