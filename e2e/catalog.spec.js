import { test, expect } from '@playwright/test';

test.describe('Catalog and Products', () => {
  test('User can browse categories and view products', async ({ page }) => {
    // Navigate to homepage/catalog
    await page.goto('/product-catalog');

    // Wait for the page to load
    await expect(page.getByText('Product Catalogs')).toBeVisible();

    // Click on a specific category if it exists, or just search
    // Testing the product listing
    const productCard = page.locator('a:has-text("View Detail")').first();
    await expect(productCard).toBeVisible();

    // Navigate to product detail
    await productCard.click();

    // Should be on the product detail page
    await expect(page).toHaveURL(/.*\/products\/.*/);

    // Verify product detail elements
    await expect(page.getByRole('link', { name: /Sign in to Inquire/i })).toBeVisible();
    await expect(page.getByRole('link', { name: 'Back' })).toBeVisible();
  });
});
