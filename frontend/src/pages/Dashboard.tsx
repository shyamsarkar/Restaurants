import React from 'react';
// import { BarChart3, Users, DollarSign, TrendingUp, Activity, Calendar } from 'lucide-react';
import { BarChart, People, AttachMoney, TrendingUp, Timeline, CalendarToday } from '@mui/icons-material';

const Dashboard: React.FC = () => {
  const stats = [
    { title: 'Total Revenue', value: '$54,239', change: '+12%', icon: AttachMoney, color: 'text-green-600' },
    { title: 'Active Users', value: '2,847', change: '+5%', icon: People, color: 'text-blue-600' },
    { title: 'Conversion Rate', value: '3.2%', change: '+8%', icon: TrendingUp, color: 'text-purple-600' },
    { title: 'Sessions', value: '12,456', change: '-2%', icon: Timeline, color: 'text-orange-600' },
  ];

  return (
    <div className="space-y-8">
      <div>
        <h1 className="text-3xl font-bold text-gray-900 mb-2">Dashboard</h1>
        <p className="text-gray-600">Welcome back! Here's what's happening with your business today.</p>
      </div>

      {/* Stats Grid */}
      <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        {stats.map((stat, index) => (
          <div key={index} className="bg-white p-6 rounded-xl shadow-sm border border-gray-200 hover:shadow-md transition-shadow duration-200">
            <div className="flex items-center justify-between">
              <div>
                <p className="text-sm font-medium text-gray-600 mb-1">{stat.title}</p>
                <p className="text-2xl font-bold text-gray-900">{stat.value}</p>
                <p className={`text-sm font-medium ${stat.change.startsWith('+') ? 'text-green-600' : 'text-red-600'}`}>
                  {stat.change} from last month
                </p>
              </div>
              <div className={`p-3 rounded-lg bg-gray-50 ${stat.color}`}>
                <stat.icon className="w-6 h-6" />
              </div>
            </div>
          </div>
        ))}
      </div>

      {/* Charts Section */}
      <div className="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div className="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
          <div className="flex items-center justify-between mb-6">
            <h3 className="text-lg font-semibold text-gray-900">Revenue Overview</h3>
            <BarChart className="w-5 h-5 text-gray-400" />
          </div>
          <div className="h-64 bg-gray-50 rounded-lg flex items-center justify-center">
            <p className="text-gray-500">Chart visualization would be here</p>
          </div>
        </div>

        <div className="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
          <div className="flex items-center justify-between mb-6">
            <h3 className="text-lg font-semibold text-gray-900">Recent Activity</h3>
            <CalendarToday className="w-5 h-5 text-gray-400" />
          </div>
          <div className="space-y-4">
            {[
              { user: 'Sarah Johnson', action: 'Created new project', time: '2 minutes ago' },
              { user: 'Mike Chen', action: 'Updated user profile', time: '15 minutes ago' },
              { user: 'Emma Davis', action: 'Completed task #1247', time: '1 hour ago' },
              { user: 'Alex Smith', action: 'Uploaded new document', time: '2 hours ago' },
            ].map((activity, index) => (
              <div key={index} className="flex items-center space-x-3 p-3 bg-gray-50 rounded-lg">
                <div className="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                  <People className="w-4 h-4 text-blue-600" />
                </div>
                <div className="flex-1">
                  <p className="text-sm font-medium text-gray-900">{activity.user}</p>
                  <p className="text-xs text-gray-600">{activity.action}</p>
                </div>
                <span className="text-xs text-gray-500">{activity.time}</span>
              </div>
            ))}
          </div>
        </div>
      </div>
    </div>
  );
};

export default Dashboard;
