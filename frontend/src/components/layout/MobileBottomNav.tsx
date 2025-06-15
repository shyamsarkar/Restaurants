import { cn } from '@/lib/utils';
import {
  LayoutDashboard,
  Users,
  Package,
  ShoppingCart,
  Menu
} from 'lucide-react';

const navigation = [
  { name: 'Dashboard', href: '/', icon: LayoutDashboard, current: true },
  { name: 'Users', href: '/users', icon: Users, current: false },
  { name: 'Products', href: '/products', icon: Package, current: false },
  { name: 'Orders', href: '/orders', icon: ShoppingCart, current: false },
];

interface NavProps {
  onMenuClick: () => void;
  onSidebarToggle: () => void;
  sidebarCollapsed: boolean;
}

export function MobileBottomNav({ onMenuClick, onSidebarToggle, sidebarCollapsed }: NavProps) {
  return (
    <div className="fixed bottom-0 left-0 right-0 z-50 bg-white dark:bg-gray-900 border-t border-gray-200 dark:border-gray-700 lg:hidden">
      <nav className="flex">
        {navigation.map((item) => {
          const Icon = item.icon;
          return (
            <a
              key={item.name}
              href={item.href}
              className={cn(
                "flex-1 flex flex-col items-center justify-center py-2 px-1 text-xs font-medium transition-colors duration-200",
                item.current
                  ? "text-blue-600 bg-blue-50 dark:text-blue-400 dark:bg-blue-900/20"
                  : "text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200"
              )}
            >
              <Icon className={cn(
                "h-5 w-5 mb-1",
                item.current && "text-blue-600 dark:text-blue-400"
              )} />
              <span className="truncate">{item.name}</span>
            </a>
          );
        })}
        <a
        onClick={onMenuClick}
        className={cn(
          "cursor-pointer flex-1 flex flex-col items-center justify-center py-2 px-1 text-xs font-medium transition-colors duration-200",
          false
            ? "text-blue-600 bg-blue-50 dark:text-blue-400 dark:bg-blue-900/20"
            : "text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200"
        )}>
          <Menu className={cn(
            "h-5 w-5 mb-1",
            "text-blue-600 dark:text-blue-400"
          )} />
        </a>
      </nav>
    </div>
  );
}