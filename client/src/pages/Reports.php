<!-- Reports Page -->
<style>
  /* ===============================
     REPORTS WRAPPER
     =============================== */
  .reports-wrapper {
    display: flex;
    flex-direction: column;
    height: calc(100vh - 70px); /* Adjust based on top navbar height */
    overflow: hidden;
  }

  .page-header.reports-header {
    padding: 1.6rem 1rem 1rem 1rem;
    background-color: var(--white, #ffffff);
    margin-bottom: 0;
    display: flex;
    justify-content: space-between;
    align-items: flex-end;
    flex-shrink: 0;
  }

  .reports-header .page-title {
    color: var(--dark-green, #055035);
    font-size: 1.5rem;
    font-weight: 600;
    margin: 0;
  }

  .reports-header .page-subtitle {
    color: var(--dark-brown, #6b4423);
    font-size: 0.7rem;
    margin-top: 0.2rem;
    font-weight: 500;
  }

  .reports-content-container {
    flex: 1;
    display: flex;
    flex-direction: column;
    background-color: var(--white, #ffffff);
    overflow: hidden;
  }

  .reports-inner-container {
    flex: 1;
    display: flex;
    flex-direction: column;
    overflow: hidden;
    margin: 1rem;
    background-color: var(--white, #ffffff);
    border-radius: 6px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.1);
  }

  @media (max-width: 768px) {
    .page-header.reports-header {
      padding: 1.2rem 0.8rem 1rem 0.8rem;
    }
    .reports-header .page-title {
      font-size: 1.3rem;
    }
  }

  @media (max-width: 480px) {
    .page-header.reports-header {
      padding: 1rem 0.5rem 0.8rem 0.5rem;
      flex-direction: column;
      align-items: flex-start;
      gap: 1rem;
    }
    .reports-header .page-title {
      font-size: 1.2rem;
    }
    .reports-header .page-subtitle {
      font-size: 0.5rem;
    }
  }
</style>

<div class="reports-wrapper">
  <!-- Header -->
  <div class="page-header reports-header">
    <div>
      <h2 class="page-title">Reports</h2>
      <div class="page-subtitle">Generate and export comprehensive reports for your coffee monitoring system</div>
    </div>
  </div>

  <!-- Table Section -->
  <div class="reports-content-container">
    <div class="reports-inner-container">
      <!-- Tabs Section -->
      <div style="padding: 1rem 1rem 0 1rem; border-bottom: 1px solid var(--border-gray, #e6e6e6);">
        <?php include __DIR__ . '/../ui/TableTabs.php'; ?>
      </div>
      
      <!-- Table Area -->
      <?php 
        // Example variables (can be overridden by controller)
        // $activeTab = null; // Test "No Tab Selected" state
        // $loadingData = false;
        // $reportData = [];
        include __DIR__ . '/../ui/ListTable.php'; 
      ?>
    </div>
  </div>
</div>
