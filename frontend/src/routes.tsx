import { RouteObject } from 'react-router-dom';

import AdminLayout from '@/components/AdminLayout';
import { RequireAuth } from '@/components/RequireAuth';

import { HomePage } from '@/pages/HomePage';
import { Login } from '@/pages/Login';
import { NotFound } from '@/pages/NotFound';

import Restaurants from '@/pages/Restaurants';
import { Order } from '@/pages/Order';
import { Tables } from '@/pages/Tables';
import { Items } from '@/pages/Items';
import { Menu } from '@/pages/Menu';
import Analytics from '@/pages/Analytics';
import Users from '@/pages/Users';
import Projects from '@/pages/Projects';
import Reports from '@/pages/Reports';
import Settings from '@/pages/Settings';
import Notification from '@/pages/Notification';

export const routes: RouteObject[] = [
  {
    path: '/login',
    element: <Login />,
  },
  {
    element: <RequireAuth />,
    children: [
      {
        path: '/',
        element: <HomePage />,
      },
      {
        element: <AdminLayout />,
        children: [
          {
            path: 'restaurants',
            children: [
              { index: true, element: <Restaurants /> },
              { path: 'orders', element: <Order /> },
              { path: 'tables', element: <Tables /> },
              { path: 'items', element: <Items /> },
              { path: 'menu', element: <Menu /> },
              { path: 'analytics', element: <Analytics /> },
              { path: 'users', element: <Users /> },
              { path: 'projects', element: <Projects /> },
              { path: 'reports', element: <Reports /> },
              { path: 'settings', element: <Settings /> },
              { path: 'notification', element: <Notification /> },
            ],
          },
        ],
      },
    ],
  },
  {
    path: '*',
    element: <NotFound />,
  },
];
