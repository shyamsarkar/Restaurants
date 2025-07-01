import React, { useEffect, useState } from 'react';
import { useNavigate } from 'react-router-dom';

import {
  Home,
  ArrowBack,
  WarningAmber,
} from '@mui/icons-material';

export const NotFound: React.FC = () => {
  const navigate = useNavigate();
  const [isVisible, setIsVisible] = useState(false);

  useEffect(() => {
    setIsVisible(true);
  }, []);

  const handleGoHome = () => {
    navigate('/');
  };

  const handleGoBack = () => {
    navigate(-1);
  };

  return (
    <div className="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-100 flex items-center justify-center p-4">
      <div className={`max-w-2xl w-full text-center transition-all duration-1000 transform ${isVisible ? 'translate-y-0 opacity-100' : 'translate-y-8 opacity-0'
        }`}>

        {/* Animated 404 Number */}
        <div className="relative mb-8">
          <div className="text-8xl md:text-9xl font-black text-transparent bg-clip-text bg-gradient-to-r from-blue-600 via-purple-600 to-indigo-600 animate-pulse">
            404
          </div>
          <div className="absolute inset-0 text-8xl md:text-9xl font-black text-blue-200 -z-10 transform translate-x-2 translate-y-2">
            404
          </div>
        </div>

        {/* Main Content Card */}
        <div className="bg-white/80 backdrop-blur-sm rounded-3xl shadow-2xl shadow-blue-900/10 p-8 md:p-12 mb-8 border border-white/20">
          <div className="flex justify-center mb-6">
            <div className="relative">
              <div className="w-20 h-20 bg-gradient-to-r from-amber-400 to-orange-500 rounded-full flex items-center justify-center animate-bounce">
                <WarningAmber className="w-10 h-10 text-white" />
              </div>
              <div className="absolute inset-0 w-20 h-20 bg-gradient-to-r from-amber-400 to-orange-500 rounded-full animate-ping opacity-20"></div>
            </div>
          </div>

          <h1 className="text-3xl md:text-4xl font-bold text-gray-800 mb-4">
            Oops! Page Not Found
          </h1>

          <p className="text-lg text-gray-600 mb-8 leading-relaxed">
            We couldn't find the page you're looking for. It might have been moved,
            deleted, or the URL might be incorrect.
          </p>

          {/* Action Buttons */}
          <div className="flex flex-col sm:flex-row gap-4 justify-center items-center">
            <button
              onClick={handleGoHome}
              className="group bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white px-8 py-4 rounded-2xl font-semibold shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-200 flex items-center gap-3 min-w-[180px]"
            >
              <Home className="w-5 h-5 group-hover:scale-110 transition-transform duration-200" />
              Go Home
            </button>

            <button
              onClick={handleGoBack}
              className="group bg-white hover:bg-gray-50 text-gray-700 px-8 py-4 rounded-2xl font-semibold shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-200 flex items-center gap-3 border border-gray-200 min-w-[180px]"
            >
              <ArrowBack className="w-5 h-5 group-hover:-translate-x-1 transition-transform duration-200" />
              Go Back
            </button>
          </div>
        </div>

        {/* Footer Message */}
        <p className="text-sm text-gray-500 mt-8">
          Error Code: 404 • If this problem persists, please contact support
        </p>
      </div>
    </div>
  );
};
