import { create } from 'zustand';
import { persist, createJSONStorage } from 'zustand/middleware';

interface CommonState {
  showSidebar: boolean;
  darkTheme: boolean;
  toggleSidebar: (value: boolean) => void;
  toggleTheme: (value: boolean) => void;
}

export const useCommonStore = create<CommonState>()(
  persist(
    (set) => ({
      showSidebar: true,
      darkTheme: false,
      toggleSidebar: (value) => set({ showSidebar: value }),
      toggleTheme: (value) => set({ darkTheme: value }),
    }),
    {
      name: 'common',
      storage: createJSONStorage(() => localStorage),
    }
  )
);
