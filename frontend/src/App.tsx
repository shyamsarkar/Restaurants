import { BrowserRouter, Routes, Route } from 'react-router-dom';

import { AppLayout } from '@/components/layout/AppLayout';

import { Toaster } from '@/components/ui/toaster';

import { Dashboard } from '@/pages/Dashboard';
import { Profile } from '@/pages/Profile';
import { Login } from '@/pages/Login';
import { NotFound } from '@/pages/NotFound';
import { Order } from '@/pages/Order';

import '@/App.css';

function App() {
  return (
     <BrowserRouter>
      <Routes>
        <Route path="/login" element={<Login />} />

        <Route element={<AppLayout />}>
          <Route path="/" element={<Dashboard />} />
          <Route path="/profile" element={<Profile />} />
          <Route path="/orders" element={<Order />} />
        </Route>

        <Route path="*" element={<NotFound />} />
      </Routes>

      <Toaster />
    </BrowserRouter>
  );
}

export default App;