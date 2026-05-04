<!-- Trend Monitoring Component -->
<style>
  /* ===============================
     TREND MONITORING
     =============================== */

  .trend-container {
    background: var(--white, #ffffff);
    padding: 1rem;
    border-radius: 6px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
    border: 1px solid var(--border-gray, #e6e6e6);
    height: 100%;
    display: flex;
    flex-direction: column;
  }

  .trend-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 0.5rem;
    flex-wrap: wrap;
    margin-bottom: 0.75rem;
  }

  .trend-title {
    color: var(--dark-green, #055035);
    font-size: 0.9rem;
    font-weight: 600;
    margin: 0;
  }

  .trend-controls {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    flex: 1;
    justify-content: flex-end;
    flex-wrap: wrap;
  }

  .search-wrapper {
    position: relative;
    display: flex;
    align-items: center;
  }

  .search-icon {
    position: absolute;
    left: 0.5rem;
    font-size: 0.9rem;
    color: #aaa;
    pointer-events: none;
    width: 14px;
    height: 14px;
  }

  .trend-search {
    width: 270px;
    padding: 0.4rem 2rem;
    font-size: 0.75rem;
    color: var(--dark-green, #055035);
    background-color: var(--white, #ffffff);
    border: 1px solid var(--border-gray, #e6e6e6);
    border-radius: 4px;
    outline: none;
    font-family: inherit;
  }

  .trend-select {
    padding: 0.4rem 0.6rem;
    font-size: 0.75rem;
    color: var(--dark-green, #055035);
    background-color: var(--white, #ffffff);
    border: 1px solid var(--border-gray, #e6e6e6);
    border-radius: 4px;
    cursor: pointer;
    outline: none;
    font-family: inherit;
  }

  .chart-placeholder {
    flex: 1;
    background-color: #fafafa;
    border: 1px dashed #ccc;
    border-radius: 4px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #999;
    font-size: 0.8rem;
    min-height: 280px;
    margin-bottom: 1rem;
  }

  .trend-legend {
    display: flex;
    justify-content: center;
    gap: 1.5rem;
    flex-wrap: wrap;
  }

  .legend-item {
    display: flex;
    align-items: center;
    font-size: 0.7rem;
    color: var(--dark-text, #333333);
  }

  .legend-dot {
    width: 8px;
    height: 8px;
    border-radius: 50%;
    margin-right: 0.4rem;
  }

  .dot-teal { background-color: #008080; } /* var(--teal) */
  .dot-success { background-color: #28a745; } /* var(--success) */
  .dot-danger { background-color: #dc3545; } /* var(--danger-red) */

  @media (max-width: 768px) {
    .trend-controls {
      justify-content: flex-start;
    }
    .search-wrapper, .trend-search {
      width: 100%;
    }
  }
</style>

<div class="trend-container">
  <div class="trend-header">
    <h3 class="trend-title">Trend Monitoring</h3>

    <div class="trend-controls">
      <!-- Beneficiary Search Bar -->
      <div class="search-wrapper">
        <svg class="search-icon" viewBox="0 0 20 20" fill="currentColor">
          <path fill-rule="evenodd" d="M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z" clip-rule="evenodd" />
        </svg>
        <input type="text" class="trend-search" placeholder="Search beneficiary...">
      </div>

      <!-- Time Period Filter -->
      <select class="trend-select">
        <option value="yearly">Yearly</option>
        <option value="monthly" selected>Monthly</option>
        <option value="weekly">Weekly</option>
      </select>

      <!-- Data Filter -->
      <select class="trend-select">
        <option value="all">All Data</option>
        <option value="seedlings">Seedlings Only</option>
        <option value="alive">Alive Crops Only</option>
        <option value="dead">Dead Crops Only</option>
      </select>
    </div>
  </div>

  <!-- Chart Area (Placeholder for actual charting library like Chart.js) -->
  <div class="chart-placeholder" id="trendChartContainer">
    <span>[ Line Chart Visualization Area ]</span>
  </div>

  <!-- Legend -->
  <div class="trend-legend">
    <div class="legend-item">
      <div class="legend-dot dot-teal"></div>
      <span>Coffee Seedlings</span>
    </div>
    <div class="legend-item">
      <div class="legend-dot dot-success"></div>
      <span>Alive Crops</span>
    </div>
    <div class="legend-item">
      <div class="legend-dot dot-danger"></div>
      <span>Dead Crops</span>
    </div>
  </div>
</div>
