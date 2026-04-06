import { expect, test } from '@playwright/test';

import { login } from './helpers/auth';

test('borrow.php workflow borrows a book successfully', async ({ page }) => {
  const uniqueSuffix = Date.now().toString();
  const title = `Playwright Borrow ${uniqueSuffix}`;

  await login(page);
  const createBookResponse = await page.request.post('/book_add.php', {
    form: {
      title,
      author: 'Playwright Borrow Author',
      publisher: 'Playwright Borrow Publisher',
      publication_year: '2026',
      category: 'Computer',
      total_copies: '1',
    },
  });

  expect(createBookResponse.ok()).toBeTruthy();

  await page.goto('/borrow.php');
  await page.locator('input[name="member_code"]').fill('M005');

  const option = page
    .locator('select[name="book_id"] option')
    .filter({ hasText: title })
    .first();
  const bookId = await option.getAttribute('value');

  expect(bookId).toBeTruthy();
  await page.locator('select[name="book_id"]').selectOption(bookId!);
  await page.getByRole('button', { name: 'Borrow Book' }).click();

  await expect(page.locator('.alert-success')).toContainText('Book borrowed successfully!');

  await page.goto('/return.php');
  const borrowedRow = page.locator('tbody tr').filter({ hasText: title }).first();
  await expect(borrowedRow).toContainText('M005');

  page.once('dialog', async (dialog) => {
    await dialog.accept();
  });
  await borrowedRow.getByRole('button', { name: 'Return' }).click();
  await expect(page.locator('.alert-success')).toContainText('Book returned successfully!');
});