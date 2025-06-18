import React from 'react';
import { Person, Shield, Palette, Storage } from '@mui/icons-material';

const Settings: React.FC = () => {
  const settingsSections = [
    {
      title: 'Profile Settings',
      icon: Person,
      description: 'Manage your personal information and preferences',
      items: [
        { label: 'Personal Information', description: 'Update your name, email, and profile picture' },
        { label: 'Password & Security', description: 'Change your password and security settings' },
        { label: 'Account Preferences', description: 'Language, timezone, and other preferences' },
      ]
    },
    {
      title: 'Privacy & Security',
      icon: Shield,
      description: 'Manage your privacy and security settings',
      items: [
        { label: 'Data Privacy', description: 'Control how your data is used and shared' },
        { label: 'Two-Factor Authentication', description: 'Add an extra layer of security' },
        { label: 'Login History', description: 'View your recent login activity' },
      ]
    },
    {
      title: 'Appearance',
      icon: Palette,
      description: 'Customize the look and feel of your dashboard',
      items: [
        { label: 'Theme Settings', description: 'Choose between light and dark themes' },
        { label: 'Layout Options', description: 'Customize your dashboard layout' },
        { label: 'Accessibility', description: 'Accessibility and display options' },
      ]
    },
    {
      title: 'Data Management',
      icon: Storage,
      description: 'Manage your data and backup settings',
      items: [
        { label: 'Data Export', description: 'Export your data in various formats' },
        { label: 'Backup Settings', description: 'Configure automatic backups' },
        { label: 'Data Retention', description: 'Set data retention policies' },
      ]
    },
  ];

  return (
    <div className="space-y-8">
      <div>
        <h1 className="text-3xl font-bold text-gray-900 mb-2">Settings</h1>
        <p className="text-gray-600">Manage your account settings and preferences.</p>
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
                    <svg className="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M9 5l7 7-7 7" />
                    </svg>
                  </div>
                </div>
              ))}
            </div>
          </div>
        ))}
      </div>

      {/* Quick Actions */}
      <div className="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
        <h3 className="text-lg font-semibold text-gray-900 mb-4">Quick Actions</h3>
        <div className="flex flex-wrap gap-3">
          <button className="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors duration-200">
            Save Changes
          </button>
          <button className="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors duration-200">
            Reset to Default
          </button>
          <button className="px-4 py-2 border border-red-300 text-red-600 rounded-lg hover:bg-red-50 transition-colors duration-200">
            Delete Account
          </button>
        </div>
      </div>
    </div>
  );
};

export default Settings;