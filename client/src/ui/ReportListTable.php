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
  flex: 1;
  min-height: 300px;
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
  color: #9ca3af;
  margin: 0 0 0.25rem 0;
  font-weight: 500;
  font-family: var(--font-main, 'Montserrat', sans-serif);
}

.list-table-no-data p {
  font-size: 0.8rem;
  color: #9ca3af;
  margin: 0;
  font-family: var(--font-main, 'Montserrat', sans-serif);
}

.list-table-no-data-icon img {
  filter: grayscale(1);
  opacity: 0.45;
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

<div class="list-table-container" style="flex: 1; overflow-y: auto; display: flex; flex-direction: column;">
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
      <div class="list-table-no-data-icon" style="font-size: 52px; width: 52px; height: 52px; margin-bottom: 0.5rem;">
        <img src="../../assets/icons/no-list-selected.png" alt="No List Selected" style="width:52px;height:52px;object-fit:contain;opacity:0.6;">
      </div>
      <h3>No List Selected</h3>
      <p>Please select a tab above to view data</p>
    </div>

  <?php elseif (empty($reportData)): ?>
    <!-- No Data State -->
    <div class="list-table-no-data" style="height: 400px;">
      <div class="list-table-no-data-icon" style="font-size: 52px; width: 52px; height: 52px; margin-bottom: 0.5rem;">
          <?php
          // Render appropriate icon based on active tab
          if ($activeTab === 'Beneficiary List') {
             echo '<img src="../../assets/icons/no-benefeciary.png" alt="No Beneficiary" style="width:52px;height:52px;object-fit:contain;opacity:0.6;">';
          } elseif ($activeTab === 'Farm Location') {
             echo '<img src="../../assets/icons/no-farm-location.png" alt="No Farm Location" style="width:52px;height:52px;object-fit:contain;opacity:0.6;">';
          } elseif ($activeTab === 'Seedling Record') {
             echo '<img src="../../assets/icons/seedling.png" alt="No Seedlings" style="width:52px;height:52px;object-fit:contain;opacity:0.6;">';
          } elseif ($activeTab === 'Crop Survey Status') {
             echo '<img src="../../assets/icons/no-data.png" alt="No Crop Data" style="width:52px;height:52px;object-fit:contain;opacity:0.6;">';
          } elseif ($activeTab === 'Recent Activities') {
             echo '<img src="../../assets/icons/no-data.png" alt="No Activities" style="width:52px;height:52px;object-fit:contain;opacity:0.6;">';
          } else {
             echo '<img src="../../assets/icons/no-data.png" alt="No Data" style="width:52px;height:52px;object-fit:contain;opacity:0.6;">';
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
