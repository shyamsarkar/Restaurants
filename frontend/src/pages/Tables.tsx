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
  createDiningTable,
  deleteDiningTable,
  DiningTable,
  getDiningTables,
  updateDiningTable,
} from "@/services/api.service";

import { formatUTCToTimeZone } from "@/lib/helper";

import { Alert, Button } from "@mui/material";

const tableSchema = z.object({
  name: z.string().min(1, "Table name is required"),
});

export const Tables = () => {
  const [tableName, setTableName] = useState("");
  const [tables, setTables] = useState<DiningTable[]>([]);
  const [openToastr, setOpenToastr] = useState(false);
  const [editingId, setEditingId] = useState<number | null>(null);

  const fetchTables = async () => {
    const tableData = await getDiningTables();
    setTables(tableData);
  };

  const handleSubmit = async (e: React.FormEvent) => {
    e.preventDefault();

    const result = tableSchema.safeParse({ name: tableName });

    if (!result.success) {
      return;
    }

    try {
      if (editingId !== null) {
        await updateDiningTable(editingId, { name: tableName });
      } else {
        await createDiningTable({ name: tableName });
      }

      fetchTables();
      resetForm();
    } catch {
      setOpenToastr(true);
    }
  };

  const handleToastrClose = () => setOpenToastr(false);

  useEffect(() => {
    fetchTables();
  }, []);

  const resetForm = () => {
    setTableName("");
    setEditingId(null);
  };

  const handleEdit = (table: DiningTable) => {
    setEditingId(table.id);
    setTableName(table.name);
  };

  const handleDelete = async (id: number) => {
    if (confirm("Are you sure you want to delete this table?")) {
      try {
        await deleteDiningTable(id);
        fetchTables();
      } catch {
        setOpenToastr(true);
      }
    }
  };

  return (
    <div className="space-y-8">
      <div>
        <h1 className="text-3xl font-bold text-gray-900 mb-2">Tables</h1>
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
                  {editingId ? "Edit Table" : "Add Table"}
                </h2>
                <p className="text-sm text-gray-500">Create a new table</p>
              </div>
            </div>

            <form onSubmit={handleSubmit} className="space-y-4">
              <div>
                <label
                  htmlFor="menuName"
                  className="block text-sm font-medium text-gray-700 mb-2"
                >
                  Table Name *
                </label>
                <input
                  type="text"
                  id="tableName"
                  value={tableName}
                  onChange={(e) => setTableName(e.target.value)}
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
                  {editingId ? "Update Table" : "Create Table"}
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
              {tables.map((table) => (
                <div
                  key={table.id}
                  className="flex items-center justify-between p-2 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors duration-200 group"
                >
                  <div className="flex items-center gap-3">
                    <div className="w-2 h-2 bg-blue-500 rounded-full"></div>
                    <div>
                      <span className="font-medium text-gray-900">
                        {table.name}
                      </span>
                      <p className="text-xs text-gray-500 mt-1">
                        Added at {formatUTCToTimeZone(table.created_at)}
                      </p>
                    </div>
                  </div>
                  <div>
                    <IconButton onClick={() => handleEdit(table)}>
                      <Edit />
                    </IconButton>
                    <IconButton onClick={() => handleDelete(table.id)}>
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
