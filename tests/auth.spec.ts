import { expect, test } from '@playwright/test';

import { login } from './helpers/auth';

test('logout.php clears access to protected pages', async ({ page }) => {
  await login(page);
  await page.goto('/logout.php');
  await expect(page).toHaveURL(/login\.php$/);

  await page.goto('/index.php');
  await expect(page).toHaveURL(/login\.php$/);
});