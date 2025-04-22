"use client";

import React from "react";
import { Box, Avatar, Typography, IconButton } from "@mui/material";
import Link from "next/link";

// Define props interface for type safety
interface UserProfileCardProps {
  name: string;
  role: string;
}

const ProfileLogout: React.FC<UserProfileCardProps> = ({
  name,
  role,
}) => {
  return (
    <Box
      marginInline={1}
      sx={{
        display: "flex",
        alignItems: "center",
        gap: 2,
        p: 2,
        bgcolor: "background.paper",
        borderRadius: 1,
        boxShadow: 1,
      }}
    >
      {/* Avatar */}
      <Avatar
        src="/images/profile/user-1.jpg"
        alt="image"
        sx={{ width: 40, height: 40 }}
      />

      {/* Name and Role */}
      <Box sx={{ flexGrow: 1 }}>
        <Typography variant="h6">
          {name}
        </Typography>
        <Typography variant="caption" color="text.secondary">
          {role}
        </Typography>
      </Box>
    </Box>
  );
};

export default ProfileLogout;