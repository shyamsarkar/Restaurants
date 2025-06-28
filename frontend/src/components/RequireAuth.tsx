import { useLocation, Navigate } from 'react-router-dom';
import { useAuthStore } from '@/stores/auth.store';

export const RequireAuth = ({ children }: { children: JSX.Element }) => {
  const user = useAuthStore((state) => state.user);
  const location = useLocation();

  if (!user) {
    return <Navigate to="/login" state={{ from: location }} replace />;
  }

  return children;
};
