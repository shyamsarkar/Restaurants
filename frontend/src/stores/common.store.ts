import { create } from 'zustand';
import { persist, createJSONStorage } from 'zustand/middleware';

interface CommonState {
  showSidebar: boolean;
  darkTheme: boolean;
  toggleSidebar: () => void;
  toggleTheme: () => void;
  setSidebar: (value: boolean) => void;
  setTheme: (value: boolean) => void;
}

export const useCommonStore = create<CommonState>()(
  persist(
    (set) => ({
      showSidebar: true,
      darkTheme: false,
      toggleSidebar: () => set((state) => ({ showSidebar: !state.showSidebar })),
      toggleTheme: () => set((state) => ({ darkTheme: !state.darkTheme })),
      setSidebar: (value) => set({ showSidebar: value }),
      setTheme: (value) => set({ darkTheme: value }),
    }),
    {
      name: 'common',
      storage: createJSONStorage(() => localStorage),
    }
  )
);
