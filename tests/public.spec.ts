import { expect, test } from '@playwright/test';

test('public pages load successfully', async ({ page }) => {
  const loginResponse = await page.goto('/login.php');
  expect(loginResponse?.ok()).toBeTruthy();
  await expect(page.getByRole('heading', { name: /Library System/i })).toBeVisible();

  const phpInfoResponse = await page.goto('/phpinfo.php');
  expect(phpInfoResponse?.ok()).toBeTruthy();
  await expect(page.locator('body')).toContainText(/PHP Version/i);
});