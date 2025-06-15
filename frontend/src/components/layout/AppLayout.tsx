import { useState } from 'react';
import { Outlet } from 'react-router-dom';

import { cn } from '@/lib/utils';

import { Sidebar } from '@/components/layout/Sidebar';
import { MobileSidebar } from '@/components/layout/MobileSidebar';
import { MobileBottomNav } from '@/components/layout/MobileBottomNav';

export function AppLayout() {
  const [sidebarOpen, setSidebarOpen] = useState(false);
  const [sidebarCollapsed, setSidebarCollapsed] = useState(false);

  return (
    <div className="min-h-screen bg-gray-50 dark:bg-gray-900">
      {/* Mobile Sidebar */}
      <MobileSidebar
        open={sidebarOpen}
        onOpenChange={setSidebarOpen}
      />

      {/* Desktop Sidebar */}
      <Sidebar
        collapsed={sidebarCollapsed}
        onCollapsedChange={setSidebarCollapsed}
        className="hidden lg:block"
      />

      {/* Main Content */}
      <div className={cn(
        "flex-1 transition-all duration-300 ease-in-out",
        "lg:ml-64",
        sidebarCollapsed && "lg:ml-16"
      )}>


        <main className="p-4 sm:p-6 lg:p-8">
          <Outlet />
        </main>
      </div>

      <MobileBottomNav
        onMenuClick={() => setSidebarOpen(true)}
        onSidebarToggle={() => setSidebarCollapsed(!sidebarCollapsed)}
        sidebarCollapsed={sidebarCollapsed}
      />
    </div>
  );
}