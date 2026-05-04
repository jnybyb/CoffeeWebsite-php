<!-- Farm Map Details Component -->
<style>
  /* ===============================
     FARM MAP DETAILS
     =============================== */
  .map-details-container {
    position: relative;
    width: 100%;
    height: 100%;
    background-color: var(--white, #ffffff);
    display: flex;
    flex-direction: column;
  }

  .md-header {
    padding: 1.5rem 1.25rem 0.5rem 1.25rem;
    display: flex;
    justify-content: space-between;
    align-items: center;
  }

  .md-title {
    font-size: 1.1rem;
    font-weight: 600;
    color: var(--dark-green, #055035);
    margin: 0;
  }

  .md-view-all {
    background: transparent;
    border: none;
    color: var(--dark-green, #055035);
    font-size: 0.65rem;
    font-weight: 500;
    cursor: pointer;
    text-decoration: underline;
    padding: 0;
    transition: opacity 0.2s;
  }

  .md-view-all:hover {
    opacity: 0.7;
  }

  .md-search-container {
    padding: 0.45rem 1.25rem;
    flex-shrink: 0;
  }

  .md-search-wrapper {
    position: relative;
    width: 100%;
  }

  .md-search-icon {
    position: absolute;
    left: 10px;
    top: 50%;
    transform: translateY(-50%);
    color: var(--placeholder-text, #999);
    width: 16px;
    height: 16px;
    pointer-events: none;
  }

  .md-search-input {
    width: 100%;
    padding: 0.5rem 2.5rem 0.5rem 2rem;
    border: 1px solid var(--border-gray, #e6e6e6);
    border-radius: 4px;
    font-size: 0.65rem;
    outline: none;
    box-sizing: border-box;
    font-family: inherit;
  }

  .md-tabs {
    display: flex;
    padding: 0 1.25rem;
    background-color: transparent;
    flex-shrink: 0;
    width: 100%;
    gap: 1rem;
    box-sizing: border-box;
  }

  .md-tab {
    flex: 1;
    padding: 1rem 0.5rem 0.5rem 0;
    background: transparent;
    color: var(--dark-gray, #666);
    border: none;
    border-bottom: 3px solid transparent;
    cursor: pointer;
    font-weight: 600;
    font-size: 0.7rem;
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-family: inherit;
  }
  
  .md-tab:last-child {
    padding: 1rem 0 0.5rem 0.5rem;
  }

  .md-tab.active {
    color: var(--dark-green, #055035);
    border-bottom-color: var(--dark-green, #055035);
  }

  .md-tab-count {
    font-size: 0.6rem;
    color: inherit;
  }

  .md-list-container {
    padding: 0.8rem 1.25rem;
    overflow-y: auto;
    flex: 1;
  }

  .md-list-container::-webkit-scrollbar {
    width: 4px;
  }
  .md-list-container::-webkit-scrollbar-track {
    background: transparent;
  }
  .md-list-container::-webkit-scrollbar-thumb {
    background: var(--border-gray, #e6e6e6);
    border-radius: 2px;
  }

  .md-card {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 0.6rem;
    border: 1px solid var(--border-gray, #e6e6e6);
    border-radius: 6px;
    background-color: var(--white, #ffffff);
    box-shadow: 0 1px 3px rgba(0,0,0,0.05);
    width: 100%;
    cursor: pointer;
    transition: all 0.2s ease;
    margin-bottom: 0.5rem;
    box-sizing: border-box;
  }

  .md-card:last-child {
    margin-bottom: 0;
  }

  .md-card:hover {
    background-color: var(--light-gray, #f9f9f9);
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.05);
  }

  .md-card-left {
    display: flex;
    align-items: center;
    flex: 1;
    min-width: 0;
  }

  .md-avatar {
    margin-right: 0.6rem;
    flex-shrink: 0;
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background-color: var(--light-gray, #f5f5f5);
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--dark-text, #333);
    font-size: 16px;
    font-weight: bold;
    overflow: hidden;
  }

  .md-avatar img {
    width: 100%;
    height: 100%;
    object-fit: cover;
  }

  .md-info {
    min-width: 0;
    flex: 1;
  }

  .md-name {
    font-weight: 600;
    font-size: 0.7rem;
    color: var(--dark-gray, #333);
    margin-bottom: 0.2rem;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
  }

  .md-id {
    font-size: 0.6rem;
    color: var(--text-gray, #888);
  }

  .md-farms-section {
    display: flex;
    align-items: center;
    justify-content: flex-end;
    flex-shrink: 0;
    margin-left: 1rem;
  }

  .md-farms-text {
    font-size: 0.6rem;
    color: var(--text-gray, #888);
    text-align: right;
  }

  .md-farms-count-val {
    font-weight: 500;
    font-size: 0.85rem;
    color: var(--dark-green, #055035);
  }
</style>

<div class="map-details-container">
  <!-- Title -->
  <div class="md-header">
    <div class="md-title">Farm Plots</div>
    <button class="md-view-all">View All</button>
  </div>

  <!-- Search Bar -->
  <div class="md-search-container">
    <div class="md-search-wrapper">
      <svg class="md-search-icon" viewBox="0 0 24 24" fill="currentColor">
        <path d="M15.5 14h-.79l-.28-.27A6.471 6.471 0 0016 9.5 6.5 6.5 0 109.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"/>
      </svg>
      <input type="text" class="md-search-input" placeholder="Search beneficiaries...">
    </div>
  </div>

  <!-- Tabs -->
  <div class="md-tabs">
    <button class="md-tab active">
      <span>Beneficiaries</span>
      <span class="md-tab-count">3</span>
    </button>
    <button class="md-tab">
      <span>Farms</span>
      <span class="md-tab-count">3</span>
    </button>
  </div>

  <!-- Content area -->
  <div class="md-list-container">
    
    <!-- Item 1 -->
    <div class="md-card">
      <div class="md-card-left">
        <div class="md-avatar">
          <!-- Profile Icon Placeholder -->
          📷
        </div>
        <div class="md-info">
          <div class="md-name">Lanie A. Pedro/Alay</div>
          <div class="md-id">ID: BEN-003</div>
        </div>
      </div>
      <div class="md-farms-section">
        <div class="md-farms-text">
          <div>Farms</div>
          <div class="md-farms-count-val">1</div>
        </div>
      </div>
    </div>

    <!-- Item 2 -->
    <div class="md-card">
      <div class="md-card-left">
        <div class="md-avatar">
          <!-- Profile Image Example -->
          📷
        </div>
        <div class="md-info">
          <div class="md-name">Jojo M. Malagdao</div>
          <div class="md-id">ID: BEN-004</div>
        </div>
      </div>
      <div class="md-farms-section">
        <div class="md-farms-text">
          <div>Farms</div>
          <div class="md-farms-count-val">1</div>
        </div>
      </div>
    </div>

    <!-- Item 3 -->
    <div class="md-card">
      <div class="md-card-left">
        <div class="md-avatar">
          📷
        </div>
        <div class="md-info">
          <div class="md-name">Danilo Pedro</div>
          <div class="md-id">ID: BEN-009</div>
        </div>
      </div>
      <div class="md-farms-section">
        <div class="md-farms-text">
          <div>Farms</div>
          <div class="md-farms-count-val">1</div>
        </div>
      </div>
    </div>

  </div>
</div>
