import { createContext, ReactNode, useCallback, useContext, useMemo, useState } from 'react';
import Snackbar from '@mui/material/Snackbar';
import { Alert } from '@mui/material';

export type ToastSeverity = 'success' | 'error' | 'warning' | 'info';

type ToastContextValue = {
  showToast: (message: string, severity: ToastSeverity) => void;
};

type ToastState = {
  open: boolean;
  message: string;
  severity: ToastSeverity;
};

const ToastContext = createContext<ToastContextValue | undefined>(undefined);

export function ToastProvider({ children }: { children: ReactNode }) {
  const [toast, setToast] = useState<ToastState>({
    open: false,
    message: '',
    severity: 'info',
  });

  const showToast = useCallback((message: string, severity: ToastSeverity) => {
    setToast({ open: true, message, severity });
  }, []);

  const handleClose = useCallback(() => {
    setToast((prev) => ({ ...prev, open: false }));
  }, []);

  const value = useMemo(() => ({ showToast }), [showToast]);

  return (
    <ToastContext.Provider value={value}>
      {children}
      <Snackbar
        open={toast.open}
        autoHideDuration={5000}
        onClose={handleClose}
        anchorOrigin={{ vertical: 'bottom', horizontal: 'right' }}
      >
        <Alert onClose={handleClose} severity={toast.severity} variant="filled">
          {toast.message}
        </Alert>
      </Snackbar>
    </ToastContext.Provider>
  );
}

export function useToast() {
  const context = useContext(ToastContext);

  if (!context) {
    throw new Error('useToast must be used within a ToastProvider');
  }

  return context;
}
