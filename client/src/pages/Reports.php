<!-- Reports Page -->
<style>
  /* ===============================
     REPORTS WRAPPER
     =============================== */
  .reports-wrapper {
    display: flex;
    flex-direction: column;
    height: calc(100vh - 70px); /* Adjust based on top navbar height */
    overflow: hidden;
  }

  .page-header.reports-header {
    padding: 1.6rem 1rem 1rem 1rem;
    background-color: var(--white, #ffffff);
    margin-bottom: 0;
    display: flex;
    justify-content: space-between;
    align-items: flex-end;
    flex-shrink: 0;
  }

  .reports-header .page-title {
    color: var(--dark-green, #055035);
    font-size: 1.5rem;
    font-weight: 600;
    margin: 0;
  }

  .reports-header .page-subtitle {
    color: var(--dark-brown, #6b4423);
    font-size: 0.7rem;
    margin-top: 0.2rem;
    font-weight: 500;
  }

  .reports-content-container {
    flex: 1;
    display: flex;
    flex-direction: column;
    background-color: var(--white, #ffffff);
    overflow: hidden;
  }

  .reports-inner-container {
    flex: 1;
    display: flex;
    flex-direction: column;
    overflow: hidden;
    margin: 1rem;
    background-color: var(--white, #ffffff);
    border-radius: 6px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.1);
  }

  /* Dynamic table override styles */
  #reportDynamicTable {
    flex: 1;
    overflow-y: auto;
    position: relative;
    display: flex;
    flex-direction: column;
  }

  #reportDynamicTable table {
    width: 100%;
    border-collapse: collapse;
    font-size: 0.7rem;
    font-family: var(--font-main, 'Montserrat', sans-serif);
  }

  #reportDynamicTable thead th {
    text-align: left;
    padding: 0.75rem 1rem;
    border-bottom: 1px solid #e5e7eb;
    color: var(--text-gray, #6b7280);
    font-weight: 600;
    background-color: #f0f7f4;
    position: sticky;
    top: 0;
    z-index: 1;
  }

  #reportDynamicTable thead th:first-child {
    width: 48px;
    text-align: center;
  }

  #reportDynamicTable tbody td {
    padding: 0.75rem 1rem;
    border-bottom: 1px solid #e5e7eb;
    color: #374151;
    vertical-align: middle;
  }

  #reportDynamicTable tbody td:first-child {
    text-align: center;
    color: var(--text-gray, #9ca3af);
    font-weight: 500;
  }

  #reportDynamicTable .plot-id-cell {
    color: var(--dark-green, #055035);
    font-weight: 600;
  }

  #reportDynamicTable .beneficiary-cell {
    color: var(--dark-green, #055035);
  }

  #reportDynamicTable .em-dash {
    color: #9ca3af;
  }

  #reportDynamicTable .coord-badge {
    font-size: 0.65rem;
    color: #6b7280;
  }

  #reportDynamicTable tbody tr:hover {
    background-color: #f9fefb;
  }

  .report-table-spinner-wrap {
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    padding: 3rem;
    gap: 1rem;
  }

  .report-table-spinner {
    width: 36px;
    height: 36px;
    border: 4px solid #f3f3f3;
    border-top: 4px solid var(--dark-green, #055035);
    border-radius: 50%;
    animation: reportSpin 0.9s linear infinite;
  }

  @keyframes reportSpin {
    0%   { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
  }

  .report-empty-state {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    flex: 1;
    min-height: 300px;
    color: #9ca3af;
    gap: 0.75rem;
  }

  .report-empty-state svg {
    width: 52px;
    height: 52px;
  }

  .report-empty-state h3 {
    font-size: 1rem;
    color: #9ca3af;
    margin: 0;
    font-weight: 500;
    font-family: var(--font-main, 'Montserrat', sans-serif);
  }

  .report-empty-state p {
    font-size: 0.8rem;
    color: #9ca3af;
    margin: 0;
    font-family: var(--font-main, 'Montserrat', sans-serif);
  }

  .report-empty-state img {
    filter: grayscale(1);
    opacity: 0.45;
    width: 52px;
    height: 52px;
    object-fit: contain;
  }

  @media (max-width: 768px) {
    .page-header.reports-header {
      padding: 1.2rem 0.8rem 1rem 0.8rem;
    }
    .reports-header .page-title {
      font-size: 1.3rem;
    }
  }

  @media (max-width: 480px) {
    .page-header.reports-header {
      padding: 1rem 0.5rem 0.8rem 0.5rem;
      flex-direction: column;
      align-items: flex-start;
      gap: 1rem;
    }
    .reports-header .page-title {
      font-size: 1.2rem;
    }
    .reports-header .page-subtitle {
      font-size: 0.5rem;
    }
  }
</style>

<div class="reports-wrapper">
  <!-- Header -->
  <div class="page-header reports-header">
    <div>
      <h2 class="page-title">Reports</h2>
      <div class="page-subtitle">Generate and export comprehensive reports for your coffee monitoring system</div>
    </div>
  </div>

  <!-- Table Section -->
  <div class="reports-content-container">
    <div class="reports-inner-container">
      <!-- Tabs Section -->
      <div style="padding: 1rem 1rem 0 1rem; border-bottom: 1px solid var(--border-gray, #e6e6e6);">
        <?php include __DIR__ . '/../ui/ReportTableTabs.php'; ?>
      </div>
      
      <!-- Dynamic Table Area (JS-driven) -->
      <div id="reportDynamicTable" style="flex: 1; overflow-y: auto;">
        <!-- No Tab Selected (default state) -->
        <div class="report-empty-state" id="reportNoTabState">
        <img src="../../assets/icons/no-list-selected.png" alt="No List Selected" style="width:52px;height:52px;object-fit:contain;">
          <h3>No List Selected</h3>
          <p>Please select a tab above to view data</p>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
(function () {
  const API_BASE = 'http://localhost:5000/api';
  let currentTab = null;
  let searchQuery = '';
  
  // Data caches for local fast search/filtering
  let allFarmPlots = [];
  let allBeneficiaries = [];
  let allSeedlings = [];
  let allCropStatusList = [];
  let allRecentActivities = [];

  // ── Helpers ──────────────────────────────────────────────────────────────

  function getToken() {
    return localStorage.getItem('authToken');
  }

  function getTableContainer() {
    return document.getElementById('reportDynamicTable');
  }

  function showSpinner() {
    getTableContainer().innerHTML = `
      <div class="report-table-spinner-wrap">
        <div class="report-table-spinner"></div>
        <p style="color:#666;font-size:0.8rem;margin:0;font-family:var(--font-main,'Montserrat',sans-serif);">Loading ${currentTab || 'data'}...</p>
      </div>`;
  }

  function showNoTab() {
    getTableContainer().innerHTML = `
      <div class="report-empty-state">
        <img src="../../assets/icons/no-list-selected.png" alt="No List Selected" style="width:52px;height:52px;object-fit:contain;opacity:0.6;">
        <h3>No List Selected</h3>
        <p>Please select a tab above to view data</p>
      </div>`;
  }

  function showEmpty(tab) {
    const icons = {
      'Beneficiary List':  `<img src="../../assets/icons/no-benefeciary.png"  alt="No Beneficiary"    style="width:52px;height:52px;object-fit:contain;">`,
      'Farm Location':     `<img src="../../assets/icons/no-farm-location.png" alt="No Farm Location"  style="width:52px;height:52px;object-fit:contain;">`,
      'Seedling Record':   `<img src="../../assets/icons/seedling.png"          alt="No Seedlings"      style="width:52px;height:52px;object-fit:contain;">`,
      'Crop Survey Status':`<img src="../../assets/icons/no-data.png"           alt="No Crop Data"      style="width:52px;height:52px;object-fit:contain;">`,
      'Recent Activities': `<img src="../../assets/icons/no-data.png"           alt="No Activities"     style="width:52px;height:52px;object-fit:contain;">`
    };
    const icon = icons[tab] || `<img src="../../assets/icons/no-data.png" alt="No Data" style="width:52px;height:52px;object-fit:contain;">`;
    getTableContainer().innerHTML = `
      <div class="report-empty-state">
        ${icon}
        <h3>No ${tab} Data Available.</h3>
      </div>`;
  }

  function formatNull(val) {
    if (val === null || val === undefined || String(val).trim() === '' || val === '—') {
      return '<span class="em-dash">&mdash;</span>';
    }
    return val;
  }

  function formatDate(dateStr) {
    if (!dateStr) return '<span class="em-dash">&mdash;</span>';
    const date = new Date(dateStr);
    if (isNaN(date.getTime())) return dateStr;
    return date.toLocaleDateString('en-US', {
      month: 'numeric',
      day: 'numeric',
      year: 'numeric'
    });
  }

  function formatDateTime(dateTimeStr) {
    if (!dateTimeStr) return '<span class="em-dash">&mdash;</span>';
    const date = new Date(dateTimeStr);
    if (isNaN(date.getTime())) return dateTimeStr;
    return date.toLocaleString('en-US', {
      month: 'numeric',
      day: 'numeric',
      year: 'numeric',
      hour: 'numeric',
      minute: '2-digit',
      hour12: true
    });
  }

  // ── 1. Beneficiary List Tab ───────────────────────────────────────────────

  async function loadBeneficiaryList() {
    showSpinner();
    const token = getToken();
    if (!token) return;

    try {
      const res = await fetch(`${API_BASE}/beneficiaries`, {
        headers: { 'Authorization': `Bearer ${token}` }
      });
      if (res.status === 401 || res.status === 403) {
        localStorage.removeItem('authToken');
        window.location.href = '../../login.php';
        return;
      }
      if (!res.ok) throw new Error('Failed to fetch beneficiaries');
      const json = await res.json();
      // The beneficiaries endpoint wraps the array: { success: true, data: [...] }
      allBeneficiaries = Array.isArray(json) ? json : (Array.isArray(json.data) ? json.data : []);
      renderBeneficiaryTable(allBeneficiaries);
    } catch (err) {
      console.error(err);
      showEmpty('Beneficiary List');
    }
  }

  function renderBeneficiaryTable(beneficiaries) {
    if (!beneficiaries || beneficiaries.length === 0) {
      showEmpty('Beneficiary List');
      return;
    }

    const query = searchQuery.toLowerCase().trim();
    const filtered = query
      ? beneficiaries.filter(b => {
          const fullName = `${b.firstName || ''} ${b.middleName || ''} ${b.lastName || ''}`.toLowerCase();
          const address = [b.purok, b.barangay, b.municipality, b.province].filter(p => p).join(', ').toLowerCase();
          return (
            (b.beneficiaryId || '').toLowerCase().includes(query) ||
            fullName.includes(query) ||
            (b.cellphone || '').toLowerCase().includes(query) ||
            address.includes(query)
          );
        })
      : beneficiaries;

    if (filtered.length === 0) {
      getTableContainer().innerHTML = `
        <div class="report-empty-state">
          <h3>No results for "${searchQuery}"</h3>
          <p>Try a different search term.</p>
        </div>`;
      return;
    }

    const rows = filtered.map((b, idx) => {
      const fullName = `${b.firstName || ''} ${b.middleName ? b.middleName + ' ' : ''}${b.lastName || ''}`.replace(/\s+/g, ' ').trim();
      const address = [b.purok, b.barangay, b.municipality, b.province].filter(p => p && p.trim() !== '').join(', ') || '<span class="em-dash">&mdash;</span>';

      return `
        <tr>
          <td>${idx + 1}</td>
          <td class="plot-id-cell">${formatNull(b.beneficiaryId)}</td>
          <td class="beneficiary-cell">${formatNull(fullName)}</td>
          <td>${formatNull(b.gender)}</td>
          <td>${formatNull(b.maritalStatus)}</td>
          <td>${formatDate(b.birthDate)}</td>
          <td>${b.age ? b.age : '<span class="em-dash">&mdash;</span>'}</td>
          <td>${formatNull(b.cellphone)}</td>
          <td>${formatNull(address)}</td>
        </tr>`;
    }).join('');

    getTableContainer().innerHTML = `
      <table>
        <thead>
          <tr>
            <th>#</th>
            <th>Beneficiary ID</th>
            <th>Full Name</th>
            <th>Gender</th>
            <th>Marital Status</th>
            <th>Birth Date</th>
            <th>Age</th>
            <th>Cellphone</th>
            <th>Address</th>
          </tr>
        </thead>
        <tbody>${rows}</tbody>
      </table>`;
  }

  // ── 2. Farm Location Tab ──────────────────────────────────────────────────

  async function loadFarmLocation() {
    showSpinner();
    const token = getToken();
    if (!token) return;

    try {
      const res = await fetch(`${API_BASE}/farm-plots`, {
        headers: { 'Authorization': `Bearer ${token}` }
      });
      if (!res.ok) throw new Error('Failed to fetch farm plots');
      const plots = await res.json();
      allFarmPlots = plots.sort((a, b) => (a.beneficiaryId || '').localeCompare(b.beneficiaryId || '', undefined, { numeric: true }));
      renderFarmLocationTable(allFarmPlots);
    } catch (err) {
      console.error(err);
      showEmpty('Farm Location');
    }
  }

  function renderFarmLocationTable(plots) {
    if (!plots || plots.length === 0) {
      showEmpty('Farm Location');
      return;
    }

    const query = searchQuery.toLowerCase().trim();
    const filtered = query
      ? plots.filter(p =>
          (p.id || '').toLowerCase().includes(query) ||
          (p.beneficiaryName || '').toLowerCase().includes(query) ||
          (p.address || '').toLowerCase().includes(query) ||
          (p.beneficiaryId || '').toLowerCase().includes(query)
        )
      : plots;

    if (filtered.length === 0) {
      getTableContainer().innerHTML = `
        <div class="report-empty-state">
          <h3>No results for "${searchQuery}"</h3>
          <p>Try a different search term.</p>
        </div>`;
      return;
    }

    const rows = filtered.map((plot, idx) => {
      const hectares = plot.hectares != null ? parseFloat(plot.hectares).toFixed(2) + ' ha' : '<span class="em-dash">&mdash;</span>';
      const coords = Array.isArray(plot.coordinates) && plot.coordinates.length > 0
        ? `<span class="coord-badge">${plot.coordinates.length} point${plot.coordinates.length !== 1 ? 's' : ''}</span>`
        : '<span class="em-dash">&mdash;</span>';
      const rawAddr = (plot.address || '').split(',').map(s => s.trim());
      const cleanAddr = rawAddr.filter(s => s && s.toLowerCase() !== 'unknown').join(', ') || '<span class="em-dash">&mdash;</span>';

      return `
        <tr>
          <td>${idx + 1}</td>
          <td class="plot-id-cell">${plot.id || '&mdash;'}</td>
          <td class="beneficiary-cell">${plot.beneficiaryName || '&mdash;'}</td>
          <td>${hectares}</td>
          <td>${cleanAddr}</td>
          <td>${coords}</td>
        </tr>`;
    }).join('');

    getTableContainer().innerHTML = `
      <table>
        <thead>
          <tr>
            <th>#</th>
            <th>Plot ID</th>
            <th>Beneficiary</th>
            <th>Hectares</th>
            <th>Address</th>
            <th>Coordinates</th>
          </tr>
        </thead>
        <tbody>${rows}</tbody>
      </table>`;
  }

  // ── 3. Seedling Record Tab ────────────────────────────────────────────────

  async function loadSeedlingRecord() {
    showSpinner();
    const token = getToken();
    if (!token) return;

    try {
      const res = await fetch(`${API_BASE}/seedlings`, {
        headers: { 'Authorization': `Bearer ${token}` }
      });
      if (!res.ok) throw new Error('Failed to fetch seedlings');
      const seedlings = await res.json();
      allSeedlings = seedlings.sort((a, b) => (a.beneficiaryId || '').localeCompare(b.beneficiaryId || '', undefined, { numeric: true }));
      renderSeedlingTable(allSeedlings);
    } catch (err) {
      console.error(err);
      showEmpty('Seedling Record');
    }
  }

  function renderSeedlingTable(seedlings) {
    if (!seedlings || seedlings.length === 0) {
      showEmpty('Seedling Record');
      return;
    }

    const query = searchQuery.toLowerCase().trim();
    const filtered = query
      ? seedlings.filter(s =>
          (s.beneficiaryId || '').toLowerCase().includes(query) ||
          (s.plotId || '').toLowerCase().includes(query)
        )
      : seedlings;

    if (filtered.length === 0) {
      getTableContainer().innerHTML = `
        <div class="report-empty-state">
          <h3>No results for "${searchQuery}"</h3>
          <p>Try a different search term.</p>
        </div>`;
      return;
    }

    const rows = filtered.map((s, idx) => {
      const plotIdVal = s.plotId ? `<span class="plot-id-cell">${s.plotId}</span>` : '<span class="em-dash">&mdash;</span>';
      return `
        <tr>
          <td>${idx + 1}</td>
          <td class="beneficiary-cell">${formatNull(s.beneficiaryId)}</td>
          <td>${s.received}</td>
          <td>${formatDate(s.dateReceived)}</td>
          <td>${s.planted}</td>
          <td>${plotIdVal}</td>
          <td>${formatDate(s.dateOfPlantingStart)}</td>
          <td>${formatDate(s.dateOfPlantingEnd)}</td>
        </tr>`;
    }).join('');

    getTableContainer().innerHTML = `
      <table>
        <thead>
          <tr>
            <th>#</th>
            <th>Beneficiary ID</th>
            <th>Received</th>
            <th>Date Received</th>
            <th>Planted</th>
            <th>Plot ID</th>
            <th>Planting Date</th>
            <th>End Date</th>
          </tr>
        </thead>
        <tbody>${rows}</tbody>
      </table>`;
  }

  // ── 4. Crop Survey Status Tab ─────────────────────────────────────────────

  async function loadCropSurveyStatus() {
    showSpinner();
    const token = getToken();
    if (!token) return;

    try {
      const res = await fetch(`${API_BASE}/crop-status`, {
        headers: { 'Authorization': `Bearer ${token}` }
      });
      if (!res.ok) throw new Error('Failed to fetch crop status');
      const list = await res.json();
      allCropStatusList = list.sort((a, b) => (a.beneficiaryId || '').localeCompare(b.beneficiaryId || '', undefined, { numeric: true }));
      renderCropStatusTable(allCropStatusList);
    } catch (err) {
      console.error(err);
      showEmpty('Crop Survey Status');
    }
  }

  function renderCropStatusTable(cropStatusList) {
    if (!cropStatusList || cropStatusList.length === 0) {
      showEmpty('Crop Survey Status');
      return;
    }

    const query = searchQuery.toLowerCase().trim();
    const filtered = query
      ? cropStatusList.filter(c =>
          (c.beneficiaryId || '').toLowerCase().includes(query) ||
          (c.beneficiaryName || '').toLowerCase().includes(query) ||
          (c.surveyer || '').toLowerCase().includes(query) ||
          (c.plotId || '').toLowerCase().includes(query)
        )
      : cropStatusList;

    if (filtered.length === 0) {
      getTableContainer().innerHTML = `
        <div class="report-empty-state">
          <h3>No results for "${searchQuery}"</h3>
          <p>Try a different search term.</p>
        </div>`;
      return;
    }

    const rows = filtered.map((c, idx) => {
      const plotIdVal = c.plotId ? `<span class="plot-id-cell">${c.plotId}</span>` : '<span class="em-dash">&mdash;</span>';
      return `
        <tr>
          <td>${idx + 1}</td>
          <td class="plot-id-cell">${formatNull(c.beneficiaryId)}</td>
          <td class="beneficiary-cell">${formatNull(c.beneficiaryName)}</td>
          <td>${formatDate(c.surveyDate)}</td>
          <td>${formatNull(c.surveyer)}</td>
          <td>${c.aliveCrops}</td>
          <td>${c.deadCrops}</td>
          <td>${plotIdVal}</td>
        </tr>`;
    }).join('');

    getTableContainer().innerHTML = `
      <table>
        <thead>
          <tr>
            <th>#</th>
            <th>Beneficiary ID</th>
            <th>Beneficiary Name</th>
            <th>Survey Date</th>
            <th>Surveyer</th>
            <th>Alive Crops</th>
            <th>Dead Crops</th>
            <th>Plot</th>
          </tr>
        </thead>
        <tbody>${rows}</tbody>
      </table>`;
  }

  // ── 5. Recent Activities Tab ──────────────────────────────────────────────

  async function loadRecentActivities() {
    showSpinner();
    const token = getToken();
    if (!token) return;

    try {
      const res = await fetch(`${API_BASE}/statistics/recent-activities?limit=100`, {
        headers: { 'Authorization': `Bearer ${token}` }
      });
      if (!res.ok) throw new Error('Failed to fetch recent activities');
      allRecentActivities = await res.json();
      renderRecentActivitiesTable(allRecentActivities);
    } catch (err) {
      console.error(err);
      showEmpty('Recent Activities');
    }
  }

  function renderRecentActivitiesTable(activities) {
    if (!activities || activities.length === 0) {
      showEmpty('Recent Activities');
      return;
    }

    const query = searchQuery.toLowerCase().trim();
    const filtered = query
      ? activities.filter(a =>
          (a.type || '').toLowerCase().includes(query) ||
          (a.action || '').toLowerCase().includes(query) ||
          (a.user || '').toLowerCase().includes(query)
        )
      : activities;

    if (filtered.length === 0) {
      getTableContainer().innerHTML = `
        <div class="report-empty-state">
          <h3>No results for "${searchQuery}"</h3>
          <p>Try a different search term.</p>
        </div>`;
      return;
    }

    const typeMeta = {
      beneficiary: 'Coffee Beneficiary',
      crop: 'Crop Survey Status',
      seedling: 'Seedling Record',
      plot: 'Farm Plot Details'
    };

    const rows = filtered.map((a, idx) => {
      const typeLabel = typeMeta[a.type] || a.type || 'System Activity';
      return `
        <tr>
          <td>${idx + 1}</td>
          <td class="beneficiary-cell" style="font-weight: 600;">${typeLabel}</td>
          <td>${a.action}</td>
          <td>${formatDateTime(a.timestamp)}</td>
          <td>${formatNull(a.user)}</td>
        </tr>`;
    }).join('');

    getTableContainer().innerHTML = `
      <table>
        <thead>
          <tr>
            <th>#</th>
            <th>Type</th>
            <th>Action</th>
            <th>Timestamp</th>
            <th>User</th>
          </tr>
        </thead>
        <tbody>${rows}</tbody>
      </table>`;
  }

  // ── Tab Change Dispatcher ─────────────────────────────────────────────────

  function handleTabChange(tab) {
    currentTab = tab;
    searchQuery = '';
    
    // Clear search input visually
    const searchEl = document.getElementById('ttSearchInput');
    if (searchEl) searchEl.value = '';

    if (!tab) {
      showNoTab();
      return;
    }

    switch (tab) {
      case 'Beneficiary List':
        loadBeneficiaryList();
        break;
      case 'Farm Location':
        loadFarmLocation();
        break;
      case 'Seedling Record':
        loadSeedlingRecord();
        break;
      case 'Crop Survey Status':
        loadCropSurveyStatus();
        break;
      case 'Recent Activities':
        loadRecentActivities();
        break;
      default:
        showEmpty(tab);
    }
  }

  // ── Event Listeners ───────────────────────────────────────────────────────

  document.addEventListener('tableTabChanged', (e) => {
    handleTabChange(e.detail.tab);
  });

  document.addEventListener('tableSearchChanged', (e) => {
    searchQuery = e.detail.query || '';
    switch (currentTab) {
      case 'Beneficiary List':
        renderBeneficiaryTable(allBeneficiaries);
        break;
      case 'Farm Location':
        renderFarmLocationTable(allFarmPlots);
        break;
      case 'Seedling Record':
        renderSeedlingTable(allSeedlings);
        break;
      case 'Crop Survey Status':
        renderCropStatusTable(allCropStatusList);
        break;
      case 'Recent Activities':
        renderRecentActivitiesTable(allRecentActivities);
        break;
    }
  });

  // Re-render on navigation back to reports
  window.addEventListener('navigationChanged', (e) => {
    if (e.detail && e.detail.page === 'reports') {
      currentTab = null;
      allFarmPlots = [];
      allBeneficiaries = [];
      allSeedlings = [];
      allCropStatusList = [];
      allRecentActivities = [];
      searchQuery = '';
      showNoTab();
      // Reset tab buttons
      document.querySelectorAll('.table-tab-button').forEach(b => b.classList.remove('active'));
    }
  });
})();
</script>
