<!-- Data Display Table UI Component -->
<?php $totalRecords = 0; // Variable to control data presence ?>
<div class="data-table-container">
  <!-- Main Content Section -->
  <div class="data-table-main">
    <!-- Search and Action Bar -->
    <div class="data-table-controls">
      <?php
        $searchPlaceholder = 'Search beneficiaries...';
        $searchInputId = 'searchInput';
        $searchOnInput = 'filterTable()';
        include 'SearchBar.php';
      ?>

      <div class="data-table-action-buttons">
        <input type="file" id="fileInput" class="data-table-file-input" accept=".xlsx,.xls" style="display: none;">
        <?php include 'ImportButton.php'; ?>
        <?php include 'AddButton.php'; ?>
      </div>
    </div>

    <!-- Table Container -->
    <div class="data-table-wrapper <?php echo $totalRecords == 0 ? 'no-data' : ''; ?>">
      <!-- Loading State -->
      <div class="data-table-loading hidden" id="loadingState">
        <div class="data-table-spinner"></div>
        <div class="data-table-loading-text">Loading beneficiaries...</div>
      </div>

      <!-- Table Section -->
      <div class="data-table-content <?php echo $totalRecords == 0 ? 'hidden' : ''; ?>" id="tableContent">
        <!-- Table Header -->
        <div class="data-table-header-row">
          <div class="data-table-header-cell">Beneficiary ID</div>
          <div class="data-table-header-cell">Full Name</div>
          <div class="data-table-header-cell">Address</div>
          <div class="data-table-header-cell" style="justify-content: center;">Number of Farms</div>
          <div class="data-table-header-cell" style="justify-content: center;">Total Seedling Received</div>
        </div>

        <!-- Table Body -->
        <div class="data-table-body" id="tableBody">
          <!-- Data will be populated here -->
        </div>
      </div>

      <!-- Empty State -->
      <div class="data-table-empty <?php echo $totalRecords > 0 ? 'hidden' : ''; ?>" id="emptyState">
        <?php
          $noDataType = 'generic';
          $noDataIcon = '<img src="../../assets/icons/no-data.png" alt="No Data Found" style="width: 45px; height: auto; opacity: 0.6;" />';
          $noDataTitle = 'No data Available';
          $noDataSubtitle = 'There are no records to display.';
          include '../ui/NoDataDisplay.php';
        ?>
      </div>

      <!-- Client-Side Pagination Container -->
      <div id="paginationContainer"></div>
      <?php include '../ui/Pagination.php'; ?>
    </div>
  </div>

  <!-- Detail Panel Component -->
  <?php include '../ui/BeneficiaryDetailPanel.php'; ?>
</div>

<style>
  /* ===============================
     CSS VARIABLES
     =============================== */
  :root {
    --dark-green: #055035;
    --dark-brown: #6b4423;
    --light-green: #066e46;
    --white: #ffffff;
    --shadow-color: rgba(0, 0, 0, 0.15);
    --light-gray: #f5f5f5;
    --border-gray: #e9ecef;
    --font-main: 'Montserrat', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
  }

  /* ===============================
     DATA TABLE CONTAINER
     =============================== */
  .data-table-container {
    display: flex;
    flex-direction: column;
    flex: 1;
    min-height: 60vh;
    overflow: hidden;
    background-color: var(--white);
    font-family: var(--font-main);
  }



  /* ===============================
     MAIN CONTENT
     =============================== */
  .data-table-main {
    flex: 1;
    display: flex;
    flex-direction: column;
    padding: 0 1rem 1rem 1rem;
    min-height: 0;
    gap: 1rem;
    background-color: var(--white);
  }

  /* ===============================
     CONTROLS BAR
     =============================== */
  .data-table-controls {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 1rem;
    flex-shrink: 0;
  }



  .data-table-action-buttons {
    display: flex;
    gap: 0.75rem;
    flex-shrink: 0;
  }

  .data-table-btn {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.5rem 1.2rem;
    border: none;
    border-radius: 4px;
    font-size: 0.7rem;
    font-weight: 600;
    font-family: var(--font-main);
    cursor: pointer;
    transition: all 0.2s ease;
    outline: none;
  }

  .data-table-btn-primary {
    background-color: var(--dark-green);
    color: var(--white);
  }

  .data-table-btn-primary:hover {
    background-color: #044029;
    transform: translateY(-2px);
    box-shadow: 0 4px 8px var(--shadow-color);
  }

  .data-table-btn-secondary {
    background-color: var(--white);
    color: var(--dark-green);
    border: 1px solid var(--dark-green);
  }

  .data-table-btn-secondary:hover {
    background-color: #f5f5f5;
  }

  .data-table-btn-icon {
    width: 18px;
    height: 18px;
    object-fit: contain;
  }

  .data-table-search-icon {
    width: 16px;
    height: 16px;
    object-fit: contain;
  }

  /* ===============================
     TABLE WRAPPER
     =============================== */
  .data-table-wrapper {
    flex: 1;
    display: flex;
    flex-direction: column;
    background-color: var(--white);
    border-radius: 0;
    box-shadow: none;
    overflow: hidden;
    min-height: 0;
  }
  
  .data-table-wrapper.no-data {
    box-shadow: none;
    border-radius: 0;
    border: none;
  }

  .data-table-content {
    display: flex;
    flex-direction: column;
    flex: 1;
    min-height: 0;
  }

  /* ===============================
     TABLE HEADER
     =============================== */
  .data-table-header-row {
    display: grid;
    grid-template-columns: 15% 25% 25% 15% 20%;
    background-color: #e8f5e8;
    border-bottom: 2px solid var(--dark-green);
    flex-shrink: 0;
  }

  .data-table-header-cell {
    padding: 10px;
    font-size: 0.7rem;
    font-weight: 700;
    color: #2c5530;
    display: flex;
    align-items: center;
  }

  /* ===============================
     TABLE BODY
     =============================== */
  .data-table-body {
    flex: 1;
    overflow-y: auto;
    min-height: 0;
  }

  .data-table-row {
    display: grid;
    grid-template-columns: 15% 25% 25% 15% 20%;
    padding: 2px 0;
    border-bottom: 1px solid var(--border-gray);
    cursor: pointer;
    transition: background-color 0.2s ease;
  }

  .data-table-row:hover {
    background-color: #f8f9fa;
  }

  .data-table-row.active {
    background-color: #f0f9f0;
  }

  .data-table-cell {
    padding: 4px 10px;
    font-size: 0.65rem;
    color: #333;
    display: flex;
    align-items: center;
    overflow: hidden;
    text-overflow: ellipsis;
  }

  .data-table-cell-avatar {
    display: flex;
    align-items: center;
    gap: 8px;
    width: 100%;
  }

  .data-table-avatar-placeholder {
    font-size: 1.2rem;
    flex-shrink: 0;
    display: flex;
  }

  /* ===============================
     LOADING STATE
     =============================== */
  .data-table-loading {
    flex: 1;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 1rem;
    color: #666;
  }

  .data-table-spinner {
    width: 40px;
    height: 40px;
    border: 4px solid #f3f3f3;
    border-top: 4px solid var(--dark-green);
    border-radius: 50%;
    animation: spin 1s linear infinite;
  }

  @keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
  }

  .data-table-loading-text {
    font-size: 0.9rem;
  }

  /* ===============================
     EMPTY STATE
     =============================== */
  .data-table-empty {
    flex: 1;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    color: #999;
  }

  .data-table-empty-icon img {
    width: 45px;
    height: auto;
    opacity: 0.6;
  }

  .data-table-empty-title {
    font-size: 1rem;
    font-weight: 600;
    color: #666;
  }

  .data-table-empty-message {
    font-size: 0.8rem;
    color: #999;
  }

  .data-table-empty.hidden,
  .data-table-loading.hidden,
  .data-table-content.hidden {
    display: none;
  }



  /* ===============================
     RESPONSIVE DESIGN
     =============================== */


  @media (max-width: 768px) {
    .data-table-main {
      padding: 0 0.5rem 0.5rem 0.5rem;
      gap: 0.5rem;
    }

    .data-table-controls {
      flex-direction: column;
      gap: 0.5rem;
    }



    .data-table-action-buttons {
      width: 100%;
    }

    .data-table-btn {
      flex: 1;
      justify-content: center;
    }



    .data-table-header-row,
    .data-table-row {
      grid-template-columns: 20% 25% 25% 15% 15%;
      font-size: 0.65rem;
    }

    .data-table-header-cell,
    .data-table-cell {
      padding: 6px 8px;
    }
  }

  @media (max-width: 480px) {
    .data-table-header-row,
    .data-table-row {
      grid-template-columns: 25% 30% 25% 10% 10%;
      font-size: 0.6rem;
    }

    .data-table-header-cell,
    .data-table-cell {
      padding: 4px 6px;
    }

    .data-table-btn {
      font-size: 0.75rem;
      padding: 0.4rem 0.8rem;
    }


  }
</style>


