import { useRef, useState } from 'react';
import { useNavigate } from 'react-router-dom';

import {
  LayoutDashboard,
  Users,
  User,
  Settings,
  BarChart3,
  FileText,
  Package,
  ShoppingCart,
  Bell,
  LogOut,
  ChevronLeft,
  ChevronRight,
  ChevronUp
} from 'lucide-react';

import { cn } from '@/lib/utils';

import { Button } from '@/components/ui/button';
import { ScrollArea } from '@/components/ui/scroll-area';
import { Separator } from '@/components/ui/separator';
import { Avatar, AvatarFallback, AvatarImage } from '@/components/ui/avatar';


interface SidebarProps {
  collapsed?: boolean;
  onCollapsedChange?: (collapsed: boolean) => void;
  className?: string;
}

const navigation = [
  { name: 'Dashboard', path: '/', icon: LayoutDashboard, current: true },
  { name: 'Orders', path: '/orders', icon: ShoppingCart, current: false },
  { name: 'Tables', path: '/tables', icon: Package, current: false },
  { name: 'Menu', path: '/menu', icon: BarChart3, current: false },
  { name: 'Items', path: '/items', icon: FileText, current: false },
  { name: 'Users', path: '/users', icon: Users, current: false },
];


export function Sidebar({ collapsed = false, onCollapsedChange, className }: SidebarProps) {
  const navigate = useNavigate();

  const [isProfileHovered, setIsProfileHovered] = useState(false);
  const closeTimeoutRef = useRef<NodeJS.Timeout | null>(null);

  const handleSignOut = () => {
    navigate('/login');
  };

  const handleNotifications = () => {
    console.log('Notifications clicked');
  };

  const handleProfileClick = () => {
    navigate('/profile'); // 👈 navigate to /profile
  };

  const handleSettingsClick = () => {
    console.log('-----settings------');
  }


const handleProfileMouseEnter = () => {
  if (closeTimeoutRef.current) {
    clearTimeout(closeTimeoutRef.current);
  }
  setIsProfileHovered(true);
};

const handleProfileMouseLeave = () => {
  closeTimeoutRef.current = setTimeout(() => {
    setIsProfileHovered(false);
  }, 300);
};

  return (
    <div className={cn(
      "fixed inset-y-0 left-0 z-50 flex flex-col bg-white dark:bg-gray-800 border-r border-gray-200 dark:border-gray-700 transition-all duration-300",
      collapsed ? "w-16" : "w-64",
      className
    )}>
      {/* Logo */}
      <div className="flex h-16 items-center justify-between px-4 border-b border-gray-200 dark:border-gray-700">
        {!collapsed && (
          <div className="flex items-center space-x-2">
            <div className="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center">
              <span className="text-white font-bold text-sm">R</span>
            </div>
            <span className="font-semibold text-gray-900 dark:text-white">Restaurant</span>
          </div>
        )}

        <Button
          variant="ghost"
          size="sm"
          onClick={() => onCollapsedChange?.(!collapsed)}
          className="p-2"
        >
          {collapsed ? (
            <ChevronRight className="h-4 w-4" />
          ) : (
            <ChevronLeft className="h-4 w-4" />
          )}
        </Button>
      </div>

      {/* Navigation */}
      <ScrollArea className="flex-1 px-3 py-4">
        <nav className="space-y-1">
          {navigation.map((item) => {
            const Icon = item.icon;
            return (
              <Button
                key={item.name}
                variant={item.current ? "secondary" : "ghost"}
                className={cn(
                  "w-full justify-start h-10 px-3",
                  collapsed && "px-2"
                )}
                onClick={() => navigate(item.path)}
              >
                <Icon className={cn("h-4 w-4", !collapsed && "mr-3")} />
                {!collapsed && (
                  <span className="text-sm font-medium">{item.name}</span>
                )}
              </Button>
            );
          })}
        </nav>
      </ScrollArea>


      {/* Profile Section with Hover Dropdown */}
      <div className={cn("w-full absolute left-0 bottom-0 bg-background", collapsed ? "py-4" : "p-4")}>
        <Separator />
        <div
          className="relative"
          onMouseEnter={handleProfileMouseEnter}
  onMouseLeave={handleProfileMouseLeave}
        >
          {/* Profile Card */}
          <div className="flex items-center space-x-3 p-2 rounded-lg hover:bg-gray-50 transition-colors cursor-pointer">
            <Avatar className="h-10 w-10">
              <AvatarImage src="https://images.pexels.com/photos/3777946/pexels-photo-3777946.jpeg?auto=compress&cs=tinysrgb&w=400" />
              <AvatarFallback className="bg-blue-600 text-white">
                <User className="h-5 w-5" />
              </AvatarFallback>
            </Avatar>
            <div className={cn("flex-1 min-w-0", collapsed && "hidden")}>
              <p className="text-sm font-medium text-gray-900 truncate">Shyam Sarkar</p>
              <p className="text-xs text-gray-500 truncate">Admin</p>
            </div>
            <ChevronUp
              className={cn(
                "h-4 w-4 text-gray-400 transition-transform duration-200",
                isProfileHovered ? "rotate-180" : "",
                collapsed && "hidden"
              )}
            />
          </div>

          {/* Dropdown Menu */}
          <div
            className={cn(
              "absolute bottom-full left-0 right-0 mb-2 bg-white border border-gray-200 rounded-lg shadow-lg transition-all duration-200 origin-bottom",
              isProfileHovered
                ? "opacity-100 scale-100 translate-y-0"
                : "opacity-0 scale-95 translate-y-2 pointer-events-none",
              collapsed && "ml-4 w-fit-content"
            )}
            onMouseEnter={handleProfileMouseEnter}
          onMouseLeave={handleProfileMouseLeave}
          >
            <div className="p-2 space-y-1">
              <Button
                variant="ghost"
                className="w-full justify-start h-9 text-left font-medium text-gray-600 hover:text-gray-900 hover:bg-gray-100"
                onClick={handleProfileClick}
              >
                <User className="mr-3 h-4 w-4" />
                Profile
              </Button>

              <Button
                variant="ghost"
                className="w-full justify-start h-9 text-left font-medium text-gray-600 hover:text-gray-900 hover:bg-gray-100"
                onClick={handleSettingsClick}
              >
                <Settings className="mr-3 h-4 w-4" />
                Settings
              </Button>

              <Button
                variant="ghost"
                className="w-full justify-start h-9 text-left font-medium text-gray-600 hover:text-gray-900 hover:bg-gray-100"
                onClick={handleNotifications}
              >
                <Bell className="mr-3 h-4 w-4" />
                Notifications
                <span className="ml-auto bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">
                  3
                </span>
              </Button>

              <Separator className="my-1" />

              <Button
                variant="ghost"
                className="w-full justify-start h-9 text-left font-medium text-red-600 hover:text-red-700 hover:bg-red-50"
                onClick={handleSignOut}
              >
                <LogOut className="mr-3 h-4 w-4" />
                Sign Out
              </Button>
            </div>
          </div>
        </div>
      </div>
    </div>
  );
}