import React, { useEffect, useState } from "react";
import { Add as AddIcon, Delete, Edit } from "@mui/icons-material";

import Grid from "@mui/material/Grid";
import IconButton from "@mui/material/IconButton";

import { Button, Card } from "@mui/material";
import {
  createMenuItem,
  updateMenuItem,
  deleteMenuItem,
  getMenuItems,
  getMenus,
  Menu,
  MenuItem,
} from "@/services/api.service";

export const Items: React.FC = () => {
  const [itemName, setItemName] = useState("");
  const [price, setPrice] = useState<number | string>("");
  const [selectedMenuId, setSelectedMenuId] = useState("");
  const [editingId, setEditingId] = useState<number | null>(null);

  const [menus, setMenus] = useState<Menu[]>([]);
  const [menuItems, setMenuItems] = useState<MenuItem[]>([]);

  const fetchMenus = async () => {
    const menuData = await getMenus();
    setMenus(menuData);
  };

  const fetchMenuItems = async () => {
    const menuItemsData = await getMenuItems();
    setMenuItems(menuItemsData);
  };

  useEffect(() => {
    fetchMenus();
    fetchMenuItems();
  }, []);

  const resetForm = () => {
    setItemName("");
    setPrice("");
    setSelectedMenuId("");
    setEditingId(null);
  };

  const handleSubmit = async (e: React.FormEvent) => {
    e.preventDefault();

    if (!itemName || !selectedMenuId || !price) {
      alert("All fields are required.");
      return;
    }

    const payload = {
      name: itemName,
      price: parseFloat(price.toString()),
      menu_id: selectedMenuId,
    };

    try {
      if (editingId !== null) {
        await updateMenuItem(editingId, payload);
      } else {
        await createMenuItem(payload);
      }

      resetForm();
      fetchMenuItems();
    } catch (err) {
      console.error("Failed to submit item", err);
      alert("Something went wrong");
    }
  };

  const handleEdit = (item: MenuItem) => {
    setEditingId(item.id);
    setItemName(item.name);
    setPrice(item.price);
    setSelectedMenuId(item.menu_id.toString());
  };

  const handleDelete = async (id: number) => {
    if (!confirm("Are you sure you want to delete this item?")) return;
    try {
      await deleteMenuItem(id);
      fetchMenuItems();
    } catch (err) {
      console.error("Failed to delete item", err);
      alert("Delete failed.");
    }
  };

  return (
    <div className="bg-white rounded-xl shadow-sm border border-gray-100 p-8">
      <Grid container spacing={2}>
        <Grid size={4}>
          <div className="flex items-center gap-3 mb-6">
            <div className="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
              <AddIcon className="text-blue-600" fontSize="small" />
            </div>
            <div>
              <h2 className="text-xl font-semibold text-gray-900">
                Add New Item
              </h2>
              <p className="text-sm text-gray-500">
                Add an item to one of your menus
              </p>
            </div>
          </div>

          <form onSubmit={handleSubmit} className="space-y-6">
            <div>
              <label
                htmlFor="itemName"
                className="block text-sm font-medium text-gray-700 mb-2"
              >
                Item Name
              </label>
              <input
                type="text"
                id="itemName"
                value={itemName}
                onChange={(e) => setItemName(e.target.value)}
                placeholder="Enter item name..."
                className="w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 outline-none placeholder-gray-400"
                required
              />
            </div>

            <div>
              <label
                htmlFor="itemPrice"
                className="block text-sm font-medium text-gray-700 mb-2"
              >
                Price
              </label>
              <input
                type="number"
                id="itemPrice"
                value={price}
                onChange={(e) => setPrice(e.target.value)}
                placeholder="Enter price..."
                className="w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none placeholder-gray-400"
                required
              />
            </div>

            <div>
              <label
                htmlFor="menuSelect"
                className="block text-sm font-medium text-gray-700 mb-2"
              >
                Select Menu
              </label>
              <select
                id="menuSelect"
                value={selectedMenuId}
                onChange={(e) => setSelectedMenuId(e.target.value)}
                className="w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 outline-none bg-white"
                required
              >
                <option value="">Choose a menu...</option>
                {menus.map((menu) => (
                  <option key={menu.id} value={menu.id}>
                    {menu.name}
                  </option>
                ))}
              </select>
            </div>

            <Button
              type="submit"
              variant="contained"
              className="flex-1"
              startIcon={<AddIcon />}
            >
              Add Item
            </Button>
          </form>
        </Grid>
        <Grid size={8}>
          <Card className="p-4">
            <div className="space-y-3">
              {menuItems.map((item) => (
                <div
                  key={item.id}
                  className="flex items-center justify-between p-2 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors duration-200 group"
                >
                  <div className="flex items-center gap-3">
                    <div className="w-2 h-2 bg-blue-500 rounded-full"></div>
                    <div>
                      <span className="font-medium text-gray-900">
                        {item.name}
                      </span>
                      <p className="text-xs text-gray-500 mt-1">
                        Added at 10/10/2023 12:00 PM
                      </p>
                    </div>
                  </div>
                  <div>
                    <IconButton onClick={() => handleEdit(item)}>
                      <Edit />
                    </IconButton>
                    <IconButton onClick={() => handleDelete(item.id)}>
                      <Delete />
                    </IconButton>
                  </div>
                </div>
              ))}
            </div>
          </Card>
        </Grid>
      </Grid>
    </div>
  );
};
