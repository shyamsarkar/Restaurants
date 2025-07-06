import React from 'react';
import { ListRounded } from '@mui/icons-material';
import { useNavigate } from 'react-router-dom';
import ResponsiveAppBar from '@/components/Home/AppBar';
import FlatwareIcon from '@mui/icons-material/Flatware';
import LockOpenIcon from '@mui/icons-material/LockOpen';
import LockOutlineIcon from '@mui/icons-material/LockOutline';

export const HomePage: React.FC = () => {
  const navigate = useNavigate();
  const applicationList = [
    {
      id: 1,
      name: 'Restaurants',
      description: 'Effortlessly create, manage, and track items on customer bills with precision and speed.',
      lastUsed: '2023-10-01',
      icon: <FlatwareIcon />,
      link: '/restaurants',
      locked: false,
    },
    {
      id: 2,
      name: 'Application Two',
      description: 'This is a description for application two.',
      lastUsed: '2023-09-15',
      icon: <ListRounded />,
      link: '/restaurants',
      locked: true,
    },
  ];

  const handleSelectApp = (link: string) => {
    navigate(link);
  };

  return (
    <div>
      <ResponsiveAppBar />
      <div className="px-8 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 mt-5">
        {applicationList.map(app => (
          <div
            key={app.id}
            onClick={() => handleSelectApp(app.link)}
            className="group bg-white rounded-xl shadow-sm hover:shadow-lg transition-all duration-100 cursor-pointer border border-gray-100 hover:border-blue-200 hover:scale-[1.02] p-6"
          >
            <div className="flex flex-col h-full">
              <div className="flex items-start justify-between mb-4">
                <div className="flex items-center justify-center w-12 h-12 bg-blue-50 rounded-lg group-hover:bg-blue-100 transition-colors duration-200">
                  {app.icon}
                </div>
                <span className={`text-xs font-medium text-white bg-${app.locked ? 'gray' : 'green'}-700 px-2 py-1 rounded-full`}>
                  {app.locked ? <LockOutlineIcon /> : <LockOpenIcon />}
                </span>
              </div>

              <div className="flex-1">
                <h3 className="text-lg font-semibold text-gray-900 mb-2 group-hover:text-blue-700 transition-colors duration-200">
                  {app.name}
                </h3>
                <p className="text-sm text-gray-600 leading-relaxed">
                  {app.description}
                </p>
              </div>

              {app.lastUsed && (
                <div className="mt-4 pt-4 border-t border-gray-100">
                  <p className="text-xs text-gray-500">
                    Last used: {app.lastUsed}
                  </p>
                </div>
              )}
            </div>
          </div>
        ))}
      </div>
    </div>
  );
};