'use client';
import { Typography } from '@mui/material';
import PageContainer from '@/app/(DashboardLayout)/components/container/PageContainer';
import DashboardCard from '@/app/(DashboardLayout)/components/shared/DashboardCard';


import React from 'react';
import { useFormik } from 'formik';
import * as yup from 'yup';
import { TextField } from '@mui/material';

import { Box, Button, Stack } from '@mui/material';
import api from '@/utils/axios';


const UserPage = () => {

  const validationSchema = yup.object({
    name: yup.string().required('Unit Name is required'),
  });

  const formik = useFormik({
    initialValues: {
      name: '',
    },
    validationSchema,
    onSubmit: async (values, { resetForm }) => {
      try {
        await api.post('/api/units', { unit: values });
        resetForm();
      } catch (error) {
        console.error('Error creating unit:', error);
      }
    },
  });

  return (
    <PageContainer title="Users" description="Add all the units for items">
      <DashboardCard title="Users">
        <Typography>Users</Typography>
      </DashboardCard>
    </PageContainer>
  );
};

export default UserPage;
