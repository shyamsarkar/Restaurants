import React from 'react';
import { Notifications, Close } from '@mui/icons-material';

const Notification: React.FC = () => {
  const settingsSections = [
    {
      title: 'Notifications',
      icon: Notifications,
      description: 'Configure how and when you receive notifications',
      items: [
        { label: 'Email Notifications', description: 'Control email notification preferences' },
        { label: 'Push Notifications', description: 'Manage browser and mobile notifications' },
        { label: 'Activity Alerts', description: 'Set alerts for important activities' },
      ]
    },
  ];

  return (
    <div className="space-y-8">
      <div>
        <h1 className="text-3xl font-bold text-gray-900 mb-2">Notifications</h1>
      </div>

      <div className="grid grid-cols-1 lg:grid-cols-2 gap-6">
        {settingsSections.map((section, index) => (
          <div key={index} className="bg-white p-6 rounded-xl shadow-sm border border-gray-200 hover:shadow-md transition-shadow duration-200">
            <div className="flex items-center space-x-3 mb-4">
              <div className="p-2 bg-blue-100 rounded-lg">
                <section.icon className="w-5 h-5 text-blue-600" />
              </div>
              <div>
                <h3 className="text-lg font-semibold text-gray-900">{section.title}</h3>
                <p className="text-sm text-gray-600">{section.description}</p>
              </div>
            </div>

            <div className="space-y-3">
              {section.items.map((item, itemIndex) => (
                <div key={itemIndex} className="flex items-center justify-between p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors duration-200 cursor-pointer">
                  <div>
                    <div className="font-medium text-gray-900">{item.label}</div>
                    <div className="text-sm text-gray-600">{item.description}</div>
                  </div>
                  <div className="text-gray-400">
                    <Close className='h-1 w-1' />
                  </div>
                </div>
              ))}
            </div>
          </div>
        ))}
      </div>
    </div>
  );
};

export default Notification;