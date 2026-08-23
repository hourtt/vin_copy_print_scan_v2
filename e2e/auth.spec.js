import { test, expect } from '@playwright/test';

test.describe('Authentication Flows', () => {
  const customerEmail = `customer_test_${Date.now()}@example.com`;
  const customerPassword = 'StrongPassword123!';
  const adminEmail = 'lyengPrinter@gmail.com'; // from AdminSeeder
  const adminPassword = 'lyengPrinter@731946';

  test('User can register a new account', async ({ page }) => {
    await page.goto('/register');
    
    // Fill out the registration form
    await page.getByLabel('First Name').fill('Test');
    await page.getByLabel('Last Name').fill('Customer');
    await page.getByLabel('Email').fill(customerEmail);
    // Playwright locator by name for password fields if labels are tricky
    await page.locator('input[name="password"]').fill(customerPassword);
    await page.locator('input[name="password_confirmation"]').fill(customerPassword);
    
    await page.getByRole('button', { name: 'Register' }).click();

    // After registration, user should be redirected to customer dashboard / catalog
    await expect(page).toHaveURL('/');
    
    // Check if Account menu button is visible (basic auth check)
    await expect(page.getByRole('button', { name: 'Account menu' })).toBeVisible();
  });

  test('Customer can login and logout', async ({ page }) => {
    // Note: The previous test might have modified the DB state if ran in parallel, 
    // but we can rely on Playwright's isolation or just re-register/use seeder.
    // Let's assume the previous test's user exists, or we register a new one to be safe.
    
    const uniqueEmail = `login_test_${Date.now()}@example.com`;
    const pwd = 'StrongPassword123!';
    // Register first to ensure we have a user
    await page.goto('/register');
    await page.getByLabel('First Name').fill('Login');
    await page.getByLabel('Last Name').fill('TestUser');
    await page.getByLabel('Email').fill(uniqueEmail);
    await page.locator('input[name="password"]').fill(pwd);
    await page.locator('input[name="password_confirmation"]').fill(pwd);
    await page.getByRole('button', { name: 'Register' }).click();
    await expect(page).toHaveURL('/');

    // Logout
    // Open dropdown (Alpine.js interaction)
    const userMenuButton = page.getByRole('button', { name: 'Account menu' });
    await userMenuButton.click();
    await page.getByText('Log Out').first().click(); // Dropdown button
    await page.getByRole('button', { name: 'Log Out' }).last().click(); // Modal confirm button
    await expect(page).toHaveURL('/');

    // Login
    await page.goto('/login');
    await page.getByLabel('Email').fill(uniqueEmail);
    await page.locator('input[name="password"]').fill(pwd);
    await page.getByRole('button', { name: 'Log in' }).click();

    // Should be redirected to customer dashboard
    await expect(page).toHaveURL('/');
    await expect(page.getByRole('button', { name: 'Account menu' })).toBeVisible();
  });

  test('Admin can login and is redirected to admin dashboard', async ({ page }) => {
    await page.goto('/login');
    await page.getByLabel('Email').fill(adminEmail);
    await page.locator('input[name="password"]').fill(adminPassword);
    await page.getByRole('button', { name: 'Log in' }).click();

    // Admins are redirected to /admin/dashboard
    await expect(page).toHaveURL(/.*\/admin\/dashboard/);
    
    // Verify admin elements are visible
    await expect(page.getByRole('heading', { name: 'Dashboard' })).toBeVisible();
  });
});
