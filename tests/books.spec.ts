import { expect, test } from '@playwright/test';

import { login } from './helpers/auth';

test('book_add.php workflow adds a book', async ({ page }) => {
  const uniqueSuffix = Date.now().toString();
  const title = `Playwright Book ${uniqueSuffix}`;

  await login(page);
  const response = await page.request.post('/book_add.php', {
    form: {
      title,
      author: 'Playwright Author',
      publisher: 'Playwright Publisher',
      publication_year: '2026',
      category: 'Computer',
      total_copies: '2',
    },
  });

  expect(response.ok()).toBeTruthy();
  await page.goto('/books.php');
  await expect(page.locator('body')).toContainText(title);
});