import { useEffect, useState } from "react";

import {
  RestaurantMenu as MenuIcon,
  Add as AddIcon,
  Delete,
  Edit,
} from "@mui/icons-material";

import { z } from "zod";

import IconButton from "@mui/material/IconButton";
import Grid from "@mui/material/Grid";
import Card from "@mui/material/Card";
import Snackbar from "@mui/material/Snackbar";

import {
  createMenu,
  deleteMenu,
  Menu,
  getMenus,
  updateMenu,
} from "@/services/api.service";

import { formatUTCToTimeZone } from "@/lib/helper";

import { Alert, Button } from "@mui/material";

const menuSchema = z.object({
  name: z.string().min(1, "Menu name is required"),
});

export const MenuOption: React.FC = () => {
  const [menuName, setMenuName] = useState("");
  const [menus, setMenus] = useState<Menu[]>([]);
  const [openToastr, setOpenToastr] = useState(false);
  const [editingId, setEditingId] = useState<number | null>(null);

  const fetchMenus = async () => {
    const menuData = await getMenus();
    setMenus(menuData);
  };

  const handleSubmit = async (e: React.FormEvent) => {
    e.preventDefault();

    const result = menuSchema.safeParse({ name: menuName });

    if (!result.success) {
      return;
    }

    try {
      if (editingId !== null) {
        await updateMenu(editingId, { name: menuName });
      } else {
        await createMenu({ name: menuName });
      }

      fetchMenus();
      resetForm();
    } catch {
      setOpenToastr(true);
    }
  };

  const handleToastrClose = () => setOpenToastr(false);

  useEffect(() => {
    fetchMenus();
  }, []);

  const resetForm = () => {
    setMenuName("");
    setEditingId(null);
  };

  const handleEdit = (menu: Menu) => {
    setEditingId(menu.id);
    setMenuName(menu.name);
  };

  const handleDelete = async (id: number) => {
    if (confirm("Are you sure you want to delete this table?")) {
      try {
        await deleteMenu(id);
        fetchMenus();
      } catch {
        setOpenToastr(true);
      }
    }
  };

  return (
    <div className="space-y-8">
      <div>
        <h1 className="text-3xl font-bold text-gray-900 mb-2">Menu</h1>
      </div>
      <Grid container spacing={2}>
        <Grid size={4}>
          <div className="bg-white rounded-xl shadow-sm border border-gray-100 p-8">
            <div className="flex items-center gap-3 mb-6">
              <div className="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                <MenuIcon className="text-blue-600" fontSize="small" />
              </div>
              <div>
                <h2 className="text-xl font-semibold text-gray-900">
                  {editingId ? "Edit Menu" : "Add Menu"}
                </h2>
                <p className="text-sm text-gray-500">Create a new Menu</p>
              </div>
            </div>

            <form onSubmit={handleSubmit} className="space-y-4">
              <div>
                <label
                  htmlFor="menuName"
                  className="block text-sm font-medium text-gray-700 mb-2"
                >
                  Menu Name *
                </label>
                <input
                  type="text"
                  id="tableName"
                  value={menuName}
                  onChange={(e) => setMenuName(e.target.value)}
                  placeholder="Floor 1, Table 1, etc."
                  className="w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-all duration-200 outline-none placeholder-gray-400"
                />
              </div>

              <div className="flex gap-3">
                <Button
                  type="submit"
                  variant="contained"
                  className="flex-1"
                  startIcon={<AddIcon />}
                >
                  {editingId ? "Update Menu" : "Create Menu"}
                </Button>
                {editingId && (
                  <Button variant="outlined" onClick={resetForm}>
                    Cancel
                  </Button>
                )}
              </div>
            </form>
          </div>
        </Grid>
        <Grid size={8}>
          <Card className="p-4">
            <div className="space-y-3">
              {menus.map((menu) => (
                <div
                  key={menu.id}
                  className="flex items-center justify-between p-2 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors duration-200 group"
                >
                  <div className="flex items-center gap-3">
                    <div className="w-2 h-2 bg-blue-500 rounded-full"></div>
                    <div>
                      <span className="font-medium text-gray-900">
                        {menu.name}
                      </span>
                      <p className="text-xs text-gray-500 mt-1">
                        Added at {formatUTCToTimeZone(menu.created_at)}
                      </p>
                    </div>
                  </div>
                  <div>
                    <IconButton onClick={() => handleEdit(menu)}>
                      <Edit />
                    </IconButton>
                    <IconButton onClick={() => handleDelete(menu.id)}>
                      <Delete />
                    </IconButton>
                  </div>
                </div>
              ))}
            </div>
          </Card>
        </Grid>
      </Grid>

      {openToastr && (
        <Snackbar
          open
          autoHideDuration={5000}
          onClose={handleToastrClose}
          anchorOrigin={{ vertical: "bottom", horizontal: "right" }}
        >
          <Alert onClose={handleToastrClose} severity="error" variant="filled">
            Login failed. Please try again.
          </Alert>
        </Snackbar>
      )}
    </div>
  );
};
