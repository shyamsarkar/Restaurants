import React from 'react';
import { FolderOpen, Add, CalendarToday, People, MoreHoriz } from '@mui/icons-material';

const Projects: React.FC = () => {
  const projects = [
    { 
      id: 1, 
      name: 'E-commerce Platform', 
      description: 'Modern online shopping platform with advanced features',
      status: 'In Progress', 
      progress: 75,
      team: 5,
      deadline: '2024-03-15',
      color: 'bg-blue-500'
    },
    { 
      id: 2, 
      name: 'Mobile Banking App', 
      description: 'Secure mobile banking application for iOS and Android',
      status: 'Planning', 
      progress: 25,
      team: 3,
      deadline: '2024-04-20',
      color: 'bg-green-500'
    },
    { 
      id: 3, 
      name: 'Analytics Dashboard', 
      description: 'Real-time analytics and reporting dashboard',
      status: 'Completed', 
      progress: 100,
      team: 4,
      deadline: '2024-02-28',
      color: 'bg-purple-500'
    },
    { 
      id: 4, 
      name: 'CRM System', 
      description: 'Customer relationship management system',
      status: 'In Progress', 
      progress: 60,
      team: 6,
      deadline: '2024-05-10',
      color: 'bg-orange-500'
    },
  ];

  return (
    <div className="space-y-8">
      <div className="flex items-center justify-between">
        <div>
          <h1 className="text-3xl font-bold text-gray-900 mb-2">Projects</h1>
          <p className="text-gray-600">Manage and track your ongoing projects and deliverables.</p>
        </div>
        <button className="flex items-center space-x-2 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors duration-200">
          <Add className="w-4 h-4" />
          <span>New Project</span>
        </button>
      </div>

      {/* Project Stats */}
      <div className="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div className="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
          <div className="text-2xl font-bold text-gray-900 mb-1">12</div>
          <div className="text-sm text-gray-600">Total Projects</div>
        </div>
        <div className="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
          <div className="text-2xl font-bold text-blue-600 mb-1">8</div>
          <div className="text-sm text-gray-600">In Progress</div>
        </div>
        <div className="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
          <div className="text-2xl font-bold text-green-600 mb-1">3</div>
          <div className="text-sm text-gray-600">Completed</div>
        </div>
        <div className="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
          <div className="text-2xl font-bold text-orange-600 mb-1">1</div>
          <div className="text-sm text-gray-600">Overdue</div>
        </div>
      </div>

      {/* Projects Grid */}
      <div className="grid grid-cols-1 lg:grid-cols-2 gap-6">
        {projects.map((project) => (
          <div key={project.id} className="bg-white p-6 rounded-xl shadow-sm border border-gray-200 hover:shadow-md transition-shadow duration-200">
            <div className="flex items-start justify-between mb-4">
              <div className="flex items-center space-x-3">
                <div className={`w-10 h-10 ${project.color} rounded-lg flex items-center justify-center`}>
                  <FolderOpen className="w-5 h-5 text-white" />
                </div>
                <div>
                  <h3 className="font-semibold text-gray-900">{project.name}</h3>
                  <p className="text-sm text-gray-600">{project.description}</p>
                </div>
              </div>
              <button className="p-1 text-gray-400 hover:text-gray-600 transition-colors duration-200">
                <MoreHoriz className="w-4 h-4" />
              </button>
            </div>

            <div className="space-y-4">
              {/* Progress */}
              <div>
                <div className="flex items-center justify-between mb-2">
                  <span className="text-sm font-medium text-gray-700">Progress</span>
                  <span className="text-sm text-gray-600">{project.progress}%</span>
                </div>
                <div className="w-full bg-gray-200 rounded-full h-2">
                  <div 
                    className={`h-2 rounded-full transition-all duration-300 ${
                      project.progress === 100 ? 'bg-green-500' : 
                      project.progress >= 75 ? 'bg-blue-500' :
                      project.progress >= 50 ? 'bg-yellow-500' : 'bg-red-500'
                    }`}
                    style={{ width: `${project.progress}%` }}
                  />
                </div>
              </div>

              {/* Status and Details */}
              <div className="flex items-center justify-between">
                <span className={`inline-flex px-2 py-1 text-xs font-medium rounded-full ${
                  project.status === 'Completed' 
                    ? 'bg-green-100 text-green-800'
                    : project.status === 'In Progress'
                    ? 'bg-blue-100 text-blue-800'
                    : 'bg-yellow-100 text-yellow-800'
                }`}>
                  {project.status}
                </span>
                <div className="flex items-center space-x-4 text-sm text-gray-600">
                  <div className="flex items-center space-x-1">
                    <People className="w-4 h-4" />
                    <span>{project.team}</span>
                  </div>
                  <div className="flex items-center space-x-1">
                    <CalendarToday className="w-4 h-4" />
                    <span>{project.deadline}</span>
                  </div>
                </div>
              </div>
            </div>
          </div>
        ))}
      </div>
    </div>
  );
};

export default Projects;