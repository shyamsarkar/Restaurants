import { RouteObject } from 'react-router-dom';

import AdminLayout from '@/components/AdminLayout';
import { RequireAuth } from '@/components/RequireAuth';

import Dashboard from '@/pages/Dashboard';
import Analytics from '@/pages/Analytics';
import Users from '@/pages/Users';
import Projects from '@/pages/Projects';
import Settings from '@/pages/Settings';
import Notification from '@/pages/Notification';
import Reports from '@/pages/Reports';

import { Login } from '@/pages/Login';
import { NotFound } from '@/pages/NotFound';
import { Order } from '@/pages/Order';


export const routes: RouteObject[] = [
  {
    path: '/login',
    element: <Login />,
  },
  {
    element: <RequireAuth><AdminLayout /></RequireAuth>,
    children: [
      { path: '/', element: <Dashboard /> },
      { path: '/orders', element: <Order /> },
      { path: '/analytics', element: <Analytics /> },
      { path: '/users', element: <Users /> },
      { path: '/projects', element: <Projects /> },
      { path: '/reports', element: <Reports /> },
      { path: '/settings', element: <Settings /> },
      { path: '/notification', element: <Notification /> },
    ],
  },
  {
    path: '*',
    element: <NotFound />,
  },
];
