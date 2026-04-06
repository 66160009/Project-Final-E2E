import { expect, type Page } from '@playwright/test';

export async function login(page: Page) {
  await page.goto('/login.php');
  await page.getByLabel('Username').fill('admin');
  await page.getByLabel('Password').fill('admin123');
  await page.getByRole('button', { name: 'Login' }).click();
  await expect(page).toHaveURL(/index\.php$/);
}