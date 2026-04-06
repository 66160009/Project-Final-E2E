import { expect, test } from '@playwright/test';

test('login.php loads and shows the login form', async ({ page }) => {
  const response = await page.goto('/login.php');

  expect(response?.ok()).toBeTruthy();
  await expect(page.getByLabel('Username')).toBeVisible();
  await expect(page.getByLabel('Password')).toBeVisible();
  await expect(page.getByRole('button', { name: 'Login' })).toBeVisible();
});

test('login.php authenticates a valid user', async ({ page }) => {
  await page.goto('/login.php');
  await page.getByLabel('Username').fill('admin');
  await page.getByLabel('Password').fill('admin123');
  await page.getByRole('button', { name: 'Login' }).click();

  await expect(page).toHaveURL(/index\.php$/);
  await expect(page.getByRole('heading', { name: 'Dashboard' })).toBeVisible();
});