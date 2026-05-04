<!-- Farm Monitoring Page -->
<style>
  /* ===============================
     HEADER SECTION
     =============================== */
  .page-header.farm-header {
    padding: 1.6rem 1rem 1.4rem 1rem;
    background-color: var(--white, #ffffff);
    margin-bottom: 0;
    display: flex;
    justify-content: space-between;
    align-items: flex-end;
  }

  .page-title {
    color: var(--dark-green, #055035);
    font-size: 1.57rem;
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
    .page-header.farm-header {
      padding: 1.2rem 0.8rem 1rem 0.8rem;
    }
    .page-title {
      font-size: 1.3rem;
    }
  }

  @media (max-width: 480px) {
    .page-header.farm-header {
      padding: 1rem 0.5rem 0.8rem 0.5rem;
      flex-direction: column;
      align-items: flex-start;
      gap: 1rem;
    }
    .page-title {
      font-size: 1.2rem;
    }
    .page-header .page-subtitle {
      font-size: 0.5rem;
    }
  }

  /* Full height wrapper to prevent scrolling */
  .farm-monitoring-wrapper {
    display: flex;
    flex-direction: column;
    height: calc(100vh - 70px); /* Adjust based on top navbar height */
    overflow: hidden;
  }
</style>

<div class="farm-monitoring-wrapper">
  <div class="page-header farm-header">
  <div>
    <h2 class="page-title">Farm Monitoring</h2>
    <div class="page-subtitle">Real-time monitoring of your farm plots</div>
  </div>
  <div>
    <?php 
      $buttonText = 'Add Plot'; 
      $buttonAction = 'handleAddPlot()';
      include '../ui/AddButton.php'; 
    ?>
  </div>
</div>

<style>
  .farm-content-wrapper {
    display: flex;
    flex: 1;
    margin: 0 1rem 1rem 1rem;
    gap: 1rem;
    min-height: 0;
  }

  .farm-map-section {
    flex: 65;
    border-radius: 8px;
    background-color: var(--white, #ffffff);
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    overflow: hidden;
    position: relative;
  }

  .farm-details-section {
    flex: 35;
    border-radius: 8px;
    background-color: var(--white, #ffffff);
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    border: 1px solid var(--border-gray, #e6e6e6);
    overflow: hidden;
    display: flex;
    flex-direction: column;
  }

  @media (max-width: 1024px) {
    .farm-content-wrapper {
      flex-direction: column;
      height: auto;
    }
    .farm-map-section {
      min-height: 400px;
    }
  }
</style>

<div class="farm-content-wrapper">
  <!-- Main Map Visualization -->
  <div class="farm-map-section">
    <?php include '../ui/FarmMap.php'; ?>
  </div>

  <!-- Map Details Component -->
  <div class="farm-details-section">
    <?php include '../ui/FarmMapDetails.php'; ?>
  </div>
</div>
</div>

<script>
  function handleAddPlot() {
    alert('Add Farm Plot modal will open here');
  }
</script>
