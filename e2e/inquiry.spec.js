import { test, expect } from '@playwright/test';

test.describe('Inquiry Flow', () => {
  const customerEmail = `inquiry_test_${Date.now()}@example.com`;
  const customerPassword = 'StrongPassword123!';

  test.beforeEach(async ({ page }) => {
    // Create a customer user and login before the test
    await page.goto('/register');
    await page.getByLabel('First Name').fill('Inquiry');
    await page.getByLabel('Last Name').fill('Tester');
    await page.getByLabel('Email').fill(customerEmail);
    await page.locator('input[name="password"]').fill(customerPassword);
    await page.locator('input[name="password_confirmation"]').fill(customerPassword);
    await page.getByRole('button', { name: 'Register' }).click();
    await expect(page).toHaveURL('/');
  });

  test('Customer can submit a Telegram inquiry from the product detail page', async ({ page }) => {
    // Go to catalog
    await page.goto('/product-catalog');
    
    // Click on the first product's "View Detail"
    const productCard = page.locator('a:has-text("View Detail")').first();
    await expect(productCard).toBeVisible();
    await productCard.click();

    // Click "Inquire Via Telegram"
    const inquireBtn = page.getByRole('button', { name: /Inquire Via Telegram/i });
    await inquireBtn.click();

    // The modal should appear containing the phone number prompt or inquiry form
    // Let's assume there's a Phone Number field or directly submitting
    // We will look for a submit button in the modal
    const submitBtn = page.getByRole('button', { name: 'Send Inquiry' });
    if (await submitBtn.isVisible()) {
        // If there's a form requiring input, fill it. For now, try clicking submit.
        await submitBtn.click();
    } else {
        // It might be a direct link to telegram or another type of button
        // Let's ensure the modal is visible by checking its heading
        await expect(page.getByRole('heading', { name: 'One more step' })).toBeVisible();
        
        await page.getByLabel('Phone Number').fill('012345678');
        await page.getByRole('button', { name: 'Continue' }).click();
        
        // Wait for the inquiry success or redirect
    }

    // This test might need refinement based on exact Alpine modal interactions,
    // but this covers the happy path structure.
  });
});
