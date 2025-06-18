import { Outlet } from 'react-router-dom';
import Sidebar from './Sidebar';
import { useCommonStore } from '@/stores/common.store';

const AdminLayout: React.FC = () => {
  const showSidebar = useCommonStore((state)=> state.showSidebar)

  return (
    <div className="flex h-screen bg-gray-50">
      <Sidebar />
      <main
        className={`flex-1 transition-all duration-300 ease-in-out ${showSidebar ? 'ml-56' : 'ml-16'
          }`}
      >
        <div className="p-4 h-full overflow-auto">
          <Outlet />
        </div>
      </main>
    </div>
  );
};

export default AdminLayout;
