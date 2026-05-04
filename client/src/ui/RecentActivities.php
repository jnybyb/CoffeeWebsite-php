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
    border: 1px solid var(--dark-brown, #6b4423);
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
    border: 1px solid var(--dark-brown, #6b4423);
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
    margin-top: 1rem;
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
  
  <div class="activities-list">
    <!-- Activity Item 1 -->
    <div class="activity-card">
      <div class="activity-row">
        <div class="activity-icon-container">
          <svg viewBox="0 0 24 24"><path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5C6.34 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z"/></svg>
        </div>
        <div class="activity-content">
          <div class="activity-header">Coffee Beneficiary</div>
          <div class="activity-action">Registered new farmer John Doe</div>
          <div class="activity-timestamp">10/24/2026, 2:30 PM</div>
        </div>
      </div>
    </div>

    <!-- Activity Item 2 -->
    <div class="activity-card">
      <div class="activity-row">
        <div class="activity-icon-container">
          <svg viewBox="0 0 24 24"><path d="M12 3c-4.97 0-9 4.03-9 9 0 2.12.74 4.07 1.97 5.61L3 21l3.39-1.97C7.93 20.26 9.88 21 12 21c4.97 0 9-4.03 9-9s-4.03-9-9-9z"/></svg>
        </div>
        <div class="activity-content">
          <div class="activity-header">Crop Survey Status</div>
          <div class="activity-action">Updated Farm Plot 12 status to Healthy</div>
          <div class="activity-timestamp">10/24/2026, 1:15 PM</div>
        </div>
      </div>
    </div>

    <!-- Activity Item 3 -->
    <div class="activity-card">
      <div class="activity-row">
        <div class="activity-icon-container">
          <svg viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2z"/></svg>
        </div>
        <div class="activity-content">
          <div class="activity-header">Seedling Record</div>
          <div class="activity-action">Distributed 150 seedlings</div>
          <div class="activity-timestamp">10/23/2026, 9:45 AM</div>
        </div>
      </div>
    </div>
    
    <!-- Activity Item 4 -->
    <div class="activity-card">
      <div class="activity-row">
        <div class="activity-icon-container">
          <svg viewBox="0 0 24 24"><path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zM9 17H7v-7h2v7zm4 0h-2V7h2v10zm4 0h-2v-4h2v4z"/></svg>
        </div>
        <div class="activity-content">
          <div class="activity-header">Reports</div>
          <div class="activity-action">Generated monthly crop report</div>
          <div class="activity-timestamp">10/22/2026, 4:20 PM</div>
        </div>
      </div>
    </div>
  </div>
  
  <div class="view-all-link">
    View All
  </div>
</div>
