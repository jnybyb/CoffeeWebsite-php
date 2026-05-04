<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Coffee Crop Monitoring - Dashboard</title>
  <link rel="stylesheet" href="fonts.css">
</head>

<body>
  <!-- Header Component -->
  <?php include 'Header.php'; ?>

  <!-- Main Layout Container -->
  <div class="app-container">
    <!-- Sidebar Component -->
    <?php include 'Sidebar.php'; ?>

    <!-- Main Content Area -->
    <?php include 'MainContent.php'; ?>
  </div>

  <style>
    /* ===============================
         ROOT VARIABLES
         =============================== */
    :root {
      --dark-green: #055035;
      --dark-brown: #6b4423;
      --light-green: #066e46;
      --white: #ffffff;
      --shadow-color: rgba(0, 0, 0, 0.15);
      --light-gray: #f5f5f5;
      --border-gray: #e9ecef;
      --error-red: #b00020;
      --font-main: 'Montserrat', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    }

    /* ===============================
         GLOBAL STYLES
       =============================== */
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    html,
    body {
      width: 100%;
      height: 100%;
    }

    body {
      font-family: var(--font-main);
      background-color: var(--light-gray);
      display: flex;
      flex-direction: column;
    }

    /* ===============================
         APP CONTAINER (SIDEBAR + CONTENT)
         =============================== */
    .app-container {
      display: flex;
      flex: 1;
      overflow: hidden;
    }

    /* ===============================
         MAIN CONTENT AREA
         =============================== */
    .app-main-content {
      flex: 1;
      overflow-y: auto;
      padding: 0;
      background-color: var(--white);
    }

    .content-placeholder {
      background: var(--white);
      padding: 2rem;
      border-radius: 8px;
      box-shadow: 0 2px 4px var(--shadow-color);
      text-align: center;
      color: #999;
    }

    /* ===============================
         RESPONSIVE DESIGN
         =============================== */
    @media (max-width: 768px) {
      .app-main-content {
        padding: 1rem;
      }
    }

    @media (max-width: 480px) {
      .app-container {
        flex-direction: column;
      }

      .app-main-content {
        padding: 0.75rem;
      }

      .content-placeholder {
        padding: 1rem;
      }
    }
  </style>

  <script>
    // Layout-specific scripts (if any) can go here
  </script>
</body>

</html>