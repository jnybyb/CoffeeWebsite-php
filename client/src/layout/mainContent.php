<!-- Main Content Area Component -->
<main class="app-main-content">
  <!-- Dashboard Page -->
  <section class="page-section active" data-page="dashboard">
    <div class="page-header">
      <h1>Dashboard</h1>
      <p class="page-subtitle">Overview of your coffee farm monitoring system</p>
    </div>
    <div class="page-content">
      <div class="dashboard-grid">
        <div class="card">
          <div class="card-icon">📊</div>
          <h3>Total Farm Plots</h3>
          <p class="card-value">24</p>
          <p class="card-description">Active monitoring plots</p>
        </div>
        <div class="card">
          <div class="card-icon">👥</div>
          <h3>Beneficiaries</h3>
          <p class="card-value">156</p>
          <p class="card-description">Registered farmers</p>
        </div>
        <div class="card">
          <div class="card-icon">🌱</div>
          <h3>Seedlings</h3>
          <p class="card-value">3,240</p>
          <p class="card-description">Total seedlings tracked</p>
        </div>
        <div class="card">
          <div class="card-icon">🌾</div>
          <h3>Crop Status</h3>
          <p class="card-value">92%</p>
          <p class="card-description">Healthy crops</p>
        </div>
      </div>
    </div>
  </section>

  <!-- Farm Monitoring Page -->
  <section class="page-section" data-page="farm-monitoring">
    <div class="page-header">
      <h1>Farm Monitoring</h1>
      <p class="page-subtitle">Real-time monitoring of your farm plots</p>
    </div>
    <div class="page-content">
      <div class="filter-section">
        <button class="filter-btn active">All Plots</button>
        <button class="filter-btn">Healthy</button>
        <button class="filter-btn">Needs Attention</button>
        <button class="filter-btn">Critical</button>
      </div>
      <div class="farm-plots-list">
        <div class="plot-card">
          <div class="plot-header">
            <h3>Plot #001 - Zone A</h3>
            <span class="status-badge healthy">Healthy</span>
          </div>
          <div class="plot-details">
            <p><strong>Location:</strong> Davao Oriental - Barangay X</p>
            <p><strong>Area:</strong> 2.5 hectares</p>
            <p><strong>Last Updated:</strong> Today, 2:30 PM</p>
          </div>
        </div>
        <div class="plot-card">
          <div class="plot-header">
            <h3>Plot #002 - Zone B</h3>
            <span class="status-badge needs-attention">Needs Attention</span>
          </div>
          <div class="plot-details">
            <p><strong>Location:</strong> Davao Oriental - Barangay Y</p>
            <p><strong>Area:</strong> 1.8 hectares</p>
            <p><strong>Last Updated:</strong> Today, 2:15 PM</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Coffee Beneficiaries Page -->
  <section class="page-section" data-page="beneficiaries">
    <?php include '../pages/CoffeeBeneficiary.php'; ?>
  </section>

  <!-- Reports Page -->
  <section class="page-section" data-page="reports">
    <div class="page-header">
      <h1>Reports</h1>
      <p class="page-subtitle">Generate and view analytics reports</p>
    </div>
    <div class="page-content">
      <div class="report-filters">
        <select class="filter-select">
          <option>Select Report Type</option>
          <option>Production Report</option>
          <option>Crop Health Report</option>
          <option>Beneficiary Report</option>
          <option>Regional Report</option>
        </select>
        <select class="filter-select">
          <option>Select Period</option>
          <option>Last 7 Days</option>
          <option>Last 30 Days</option>
          <option>Last 3 Months</option>
          <option>Last 6 Months</option>
          <option>Last Year</option>
        </select>
        <button class="btn btn-primary">Generate Report</button>
        <button class="btn btn-secondary">Download PDF</button>
      </div>
      <div class="report-container">
        <div class="report-item">
          <h3>Production Report - Last 30 Days</h3>
          <div class="report-chart-placeholder">
            <p>📈 Chart visualization will appear here</p>
          </div>
        </div>
        <div class="report-item">
          <h3>Crop Health Summary</h3>
          <div class="report-stats">
            <div class="stat">
              <p>Healthy</p>
              <p class="stat-value">92%</p>
            </div>
            <div class="stat">
              <p>At Risk</p>
              <p class="stat-value">6%</p>
            </div>
            <div class="stat">
              <p>Critical</p>
              <p class="stat-value">2%</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</main>

<style>
  /* ===============================
     PAGE SECTION STYLES
     =============================== */
  .page-section {
    display: none;
    animation: fadeIn 0.3s ease-in;
  }

  .page-section.active {
    display: block;
  }

  @keyframes fadeIn {
    from {
      opacity: 0;
      transform: translateY(10px);
    }
    to {
      opacity: 1;
      transform: translateY(0);
    }
  }

  /* ===============================
     PAGE HEADER
     =============================== */
  .page-header {
    margin-bottom: 2rem;
  }

  .page-header h1 {
    font-size: 2rem;
    color: var(--dark-green);
    margin-bottom: 0.5rem;
    font-weight: 700;
  }

  .page-subtitle {
    color: #666;
    font-size: 0.95rem;
    margin: 0;
  }

  /* ===============================
     PAGE CONTENT
     =============================== */
  .page-content {
    background: var(--white);
    border-radius: 8px;
    box-shadow: 0 2px 8px var(--shadow-color);
    padding: 2rem;
  }

  /* ===============================
     DASHBOARD GRID
     =============================== */
  .dashboard-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1.5rem;
    margin-bottom: 2rem;
  }

  .card {
    background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
    border-radius: 8px;
    padding: 1.5rem;
    text-align: center;
    border-left: 4px solid var(--dark-green);
    transition: transform 0.2s ease;
  }

  .card:hover {
    transform: translateY(-5px);
    box-shadow: 0 4px 12px var(--shadow-color);
  }

  .card-icon {
    font-size: 2.5rem;
    margin-bottom: 1rem;
  }

  .card h3 {
    color: var(--dark-green);
    margin: 0.5rem 0;
    font-size: 0.95rem;
  }

  .card-value {
    font-size: 1.8rem;
    font-weight: 700;
    color: var(--dark-green);
    margin: 0.5rem 0;
  }

  .card-description {
    color: #999;
    font-size: 0.85rem;
    margin: 0;
  }

  /* ===============================
     FARM MONITORING
     =============================== */
  .filter-section {
    display: flex;
    gap: 1rem;
    margin-bottom: 1.5rem;
    flex-wrap: wrap;
  }

  .filter-btn {
    padding: 1.5rem 1rem;
    border: 2px solid var(--border-gray);
    background: var(--white);
    color: #666;
    border-radius: 6px;
    cursor: pointer;
    font-weight: 500;
    transition: all 0.2s ease;
  }

  .filter-btn:hover,
  .filter-btn.active {
    border-color: var(--dark-green);
    background-color: var(--dark-green);
    color: var(--white);
  }

  .farm-plots-list {
    display: grid;
    gap: 1rem;
  }

  .plot-card {
    border: 1px solid var(--border-gray);
    border-radius: 8px;
    padding: 1.5rem;
    transition: all 0.2s ease;
  }

  .plot-card:hover {
    box-shadow: 0 4px 12px var(--shadow-color);
    border-color: var(--light-green);
  }

  .plot-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1rem;
  }

  .plot-header h3 {
    margin: 0;
    color: var(--dark-green);
  }

  .status-badge {
    padding: 0.4rem 0.8rem;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 600;
  }

  .status-badge.healthy {
    background-color: #d4edda;
    color: #155724;
  }

  .status-badge.needs-attention {
    background-color: #fff3cd;
    color: #856404;
  }

  .status-badge.critical {
    background-color: #f8d7da;
    color: #721c24;
  }

  .status-badge.active {
    background-color: #d4edda;
    color: #155724;
  }

  .status-badge.inactive {
    background-color: #e2e3e5;
    color: #383d41;
  }

  .plot-details p {
    margin: 0.5rem 0;
    color: #666;
    font-size: 0.9rem;
  }

  /* ===============================
     BENEFICIARIES
     =============================== */
  .action-bar {
    display: flex;
    gap: 1rem;
    margin-bottom: 1.5rem;
    flex-wrap: wrap;
  }

  .search-input {
    flex: 1;
    min-width: 200px;
    padding: 0.75rem 1rem;
    border: 1px solid var(--border-gray);
    border-radius: 6px;
    font-size: 0.9rem;
    font-family: var(--font-main);
  }

  .search-input:focus {
    outline: none;
    border-color: var(--dark-green);
    box-shadow: 0 0 0 3px rgba(5, 80, 53, 0.1);
  }

  .btn {
    padding: 0.75rem 1.5rem;
    border: none;
    border-radius: 6px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s ease;
    font-family: var(--font-main);
    font-size: 0.9rem;
  }

  .btn-primary {
    background-color: var(--dark-green);
    color: var(--white);
  }

  .btn-primary:hover {
    background-color: #044029;
    transform: translateY(-2px);
  }

  .btn-secondary {
    background-color: var(--border-gray);
    color: #333;
  }

  .btn-secondary:hover {
    background-color: #ddd;
  }

  .data-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 0.9rem;
  }

  .data-table thead {
    background-color: var(--light-gray);
    border-bottom: 2px solid var(--border-gray);
  }

  .data-table th {
    padding: 1rem;
    text-align: left;
    font-weight: 700;
    color: var(--dark-green);
  }

  .data-table td {
    padding: 1rem;
    border-bottom: 1px solid var(--border-gray);
  }

  .data-table tbody tr:hover {
    background-color: #f9f9f9;
  }

  .btn-icon {
    background: none;
    border: none;
    cursor: pointer;
    font-size: 1.1rem;
    margin: 0 0.5rem;
    transition: transform 0.2s ease;
  }

  .btn-icon:hover {
    transform: scale(1.2);
  }

  /* ===============================
     REPORTS
     =============================== */
  .report-filters {
    display: flex;
    gap: 1rem;
    margin-bottom: 2rem;
    flex-wrap: wrap;
    align-items: center;
  }

  .filter-select {
    padding: 0.75rem 1rem;
    border: 1px solid var(--border-gray);
    border-radius: 6px;
    font-size: 0.9rem;
    font-family: var(--font-main);
    background-color: var(--white);
    cursor: pointer;
  }

  .filter-select:focus {
    outline: none;
    border-color: var(--dark-green);
    box-shadow: 0 0 0 3px rgba(5, 80, 53, 0.1);
  }

  .report-container {
    display: grid;
    gap: 2rem;
  }

  .report-item {
    background: var(--white);
    border: 1px solid var(--border-gray);
    border-radius: 8px;
    padding: 1.5rem;
  }

  .report-item h3 {
    color: var(--dark-green);
    margin-top: 0;
    margin-bottom: 1rem;
  }

  .report-chart-placeholder {
    background-color: var(--light-gray);
    border: 2px dashed var(--border-gray);
    border-radius: 6px;
    padding: 3rem;
    text-align: center;
    color: #999;
  }

  .report-stats {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
    gap: 1rem;
  }

  .stat {
    background-color: var(--light-gray);
    padding: 1rem;
    border-radius: 6px;
    text-align: center;
  }

  .stat p {
    margin: 0.5rem 0;
    color: #666;
  }

  .stat-value {
    font-size: 1.8rem;
    font-weight: 700;
    color: var(--dark-green);
  }

  /* ===============================
     RESPONSIVE DESIGN
     =============================== */
  @media (max-width: 768px) {
    .page-header h1 {
      font-size: 1.5rem;
    }

    .page-content {
      padding: 1.5rem;
    }

    .dashboard-grid {
      grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
      gap: 1rem;
    }

    .action-bar {
      flex-direction: column;
    }

    .search-input {
      flex: 1;
      min-width: auto;
    }

    .data-table {
      font-size: 0.8rem;
    }

    .data-table th,
    .data-table td {
      padding: 0.75rem;
    }

    .report-filters {
      flex-direction: column;
    }

    .filter-select {
      width: 100%;
    }
  }
</style>

<script>
  // Page navigation functionality
  (function () {
    const pageSections = document.querySelectorAll('.page-section');

    // Get active page from localStorage
    const getActivePage = () => {
      return localStorage.getItem('activePage') || 'beneficiaries';
    };

    // Show specific page
    const showPage = (pageName) => {
      pageSections.forEach(section => {
        const isActive = section.getAttribute('data-page') === pageName;
        section.classList.toggle('active', isActive);
      });
    };

    // Initialize active page on load
    showPage(getActivePage());

    // Listen for navigation events from sidebar
    window.addEventListener('navigationChanged', (event) => {
      const pageName = event.detail.page;
      showPage(pageName);
    });
  })();
</script>
