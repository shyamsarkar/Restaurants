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
  status: string;
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

export interface OrderItem {
  id: number;
  order_id: number;
  item_id: number;
  quantity: number;
  price: number;
  name?: string;
  sub_total?: number;
}

export interface TableOrderItemsResponse {
  order_id: number | null;
  order_items: OrderItem[];
}

type CreateMenuItemDto = {
  name: string;
  price: number;
  menu_id: string;
  unit?: string;
};

export interface Id {
  id: number | string | null;
}

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
    url: `/api/v1/dining_tables/${table_id}`,
    data,
  });
};

export const deleteDiningTable = async (table_id: number | string) => {
  return apiClient<DiningTable>({
    method: "delete",
    url: `/api/v1/dining_tables/${table_id}`,
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
    url: "/api/v1/menus",
    data,
  });
};

export const updateMenu = async (
  table_id: number | string,
  data: { name: string }
) => {
  return apiClient<Menu>({
    method: "patch",
    url: `/api/v1/menus/${table_id}`,
    data,
  });
};

export const deleteMenu = async (table_id: number | string) => {
  return apiClient<Menu>({
    method: "delete",
    url: `/api/v1/menus/${table_id}`,
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
    url: "/api/v1/items",
    data: {
      ...data,
      unit: data.unit ?? "piece",
    },
  });
};

export const updateMenuItem = async (
  table_id: number | string,
  data: { name: string; price: number; menu_id: string; unit?: string }
) => {
  return apiClient<MenuItem>({
    method: "patch",
    url: `/api/v1/items/${table_id}`,
    data: {
      ...data,
      unit: data.unit ?? "piece",
    },
  });
};

export const deleteMenuItem = async (table_id: number | string) => {
  return apiClient<MenuItem>({
    method: "delete",
    url: `/api/v1/items/${table_id}`,
  });
};

export const getOrderItems = async (orderId: number | string) => {
  return apiClient<OrderItem[]>({
    method: "get",
    url: `/api/v1/orders/${orderId}/items`,
  });
};

export const getOrderItemsByDiningTable = async (diningTableId: number | string) => {
  return apiClient<TableOrderItemsResponse>({
    method: "get",
    url: "/api/v1/order_items",
    params: { dining_table_id: diningTableId },
  });
};

export const addOrderItem = async (
  diningTableId: number | string | null,
  itemId: number | string | null,
  price: number
) => {
  if (!diningTableId || !itemId) {
    throw new Error("Invalid dining table or item.");
  }

  return apiClient<OrderItem>({
    method: "post",
    url: "/api/v1/order_items",
    data: {
      dining_table_id: diningTableId,
      order_item: {
        item_id: itemId,
        price,
      },
    },
  });
};

export const deleteOrderItem = async (orderItemId: number | string) => {
  return apiClient<{ id: number; order_id: number; total_price: number }>({
    method: "delete",
    url: `/api/v1/order_items/${orderItemId}`,
  });
};
