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


const UnitPage = () => {

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
    <PageContainer title="Units" description="Add all the units for items">
      <DashboardCard title="Units">
        <form onSubmit={formik.handleSubmit}>
          <Stack>
            <Box>
              <Typography variant="subtitle1" fontWeight={600} marginBottom='5px' marginTop='25px' gutterBottom>
                Unit Name
              </Typography>

              <TextField
                id="name"
                name="name"
                value={formik.values.name}
                onChange={formik.handleChange}
                error={formik.touched.name && Boolean(formik.errors.name)}
                helperText={formik.touched.name && formik.errors.name}
              />
              <Button variant="contained" type="submit">
                Submit
              </Button>
            </Box>
          </Stack>
        </form>
      </DashboardCard>
    </PageContainer>
  );
};

export default UnitPage;
