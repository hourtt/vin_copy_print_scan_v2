# Instructions

- Following Playwright test failed.
- Explain why, be concise, respect Playwright best practices.
- Provide a snippet of code with the fix, if possible.

# Test info

- Name: profile.spec.js >> Customer Profile Management >> Customer can update their profile information
- Location: e2e\profile.spec.js:19:3

# Error details

```
Error: expect(locator).toBeVisible() failed

Locator: getByText('UpdatedName')
Expected: visible
Error: strict mode violation: getByText('UpdatedName') resolved to 5 elements:
    1) <div class="text-sm font-semibold font-['Kantumruy_Pro',sans-serif] text-[#0D0D0B]">↵                                    UpdatedName …</div> aka getByText('UpdatedName Tester').first()
    2) <div class="text-sm font-semibold font-['Kantumruy_Pro',sans-serif] text-[#0D0D0B]">↵                            UpdatedName Tester↵ …</div> aka getByText('UpdatedName Tester').nth(1)
    3) <p class="text-sm font-semibold text-black truncate">UpdatedName↵                Tester</p> aka getByRole('complementary').getByText('UpdatedName Tester')
    4) <h2 class="text-2xl font-bold text-gray-900">UpdatedName↵                            Tester</h2> aka getByRole('heading', { name: 'UpdatedName Tester' })
    5) <span class="mt-1" id="ie-display-name">UpdatedName↵                Tester</span> aka locator('#ie-display-name')

Call log:
  - Expect "toBeVisible" with timeout 5000ms
  - waiting for getByText('UpdatedName')

```

# Page snapshot

```yaml
- generic [ref=f3e2]:
  - navigation [ref=f3e3]:
    - generic [ref=f3e5]:
      - link "Vin Copy Print Scan V2 — Home" [ref=f3e7] [cursor=pointer]:
        - /url: /
        - img "Vin Copy Print Scan V2 logo" [ref=f3e8]
      - generic [ref=f3e9]:
        - link "Home" [ref=f3e10] [cursor=pointer]:
          - /url: /
        - button "Products" [ref=f3e12] [cursor=pointer]
        - link "Services" [ref=f3e15] [cursor=pointer]:
          - /url: http://127.0.0.1:8000/services
      - generic [ref=f3e16]:
        - link "My Inquiries" [ref=f3e17] [cursor=pointer]:
          - /url: http://127.0.0.1:8000/profile/inquiries
        - button "Account menu" [ref=f3e21] [cursor=pointer]
  - dialog "Log Out":
    - generic:
      - heading "Log Out" [level=2]
      - paragraph: Are you sure you want to log out?
      - generic:
        - button "Cancel"
        - button "Log Out"
  - main [ref=f3e25]:
    - generic [ref=f3e26]:
      - complementary [ref=f3e27]:
        - button [ref=f3e29] [cursor=pointer]
        - generic [ref=f3e32]:
          - generic [ref=f3e33]: U
          - generic [ref=f3e34]:
            - paragraph [ref=f3e35]: UpdatedName Tester
            - paragraph [ref=f3e36]: profile_test_1787457431155@example.com
        - generic [ref=f3e37]:
          - link "Home" [ref=f3e38] [cursor=pointer]:
            - /url: http://127.0.0.1:8000
          - link "Inquiries" [ref=f3e43] [cursor=pointer]:
            - /url: http://127.0.0.1:8000/profile/inquiries
          - button "Activity" [ref=f3e47] [cursor=pointer]
          - button "Favorites" [ref=f3e53] [cursor=pointer]
        - generic [ref=f3e57]:
          - heading "Settings" [level=2] [ref=f3e58]
          - button "General Profile" [ref=f3e59] [cursor=pointer]
          - button "Payment Methods" [ref=f3e64] [cursor=pointer]
          - button "Login & Security" [ref=f3e68] [cursor=pointer]
          - button "Notification Preferences" [ref=f3e73] [cursor=pointer]
        - generic [ref=f3e78]:
          - button "Help" [ref=f3e79] [cursor=pointer]
          - button "Log Out" [ref=f3e84] [cursor=pointer]
      - main [ref=f3e89]:
        - generic:
          - generic [ref=f3e90]:
            - generic [ref=f3e91]: U
            - heading "UpdatedName Tester" [level=2] [ref=f3e100]
          - generic [ref=f3e101]:
            - heading "Activity Overview" [level=3] [ref=f3e102]
            - generic [ref=f3e103]:
              - generic: My Inquiries
              - generic [ref=f3e104]:
                - generic [ref=f3e105]: "0"
                - generic [ref=f3e106]: total inquiries sent
              - link "View History" [ref=f3e108] [cursor=pointer]:
                - /url: http://127.0.0.1:8000/profile/inquiries
            - generic [ref=f3e109]:
              - generic: Saved
              - generic [ref=f3e110]: 0 wishlist
              - link "Telegram Support" [ref=f3e114] [cursor=pointer]:
                - /url: https://t.me/
          - generic [ref=f3e117]:
            - heading "Personal Information" [level=3] [ref=f3e118]
            - generic [ref=f3e119]:
              - generic: Full Name
              - generic:
                - generic [ref=f3e120]: UpdatedName Tester
                - button "Edit" [ref=f3e121] [cursor=pointer]
            - generic [ref=f3e122]:
              - generic: Contact Details
              - generic:
                - generic [ref=f3e123]:
                  - generic [ref=f3e124]: profile_test_1787457431155@example.com
                  - generic [ref=f3e125]: Phone not added
                - button "Edit" [ref=f3e126] [cursor=pointer]
          - generic [ref=f3e127]:
            - heading "Preferences" [level=3] [ref=f3e128]
            - generic [ref=f3e129]:
              - generic: Preferences
              - generic [ref=f3e130]: English (US) USD ($)
              - button "Edit" [ref=f3e132] [cursor=pointer]
          - generic [ref=f3e133]:
            - heading "Security & Integrations" [level=3] [ref=f3e134]
            - generic [ref=f3e135]:
              - generic: Connected Accounts
              - generic [ref=f3e136]: Signed in with Google
              - button "Manage" [ref=f3e144] [cursor=pointer]
```

# Test source

```ts
  1  | import { test, expect } from '@playwright/test';
  2  | 
  3  | test.describe('Customer Profile Management', () => {
  4  |   const customerEmail = `profile_test_${Date.now()}@example.com`;
  5  |   const customerPassword = 'StrongPassword123!';
  6  | 
  7  |   test.beforeEach(async ({ page }) => {
  8  |     // Register and login
  9  |     await page.goto('/register');
  10 |     await page.getByLabel('First Name').fill('Profile');
  11 |     await page.getByLabel('Last Name').fill('Tester');
  12 |     await page.getByLabel('Email').fill(customerEmail);
  13 |     await page.locator('input[name="password"]').fill(customerPassword);
  14 |     await page.locator('input[name="password_confirmation"]').fill(customerPassword);
  15 |     await page.getByRole('button', { name: 'Register' }).click();
  16 |     await expect(page).toHaveURL('/');
  17 |   });
  18 | 
  19 |   test('Customer can update their profile information', async ({ page }) => {
  20 |     // Navigate to profile
  21 |     // Note: Assuming there's a user dropdown
  22 |     const userMenuButton = page.getByRole('button', { name: 'Account menu' });
  23 |     await userMenuButton.click();
  24 |     await page.getByRole('link', { name: 'Profile' }).click();
  25 |     
  26 |     await expect(page).toHaveURL('/profile');
  27 |     
  28 |     // Update first name
  29 |     // Click the Edit button for the Personal Information section
  30 |     await page.getByRole('button', { name: 'Edit' }).first().click();
  31 |     await page.getByLabel('First Name').fill('UpdatedName');
  32 |     // Save button might be within a specific form
  33 |     const saveButton = page.locator('button:has-text("Save")').first();
  34 |     await saveButton.click();
  35 | 
  36 |     // Verify it saved by checking if the updated name is displayed
> 37 |     await expect(page.getByText('UpdatedName')).toBeVisible();
     |                                                 ^ Error: expect(locator).toBeVisible() failed
  38 |   });
  39 | });
  40 | 
```