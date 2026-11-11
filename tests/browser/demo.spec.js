import { test, expect } from '@playwright/test';
import { mkdir } from 'node:fs/promises';

async function login(page, account) {
    await page.goto('/login');
    await page.getByLabel('Email').fill(`${account}@hris.example`);
    await page.getByLabel('Password', { exact: true }).fill('demo-password');
    await page.getByRole('button', { name: 'Log in', exact: true }).click();
    await expect(page).toHaveURL(/\/dashboard$/);
}

async function screenshot(page, name) {
    if (process.env.CAPTURE_DEMO_SCREENSHOTS !== '1') return;
    await mkdir('docs/screenshots', { recursive: true });
    await page.evaluate(() => document.fonts.ready);
    await page.screenshot({ path: `docs/screenshots/${name}.png`, fullPage: true });
}

test('HR can review leave requests and log out through the interface', async ({ page }) => {
    const errors = [];
    page.on('pageerror', error => errors.push(error.message));
    await login(page, 'hr');
    await expect(page.getByRole('heading', { name: 'Dashboard', exact: true })).toBeVisible();
    const counts = await page.request.get('/dashboard/presence');
    expect(counts.ok()).toBeTruthy();
    expect(await counts.json()).toHaveLength(12);
    await expect.poll(() => page.locator('#presence').evaluate(canvas =>
        window.Chart.getChart(canvas)?.data.datasets[0].data.length || 0)).toBe(12);
    await page.locator('#presence').evaluate(canvas => window.Chart.getChart(canvas).update('none'));
    await screenshot(page, 'dashboard');

    await page.goto('/leave-requests');
    let row = page.getByRole('row').filter({ hasText: 'Jordan Lee' });
    // Reset the demo decision if this test is run again against the same database.
    if (!(await row.getByRole('button', { name: 'Confirm', exact: true }).count())) {
        await row.getByRole('button', { name: 'Reject', exact: true }).click();
    }
    row = page.getByRole('row').filter({ hasText: 'Jordan Lee' });
    await row.getByRole('button', { name: 'Confirm', exact: true }).click();
    await expect(page.getByRole('row').filter({ hasText: 'Jordan Lee' }).locator('.badge')).toHaveText('Confirm');
    await screenshot(page, 'leave-requests');

    await page.getByRole('button', { name: /Logout$/ }).click();
    await expect(page).toHaveURL(/\/login$/);
    expect(errors).toEqual([]);
});

for (const account of ['developer', 'sales']) {
    test(`${account} sees only assigned tasks and cannot manage employees`, async ({ page }) => {
        const errors = [];
        page.on('pageerror', error => errors.push(error.message));
        await login(page, account);
        await page.goto('/tasks');
        const title = account === 'developer' ? 'Prepare the release checklist' : 'Follow up on the demo proposal';
        let row = page.getByRole('row').filter({ hasText: title });
        await expect(row).toBeVisible();
        await expect(page.getByText('Review the leave requests', { exact: true })).toHaveCount(0);
        await expect(page.getByRole('link', { name: 'New Task', exact: true })).toHaveCount(0);
        if (await row.getByRole('button', { name: 'Mark as Pending', exact: true }).count()) {
            await row.getByRole('button', { name: 'Mark as Pending', exact: true }).click();
        }
        row = page.getByRole('row').filter({ hasText: title });
        await row.getByRole('button', { name: 'Mark as Done', exact: true }).click();
        await expect(page.getByRole('row').filter({ hasText: title }).locator('.badge')).toHaveText('Done');
        if (account === 'developer') await screenshot(page, 'employee-tasks');
        const forbidden = await page.goto('/employees');
        expect(forbidden.status()).toBe(403);
        expect(errors).toEqual([]);
    });
}
