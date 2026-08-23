import { test, expect } from '@playwright/test';

test.describe('Admin Settings', () => {
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

  test('Admin can view settings page', async ({ page }) => {
    await page.goto('/admin/settings');
    await expect(page.getByRole('heading', { name: 'Settings' })).toBeVisible();
    // Assuming there is a Store Name setting
    await expect(page.locator('input[name="shop_name"]')).toBeVisible();
  });
});
