import { test, expect } from '@playwright/test';

test.describe('Customer Profile Management', () => {
  const customerEmail = `profile_test_${Date.now()}@example.com`;
  const customerPassword = 'StrongPassword123!';

  test.beforeEach(async ({ page }) => {
    // Register and login
    await page.goto('/register');
    await page.getByLabel('First Name').fill('Profile');
    await page.getByLabel('Last Name').fill('Tester');
    await page.getByLabel('Email').fill(customerEmail);
    await page.locator('input[name="password"]').fill(customerPassword);
    await page.locator('input[name="password_confirmation"]').fill(customerPassword);
    await page.getByRole('button', { name: 'Register' }).click();
    await expect(page).toHaveURL('/');
  });

  test('Customer can update their profile information', async ({ page }) => {
    // Navigate to profile
    // Note: Assuming there's a user dropdown
    const userMenuButton = page.getByRole('button', { name: 'Account menu' });
    await userMenuButton.click();
    await page.getByRole('link', { name: 'Profile' }).click();
    
    await expect(page).toHaveURL('/profile');
    
    // Update first name
    // Click the Edit button for the Personal Information section
    await page.getByRole('button', { name: 'Edit' }).first().click();
    await page.getByLabel('First Name').fill('UpdatedName');
    // Save button might be within a specific form
    const saveButton = page.locator('button:has-text("Save")').first();
    await saveButton.click();

    // Verify it saved by checking if the updated name is displayed
    await expect(page.getByText('UpdatedName').first()).toBeVisible();
  });
});
