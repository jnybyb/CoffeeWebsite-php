<!-- Header Component -->
<header class="app-header">
  <div class="header-branding">
    <img 
      src="../../assets/images/coffee crop logo.png" 
      alt="Coffee Crop Logo" 
      class="header-logo"
    />
    <div class="header-text">
      <span class="header-title">Coffee Crop Monitoring System</span>
    </div>
  </div>

  <div class="header-user-container">
    <span class="header-logout-text">Logout</span>
    <button class="header-logout-icon" id="logoutBtn" title="Logout">
      <img src="../../assets/icons/logout.png" alt="Logout" class="logout-icon-img" />
    </button>
  </div>

  <!-- Logout Confirmation Modal -->
  <div class="logout-modal" id="logoutModal" style="display: none;">
    <div class="logout-modal-overlay"></div>
    <div class="logout-modal-content">
      <div class="logout-modal-header">
        <h2 class="logout-modal-title">Log out?</h2>
      </div>
      <div class="logout-modal-body">
        <p class="logout-modal-message">Are you sure you want to log out of your admin session?</p>
      </div>
      <div class="logout-modal-footer">
        <button class="logout-modal-cancel" id="cancelLogoutBtn">Cancel</button>
        <button class="logout-modal-confirm" id="confirmLogoutBtn">Log out</button>
      </div>
    </div>
  </div>
</header>

<style>
  /* ===============================
     ROOT VARIABLES
     =============================== */
  :root {
    --dark-green: #055035;
    --dark-brown: #6b4423;
    --white: #ffffff;
    --shadow-color: rgba(0, 0, 0, 0.15);
    --light-gray: #f5f5f5;
    --border-gray: #e9ecef;
    --error-red: #b00020;
    --font-main: 'Montserrat', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
  }

  /* ===============================
     HEADER STYLES
     =============================== */
  .app-header {
    background: var(--white);
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 0.2rem 0.32rem;
    box-sizing: border-box;
    box-shadow: 0 4px 7px var(--shadow-color);
    z-index: 10;
    position: sticky;
    top: 0;
  }

  /* ===============================
     BRANDING SECTION
     =============================== */
  .header-branding {
    display: flex;
    align-items: center;
    gap: 0;
  }

  .header-logo {
    height: 48px;
    width: auto;
  }

  .header-text {
    display: flex;
    flex-direction: column;
  }

  .header-title {
    font-weight: 800;
    font-size: 1.3rem;
    color: var(--dark-green);
    font-family: var(--font-main);
  }

  /* ===============================
     USER/LOGOUT SECTION
     =============================== */
  .header-user-container {
    display: flex;
    align-items: center;
    gap: 0.2rem;
    padding: 0.3rem 0.8rem;
  }

  .header-logout-text {
    color: var(--dark-green);
    font-weight: 600;
    font-family: var(--font-main);
    font-size: 0.79rem;
    margin-right: 1px;
  }

  .header-logout-icon {
    cursor: pointer;
    color: var(--dark-green);
    transition: all 0.1s ease;
    transform: scale(1);
    background: none;
    border: none;
    padding: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    outline: none;
  }

  .header-logout-icon:hover {
    transform: scale(1.2);
  }

  .header-logout-icon:active {
    transform: scale(0.95);
  }

  .logout-icon-img {
    width: 20px;
    height: 20px;
    display: block;
  }

  /* ===============================
     LOGOUT MODAL
     =============================== */
  .logout-modal {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 1000;
  }

  .logout-modal-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: rgba(0, 0, 0, 0.5);
  }

  .logout-modal-content {
    position: relative;
    background: var(--white);
    border-radius: 8px;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
    max-width: 420px;
    width: 90%;
    animation: slideUp 0.3s ease;
  }

  @keyframes slideUp {
    from {
      opacity: 0;
      transform: translateY(20px);
    }
    to {
      opacity: 1;
      transform: translateY(0);
    }
  }

  .logout-modal-header {
    padding: 1.5rem;
    border-bottom: 1px solid var(--border-gray);
  }

  .logout-modal-title {
    font-size: 1.2rem;
    font-weight: 700;
    color: var(--dark-green);
    margin: 0;
    font-family: var(--font-main);
  }

  .logout-modal-body {
    padding: 1.5rem;
  }

  .logout-modal-message {
    font-size: 0.95rem;
    color: #333;
    margin: 0;
    font-family: var(--font-main);
    line-height: 1.5;
  }

  .logout-modal-footer {
    padding: 1.5rem;
    border-top: 1px solid var(--border-gray);
    display: flex;
    gap: 1rem;
    justify-content: flex-end;
  }

  .logout-modal-cancel,
  .logout-modal-confirm {
    padding: 0.75rem 1.5rem;
    border-radius: 8px;
    border: none;
    font-weight: 600;
    font-size: 0.9rem;
    font-family: var(--font-main);
    cursor: pointer;
    transition: all 0.2s ease;
  }

  .logout-modal-cancel {
    background-color: var(--light-gray);
    color: #333;
    border: 1px solid var(--border-gray);
  }

  .logout-modal-cancel:hover {
    background-color: #efefef;
  }

  .logout-modal-confirm {
    background-color: var(--dark-green);
    color: var(--white);
  }

  .logout-modal-confirm:hover {
    background-color: #033d2a;
    box-shadow: 0 4px 12px rgba(5, 80, 53, 0.3);
  }

  /* ===============================
     RESPONSIVE DESIGN
     =============================== */
  @media (max-width: 768px) {
    .app-header {
      padding: 0.15rem 0.2rem;
    }

    .header-logo {
      height: 40px;
    }

    .header-title {
      font-size: 1.1rem;
    }

    .header-logout-text {
      font-size: 0.75rem;
    }
  }

  @media (max-width: 480px) {
    .app-header {
      padding: 0.1rem 0.15rem;
      gap: 0.5rem;
    }

    .header-branding {
      gap: 0.3rem;
    }

    .header-logo {
      height: 36px;
    }

    .header-title {
      font-size: 0.95rem;
    }

    .header-logout-text {
      display: none;
    }

    .logout-modal-content {
      width: 95%;
    }
  }
</style>

<script>
  // Header component functionality
  (function() {
    // Get elements
    const logoutBtn = document.getElementById('logoutBtn');
    const logoutModal = document.getElementById('logoutModal');
    const cancelLogoutBtn = document.getElementById('cancelLogoutBtn');
    const confirmLogoutBtn = document.getElementById('confirmLogoutBtn');
    const modalOverlay = document.querySelector('.logout-modal-overlay');

    // Open logout modal
    if (logoutBtn) {
      logoutBtn.addEventListener('click', () => {
        logoutModal.style.display = 'flex';
      });
    }

    // Close modal functions
    const closeModal = () => {
      logoutModal.style.display = 'none';
    };

    // Close on cancel button
    if (cancelLogoutBtn) {
      cancelLogoutBtn.addEventListener('click', closeModal);
    }

    // Close on overlay click
    if (modalOverlay) {
      modalOverlay.addEventListener('click', closeModal);
    }

    // Handle logout confirmation
    if (confirmLogoutBtn) {
      confirmLogoutBtn.addEventListener('click', () => {
        try {
          // Clear authentication data
          localStorage.removeItem('authToken');
          localStorage.removeItem('auth_token');
          localStorage.removeItem('user');
          localStorage.removeItem('auth_user');
        } catch (error) {
          console.error('Error clearing localStorage:', error);
        }
        
        // Redirect to login page
        window.location.replace('../../../index.php');
      });
    }

    // Close modal on Escape key
    document.addEventListener('keydown', (e) => {
      if (e.key === 'Escape' && logoutModal.style.display === 'flex') {
        closeModal();
      }
    });
  })();
</script>
