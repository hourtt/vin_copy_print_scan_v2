import { test, expect } from '@playwright/test';

test.describe('Admin Categories Management', () => {
  const adminEmail = 'lyengPrinter@gmail.com';
  const adminPassword = 'lyengPrinter@731946';

  test.beforeEach(async ({ page }) => {
    // Login as admin
    await page.goto('/login');
    await page.getByLabel('Email').fill(adminEmail);
    await page.locator('input[name="password"]').fill(adminPassword);
    await page.getByRole('button', { name: 'Log in' }).click();
    await expect(page).toHaveURL(/.*\/admin\/dashboard/);
  });

  test('Admin can view categories list', async ({ page }) => {
    await page.goto('/admin/categories');
    await expect(page.getByRole('heading', { name: 'Categories' })).toBeVisible();
  });
});
