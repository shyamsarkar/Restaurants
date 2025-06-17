import { ReactNode } from 'react';

interface PageContainerProps {
  title: string;
  description: string;
  children: ReactNode;
}

export default function PageContainer({ title, description, children }: PageContainerProps) {
  return (
    <div className="w-full min-h-screen bg-gray-50">
      <div className="hidden">
        <h1>{title}</h1>
        <meta name="description" content={description} />
      </div>
      {children}
    </div>
  );
}