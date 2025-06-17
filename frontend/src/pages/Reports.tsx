import React from 'react';
import { Description, FileDownload, CalendarToday, FilterList } from '@mui/icons-material';

const Reports: React.FC = () => {
  const reports = [
    { id: 1, name: 'Monthly Sales Report', type: 'Sales', date: '2024-02-01', size: '2.3 MB', status: 'Ready' },
    { id: 2, name: 'User Analytics Report', type: 'Analytics', date: '2024-01-28', size: '1.8 MB', status: 'Processing' },
    { id: 3, name: 'Financial Summary Q1', type: 'Financial', date: '2024-01-25', size: '3.1 MB', status: 'Ready' },
    { id: 4, name: 'Performance Metrics', type: 'Performance', date: '2024-01-20', size: '1.2 MB', status: 'Ready' },
    { id: 5, name: 'Customer Feedback Report', type: 'Customer', date: '2024-01-15', size: '2.7 MB', status: 'Ready' },
  ];

  return (
    <div className="space-y-8">
      <div className="flex items-center justify-between">
        <div>
          <h1 className="text-3xl font-bold text-gray-900 mb-2">Reports</h1>
          <p className="text-gray-600">Generate and download various business reports and analytics.</p>
        </div>
        <button className="flex items-center space-x-2 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors duration-200">
          <Description className="w-4 h-4" />
          <span>Generate Report</span>
        </button>
      </div>

      {/* Report Categories */}
      <div className="grid grid-cols-1 md:grid-cols-4 gap-6">
        {[
          { title: 'Sales Reports', count: 12, icon: '📊' },
          { title: 'Analytics', count: 8, icon: '📈' },
          { title: 'Financial', count: 6, icon: '💰' },
          { title: 'Performance', count: 4, icon: '⚡' },
        ].map((category, index) => (
          <div key={index} className="bg-white p-6 rounded-xl shadow-sm border border-gray-200 hover:shadow-md transition-shadow duration-200 cursor-pointer">
            <div className="text-2xl mb-3">{category.icon}</div>
            <h3 className="font-semibold text-gray-900 mb-1">{category.title}</h3>
            <p className="text-sm text-gray-600">{category.count} reports available</p>
          </div>
        ))}
      </div>

      {/* Filters */}
      <div className="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
        <div className="flex items-center space-x-4">
          <div className="flex items-center space-x-2">
            <FilterList className="w-4 h-4 text-gray-400" />
            <span className="text-sm font-medium text-gray-700">Filters:</span>
          </div>
          <select className="px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            <option>All Types</option>
            <option>Sales</option>
            <option>Analytics</option>
            <option>Financial</option>
            <option>Performance</option>
          </select>
          <div className="flex items-center space-x-2">
            <CalendarToday className="w-4 h-4 text-gray-400" />
            <input
              type="date"
              className="px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
            />
          </div>
          <button className="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors duration-200">
            Apply Filters
          </button>
        </div>
      </div>

      {/* Reports Table */}
      <div className="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div className="overflow-x-auto">
          <table className="w-full">
            <thead className="bg-gray-50 border-b border-gray-200">
              <tr>
                <th className="text-left py-4 px-6 font-medium text-gray-900">Report Name</th>
                <th className="text-left py-4 px-6 font-medium text-gray-900">Type</th>
                <th className="text-left py-4 px-6 font-medium text-gray-900">Date Created</th>
                <th className="text-left py-4 px-6 font-medium text-gray-900">Size</th>
                <th className="text-left py-4 px-6 font-medium text-gray-900">Status</th>
                <th className="text-right py-4 px-6 font-medium text-gray-900">Actions</th>
              </tr>
            </thead>
            <tbody className="divide-y divide-gray-200">
              {reports.map((report) => (
                <tr key={report.id} className="hover:bg-gray-50 transition-colors duration-200">
                  <td className="py-4 px-6">
                    <div className="flex items-center space-x-3">
                      <Description className="w-5 h-5 text-gray-400" />
                      <span className="font-medium text-gray-900">{report.name}</span>
                    </div>
                  </td>
                  <td className="py-4 px-6">
                    <span className="inline-flex px-2 py-1 text-xs font-medium rounded-full bg-blue-100 text-blue-800">
                      {report.type}
                    </span>
                  </td>
                  <td className="py-4 px-6 text-gray-600">{report.date}</td>
                  <td className="py-4 px-6 text-gray-600">{report.size}</td>
                  <td className="py-4 px-6">
                    <span className={`inline-flex px-2 py-1 text-xs font-medium rounded-full ${
                      report.status === 'Ready' 
                        ? 'bg-green-100 text-green-800' 
                        : 'bg-yellow-100 text-yellow-800'
                    }`}>
                      {report.status}
                    </span>
                  </td>
                  <td className="py-4 px-6 text-right">
                    {report.status === 'Ready' && (
                      <button className="flex items-center space-x-1 px-3 py-1 text-sm text-blue-600 hover:bg-blue-50 rounded-lg transition-colors duration-200">
                        <FileDownload className="w-4 h-4" />
                        <span>Download</span>
                      </button>
                    )}
                  </td>
                </tr>
              ))}
            </tbody>
          </table>
        </div>
      </div>
    </div>
  );
};

export default Reports;