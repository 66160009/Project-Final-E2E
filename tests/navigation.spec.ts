import { expect, test } from '@playwright/test';

import { login } from './helpers/auth';

test('protected pages in src are reachable after login', async ({ page }) => {
  await login(page);

  await page.goto('/index.php');
  await expect(page.getByRole('heading', { name: 'Dashboard' })).toBeVisible();

  await page.goto('/books.php');
  await expect(page.getByRole('heading', { name: 'Books Management' })).toBeVisible();

  await page.goto('/book_view.php?id=1');
  await expect(page.getByRole('heading', { name: 'View Book Details' })).toBeVisible();

  await page.goto('/book_edit.php?id=1');
  await expect(page.getByRole('heading', { name: 'Edit Book' })).toBeVisible();

  await page.goto('/borrow.php');
  await expect(page.getByRole('heading', { name: 'Borrow Book' })).toBeVisible();

  await page.goto('/return.php');
  await expect(page.getByRole('heading', { name: 'Return Book' })).toBeVisible();

  await page.goto('/members.php');
  await expect(page.getByRole('heading', { name: 'Members Management' })).toBeVisible();

  await page.goto('/reports.php');
  await expect(page.getByRole('heading', { name: 'Reports & Statistics' })).toBeVisible();
});