import React from 'react';
import { Notifications, Settings, Logout, Person } from '@mui/icons-material';
import { useNavigate } from 'react-router-dom';

interface ProfileDropdownProps {
  collapsed: boolean;
  onClose: () => void;
}


const ProfileDropdown: React.FC<ProfileDropdownProps> = ({ collapsed, onClose }) => {
  const navigate = useNavigate()
  const handleLogout = () => {
    navigate('/login');
  }
  const gotoSettings = () => {
    navigate('/settings');
  }
  const menuItems = [
    { icon: Notifications, label: 'Notifications', badge: '3' },
    { icon: Settings, label: 'Settings', onClick: gotoSettings },
    { icon: Logout, label: 'Logout', danger: true, onClick: handleLogout },
  ];

  return (
    <>
      {/* Backdrop */}
      <div 
        className="fixed inset-0 z-40" 
        onClick={onClose}
      />
      
      {/* Dropdown */}
      <div className={`absolute bottom-full mb-2 ${collapsed ? 'left-full ml-2' : 'left-0'} w-56 bg-white rounded-lg shadow-lg border border-gray-200 py-2 z-50`}>
        {/* Profile Header */}
        <div className="px-4 py-3 border-b border-gray-100">
          <div className="flex items-center space-x-3">
            <div className="w-10 h-10 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full flex items-center justify-center">
              <Person className="w-5 h-5 text-white" />
            </div>
            <div>
              <div className="text-sm font-medium text-gray-900">Administrator</div>
              <div className="text-xs text-gray-500">shyamsarkar@github.com</div>
            </div>
          </div>
        </div>

        {/* Menu Items */}
        <div className="py-2">
          {menuItems.map((item, index) => (
            <button
              key={index}
              className={`flex items-center w-full px-4 py-2 text-left hover:bg-gray-50 transition-colors duration-200 ${
                item.danger ? 'text-red-600 hover:bg-red-50' : 'text-gray-700'
              }`}
              onClick={ item.onClick ?? onClose}
            >
              <item.icon className="w-4 h-4 mr-3" />
              <span className="text-sm font-medium">{item.label}</span>
              {item.badge && (
                <span className="ml-auto bg-blue-100 text-blue-600 text-xs px-2 py-1 rounded-full">
                  {item.badge}
                </span>
              )}
            </button>
          ))}
        </div>
      </div>
    </>
  );
};

export default ProfileDropdown;