<!-- Main Content Area Component -->
<main class="app-main-content">
  <!-- Dashboard Page -->
  <section class="page-section active" data-page="dashboard">
    <?php include '../pages/Dashboard.php'; ?>
  </section>

  <!-- Farm Monitoring Page -->
  <section class="page-section" data-page="farm-monitoring">
    <?php include '../pages/FarmMonitoring.php'; ?>
  </section>

  <!-- Coffee Beneficiaries Page -->
  <section class="page-section" data-page="beneficiaries">
    <?php include '../pages/CoffeeBeneficiary.php'; ?>
  </section>

  <!-- Reports Page -->
  <section class="page-section" data-page="reports">
    <?php include '../pages/Reports.php'; ?>
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
