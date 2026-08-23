import { execSync } from 'child_process';

export default async () => {
  console.log('Starting global setup...');
  console.log('Running database migrations and seeders for testing environment...');
  
  // Run artisan command with testing environment
  try {
    execSync('php artisan migrate:fresh --seed --env=testing', {
      stdio: 'inherit',
    });
    console.log('Database migrated and seeded successfully.');
  } catch (error) {
    console.error('Failed to run database migrations:', error);
    throw error;
  }
};
