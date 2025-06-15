import {
  Users,
  ShoppingCart,
  TrendingUp,
  DollarSign
} from 'lucide-react';

import { StatsCard } from '@/components/dashboard/StatsCard';


export function Dashboard() {
  return (
    <div className="space-y-6">
      {/* Header */}
      <h1 className="text-2xl font-bold text-gray-900 dark:text-white">
        Dashboard
      </h1>

      {/* Stats Cards */}
      <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <StatsCard
          title="Total Users"
          value="2,543"
          change="+12% from last month"
          changeType="positive"
          icon={Users}
        />
        <StatsCard
          title="Sales"
          value="$45,231"
          change="+8% from last month"
          changeType="positive"
          icon={DollarSign}
        />
        <StatsCard
          title="Orders"
          value="1,234"
          change="-3% from last month"
          changeType="negative"
          icon={ShoppingCart}
        />
        <StatsCard
          title="Growth"
          value="23.5%"
          change="+2% from last month"
          changeType="positive"
          icon={TrendingUp}
        />
      </div>

      {/* Main Content Grid */}
      <div className="grid grid-cols-1 lg:grid-cols-3 gap-6">
        Main Data Here...
      </div>
    </div>
  );
}