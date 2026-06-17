<!-- Dashboard Page -->
<style>
  /* ===============================
     HEADER SECTION
     =============================== */
  .dashboard-wrapper {
    display: flex;
    flex-direction: column;
    min-height: calc(100vh - 70px); /* Adjust based on top navbar height */
    height: 100%;
  }

  .page-header.dashboard-header {
    padding: 1.6rem 1rem 0.5rem 1rem;
    background-color: var(--white, #ffffff);
    display: flex;
    justify-content: space-between;
    align-items: flex-end;
    margin-bottom: 0;
    flex-shrink: 0;
  }

  .page-title {
    color: var(--dark-green, #055035);
    font-size: 1.5rem;
    font-weight: 600;
    margin: 0;
  }

  .page-header .page-subtitle {
    color: var(--dark-brown, #6b4423);
    font-size: 0.7rem;
    margin-top: 0.2rem;
    font-weight: 500;
  }

  @media (max-width: 768px) {
    .page-header {
      padding: 1.2rem 0.8rem 1rem 0.8rem;
    }
    .page-title {
      font-size: 1.3rem;
    }
  }

  @media (max-width: 480px) {
    .page-header {
      padding: 1rem 0.5rem 0.8rem 0.5rem;
    }
    .page-title {
      font-size: 1.2rem;
    }
    .page-header .page-subtitle {
      font-size: 0.5rem;
    }
  }
</style>

<div class="dashboard-wrapper">
  <div class="page-header dashboard-header">
    <div>
      <h2 class="page-title">Dashboard</h2>
      <div class="page-subtitle">Overview of key metrics and recent activities</div>
    </div>
  </div>

  <style>
    .dashboard-content {
      padding: 0.5rem 1rem 1rem 1rem;
      display: flex;
      flex-direction: column;
      flex: 1;
    }

    .dashboard-main-grid {
      display: grid;
      grid-template-columns: 2fr 1fr;
      gap: 1rem;
      flex: 1;
      min-height: 400px; /* Prevent collapse */
    }
  
  @media (max-width: 1024px) {
    .dashboard-main-grid {
      grid-template-columns: 1fr;
    }
  }
</style>

  <div class="dashboard-content">
    <?php include '../ui/DashboardMetrics.php'; ?>

    <div class="dashboard-main-grid">
      <!-- Left Side - Charts -->
      <div style="display: flex; flex-direction: column; height: 100%;">
        <?php include '../ui/DashboardTrendMonitoring.php'; ?>
      </div>
      
      <!-- Right Side - Recent Activities -->
      <div style="min-width: 200px; height: 100%; display: flex; flex-direction: column;">
        <?php include '../ui/RecentActivities.php'; ?>
      </div>
    </div>
  </div>
</div>

<script>
  (function() {
    const API_BASE_URL = 'http://localhost:5000/api';

    async function loadDashboardMetrics() {
      const token = localStorage.getItem('authToken');
      if (!token) {
        window.location.href = '../../login.php';
        return;
      }

      try {
        const response = await fetch(`${API_BASE_URL}/statistics`, {
          headers: {
            'Authorization': `Bearer ${token}`
          }
        });

        if (response.status === 401 || response.status === 403) {
          localStorage.removeItem('authToken');
          window.location.href = '../../login.php';
          return;
        }

        if (!response.ok) {
          throw new Error('Failed to fetch dashboard statistics');
        }

        const data = await response.json();

        // Update DOM elements with formatting
        const totalBeneficiariesEl = document.getElementById('metric-total-beneficiaries');
        const seedsDistributedEl = document.getElementById('metric-seeds-distributed');
        const aliveCropsEl = document.getElementById('metric-alive-crops');
        const deadCropsEl = document.getElementById('metric-dead-crops');

        if (totalBeneficiariesEl) {
          totalBeneficiariesEl.textContent = (data.totalBeneficiaries || 0).toLocaleString();
        }
        if (seedsDistributedEl) {
          seedsDistributedEl.textContent = (data.totalSeedsDistributed || 0).toLocaleString();
        }
        if (aliveCropsEl) {
          aliveCropsEl.textContent = (data.totalAlive || 0).toLocaleString();
        }
        if (deadCropsEl) {
          deadCropsEl.textContent = (data.totalDead || 0).toLocaleString();
        }
      } catch (error) {
        console.error('Error loading dashboard metrics:', error);
      }
    }

    // Load metrics when DOM is ready
    document.addEventListener('DOMContentLoaded', loadDashboardMetrics);

    // Also load metrics if DOM is already loaded (fallback for SPA layout inclusion)
    if (document.readyState === 'complete' || document.readyState === 'interactive') {
      loadDashboardMetrics();
    }

    // Refresh metrics when navigating back to the dashboard page
    window.addEventListener('navigationChanged', (event) => {
      if (event.detail && event.detail.page === 'dashboard') {
        loadDashboardMetrics();
      }
    });
  })();
</script>
