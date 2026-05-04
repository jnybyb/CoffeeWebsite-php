<!-- Dashboard Metrics Component -->
<style>
  /* ===============================
     DASHBOARD METRICS
     =============================== */

  .metrics-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 0.75rem;
    margin-bottom: 0.75rem;
  }

  .metric-card {
    background: var(--white, #ffffff);
    padding: 0.75rem;
    border-radius: 6px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
    border: 1px solid var(--border-gray, #e6e6e6);
    display: flex;
    flex-direction: column;
    align-items: flex-start;
    justify-content: center;
    min-height: 80px;
    cursor: pointer;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
  }

  .metric-card:hover {
    transform: scale(1.03);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
  }

  .metric-header {
    display: flex;
    align-items: center;
    margin-bottom: 0.25rem;
  }

  .metric-icon {
    width: 14px;
    height: 14px;
    margin-right: 0.3rem;
  }

  .icon-grey {
    /* Converts a white icon to grey without modifying the file */
    filter: invert(50%);
  }

  .metric-title {
    font-size: 0.7rem;
    font-weight: 500;
    color: #555;
    margin: 0;
  }

  .metric-value {
    margin: 0.25rem 0 0 0.25rem;
    font-size: 1.8rem;
    font-weight: 700;
  }

  /* Colors */
  .value-olive { color: #5B7524; } 
  .value-teal { color: #008080; } 
  .value-success { color: #28a745; } 
  .value-danger { color: #dc3545; } 
</style>

  <div class="metrics-grid">
    <!-- Total Beneficiaries -->
    <div class="metric-card">
      <div class="metric-header">
        <img src="../../assets/icons/users.png" class="metric-icon icon-grey" alt="Users">
        <h3 class="metric-title">Total Beneficiaries</h3>
      </div>
      <p class="metric-value value-olive">35</p>
    </div>

    <!-- Total Seeds Distributed -->
    <div class="metric-card">
      <div class="metric-header">
        <img src="../../assets/icons/seedling.png" class="metric-icon" alt="Seedling">
        <h3 class="metric-title">Total Seeds Distributed</h3>
      </div>
      <p class="metric-value value-teal">532,177</p>
    </div>

    <!-- Alive Crops -->
    <div class="metric-card">
      <div class="metric-header">
        <img src="../../assets/icons/alive-seed.png" class="metric-icon" alt="Alive Crops">
        <h3 class="metric-title">Alive Crops</h3>
      </div>
      <p class="metric-value value-success">4,482</p>
    </div>

    <!-- Dead Crops -->
    <div class="metric-card">
      <div class="metric-header">
        <img src="../../assets/icons/dead-seed.png" class="metric-icon" alt="Dead Crops">
        <h3 class="metric-title">Dead Crops</h3>
      </div>
      <p class="metric-value value-danger">1,800</p>
    </div>
  </div>
