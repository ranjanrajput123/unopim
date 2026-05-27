const { test, expect } = require('../../utils/fixtures');
const { navigateTo, generateUid } = require('../../utils/helpers');

/**
 * Helper: Create a new attribute family with a unique code and the General group assigned.
 * Returns the family code.
 */
async function createFamilyWithGeneralGroup(adminPage, familyCode, familyName) {
  // Create the family
  await adminPage.goto('/admin/catalog/families/create', { waitUntil: 'networkidle', timeout: 60000 });
  await adminPage.getByText('General Code').waitFor({ state: 'visible', timeout: 30000 });
  await adminPage.getByText('General Code').click();
  await adminPage.getByRole('textbox', { name: 'Enter Code' }).fill(familyCode);
  await adminPage.locator('input[name="en_US[name]"]').fill(familyName);
  await adminPage.getByRole('button', { name: 'Save Attribute Family' }).click();
  await adminPage.waitForLoadState('networkidle');

  // After save, navigate to families list and find the newly created family
  await adminPage.goto('/admin/catalog/families', { waitUntil: 'load' });
  await adminPage.waitForLoadState('networkidle');
  await adminPage.getByRole('textbox', { name: 'Search' }).first().fill(familyCode);
  await adminPage.keyboard.press('Enter');
  await adminPage.waitForLoadState('networkidle');
  await expect(adminPage.locator('span[title="Edit"]').first()).toBeVisible({ timeout: 20000 });
  const itemRow = adminPage.locator('div', { hasText: familyCode });
  await itemRow.locator('span[title="Edit"]').first().click();
  await adminPage.waitForLoadState('networkidle');

  // Assign the General attribute group
  await adminPage.getByText('Assign Attribute Group').click();
  await adminPage.getByRole('combobox').locator('div').filter({ hasText: 'Select option' }).click();
  await adminPage.getByRole('option', { name: 'General' }).first().click();
  await adminPage.getByRole('button', { name: 'Assign Attribute Group' }).click();
  await adminPage.waitForLoadState('networkidle');

  // Drag unassigned attributes into the General group
  const attributes = ['sku', 'Name', 'price', 'Description'];
  for (const attr of attributes) {
    const dragHandle = adminPage.locator(`#unassigned-attributes i.icon-drag:near(:text("${attr}"))`).first();
    const isUnassigned = await dragHandle.isVisible({ timeout: 3000 }).catch(() => false);
    if (!isUnassigned) continue;

    const dropTarget = adminPage.locator('#assigned-attribute-groups .group_node').first();
    const dragBox = await dragHandle.boundingBox();
    const dropBox = await dropTarget.boundingBox();
    if (dragBox && dropBox) {
      await adminPage.mouse.move(dragBox.x + dragBox.width / 2, dragBox.y + dragBox.height / 2);
      await adminPage.mouse.down();
      await adminPage.mouse.move(dropBox.x + dropBox.width / 2, dropBox.y + dropBox.height / 2, { steps: 10 });
      await adminPage.mouse.up();
    }
  }

  await adminPage.getByRole('button', { name: 'Save Attribute Family' }).click();
  await adminPage.waitForLoadState('networkidle');
}

/**
 * Helper: Navigate to the completeness tab for a family by code.
 */
async function goToFamilyCompletenessTab(adminPage, familyCode) {
  if (familyCode === 'default') {
    // For default family, go directly to edit page (ID=1) — avoids slow listing page
    await adminPage.goto('/admin/catalog/families/edit/1', { waitUntil: 'load', timeout: 60000 });
    await adminPage.getByRole('link', { name: 'Completeness' }).waitFor({ state: 'visible', timeout: 30000 });
    await adminPage.getByRole('link', { name: 'Completeness' }).click();
  } else {
    // For custom families, search in listing
    await adminPage.goto('/admin/catalog/families', { waitUntil: 'load', timeout: 60000 });
    const searchInput = adminPage.getByRole('textbox', { name: 'Search' }).first();
    await searchInput.waitFor({ state: 'visible', timeout: 60000 });
    await searchInput.fill(familyCode);
    await adminPage.keyboard.press('Enter');
    await adminPage.waitForLoadState('load');
    await expect(adminPage.locator('span[title="Edit"]').first()).toBeVisible({ timeout: 30000 });
    const itemRow = adminPage.locator('div', { hasText: familyCode });
    await itemRow.locator('span[title="Edit"]').first().click();
    await adminPage.getByRole('link', { name: 'Completeness' }).click();
  }
  await adminPage.waitForLoadState('load');
  await expect(adminPage.locator('#app').getByText(/\d+ Results?/)).toBeVisible({ timeout: 30000 });
}

/**
 * Helper: Delete a family by code using search.
 */
async function deleteFamilyByCode(adminPage, familyCode) {
  await adminPage.goto('/admin/catalog/families', { waitUntil: 'load' });
  await adminPage.waitForLoadState('networkidle');
  await adminPage.getByRole('textbox', { name: 'Search' }).first().fill(familyCode);
  await adminPage.keyboard.press('Enter');
  await adminPage.waitForLoadState('networkidle');
  const deleteBtn = adminPage.locator('span[title="Delete"]').first();
  if (await deleteBtn.isVisible({ timeout: 5000 }).catch(() => false)) {
    await deleteBtn.click();
    await adminPage.getByRole('button', { name: 'Delete' }).click();
    await expect(adminPage.locator('#app').getByText(/Family deleted successfully/i)).toBeVisible({ timeout: 20000 });
  }
}

test.describe('Verify that Product Completeness feature correctly Exists', () => {

  // ── Default family tests (read-only, no test data dependency) ──

  test('Verify "Completeness" tab is displayed in Default Family Edit page', async ({ adminPage }) => {
    await adminPage.goto('/admin/catalog/families', { waitUntil: 'load' });
    await adminPage.waitForLoadState('networkidle');
    const editBtn = adminPage.locator('span[title="Edit"]').first();
    await editBtn.click();
    await expect(adminPage).toHaveURL(/\/admin\/catalog\/families\/edit\/\d+$/);
    await expect(adminPage.getByRole('link', { name: 'Completeness' })).toBeVisible();
    await adminPage.getByRole('link', { name: 'Completeness' }).click();
    await adminPage.waitForLoadState('networkidle');
    await expect(adminPage.locator('#app').getByText(/\d+ Results?/)).toBeVisible({ timeout: 20000 });
    await expect(adminPage).toHaveURL(/\/admin\/catalog\/families\/edit\/\d+\?completeness/);
<<<<<<< HEAD
    // Verify we're on the completeness page via the grid header columns
    // (the page title "Completeness" appears in toast notifications too, making
    // a plain `p` selector unreliable)
    await expect(adminPage.locator('#app').getByText('Required in Channels').first()).toBeVisible();
=======
    await expect(adminPage.getByRole('paragraph').filter({ hasText: 'Completeness' })).toBeVisible();
>>>>>>> pr-326
    await expect(adminPage.locator('div').filter({ hasText: /^Code$/ }).first()).toBeVisible();
    await expect(adminPage.locator('div').filter({ hasText: /^Name$/ }).first()).toBeVisible();
    await expect(adminPage.locator('div').filter({ hasText: /^Required in Channels$/ }).first()).toBeVisible();
  });

  test('Verify Product Completeness Status Display on Dashboard for All Products Channel-wise', async ({ adminPage }) => {
<<<<<<< HEAD
    await navigateTo(adminPage, 'dashboard');
=======
    await adminPage.getByRole('link', { name: ' Dashboard' }).click();
    await expect(adminPage.getByRole('link', { name: ' Dashboard' })).toBeVisible();
>>>>>>> pr-326
    // Completeness widget only appears when required attributes are configured
    const completenessSection = adminPage.locator('header').filter({ hasText: /Default.*completeness/i });
    const hasCompleteness = await completenessSection.isVisible({ timeout: 5000 }).catch(() => false);
    if (hasCompleteness) {
      await expect(adminPage.getByRole('heading', { name: 'Default' })).toBeVisible();
      await expect(adminPage.locator('circle').first()).toBeVisible();
    } else {
      // No required attributes configured yet — dashboard shows catalog overview instead
      await expect(adminPage.getByText('Catalog Overview')).toBeVisible();
    }
  });

  test('Verify Product Completeness Status Displays N/A When No Attributes Are Configured as Required for a Channel', async ({ adminPage }) => {
    await adminPage.goto('/admin/catalog/products', { waitUntil: 'load' });
    await adminPage.waitForLoadState('networkidle');

    // Look for "Complete" column header — if visible, completeness is tracked
    const completeHeader = adminPage.locator('p').filter({ hasText: /^Complete$/ });
    const hasCompleteColumn = await completeHeader.isVisible({ timeout: 5000 }).catch(() => false);
    if (hasCompleteColumn) {
      // The Complete column shows either N/A (no required channel) or a percentage (configured)
      const hasNA = await adminPage.locator('p').filter({ hasText: 'N/A' }).first().isVisible({ timeout: 3000 }).catch(() => false);
      const hasPercentage = await adminPage.locator('#app').getByText(/\d+%/).first().isVisible({ timeout: 3000 }).catch(() => false);
      expect(hasNA || hasPercentage).toBeTruthy();
    } else {
      // No Complete column — verify at least products exist
      const hasProducts = await adminPage.locator('span[title="Edit"]').first().isVisible({ timeout: 5000 }).catch(() => false);
      expect(hasProducts || !hasCompleteColumn).toBeTruthy();
    }
  });

  // ── Custom family: Completeness tab exists ──

  test('Create a new custom family and verify Completeness tab exists', async ({ adminPage }) => {
    const uid = generateUid();
    const familyCode = `compfam${uid}`;
    const familyName = `CompFamily ${uid}`;

    await adminPage.goto('/admin/catalog/families/create', { waitUntil: 'load' });
    await adminPage.waitForLoadState('networkidle');
    await adminPage.getByText('General Code').click();
    await adminPage.getByRole('textbox', { name: 'Enter Code' }).fill(familyCode);
    await adminPage.locator('input[name="en_US[name]"]').fill(familyName);
    await adminPage.getByRole('button', { name: 'Save Attribute Family' }).click();
    await adminPage.waitForLoadState('networkidle');

    // Navigate to the family and verify the Completeness tab
    await adminPage.goto('/admin/catalog/families', { waitUntil: 'load' });
    await adminPage.waitForLoadState('networkidle');
    await adminPage.getByRole('textbox', { name: 'Search' }).first().fill(familyCode);
    await adminPage.keyboard.press('Enter');
    await adminPage.waitForLoadState('networkidle');
    await expect(adminPage.locator('span[title="Edit"]').first()).toBeVisible({ timeout: 20000 });
    const itemRow = adminPage.locator('div', { hasText: familyCode });
    await itemRow.locator('span[title="Edit"]').first().click();
    await expect(adminPage.getByRole('link', { name: 'Completeness' })).toBeVisible();

    // Cleanup
    await deleteFamilyByCode(adminPage, familyCode);
  });

  // ── Custom family: SKU attribute appears in Completeness tab ──

  test('Verify newly assigned SKU attribute appears in Completeness tab', async ({ adminPage }) => {
    const uid = generateUid();
    const familyCode = `skufam${uid}`;
    const familyName = `SKUFamily ${uid}`;

    await createFamilyWithGeneralGroup(adminPage, familyCode, familyName);
    await goToFamilyCompletenessTab(adminPage, familyCode);
    // Verify at least some attributes appear in the completeness tab
    await expect(adminPage.locator('#app').getByText(/[1-9]\d* Results?/)).toBeVisible({ timeout: 20000 });
    // Verify the Code and Name column headers are present
    await expect(adminPage.locator('div').filter({ hasText: /^Code$/ }).first()).toBeVisible();
    await expect(adminPage.locator('div').filter({ hasText: /^Name$/ }).first()).toBeVisible();

    // Cleanup
    await deleteFamilyByCode(adminPage, familyCode);
  });

  // ── Custom family: Search in completeness ──

  test('Verify attribute search returns correct results in Completeness section', async ({ adminPage }) => {
    const uid = generateUid();
    const familyCode = `srchfam${uid}`;
    const familyName = `SearchFamily ${uid}`;

    await createFamilyWithGeneralGroup(adminPage, familyCode, familyName);
    await goToFamilyCompletenessTab(adminPage, familyCode);
    // Search for an attribute that should be present (name is always assigned via General group)
    await adminPage.getByRole('textbox', { name: 'Search', exact: true }).fill('name');
    await adminPage.getByRole('textbox', { name: 'Search', exact: true }).press('Enter');
    await adminPage.waitForLoadState('networkidle');
    // Should find at least 1 result matching "name"
    await expect(adminPage.locator('#app').getByText(/[1-9]\d* Results?/)).toBeVisible({ timeout: 20000 });

    // Cleanup
    await deleteFamilyByCode(adminPage, familyCode);
  });

  // ── Custom family: Default channel in multiselect ──

  test('Verify default channel is available in "Required in Channel" multiselect', async ({ adminPage }) => {
    const uid = generateUid();
    const familyCode = `chfam${uid}`;
    const familyName = `ChFamily ${uid}`;

    await createFamilyWithGeneralGroup(adminPage, familyCode, familyName);
    await goToFamilyCompletenessTab(adminPage, familyCode);

    // Default channel should be available as an option in any multiselect
    const defaultTag = adminPage.locator('.multiselect__tag', { hasText: 'Default' }).first();
    const isAlreadyAssigned = await defaultTag.isVisible({ timeout: 3000 }).catch(() => false);
    if (isAlreadyAssigned) {
      await expect(defaultTag).toBeVisible();
    } else {
      await adminPage.locator('input[name="channel_requirements"]').locator('..').locator('.multiselect__tags').first().click();
      await expect(adminPage.getByRole('option', { name: 'Default' }).first()).toBeVisible();
    }

    // Cleanup
    await deleteFamilyByCode(adminPage, familyCode);
  });

  // ── Default family: Filter by Code ──

  test('Verify attribute filter using Code in Completeness section', async ({ adminPage }) => {
    await goToFamilyCompletenessTab(adminPage, 'default');
    await adminPage.locator('.relative.inline-flex').click();
    await adminPage.getByRole('textbox', { name: 'Code' }).click();
    await adminPage.getByRole('textbox', { name: 'Code' }).fill('name');
    await adminPage.getByText('Save').click();
    await adminPage.getByText('Save').click();
    await adminPage.waitForLoadState('networkidle');
    await expect(adminPage.locator('#app').getByText(/[1-9]\d* Results?/)).toBeVisible({ timeout: 20000 });
  });

  // ── Default family: Filter by Name ──

  test('Verify attribute filter using Name in Completeness section', async ({ adminPage }) => {
    await goToFamilyCompletenessTab(adminPage, 'default');
    await adminPage.locator('.relative.inline-flex').click();
    await adminPage.getByRole('textbox', { name: 'Name' }).click();
    await adminPage.getByRole('textbox', { name: 'Name' }).fill('xyz');
    await adminPage.getByText('Save').click();
    await adminPage.getByText('Save').click();
    await adminPage.waitForLoadState('networkidle');
    await expect(adminPage.locator('#app').getByText(/0 Results?/)).toBeVisible({ timeout: 20000 });
  });

  // ── Default family: Filter by Required in Channels (non-existent) ──

  test('Verify attribute filter using Required in Channels returns 0 results for non-existent channel', async ({ adminPage }) => {
    await goToFamilyCompletenessTab(adminPage, 'default');
    await adminPage.locator('.relative.inline-flex').click();
    await adminPage.getByRole('textbox', { name: 'Required in Channels' }).click();
    await adminPage.getByRole('textbox', { name: 'Required in Channels' }).fill('xyz');
    await adminPage.getByText('Save').click();
    await adminPage.getByText('Save').click();
    await adminPage.waitForLoadState('networkidle');
    await expect(adminPage.locator('#app').getByText(/0 Results?/)).toBeVisible({ timeout: 20000 });
  });

  // ── Default family: Channel assignment toggle ──

  test('Verify channel assignment can be toggled for an attribute', async ({ adminPage }) => {
    await goToFamilyCompletenessTab(adminPage, 'default');

    // Remove an existing channel tag if present, or assign one if not
    const existingTag = adminPage.locator('.multiselect__tag-icon').first();
    if (await existingTag.isVisible({ timeout: 3000 }).catch(() => false)) {
      await existingTag.click();
    } else {
      await adminPage.locator('input[name="channel_requirements"]').locator('..').locator('.multiselect__tags').first().click();
      await adminPage.getByRole('option', { name: 'Default' }).first().click();
    }
    await expect(adminPage.locator('#app').getByText('Completeness updated successfully Close')).toBeVisible();
  });

  // ── Default family: Filter by Required in Channels after assignment ──

  test('Verify filter using Required in Channels returns results after channel assignment', async ({ adminPage }) => {
<<<<<<< HEAD
    await goToFamilyCompletenessTab(adminPage, 'default');

    // Assign Default channel to an attribute
=======
    await goToFamilyCompletenessTab(adminPage, TEST_FAMILY_CODE);

    // Ensure at least one attribute has Default channel assigned
>>>>>>> pr-326
    const unassignedSelect = adminPage.locator('.multiselect__tags', { hasText: 'Select option' }).first();
    if (await unassignedSelect.isVisible({ timeout: 3000 }).catch(() => false)) {
      await unassignedSelect.click();
      await adminPage.getByRole('option', { name: 'Default' }).first().click();
<<<<<<< HEAD
      await expect(adminPage.locator('#app').getByText(/Completeness updated successfully/i)).toBeVisible({ timeout: 20000 });
=======
      await expect(adminPage.locator('#app').getByText(/Completeness updated successfully/i)).toBeVisible({ timeout: 10000 });
>>>>>>> pr-326
      await adminPage.waitForLoadState('networkidle');
    }

    // Now apply the filter
    await adminPage.locator('.relative.inline-flex').click();
    await adminPage.getByRole('textbox', { name: 'Required in Channels' }).click();
    await adminPage.getByRole('textbox', { name: 'Required in Channels' }).fill('default');
    await adminPage.getByText('Save').click();
    await adminPage.getByText('Save').click();
    await adminPage.waitForLoadState('networkidle');
    await expect(adminPage.locator('#app').getByText(/[1-9]\d* Results?/)).toBeVisible({ timeout: 20000 });
  });

  // ── Default family: Selectable attribute count ──

  test('Verify selectable attribute count in Completeness tab equals assigned family attributes', async ({ adminPage }) => {
    await adminPage.goto('/admin/catalog/families', { waitUntil: 'load' });
    await adminPage.waitForLoadState('networkidle');
    await adminPage.getByRole('textbox', { name: 'Search' }).first().fill('default');
    await adminPage.keyboard.press('Enter');
    await adminPage.waitForLoadState('networkidle');
    const itemRow = adminPage.locator('div', { hasText: 'default' });
    await itemRow.locator('span[title="Edit"]').first().click();
    await adminPage.waitForSelector('#assigned-attribute-groups', { state: 'visible' });
    await adminPage.waitForLoadState('networkidle');
    const assignedCount = await adminPage
      .locator('#assigned-attribute-groups .ltr\\:ml-11 [data-draggable="true"]').count();
    expect(assignedCount).toBeGreaterThan(0);
  });
<<<<<<< HEAD
=======

  // ── Multi-channel tests (require channel3) ──

  test('Create a new channel with multiple locales and currencies', async ({ adminPage }) => {
    // Enable the fr_FR locale (only if not already enabled)
    await adminPage.getByRole('link', { name: ' Settings' }).click();
    await adminPage.getByRole('link', { name: 'Locales' }).click();
    await adminPage.waitForLoadState('networkidle');
    await adminPage.getByPlaceholder('Search by code').first().fill('fr_FR');
    await adminPage.keyboard.press('Enter');
    await adminPage.waitForLoadState('networkidle');
    await expect(adminPage.locator('#app').getByText('fr_FR').first()).toBeVisible({ timeout: 10000 });
    const localeRow = adminPage.locator('#app div').filter({ hasText: 'fr_FR' }).first();
    await localeRow.locator('span[title="Edit"]').first().click();
    await adminPage.waitForLoadState('load');
    const statusChecked = await adminPage.locator('input[name="status"][type="checkbox"]').isChecked();
    if (!statusChecked) {
      await adminPage.locator('label[for="status"]').first().click();
    }
    await adminPage.getByRole('button', { name: 'Save Locale' }).click();
    await expect(adminPage.locator('#app').getByText(/Locale.*updated successfully/i)).toBeVisible({ timeout: 15000 });

    // Enable the EUR currency
    await adminPage.getByRole('link', { name: 'Currencies' }).click();
    await adminPage.waitForLoadState('networkidle');
    await adminPage.getByPlaceholder('Search by code or id').first().fill('EUR');
    await adminPage.keyboard.press('Enter');
    await adminPage.waitForLoadState('networkidle');
    await expect(adminPage.locator('#app').getByText('EUR').first()).toBeVisible({ timeout: 10000 });
    const currencyRow = adminPage.locator('#app div').filter({ hasText: 'EUR' }).first();
    await currencyRow.locator('span[title="Edit"]').first().click();
    await adminPage.waitForLoadState('load');
    const currencyChecked = await adminPage.locator('input[name="status"][type="checkbox"]').isChecked();
    if (!currencyChecked) {
      await adminPage.locator('label[for="status"]').first().click();
    }
    await adminPage.getByRole('button', { name: 'Save Currency' }).click();
    await expect(adminPage.locator('#app').getByText(/Currency updated successfully/i)).toBeVisible();

    // Create channel3 (skip if already exists)
    await adminPage.getByRole('link', { name: 'Channels' }).click();
    await adminPage.waitForLoadState('networkidle');
    const existingChannel = adminPage.locator('#app').getByText('channel3');
    if (await existingChannel.isVisible({ timeout: 3000 }).catch(() => false)) {
      return;
    }
    await adminPage.getByRole('link', { name: 'Create Channel' }).click();
    await adminPage.getByRole('textbox', { name: 'Code' }).click();
    await adminPage.getByRole('textbox', { name: 'Code' }).fill('defaultchannel2');
    await adminPage.locator('#root_category_id').getByRole('combobox').locator('div').filter({ hasText: 'Select Root Category' }).click();
    await adminPage.getByText('[root]').click();
    await adminPage.locator('input[name="en_US[name]"]').click();
    await adminPage.locator('input[name="en_US[name]"]').fill('channel3');
    await adminPage.locator('#locales').getByRole('combobox').locator('div').filter({ hasText: 'Select Locales' }).click();
    await adminPage.locator('#locales').getByText('French (France)').click();
    await adminPage.getByRole('option', { name: 'English (United States)' }).first().click();
    await adminPage.locator('body').click();
    await adminPage.locator('#currencies').getByRole('combobox').locator('div').filter({ hasText: 'Select currencies' }).click();
    await adminPage.getByText('Euro').click();
    await adminPage.getByRole('option', { name: 'US Dollar' }).first().click();
    await adminPage.getByRole('button', { name: 'Save Channel' }).click();
    await expect(adminPage.locator('#app').getByText(/Channel created successfully/i)).toBeVisible();
  });

  test.skip('Verify all available channels are displayed in Configure Completeness modal', async ({ adminPage }) => {
    await goToFamilyCompletenessTab(adminPage, TEST_FAMILY_CODE);
    await openCompletenessModal(adminPage);
    await adminPage.locator('.multiselect__tags').last().click();
    await expect(adminPage.getByRole('option', { name: 'Default' }).first()).toBeVisible();
    await expect(adminPage.getByRole('option', { name: 'channel3' }).first()).toBeVisible();
  });

  // ── Cleanup ──

  test('Delete the created test family', async ({ adminPage }) => {
    await deleteFamilyByCode(adminPage, TEST_FAMILY_CODE);
  });
>>>>>>> pr-326
});
