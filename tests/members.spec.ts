import { expect, test } from '@playwright/test';

import { login } from './helpers/auth';

test('member_add.php workflow adds a member', async ({ page }) => {
  const uniqueSuffix = Date.now().toString().slice(-6);
  const memberCode = `PW${uniqueSuffix}`;
  const memberName = `Playwright Member ${uniqueSuffix}`;
  const email = `pw${uniqueSuffix}@example.com`;
  const phoneDigits = `08${uniqueSuffix}`.padEnd(10, '0').slice(0, 10);
  const phone = `${phoneDigits.slice(0, 3)}-${phoneDigits.slice(3, 6)}-${phoneDigits.slice(6, 10)}`;

  await login(page);
  const response = await page.request.post('/member_add.php', {
    form: {
      member_code: memberCode,
      full_name: memberName,
      email,
      phone,
      member_type: 'student',
    },
  });

  expect(response.ok()).toBeTruthy();
  await page.goto('/members.php');
  await expect(page.locator('body')).toContainText(memberCode);
  await expect(page.locator('body')).toContainText(memberName);
});