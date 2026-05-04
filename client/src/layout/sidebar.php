<!-- Sidebar Navigation Component -->
<aside class="app-sidebar">
  <nav class="sidebar-nav">
    <ul class="sidebar-nav-list">
      <li class="sidebar-nav-item">
        <button class="sidebar-button" data-page="dashboard" data-inactive-icon="../../assets/icons/dashboard.png"
          data-active-icon="../../assets/icons/dashboard-active.png">
          <img src="../../assets/icons/dashboard.png" alt="Dashboard" class="sidebar-icon" />
          <span class="sidebar-label">Dashboard</span>
        </button>
      </li>
      <li class="sidebar-nav-item">
        <button class="sidebar-button" data-page="farm-monitoring" data-inactive-icon="../../assets/icons/maps.png"
          data-active-icon="../../assets/icons/maps-active.png">
          <img src="../../assets/icons/maps.png" alt="Farm Monitoring" class="sidebar-icon" />
          <span class="sidebar-label">Farm Monitoring</span>
        </button>
      </li>
      <li class="sidebar-nav-item">
        <button class="sidebar-button active" data-page="beneficiaries"
          data-inactive-icon="../../assets/icons/users.png" data-active-icon="../../assets/icons/users-active.png">
          <img src="../../assets/icons/users-active.png" alt="Coffee Beneficiaries" class="sidebar-icon" />
          <span class="sidebar-label">Coffee Beneficiaries</span>
        </button>
      </li>
      <li class="sidebar-nav-item">
        <button class="sidebar-button" data-page="reports" data-inactive-icon="../../assets/icons/reports.png"
          data-active-icon="../../assets/icons/reports-active.png">
          <img src="../../assets/icons/reports.png" alt="Reports" class="sidebar-icon" />
          <span class="sidebar-label">Reports</span>
        </button>
      </li>
    </ul>
  </nav>
</aside>

<style>
  /* ===============================
     ROOT VARIABLES
     =============================== */
  :root {
    --dark-green: #055035;
    --light-green: #066e46;
    --white: #ffffff;
    --font-main: 'Montserrat', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
  }

  /* ===============================
     SIDEBAR STYLES
     =============================== */
  .app-sidebar {
    background: var(--dark-green);
    color: var(--white);
    box-sizing: border-box;
    padding: 7px 0;
    font-family: var(--font-main);
    display: flex;
    flex-direction: column;
    align-items: stretch;
    flex: 0 0 220px;
    min-height: 0;
    width: 220px;
    overflow-y: auto;
    scrollbar-width: thin;
    scrollbar-color: rgba(255, 255, 255, 0.3) transparent;
  }

  .app-sidebar::-webkit-scrollbar {
    width: 6px;
  }

  .app-sidebar::-webkit-scrollbar-track {
    background: transparent;
  }

  .app-sidebar::-webkit-scrollbar-thumb {
    background: rgba(255, 255, 255, 0.3);
    border-radius: 3px;
  }

  .app-sidebar::-webkit-scrollbar-thumb:hover {
    background: rgba(255, 255, 255, 0.5);
  }

  /* ===============================
     NAVIGATION STYLES
     =============================== */
  .sidebar-nav {
    width: 100%;
    flex: 1;
    display: flex;
    flex-direction: column;
    overflow-y: auto;
    padding-top: 1rem;
  }

  .sidebar-nav-list {
    list-style: none;
    padding: 0;
    margin: 0;
    width: 100%;
    flex: 1;
    display: flex;
    flex-direction: column;
    gap: 10px;
  }

  .sidebar-nav-item {
    width: 100%;
    display: flex;
  }

  /* ===============================
     SIDEBAR BUTTONS
     =============================== */
  .sidebar-button {
    width: 94%;
    height: 55px;
    display: flex;
    align-items: center;
    gap: .72rem;
    padding: 0 1.3rem;
    background: transparent;
    border: none;
    color: rgba(255, 255, 255, 0.9);
    font-family: var(--font-main);
    font-size: 0.8rem;
    font-weight: 300;
    cursor: pointer;
    transition: all 0.2s ease;
    position: relative;
    border-left: 4px solid transparent;
    border-radius: 8px 0 0 8px;
    box-sizing: border-box;
    outline: none;
    margin-bottom: 8px;
    margin-left: 4%;
  }

  .sidebar-button:hover {
    background-color: rgba(255, 255, 255, 0.08);
  }

  .sidebar-button:active {
    background-color: rgba(255, 255, 255, 0.12);
  }

  /* Active state styling */
  .sidebar-button.active {
    background-color: rgba(255, 255, 255, 0.12);
    border-left-color: var(--white);
    color: var(--white);
    font-weight: 700;
    margin-left: 0;
    width: 100%;
  }

  /* ===============================
     SIDEBAR ICON
     =============================== */
  .sidebar-icon {
    width: 22px;
    height: 22px;
    min-width: 22px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
  }

  .sidebar-button.active .sidebar-icon {
    color: var(--white);
  }

  .sidebar-button:not(.active) .sidebar-icon {
    color: #d0d0d0;
  }

  /* ===============================
     SIDEBAR LABEL
     =============================== */
  .sidebar-label {
    flex: 1;
    text-align: left;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
  }

  /* ===============================
     RESPONSIVE DESIGN
     =============================== */
  @media (max-width: 1024px) {
    .app-sidebar {
      width: 20px;
      flex: 0 0 20px;
    }

    .sidebar-button {
      height: 50px;
      padding: 0 1.2rem;
      font-size: 0.85rem;
      gap: 0.8rem;
    }

    .sidebar-icon {
      width: 12.5%;
      height: 20px;
    }
  }

  @media (max-width: 768px) {
    .app-sidebar {
      width: 20px;
      flex: 0 0 20px;
    }

    .sidebar-button {
      height: 48px;
      padding: 0 1rem;
      gap: 0.7rem;
      font-size: 0.8rem;
      margin-bottom: 5px;
    }

    .sidebar-icon {
      width: 18px;
      height: 18px;
    }
  }

  @media (max-width: 480px) {
    .app-sidebar {
      width: 100%;
      height: auto;
      padding: 4px;
      flex-direction: row;
      overflow-x: auto;
      overflow-y: hidden;
      border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    }

    .sidebar-nav-list {
      flex-direction: row;
    }

    .sidebar-nav-item {
      flex-shrink: 0;
    }

    .sidebar-button {
      height: 30px;
      padding: 0.5rem 1rem;
      margin-top: 0;
      border-left: none;
      border-bottom: 3px solid transparent;
    }

    .sidebar-button:hover:not(.active) {
      border-bottom-color: rgba(255, 255, 255, 0.5);
    }

    .sidebar-button.active {
      border-left: none;
      border-bottom: 3px solid var(--white);
      padding-bottom: calc(0.5rem - 3px);
    }

    .sidebar-label {
      display: none;
    }

    .sidebar-icon {
      width: 24px;
      height: 24px;
    }
  }
</style>

<script>
  // Sidebar navigation functionality
  (function () {
    const sidebarButtons = document.querySelectorAll('.sidebar-button');

    // Get active page from localStorage or current page
    const getActivePage = () => {
      return localStorage.getItem('activePage') || 'beneficiaries';
    };

    // Set active button on page load
    const setActiveButton = (pageName) => {
      sidebarButtons.forEach(button => {
        const isActive = button.getAttribute('data-page') === pageName;
        button.classList.toggle('active', isActive);

        // Update icon based on active state
        const icon = button.querySelector('.sidebar-icon');
        if (icon) {
          if (isActive) {
            icon.src = button.getAttribute('data-active-icon');
          } else {
            icon.src = button.getAttribute('data-inactive-icon');
          }
        }
      });

      localStorage.setItem('activePage', pageName);
    };

    // Initialize active button
    setActiveButton(getActivePage());

    // Handle button clicks
    sidebarButtons.forEach(button => {
      button.addEventListener('click', (e) => {
        e.preventDefault();
        const pageName = button.getAttribute('data-page');
        setActiveButton(pageName);

        // Emit custom event for other components to listen
        const event = new CustomEvent('navigationChanged', {
          detail: { page: pageName }
        });
        window.dispatchEvent(event);

        // Optional: Navigate or load page content
        console.log('Navigated to:', pageName);
        // You can add logic here to load different pages/content
      });
    });

    // Listen for navigation events from other components
    window.addEventListener('navigateToPage', (event) => {
      setActiveButton(event.detail.page);
    });
  })();
</script>