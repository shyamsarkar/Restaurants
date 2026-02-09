import React, { useState } from 'react';
import { NavLink, useNavigate } from 'react-router-dom';

import { 
  Home, 
  BarChart, 
  People, 
  FolderOpen, 
  Description, 
  ChevronLeft,
  ChevronRight,
  ShoppingCart,
  TableRestaurant,
  MenuBook,
  ChecklistRtl,
  Scale
} from '@mui/icons-material';

import ProfileDropdown from './ProfileDropdown';
import { useCommonStore } from '@/stores/common.store';

const basePath = '/restaurants';

const menuItems = [
  { icon: Home, label: 'Dashboard', path: `${basePath}` },
  { icon: ShoppingCart, label: 'Orders', path: `${basePath}/orders` },
  { icon: TableRestaurant, label: 'Table', path: `${basePath}/tables` },
  { icon: MenuBook, label: 'Menu', path: `${basePath}/menu` },
  { icon: ChecklistRtl, label: 'Items', path: `${basePath}/items` },
  { icon: Scale, label: '---', path: `${basePath}/units` },
  { icon: BarChart, label: 'Analytics', path: `${basePath}/analytics` },
  { icon: People, label: 'Users', path: `${basePath}/users` },
  { icon: FolderOpen, label: 'Projects', path: `${basePath}/projects` },
  { icon: Description, label: 'Reports', path: `${basePath}/reports` },
];

const Sidebar: React.FC = () => {
  const [profileDropdownOpen, setProfileDropdownOpen] = useState(false);
  const showSidebar = useCommonStore((state) => state.showSidebar)
  const { toggleSidebar } = useCommonStore()
  const navigate = useNavigate();

  const handleNavigate = () => {
    navigate(basePath);
  }

  return (
    <div className={`fixed left-0 top-0 h-full bg-white shadow-xl z-50 transition-all duration-300 ease-in-out ${
      showSidebar ? 'w-56' : 'w-16'
    }`}>
      {/* Header */}
      <div className="flex items-center justify-between p-2 border-b border-gray-200">
        <div className={`flex items-center space-x-3 ${showSidebar ? 'opacity-100' : 'opacity-0'} transition-opacity duration-200 ${showSidebar ? '' : 'hidden'}`}>
          <div className="hidden w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center">
            <Home className="w-5 h-5 text-white" />
          </div>
          <h1 onClick={handleNavigate} className="cursor-pointer text-xl font-bold text-gray-800 whitespace-nowrap">Restaurants</h1>
        </div>
        <button
          onClick={() => toggleSidebar(!showSidebar)}
          className="p-2 rounded-lg hover:bg-gray-100 transition-colors duration-200"
        >
          {showSidebar ? (
            <ChevronLeft className="w-5 h-5 text-gray-600" />
          ) : (
            <ChevronRight className="w-5 h-5 text-gray-600" />
          )}
        </button>
      </div>

      {/* Navigation */}
      <nav className="mt-4 px-1">
        <ul className="space-y-2">
          {menuItems.map((item) => (
            <li key={item.path}>
              <NavLink
                to={item.path}
                className={({ isActive }) =>
                  `flex items-center px-4 py-1 rounded-lg transition-all duration-200 group relative ${
                    isActive
                      ? 'bg-blue-50 text-blue-600 border-r-2 border-blue-600'
                      : 'text-gray-700 hover:bg-gray-50 hover:text-gray-900'
                  }`
                }
              >
                <item.icon className="w-5 h-5 flex-shrink-0" />
                <span className={`ml-3 font-medium ${showSidebar ? 'opacity-100' : 'opacity-0 w-0'} transition-all duration-200`}>
                  {item.label}
                </span>
                
                {/* Tooltip for collapsed state */}
                {!showSidebar && (
                  <div className="absolute left-full ml-2 px-3 py-1 bg-gray-800 text-white text-sm rounded-lg opacity-0 group-hover:opacity-100 transition-opacity duration-200 whitespace-nowrap z-50">
                    {item.label}
                  </div>
                )}
              </NavLink>
            </li>
          ))}
        </ul>
      </nav>

      {/* Profile Section */}
      <div className="absolute bottom-0 left-0 right-0 p-2 border-t border-gray-200">
        <div className="relative">
          <button
            onClick={() => setProfileDropdownOpen(!profileDropdownOpen)}
            className={`flex items-center w-full p-3 rounded-lg hover:bg-gray-50 transition-colors duration-200 ${
              showSidebar ? 'space-x-3' : 'justify-center'
            }`}
          >
            <div className="w-8 h-8 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full flex items-center justify-center flex-shrink-0">
              <People className="w-5 h-5 text-white" />
            </div>
            <div className={`flex-1 text-left truncate ${showSidebar ? 'opacity-100' : 'opacity-0 w-0'} transition-all duration-200`}>
              <div className="text-sm font-medium text-gray-900">Shyam Sarkar</div>
            </div>
          </button>

          {/* Profile Dropdown */}
          {profileDropdownOpen && (
            <ProfileDropdown onClose={() => setProfileDropdownOpen(false)} />
          )}
        </div>
      </div>
    </div>
  );
};

export default Sidebar;