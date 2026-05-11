<?php
/**
 * ListTable Component
 * Renders the data table with loading, empty, and populated states
 */

$activeTab = $activeTab ?? null;
$loadingData = $loadingData ?? false;
$reportData = $reportData ?? null; // null or empty array for no data
$tableHeadersHtml = $tableHeadersHtml ?? '';
$tableBodyHtml = $tableBodyHtml ?? '';
?>

<style>
.list-table-loading {
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  height: 100%;
  padding: 2rem;
  gap: 1rem;
}

.list-table-spinner {
  width: 40px;
  height: 40px;
  border: 4px solid #f3f3f3;
  border-top: 4px solid var(--dark-green, #055035);
  border-radius: 50%;
  animation: listTableSpin 1s linear infinite;
}

@keyframes listTableSpin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}

.list-table-no-data {
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  text-align: center;
  padding: 3rem 1rem;
  height: 400px;
}

.list-table-no-data-icon {
  margin-bottom: 1rem;
  color: var(--gray-icon, #9ca3af);
  display: flex;
  justify-content: center;
  align-items: center;
}

.list-table-no-data h3 {
  font-size: 1rem;
  color: var(--text-dark, #374151);
  margin: 0 0 0.5rem 0;
  font-weight: 600;
  font-family: var(--font-main, 'Montserrat', sans-serif);
}

.list-table-no-data p {
  font-size: 0.8rem;
  color: var(--text-gray, #6b7280);
  margin: 0;
  font-family: var(--font-main, 'Montserrat', sans-serif);
}

.list-table-element {
  width: 100%;
  border-collapse: collapse;
  font-size: 0.7rem;
  font-family: var(--font-main, 'Montserrat', sans-serif);
}

/* Base styles for table if needed */
.list-table-element th {
  text-align: left;
  padding: 0.75rem 1rem;
  border-bottom: 1px solid #e5e7eb;
  color: var(--text-gray, #6b7280);
  font-weight: 600;
  background-color: #f9fafb;
}

.list-table-element td {
  padding: 0.75rem 1rem;
  border-bottom: 1px solid #e5e7eb;
  color: #374151;
}
</style>

<div class="list-table-container" style="flex: 1; overflow-y: auto;">
  <?php if ($loadingData): ?>
    <!-- Loading State -->
    <div class="list-table-loading">
      <div class="list-table-spinner"></div>
      <p style="color: #666; font-size: 0.875rem; margin: 0; font-family: var(--font-main, 'Montserrat', sans-serif);">
        Loading <?php echo htmlspecialchars(strtolower((string)$activeTab)); ?>...
      </p>
    </div>

  <?php elseif (!$activeTab): ?>
    <!-- No Tab Selected State -->
    <div class="list-table-no-data">
      <div class="list-table-no-data-icon" style="font-size: 48px; width: 48px; height: 48px;">
        <!-- BsClipboard2Data equivalent SVG -->
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" fill="currentColor"><path d="M192 0c-41.8 0-77.4 26.7-90.5 64H64C28.7 64 0 92.7 0 128V448c0 35.3 28.7 64 64 64H320c35.3 0 64-28.7 64-64V128c0-35.3-28.7-64-64-64H282.5C269.4 26.7 233.8 0 192 0zm0 64a32 32 0 1 1 0 64 32 32 0 1 1 0-64zM112 192H272c8.8 0 16 7.2 16 16s-7.2 16-16 16H112c-8.8 0-16-7.2-16-16s7.2-16 16-16z"/></svg>
      </div>
      <h3>No List Selected</h3>
      <p>Please select a tab above to view data</p>
    </div>

  <?php elseif (empty($reportData)): ?>
    <!-- No Data State -->
    <div class="list-table-no-data" style="height: 400px;">
      <div class="list-table-no-data-icon" style="font-size: 40px; width: 40px; height: 40px;">
        <?php
          // Render appropriate icon based on active tab
          if ($activeTab === 'Beneficiary List') {
             // FaUsersLine equivalent
             echo '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512" fill="currentColor"><path d="M144 160A80 80 0 1 0 144 0a80 80 0 1 0 0 160zm352 0A80 80 0 1 0 496 0a80 80 0 1 0 0 160zM0 298.7C0 239.8 47.8 192 106.7 192h42.7c15.9 0 31 3.5 44.6 9.7c-1.3 7.2-1.9 14.7-1.9 22.3c0 38.2 16.8 72.5 43.3 96c-.2 0-.4 0-.7 0H21.3C9.6 320 0 310.4 0 298.7zM405.3 320c-.2 0-.4 0-.7 0c26.6-23.5 43.3-57.8 43.3-96c0-7.6-.7-15-1.9-22.3c13.6-6.1 28.8-9.7 44.6-9.7h42.7C592.2 192 640 239.8 640 298.7c0 11.8-9.6 21.3-21.3 21.3H405.3zM224 224a96 96 0 1 1 192 0 96 96 0 1 1 -192 0zM128 485.3C128 411.7 187.7 352 261.3 352H378.7C452.3 352 512 411.7 512 485.3c0 14.7-11.9 26.7-26.7 26.7H154.7c-14.7 0-26.7-11.9-26.7-26.7z"/></svg>';
          } elseif ($activeTab === 'Farm Location') {
             // GrMapLocation equivalent
             echo '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" fill="currentColor"><path d="M408 120c0 54.6-73.1 151.9-105.2 192c-7.7 9.6-22 9.6-29.6 0C241.1 271.9 168 174.6 168 120C168 53.7 221.7 0 288 0s120 53.7 120 120zm8 80.4c3.5-6.9 6.7-13.8 9.6-20.6c.5-1.2 1-2.5 1.5-3.7l116-46.4C558.9 123.4 576 135 576 152V422.8c0 9.8-6 18.6-15.1 22.3L416 496v-96c0-35.3-28.7-64-64-64H224c-35.3 0-64 28.7-64 64v96L15.1 445.1C6 441.4 0 432.6 0 422.8V152c0-17 17.1-28.6 32.9-22.3L160 178.6V296c0 13.3 10.7 24 24 24h32v80c0 17.7 14.3 32 32 32h80c17.7 0 32-14.3 32-32v-80h32c13.3 0 24-10.7 24-24V200.4zM288 152a32 32 0 1 0 0-64 32 32 0 1 0 0 64z"/></svg>';
          } elseif ($activeTab === 'Seedling Record') {
             // FaSeedling equivalent
             echo '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" fill="currentColor"><path d="M272 96c-78.6 0-145.1 51.5-167.7 122.5c33.6-17 71.5-26.5 111.7-26.5h88c8.8 0 16 7.2 16 16s-7.2 16-16 16H216c-39.9 0-76.2 11.8-106.9 31.6C147.1 305.8 204 352 272 352c88.4 0 160-71.6 160-160c0-61.9-35.6-115.4-86.4-142.6C325.2 40.5 299.7 32 272 32c-5.9 0-11.7 .3-17.5 .8C265 52.8 272 73.6 272 96zm24 272c-88.4 0-160-71.6-160-160c0-12.8 1.5-25.2 4.3-37.1C55.4 195.9 0 274.6 0 368c0 44.2 16 84.5 42.4 115.5C40.6 486 32 491 32 496c0 8.8 7.2 16 16 16s16-7.2 16-16c0-5.8-1.5-11.2-4.1-15.8C89.4 501.4 125.7 512 164 512c88.4 0 160-71.6 160-160zM496 160c0-88.4-71.6-160-160-160c-25.4 0-49.3 5.9-70.5 16.5c39.6 15.6 72 44.8 91.8 80.9C394.3 115 419.6 136 448 136c17.7 0 32 14.3 32 32s-14.3 32-32 32h-4.3c3.8 10.1 6.3 20.9 6.3 32c0 20.3-6.4 39.2-17.2 54.5C466.8 266 496 216.5 496 160z"/></svg>';
          } elseif ($activeTab === 'Crop Survey Status') {
             // MdOutlineFactCheck equivalent
             echo '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" fill="currentColor"><path d="M152.1 38.2c9.9 8.9 10.7 24.1 1.8 34L81.9 152.1c-8.9 9.9-24.1 10.7-34 1.8L11.8 122.9c-9.9-8.9-10.7-24.1-1.8-34s24.1-10.7 34-1.8l18 16.1 56.1-62.3c8.9-9.9 24.1-10.7 34-1.8zM224 96c0-17.7 14.3-32 32-32h224c17.7 0 32 14.3 32 32s-14.3 32-32 32H256c-17.7 0-32-14.3-32-32zm0 160c0-17.7 14.3-32 32-32h224c17.7 0 32 14.3 32 32s-14.3 32-32 32H256c-17.7 0-32-14.3-32-32zm0 160c0-17.7 14.3-32 32-32h224c17.7 0 32 14.3 32 32s-14.3 32-32 32H256c-17.7 0-32-14.3-32-32zM152.1 198.2c9.9 8.9 10.7 24.1 1.8 34L81.9 312.1c-8.9 9.9-24.1 10.7-34 1.8l-36.1-31c-9.9-8.9-10.7-24.1-1.8-34s24.1-10.7 34-1.8l18 16.1 56.1-62.3c8.9-9.9 24.1-10.7 34-1.8zM152.1 358.2c9.9 8.9 10.7 24.1 1.8 34L81.9 472.1c-8.9 9.9-24.1 10.7-34 1.8l-36.1-31c-9.9-8.9-10.7-24.1-1.8-34s24.1-10.7 34-1.8l18 16.1 56.1-62.3c8.9-9.9 24.1-10.7 34-1.8z"/></svg>';
          } elseif ($activeTab === 'Recent Activities') {
             // MdHistory equivalent
             echo '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" fill="currentColor"><path d="M75 75L41 41C25.9 25.9 0 36.6 0 57.9V168c0 13.3 10.7 24 24 24H134.1c21.4 0 32.1-25.9 17-41l-30.8-30.8C155 85.5 203 64 256 64c106 0 192 86 192 192s-86 192-192 192c-40.8 0-78.6-12.7-109.7-34.4c-14.5-10.1-34.4-6.6-44.6 7.9s-6.6 34.4 7.9 44.6C151.2 495 201.7 512 256 512c141.4 0 256-114.6 256-256S397.4 0 256 0C185.3 0 121.3 28.7 75 75zm181 53c-13.3 0-24 10.7-24 24V256c0 6.4 2.5 12.5 7 17l72 72c9.4 9.4 24.6 9.4 33.9 0s9.4-24.6 0-33.9l-65-65V152c0-13.3-10.7-24-24-24z"/></svg>';
          } else {
             // Fallback
             echo '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" fill="currentColor"><path d="M416 208c0 45.9-14.9 88.3-40 122.7L502.6 457.4c12.5 12.5 12.5 32.8 0 45.3s-32.8 12.5-45.3 0L330.7 376c-34.4 25.2-76.8 40-122.7 40C93.1 416 0 322.9 0 208S93.1 0 208 0S416 93.1 416 208zM208 352a144 144 0 1 0 0-288 144 144 0 1 0 0 288z"/></svg>';
          }
        ?>
      </div>
      <h3>No <?php echo htmlspecialchars((string)$activeTab); ?> Data Available.</h3>
    </div>

  <?php else: ?>
    <!-- Table with Data -->
    <table class="list-table-element">
      <?php if (!empty($tableHeadersHtml)): ?>
        <thead>
          <?php echo $tableHeadersHtml; ?>
        </thead>
      <?php endif; ?>
      <?php if (!empty($tableBodyHtml)): ?>
        <tbody>
          <?php echo $tableBodyHtml; ?>
        </tbody>
      <?php endif; ?>
    </table>
  <?php endif; ?>
</div>
