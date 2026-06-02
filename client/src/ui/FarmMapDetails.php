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

  .md-card.active {
    border-color: var(--dark-green, #055035);
    background-color: rgba(5, 80, 53, 0.03);
    box-shadow: 0 4px 8px rgba(5, 80, 53, 0.1);
  }

  .md-empty-state {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 2.5rem 1rem;
    color: var(--text-gray, #888);
    text-align: center;
    font-size: 0.65rem;
    font-weight: 500;
  }

  .md-empty-state svg {
    margin-bottom: 0.75rem;
    opacity: 0.6;
    width: 24px;
    height: 24px;
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
      <input type="text" class="md-search-input" id="mdSearchInput" placeholder="Search beneficiaries...">
    </div>
  </div>

  <!-- Tabs -->
  <div class="md-tabs">
    <button class="md-tab active" id="tabBeneficiariesBtn">
      <span>Beneficiaries</span>
      <span class="md-tab-count" id="benTabCount">0</span>
    </button>
    <button class="md-tab" id="tabFarmsBtn">
      <span>Farms</span>
      <span class="md-tab-count" id="farmTabCount">0</span>
    </button>
  </div>

  <!-- Content area -->
  <div class="md-list-container" id="mdListContainer">
    <!-- Items rendered here dynamically -->
  </div>
</div>

<script>
  document.addEventListener('DOMContentLoaded', () => {
    const apiUrl = typeof API_BASE_URL !== 'undefined' ? API_BASE_URL : 'http://localhost:5000/api';
    const listContainer = document.getElementById('mdListContainer');
    const searchInput = document.getElementById('mdSearchInput');
    const benTabBtn = document.getElementById('tabBeneficiariesBtn');
    const farmTabBtn = document.getElementById('tabFarmsBtn');
    const benTabCount = document.getElementById('benTabCount');
    const farmTabCount = document.getElementById('farmTabCount');
    const viewAllBtn = document.querySelector('.md-view-all');

    let currentTab = 'beneficiaries'; // 'beneficiaries' or 'farms'
    window.allFarmPlots = [];
    window.allBeneficiaries = [];
    let beneficiariesWithFarms = [];

    // Switch Tab
    function switchTab(tab) {
      currentTab = tab;
      if (tab === 'beneficiaries') {
        benTabBtn.classList.add('active');
        farmTabBtn.classList.remove('active');
        searchInput.placeholder = 'Search beneficiaries...';
      } else {
        farmTabBtn.classList.add('active');
        benTabBtn.classList.remove('active');
        searchInput.placeholder = 'Search farm plots...';
      }
      renderList();
    }

    benTabBtn.addEventListener('click', () => switchTab('beneficiaries'));
    farmTabBtn.addEventListener('click', () => switchTab('farms'));

    // Search input handler
    searchInput.addEventListener('input', () => {
      renderList();
    });

    // Fetch data
    async function fetchData() {
      const token = localStorage.getItem('authToken');
      if (!token) {
        window.location.href = '../../login.php';
        return;
      }

      listContainer.innerHTML = `
        <div class="md-empty-state">
          <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="animate-spin" style="animation: spin 1s linear infinite;">
            <circle cx="12" cy="12" r="10" stroke-dasharray="32" stroke-dashoffset="16"></circle>
          </svg>
          <div style="margin-top: 0.5rem;">Loading data...</div>
        </div>
        <style>
          @keyframes spin { to { transform: rotate(360deg); } }
        </style>
      `;

      try {
        const [resPlots, resBens] = await Promise.all([
          fetch(`${apiUrl}/farm-plots`, { headers: { 'Authorization': `Bearer ${token}` } }),
          fetch(`${apiUrl}/beneficiaries`, { headers: { 'Authorization': `Bearer ${token}` } })
        ]);

        if (resPlots.status === 401 || resPlots.status === 403 || resBens.status === 401 || resBens.status === 403) {
          localStorage.removeItem('authToken');
          window.location.href = '../../login.php';
          return;
        }

        const plots = await resPlots.json();
        const beneficiaries = await resBens.json();

        window.allFarmPlots = Array.isArray(plots) ? plots : [];
        window.allBeneficiaries = Array.isArray(beneficiaries) ? beneficiaries : (beneficiaries.data || []);

        // Process beneficiaries with farms
        const bensMap = {};
        window.allFarmPlots.forEach(plot => {
          const bId = plot.beneficiaryId;
          if (!bId) return;
          if (!bensMap[bId]) {
            const fullBen = window.allBeneficiaries.find(b => b.beneficiaryId === bId);
            bensMap[bId] = {
              id: bId,
              name: plot.beneficiaryName || (fullBen ? `${fullBen.firstName} ${fullBen.lastName}` : 'Unknown'),
              picture: plot.beneficiaryPicture || (fullBen ? fullBen.picture : null),
              farmsCount: 0,
              farms: []
            };
          }
          bensMap[bId].farmsCount++;
          bensMap[bId].farms.push(plot);
        });

        beneficiariesWithFarms = Object.values(bensMap);

        // Update counts
        benTabCount.textContent = beneficiariesWithFarms.length;
        farmTabCount.textContent = window.allFarmPlots.length;

        // Render map plots
        if (window.leafletMap && typeof window.drawFarmPlotsOnMap === 'function') {
          window.drawFarmPlotsOnMap(window.allFarmPlots);
        }

        renderList();
      } catch (error) {
        console.error('Error loading farm map details:', error);
        listContainer.innerHTML = `
          <div class="md-empty-state" style="color: var(--error-red, #b00020);">
            <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
            <div style="margin-top: 0.5rem;">Failed to load farm details.</div>
          </div>
        `;
      }
    }

    // Render list items based on active tab and query
    function renderList() {
      const query = searchInput.value.toLowerCase().trim();
      listContainer.innerHTML = '';

      if (currentTab === 'beneficiaries') {
        const filteredBens = beneficiariesWithFarms.filter(b => 
          b.name.toLowerCase().includes(query) || b.id.toLowerCase().includes(query)
        );

        if (filteredBens.length === 0) {
          listContainer.innerHTML = `
            <div class="md-empty-state">
              <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
              <div>No beneficiaries found</div>
            </div>
          `;
          return;
        }

        filteredBens.forEach(ben => {
          const initial = ben.name.charAt(0).toUpperCase() || '?';
          const avatarHtml = ben.picture
            ? `<img src="${apiUrl.replace('/api', '')}${ben.picture}" alt="${ben.name}">`
            : `<span style="color: var(--dark-green, #055035);">${initial}</span>`;

          const card = document.createElement('div');
          card.className = 'md-card';
          card.innerHTML = `
            <div class="md-card-left">
              <div class="md-avatar">
                ${avatarHtml}
              </div>
              <div class="md-info">
                <div class="md-name">${ben.name}</div>
                <div class="md-id">ID: ${ben.id}</div>
              </div>
            </div>
            <div class="md-farms-section">
              <div class="md-farms-text">
                <div>Farms</div>
                <div class="md-farms-count-val">${ben.farmsCount}</div>
              </div>
            </div>
          `;

          // Focus map on click
          card.addEventListener('click', () => {
            document.querySelectorAll('.md-card').forEach(c => c.classList.remove('active'));
            card.classList.add('active');
            if (window.leafletMap && window.drawFarmPlotsOnMap) {
              const plots = window.allFarmPlots.filter(p => p.beneficiaryId === ben.id);
              const polygons = plots.filter(p => p.polygon).map(p => p.polygon);

              if (polygons.length > 0) {
                const group = L.featureGroup(polygons);
                window.leafletMap.fitBounds(group.getBounds(), { padding: [50, 50] });
                
                const firstPlot = plots.find(p => p.polygon);
                if (firstPlot && firstPlot.marker) {
                  firstPlot.marker.openPopup();
                } else {
                  polygons[0].openPopup();
                }
              }
            }
            if (ben.farms && ben.farms.length > 0 && typeof window.openViewFarmPlotDetailsModal === 'function') {
              window.openViewFarmPlotDetailsModal(ben.farms[0], window.allFarmPlots, window.allBeneficiaries, () => {
                fetchData();
              });
            }
          });

          listContainer.appendChild(card);
        });
      } else {
        const filteredPlots = window.allFarmPlots.filter(p => 
          p.id.toLowerCase().includes(query) || 
          p.beneficiaryName.toLowerCase().includes(query) || 
          (p.address && p.address.toLowerCase().includes(query))
        );

        if (filteredPlots.length === 0) {
          listContainer.innerHTML = `
            <div class="md-empty-state">
              <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
              <div>No farm plots found</div>
            </div>
          `;
          return;
        }

        filteredPlots.forEach(plot => {
          const fullBen = window.allBeneficiaries.find(b => b.beneficiaryId === plot.beneficiaryId);
          const ownerName = plot.beneficiaryName || (fullBen ? `${fullBen.firstName} ${fullBen.lastName}` : 'Unknown Owner');
          const picture = plot.beneficiaryPicture || (fullBen ? fullBen.picture : null);

          const avatarHtml = picture
            ? `<img src="${apiUrl.replace('/api', '')}${picture}" alt="${ownerName}">`
            : `<svg width="18" height="18" fill="currentColor" viewBox="0 0 24 24" style="color: #8c8c8c; opacity: 0.8;"><path d="M12 15c-1.66 0-3-1.34-3-3s1.34-3 3-3 3 1.34 3 3-1.34 3-3 3zm0-8c-3.87 0-7 3.13-7 7s3.13 7 7 7 7-3.13 7-7-3.13-7-7-7zm0-5L9 2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2h-4l-2-2h-2z"/></svg>`;

          const card = document.createElement('div');
          card.className = 'md-card';
          card.innerHTML = `
            <div class="md-card-left">
              <div class="md-avatar" style="${picture ? '' : 'background-color: #e9ecef;'}">
                ${avatarHtml}
              </div>
              <div class="md-info">
                <div class="md-name" style="font-size: 0.75rem; font-weight: 700; color: #111;">${plot.id}</div>
                <div class="md-owner" style="font-size: 0.65rem; color: #888888; font-weight: 500; margin-top: 1px;">${ownerName}</div>
              </div>
            </div>
            <div class="md-farms-section" style="margin-left: auto; flex-shrink: 0; align-self: center;">
              <div style="font-size: 0.65rem; color: #a8a8a8; font-weight: 500;">
                ${plot.beneficiaryId || ''}
              </div>
            </div>
          `;

          // Focus map on click
          card.addEventListener('click', () => {
            document.querySelectorAll('.md-card').forEach(c => c.classList.remove('active'));
            card.classList.add('active');
            if (window.leafletMap && plot.polygon) {
              window.leafletMap.fitBounds(plot.polygon.getBounds(), { padding: [50, 50] });
              if (plot.marker) {
                plot.marker.openPopup();
              } else {
                plot.polygon.openPopup();
              }
            }
            if (typeof window.openViewFarmPlotDetailsModal === 'function') {
              window.openViewFarmPlotDetailsModal(plot, window.allFarmPlots, window.allBeneficiaries, () => {
                fetchData();
              });
            }
          });

          listContainer.appendChild(card);
        });
      }
    }

    // View all button handler
    if (viewAllBtn) {
      viewAllBtn.addEventListener('click', () => {
        if (window.leafletMap && window.mapPolygons && window.mapPolygons.length > 0) {
          const group = L.featureGroup(window.mapPolygons);
          window.leafletMap.fitBounds(group.getBounds(), { padding: [40, 40] });
        }
      });
    }

    // Initial load
    fetchData();
  });
</script>
