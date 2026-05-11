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

  <?php include_once __DIR__ . '/../ui/LoadingModal.php'; ?>
  <?php include_once __DIR__ . '/../ui/AlertModal.php'; ?>
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

  }
</style>

<script>
  // Header component functionality
  (function() {
    // Get elements
    const logoutBtn = document.getElementById('logoutBtn');

    // Open logout modal using AlertModal
    if (logoutBtn) {
      logoutBtn.addEventListener('click', () => {
        if (typeof AlertModal !== 'undefined') {
          AlertModal.show({
            type: 'logout',
            title: 'Log out?',
            message: 'Are you sure you want to log out of your admin session?',
            showCancel: true,
            confirmText: 'Log out',
            cancelText: 'Cancel',
            onConfirm: function() {
              AlertModal.hide();
              
              if (typeof ModalTypes !== 'undefined') {
                ModalTypes.showLoggingIn({
                  title: 'Logging out...',
                  message: 'Ending your session safely'
                });
              }

              setTimeout(() => {
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
              }, 800);
            }
          });
        }
      });
    }
  })();
</script>
