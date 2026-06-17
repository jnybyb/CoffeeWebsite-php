<!-- Recent Activities Component -->
<style>
  /* ===============================
     RECENT ACTIVITIES
     =============================== */
  .recent-activities-container {
    background: var(--white, #ffffff);
    padding: 0.7rem;
    border-radius: 6px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
    border: 1px solid var(--border-gray, #e6e6e6);
    height: 100%;
    display: flex;
    flex-direction: column;
  }

  .recent-title {
    color: var(--dark-green, #055035);
    font-size: 1rem;
    font-weight: 600;
    margin: 0 0 0.5rem 0;
  }

  .activities-list {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
    flex: 1;
    overflow-y: auto;
    padding-right: 0.25rem;
  }

  /* Custom scrollbar for activities list */
  .activities-list::-webkit-scrollbar {
    width: 4px;
  }
  .activities-list::-webkit-scrollbar-track {
    background: transparent;
  }
  .activities-list::-webkit-scrollbar-thumb {
    background: rgba(0,0,0,0.2);
    border-radius: 2px;
  }

  .activity-card {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
    padding: 0.75rem;
    border-radius: 4px;
    background-color: var(--white, #ffffff);
    border: 1px solid #e0dcd5;
    cursor: pointer;
    transition: background-color 0.2s ease;
  }

  .activity-card:hover {
    background-color: #eaf2ed; /* Equivalent to var(--mint-green) */
  }

  .activity-row {
    display: flex;
    flex-direction: row;
    gap: 0.5rem;
  }

  .activity-icon-container {
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--dark-green, #055035);
    flex-shrink: 0;
    width: 1.5rem;
    height: 1.5rem;
    border-radius: 50%;
    background-color: var(--light-gray, #f5f5f5);
    border: 1px solid #e0dcd5;
  }

  .activity-icon-container svg {
    width: 14px;
    height: 14px;
    fill: currentColor;
  }

  .activity-content {
    display: flex;
    flex-direction: column;
    gap: 0.25rem;
    flex: 1;
  }

  .activity-header {
    font-size: 0.65rem;
    font-weight: 700;
    color: var(--dark-green, #055035);
  }

  .activity-action {
    font-size: 0.75rem;
    color: var(--dark-brown, #6b4423);
    line-height: 1;
    font-weight: 400;
  }

  .activity-timestamp {
    font-size: 0.55rem;
    margin-top: 0.25rem;
    color: var(--dark-text, #333333);
    font-weight: 400;
  }

  .view-all-link {
    margin-top: auto;
    padding-top: 0.75rem;
    text-align: center;
    font-size: 0.75rem;
    font-weight: 600;
    color: var(--dark-green, #055035);
    text-decoration: underline;
    cursor: pointer;
    transition: color 0.2s ease;
  }

  .view-all-link:hover {
    color: #6b8e23; /* var(--olive-green) */
  }
</style>

<div class="recent-activities-container">
  <h3 class="recent-title">Recent Activity</h3>
  
  <div class="activities-list" id="recent-activities-list">
    <!-- Dynamic activities will be rendered here -->
  </div>
  
  <div class="view-all-link" id="view-all-activities-btn">
    View All
  </div>
</div>

<script>
(function() {
  const API_BASE_URL = typeof window.API_BASE_URL !== 'undefined' ? window.API_BASE_URL : 'http://localhost:5000/api';

  async function loadRecentActivities() {
    const container = document.getElementById('recent-activities-list');
    if (!container) return;

    const token = localStorage.getItem('authToken');
    if (!token) {
      window.location.href = '../../login.php';
      return;
    }

    // Show loading state
    container.innerHTML = `
      <div class="activity-loading" style="display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 3rem 1rem; color: var(--dark-green, #055035); font-size: 0.75rem; font-weight: 500; height: 100%;">
        <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" class="animate-spin" style="animation: spin 1s linear infinite; margin-bottom: 0.75rem;">
          <circle cx="12" cy="12" r="10" stroke-dasharray="32" stroke-dashoffset="16" stroke="rgba(5, 80, 53, 0.2)"></circle>
          <path d="M12 2C6.48 2 2 6.48 2 12" stroke="currentColor" stroke-linecap="round"></path>
        </svg>
        <span style="font-family: var(--font-main, 'Montserrat', sans-serif);">Loading activities...</span>
      </div>
      <style>
        @keyframes spin { to { transform: rotate(360deg); } }
      </style>
    `;

    try {
      const response = await fetch(`${API_BASE_URL}/statistics/recent-activities?limit=5`, {
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
        throw new Error('Failed to fetch recent activities');
      }

      const activities = await response.json();

      if (!activities || activities.length === 0) {
        container.innerHTML = `
          <div class="activity-empty" style="display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 3rem 1rem; color: #9ca3af; text-align: center; height: 100%; gap: 0.75rem;">
            <img src="../../assets/icons/no-data.png" alt="No Activities" style="width: 45px; height: 45px; object-fit: contain; opacity: 0.55; filter: grayscale(1);">
            <h4 style="font-size: 0.85rem; color: #9ca3af; margin: 0; font-weight: 600; font-family: var(--font-main, 'Montserrat', sans-serif);">No Recent Activities</h4>
            <p style="font-size: 0.65rem; color: #9ca3af; margin: 0; font-family: var(--font-main, 'Montserrat', sans-serif);">Recorded activities will show up here.</p>
          </div>
        `;
        return;
      }

      const typeMeta = {
        beneficiary: {
          header: 'Coffee Beneficiary',
          icon: `<svg viewBox="0 0 24 24"><path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5C6.34 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z"/></svg>`
        },
        crop: {
          header: 'Crop Survey Status',
          icon: `<svg viewBox="0 0 24 24"><path d="M17 8C8 10 5.9 16.17 5.1 19c2.83-.8 9-2.9 11-11.9M2 2v2c0 8.28 6.72 15 15 15h2v-2c0-8.28-6.72-15-15-15H2z"/></svg>`
        },
        seedling: {
          header: 'Seedling Record',
          icon: `<svg viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 10h3l-4 4-4-4h3V8h2v4z"/></svg>`
        },
        plot: {
          header: 'Farm Plot Details',
          icon: `<svg viewBox="0 0 24 24"><path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zM9 17H7v-7h2v7zm4 0h-2V7h2v10zm4 0h-2v-4h2v4z"/></svg>`
        }
      };

      container.innerHTML = activities.map(act => {
        const meta = typeMeta[act.type] || {
          header: 'System Activity',
          icon: `<svg viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-6h2v6zm0-8h-2V7h2v2z"/></svg>`
        };

        let formattedTime = 'N/A';
        if (act.timestamp) {
          const date = new Date(act.timestamp);
          if (!isNaN(date.getTime())) {
            formattedTime = date.toLocaleString('en-US', {
              month: 'numeric',
              day: 'numeric',
              year: 'numeric',
              hour: 'numeric',
              minute: '2-digit',
              hour12: true
            });
          }
        }

        return `
          <div class="activity-card" data-type="${act.type}">
            <div class="activity-row">
              <div class="activity-icon-container">
                ${meta.icon}
              </div>
              <div class="activity-content">
                <div class="activity-header">${meta.header}</div>
                <div class="activity-action">${act.action}</div>
                <div class="activity-timestamp">${formattedTime}</div>
              </div>
            </div>
          </div>
        `;
      }).join('');

    } catch (error) {
      console.error('Error loading recent activities:', error);
      container.innerHTML = `
        <div class="activity-error" style="display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 2rem 1rem; color: #b00020; text-align: center; height: 100%; gap: 0.5rem;">
          <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
          <div style="font-size: 0.75rem; font-weight: 600; font-family: var(--font-main, 'Montserrat', sans-serif);">Failed to load activities</div>
        </div>
      `;
    }
  }

  // Load when DOM content is loaded
  document.addEventListener('DOMContentLoaded', loadRecentActivities);

  // Fallback for dynamic/SPA page inclusions
  if (document.readyState === 'complete' || document.readyState === 'interactive') {
    loadRecentActivities();
  }

  // Reload when navigating back to the dashboard page
  window.addEventListener('navigationChanged', (event) => {
    if (event.detail && event.detail.page === 'dashboard') {
      loadRecentActivities();
    }
  });

  // Handle "View All" — navigate to Reports > Recent Activities tab
  const viewAllBtn = document.getElementById('view-all-activities-btn');
  if (viewAllBtn) {
    viewAllBtn.addEventListener('click', () => {
      // 1. Tell the Sidebar to highlight the Reports button
      window.dispatchEvent(new CustomEvent('navigateToPage', {
        detail: { page: 'reports' }
      }));

      // 2. Tell the MainContent area to show the Reports page section
      window.dispatchEvent(new CustomEvent('navigationChanged', {
        detail: { page: 'reports' }
      }));

      // 3. After the page section is visible, activate the Recent Activities tab
      setTimeout(() => {
        const tabButtons = document.querySelectorAll('.table-tab-button');
        tabButtons.forEach(btn => {
          if (btn.textContent.trim() === 'Recent Activities') {
            btn.click();
          }
        });
      }, 50);
    });
  }
})();
</script>
