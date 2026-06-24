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

      <!-- Filter Section (JS-driven, toggleable) -->
      <div id="reportsFilterSectionContainer" style="padding: 0.5rem 1rem 0 1rem; display: none; border-bottom: 1px solid var(--border-gray, #e6e6e6);">
        <?php include __DIR__ . '/../ui/FilterSection.php'; ?>
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
  let activeFilters = null;
  
  // Data caches for local fast search/filtering
  let allFarmPlots = [];
  let allBeneficiaries = [];
  let allSeedlings = [];
  let allCropStatusList = [];
  let allRecentActivities = [];

  function isColumnVisible(attrId) {
    if (!activeFilters || !activeFilters.selectedAttributes || activeFilters.selectedAttributes.length === 0) {
      return true;
    }
    return activeFilters.selectedAttributes.includes(attrId);
  }

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

    let filtered = beneficiaries;
    const query = searchQuery.toLowerCase().trim();
    if (query) {
      filtered = filtered.filter(b => {
        const fullName = `${b.firstName || ''} ${b.middleName || ''} ${b.lastName || ''}`.toLowerCase();
        const address = [b.purok, b.barangay, b.municipality, b.province].filter(p => p).join(', ').toLowerCase();
        return (
          (b.beneficiaryId || '').toLowerCase().includes(query) ||
          fullName.includes(query) ||
          (b.cellphone || '').toLowerCase().includes(query) ||
          address.includes(query)
        );
      });
    }

    if (activeFilters) {
      if (activeFilters.selectedGender) {
        filtered = filtered.filter(b => b.gender === activeFilters.selectedGender);
      }
      if (activeFilters.selectedMaritalStatus) {
        filtered = filtered.filter(b => b.maritalStatus === activeFilters.selectedMaritalStatus);
      }
      if (activeFilters.dateFrom) {
        const fromDate = new Date(activeFilters.dateFrom);
        filtered = filtered.filter(b => b.birthDate && new Date(b.birthDate) >= fromDate);
      }
      if (activeFilters.dateTo) {
        const toDate = new Date(activeFilters.dateTo);
        toDate.setHours(23, 59, 59, 999);
        filtered = filtered.filter(b => b.birthDate && new Date(b.birthDate) <= toDate);
      }
      if (activeFilters.selectedProvince) {
        filtered = filtered.filter(b => b.province === activeFilters.selectedProvince);
      }
      if (activeFilters.selectedMunicipality) {
        filtered = filtered.filter(b => b.municipality === activeFilters.selectedMunicipality);
      }
    }

    if (filtered.length === 0) {
      getTableContainer().innerHTML = `
        <div class="report-empty-state">
          <h3>No results found</h3>
          <p>Try different search or filter options.</p>
        </div>`;
      return;
    }

    const rows = filtered.map((b, idx) => {
      const fullName = `${b.firstName || ''} ${b.middleName ? b.middleName + ' ' : ''}${b.lastName || ''}`.replace(/\s+/g, ' ').trim();
      const address = [b.purok, b.barangay, b.municipality, b.province].filter(p => p && p.trim() !== '').join(', ') || '<span class="em-dash">&mdash;</span>';

      return `
        <tr>
          <td>${idx + 1}</td>
          ${isColumnVisible('ben_id') ? `<td class="plot-id-cell">${formatNull(b.beneficiaryId)}</td>` : ''}
          ${isColumnVisible('ben_fullname') ? `<td class="beneficiary-cell">${formatNull(fullName)}</td>` : ''}
          ${isColumnVisible('ben_gender') ? `<td>${formatNull(b.gender)}</td>` : ''}
          ${isColumnVisible('ben_marital') ? `<td>${formatNull(b.maritalStatus)}</td>` : ''}
          ${isColumnVisible('ben_birthdate') ? `<td>${formatDate(b.birthDate)}</td>` : ''}
          ${isColumnVisible('ben_age') ? `<td>${b.age ? b.age : '<span class="em-dash">&mdash;</span>'}</td>` : ''}
          ${isColumnVisible('ben_cellphone') ? `<td>${formatNull(b.cellphone)}</td>` : ''}
          ${isColumnVisible('ben_address') ? `<td>${formatNull(address)}</td>` : ''}
        </tr>`;
    }).join('');

    getTableContainer().innerHTML = `
      <table>
        <thead>
          <tr>
            <th>#</th>
            ${isColumnVisible('ben_id') ? '<th>Beneficiary ID</th>' : ''}
            ${isColumnVisible('ben_fullname') ? '<th>Full Name</th>' : ''}
            ${isColumnVisible('ben_gender') ? '<th>Gender</th>' : ''}
            ${isColumnVisible('ben_marital') ? '<th>Marital Status</th>' : ''}
            ${isColumnVisible('ben_birthdate') ? '<th>Birth Date</th>' : ''}
            ${isColumnVisible('ben_age') ? '<th>Age</th>' : ''}
            ${isColumnVisible('ben_cellphone') ? '<th>Cellphone</th>' : ''}
            ${isColumnVisible('ben_address') ? '<th>Address</th>' : ''}
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

    let filtered = plots;
    const query = searchQuery.toLowerCase().trim();
    if (query) {
      filtered = filtered.filter(p =>
        (p.id || '').toLowerCase().includes(query) ||
        (p.beneficiaryName || '').toLowerCase().includes(query) ||
        (p.address || '').toLowerCase().includes(query) ||
        (p.beneficiaryId || '').toLowerCase().includes(query)
      );
    }

    if (activeFilters) {
      if (activeFilters.hectaresMin) {
        const minH = parseFloat(activeFilters.hectaresMin);
        filtered = filtered.filter(p => p.hectares != null && parseFloat(p.hectares) >= minH);
      }
      if (activeFilters.hectaresMax) {
        const maxH = parseFloat(activeFilters.hectaresMax);
        filtered = filtered.filter(p => p.hectares != null && parseFloat(p.hectares) <= maxH);
      }
      if (activeFilters.selectedProvince) {
        filtered = filtered.filter(p => p.address && p.address.toLowerCase().includes(activeFilters.selectedProvince.toLowerCase()));
      }
      if (activeFilters.selectedMunicipality) {
        filtered = filtered.filter(p => p.address && p.address.toLowerCase().includes(activeFilters.selectedMunicipality.toLowerCase()));
      }
    }

    if (filtered.length === 0) {
      getTableContainer().innerHTML = `
        <div class="report-empty-state">
          <h3>No results found</h3>
          <p>Try different search or filter options.</p>
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
          ${isColumnVisible('farm_plot_id') ? `<td class="plot-id-cell">${plot.id || '&mdash;'}</td>` : ''}
          ${isColumnVisible('farm_beneficiary') ? `<td class="beneficiary-cell">${plot.beneficiaryName || '&mdash;'}</td>` : ''}
          ${isColumnVisible('farm_hectares') ? `<td>${hectares}</td>` : ''}
          ${isColumnVisible('farm_address') ? `<td>${cleanAddr}</td>` : ''}
          ${isColumnVisible('farm_coordinates') ? `<td>${coords}</td>` : ''}
        </tr>`;
    }).join('');

    getTableContainer().innerHTML = `
      <table>
        <thead>
          <tr>
            <th>#</th>
            ${isColumnVisible('farm_plot_id') ? '<th>Plot ID</th>' : ''}
            ${isColumnVisible('farm_beneficiary') ? '<th>Beneficiary</th>' : ''}
            ${isColumnVisible('farm_hectares') ? '<th>Hectares</th>' : ''}
            ${isColumnVisible('farm_address') ? '<th>Address</th>' : ''}
            ${isColumnVisible('farm_coordinates') ? '<th>Coordinates</th>' : ''}
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

    let filtered = seedlings;
    const query = searchQuery.toLowerCase().trim();
    if (query) {
      filtered = filtered.filter(s =>
        (s.beneficiaryId || '').toLowerCase().includes(query) ||
        (s.plotId || '').toLowerCase().includes(query)
      );
    }

    if (activeFilters) {
      if (activeFilters.dateFrom) {
        const fromDate = new Date(activeFilters.dateFrom);
        filtered = filtered.filter(s => s.dateReceived && new Date(s.dateReceived) >= fromDate);
      }
      if (activeFilters.dateTo) {
        const toDate = new Date(activeFilters.dateTo);
        toDate.setHours(23, 59, 59, 999);
        filtered = filtered.filter(s => s.dateReceived && new Date(s.dateReceived) <= toDate);
      }
    }

    if (filtered.length === 0) {
      getTableContainer().innerHTML = `
        <div class="report-empty-state">
          <h3>No results found</h3>
          <p>Try different search or filter options.</p>
        </div>`;
      return;
    }

    const rows = filtered.map((s, idx) => {
      const plotIdVal = s.plotId ? `<span class="plot-id-cell">${s.plotId}</span>` : '<span class="em-dash">&mdash;</span>';
      return `
        <tr>
          <td>${idx + 1}</td>
          ${isColumnVisible('seed_id') && filtered.some(item => item.id) ? `<td>${s.id || '&mdash;'}</td>` : ''}
          ${isColumnVisible('seed_ben_id') ? `<td class="beneficiary-cell">${formatNull(s.beneficiaryId)}</td>` : ''}
          ${isColumnVisible('seed_received') ? `<td>${s.received}</td>` : ''}
          ${isColumnVisible('seed_date_received') ? `<td>${formatDate(s.dateReceived)}</td>` : ''}
          ${isColumnVisible('seed_planted') ? `<td>${s.planted}</td>` : ''}
          ${isColumnVisible('seed_plot_id') ? `<td>${plotIdVal}</td>` : ''}
          ${isColumnVisible('seed_planting_date') ? `<td>${formatDate(s.dateOfPlantingStart)}</td>` : ''}
          ${isColumnVisible('seed_planting_date') ? `<td>${formatDate(s.dateOfPlantingEnd)}</td>` : ''}
        </tr>`;
    }).join('');

    getTableContainer().innerHTML = `
      <table>
        <thead>
          <tr>
            <th>#</th>
            ${isColumnVisible('seed_id') && filtered.some(item => item.id) ? '<th>Seedling ID</th>' : ''}
            ${isColumnVisible('seed_ben_id') ? '<th>Beneficiary ID</th>' : ''}
            ${isColumnVisible('seed_received') ? '<th>Received</th>' : ''}
            ${isColumnVisible('seed_date_received') ? '<th>Date Received</th>' : ''}
            ${isColumnVisible('seed_planted') ? '<th>Planted</th>' : ''}
            ${isColumnVisible('seed_plot_id') ? '<th>Plot ID</th>' : ''}
            ${isColumnVisible('seed_planting_date') ? '<th>Planting Date</th>' : ''}
            ${isColumnVisible('seed_planting_date') ? '<th>End Date</th>' : ''}
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

    let filtered = cropStatusList;
    const query = searchQuery.toLowerCase().trim();
    if (query) {
      filtered = filtered.filter(c =>
        (c.beneficiaryId || '').toLowerCase().includes(query) ||
        (c.beneficiaryName || '').toLowerCase().includes(query) ||
        (c.surveyer || '').toLowerCase().includes(query) ||
        (c.plotId || '').toLowerCase().includes(query)
      );
    }

    if (activeFilters) {
      if (activeFilters.dateFrom) {
        const fromDate = new Date(activeFilters.dateFrom);
        filtered = filtered.filter(c => c.surveyDate && new Date(c.surveyDate) >= fromDate);
      }
      if (activeFilters.dateTo) {
        const toDate = new Date(activeFilters.dateTo);
        toDate.setHours(23, 59, 59, 999);
        filtered = filtered.filter(c => c.surveyDate && new Date(c.surveyDate) <= toDate);
      }
    }

    if (filtered.length === 0) {
      getTableContainer().innerHTML = `
        <div class="report-empty-state">
          <h3>No results found</h3>
          <p>Try different search or filter options.</p>
        </div>`;
      return;
    }

    const rows = filtered.map((c, idx) => {
      const plotIdVal = c.plotId ? `<span class="plot-id-cell">${c.plotId}</span>` : '<span class="em-dash">&mdash;</span>';
      return `
        <tr>
          <td>${idx + 1}</td>
          ${isColumnVisible('crop_id') && filtered.some(item => item.id) ? `<td>${c.id || '&mdash;'}</td>` : ''}
          ${isColumnVisible('crop_ben_id') ? `<td class="plot-id-cell">${formatNull(c.beneficiaryId)}</td>` : ''}
          ${isColumnVisible('crop_beneficiary') ? `<td class="beneficiary-cell">${formatNull(c.beneficiaryName)}</td>` : ''}
          ${isColumnVisible('crop_survey_date') ? `<td>${formatDate(c.surveyDate)}</td>` : ''}
          ${isColumnVisible('crop_surveyer') ? `<td>${formatNull(c.surveyer)}</td>` : ''}
          ${isColumnVisible('crop_alive') ? `<td>${c.aliveCrops}</td>` : ''}
          ${isColumnVisible('crop_dead') ? `<td>${c.deadCrops}</td>` : ''}
          ${isColumnVisible('crop_plot') ? `<td>${plotIdVal}</td>` : ''}
        </tr>`;
    }).join('');

    getTableContainer().innerHTML = `
      <table>
        <thead>
          <tr>
            <th>#</th>
            ${isColumnVisible('crop_id') && filtered.some(item => item.id) ? '<th>Survey ID</th>' : ''}
            ${isColumnVisible('crop_ben_id') ? '<th>Beneficiary ID</th>' : ''}
            ${isColumnVisible('crop_beneficiary') ? '<th>Beneficiary Name</th>' : ''}
            ${isColumnVisible('crop_survey_date') ? '<th>Survey Date</th>' : ''}
            ${isColumnVisible('crop_surveyer') ? '<th>Surveyer</th>' : ''}
            ${isColumnVisible('crop_alive') ? '<th>Alive Crops</th>' : ''}
            ${isColumnVisible('crop_dead') ? '<th>Dead Crops</th>' : ''}
            ${isColumnVisible('crop_plot') ? '<th>Plot</th>' : ''}
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

    let filtered = activities;
    const query = searchQuery.toLowerCase().trim();
    if (query) {
      filtered = filtered.filter(a =>
        (a.type || '').toLowerCase().includes(query) ||
        (a.action || '').toLowerCase().includes(query) ||
        (a.user || '').toLowerCase().includes(query)
      );
    }

    if (activeFilters) {
      if (activeFilters.dateFrom) {
        const fromDate = new Date(activeFilters.dateFrom);
        filtered = filtered.filter(a => a.timestamp && new Date(a.timestamp) >= fromDate);
      }
      if (activeFilters.dateTo) {
        const toDate = new Date(activeFilters.dateTo);
        toDate.setHours(23, 59, 59, 999);
        filtered = filtered.filter(a => a.timestamp && new Date(a.timestamp) <= toDate);
      }
    }

    if (filtered.length === 0) {
      getTableContainer().innerHTML = `
        <div class="report-empty-state">
          <h3>No results found</h3>
          <p>Try different search or filter options.</p>
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
          ${isColumnVisible('act_id') && filtered.some(item => item.id) ? `<td>${a.id || '&mdash;'}</td>` : ''}
          ${isColumnVisible('act_type') ? `<td class="beneficiary-cell" style="font-weight: 600;">${typeLabel}</td>` : ''}
          ${isColumnVisible('act_action') ? `<td>${a.action}</td>` : ''}
          ${isColumnVisible('act_timestamp') ? `<td>${formatDateTime(a.timestamp)}</td>` : ''}
          ${isColumnVisible('act_user') ? `<td>${formatNull(a.user)}</td>` : ''}
        </tr>`;
    }).join('');

    getTableContainer().innerHTML = `
      <table>
        <thead>
          <tr>
            <th>#</th>
            ${isColumnVisible('act_id') && filtered.some(item => item.id) ? '<th>Activity ID</th>' : ''}
            ${isColumnVisible('act_type') ? '<th>Type</th>' : ''}
            ${isColumnVisible('act_action') ? '<th>Action</th>' : ''}
            ${isColumnVisible('act_timestamp') ? '<th>Timestamp</th>' : ''}
            ${isColumnVisible('act_user') ? '<th>User</th>' : ''}
          </tr>
        </thead>
        <tbody>${rows}</tbody>
      </table>`;
  }

  // ── Tab Change Dispatcher ─────────────────────────────────────────────────

  function handleTabChange(tab) {
    currentTab = tab;
    searchQuery = '';
    activeFilters = null;
    
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

  async function loadAllAndRenderConsolidatedTable() {
    showSpinner();
    const token = getToken();
    if (!token) return;

    try {
      const [resBen, resPlots, resSeed, resCrop, resAct] = await Promise.all([
        fetch(`${API_BASE}/beneficiaries`, { headers: { 'Authorization': `Bearer ${token}` } }),
        fetch(`${API_BASE}/farm-plots`, { headers: { 'Authorization': `Bearer ${token}` } }),
        fetch(`${API_BASE}/seedlings`, { headers: { 'Authorization': `Bearer ${token}` } }),
        fetch(`${API_BASE}/crop-status`, { headers: { 'Authorization': `Bearer ${token}` } }),
        fetch(`${API_BASE}/statistics/recent-activities?limit=100`, { headers: { 'Authorization': `Bearer ${token}` } })
      ]);

      const [jsonBen, jsonPlots, jsonSeed, jsonCrop, jsonAct] = await Promise.all([
        resBen.json(),
        resPlots.json(),
        resSeed.json(),
        resCrop.json(),
        resAct.json()
      ]);

      allBeneficiaries = Array.isArray(jsonBen) ? jsonBen : (Array.isArray(jsonBen.data) ? jsonBen.data : []);
      allFarmPlots = Array.isArray(jsonPlots) ? jsonPlots : [];
      allSeedlings = Array.isArray(jsonSeed) ? jsonSeed : [];
      allCropStatusList = Array.isArray(jsonCrop) ? jsonCrop : [];
      allRecentActivities = Array.isArray(jsonAct) ? jsonAct : [];

      renderConsolidatedTable();
    } catch (err) {
      console.error(err);
      getTableContainer().innerHTML = `
        <div class="report-empty-state">
          <h3>Error loading database records</h3>
          <p>Please try again later.</p>
        </div>`;
    }
  }

  function renderConsolidatedTable() {
    const allCols = [
      { id: 'ben_id', header: 'Beneficiary ID', value: item => formatNull(item.ben_id) },
      { id: 'ben_fullname', header: 'Full Name', value: item => formatNull(item.ben_fullname) },
      { id: 'ben_gender', header: 'Gender', value: item => formatNull(item.ben_gender) },
      { id: 'ben_marital', header: 'Marital Status', value: item => formatNull(item.ben_marital) },
      { id: 'ben_birthdate', header: 'Birth Date', value: item => formatDate(item.ben_birthdate) },
      { id: 'ben_age', header: 'Age', value: item => item.ben_age ? item.ben_age : '<span class="em-dash">&mdash;</span>' },
      { id: 'ben_cellphone', header: 'Cellphone', value: item => formatNull(item.ben_cellphone) },
      { id: 'ben_address', header: 'Address', value: item => formatNull(item.ben_address) },

      { id: 'farm_plot_id', header: 'Plot ID', value: item => formatNull(item.farm_plot_id) },
      { id: 'farm_beneficiary', header: 'Beneficiary Name', value: item => formatNull(item.farm_beneficiary) },
      { id: 'farm_hectares', header: 'Hectares', value: item => item.farm_hectares != null ? parseFloat(item.farm_hectares).toFixed(2) + ' ha' : '<span class="em-dash">&mdash;</span>' },
      { id: 'farm_address', header: 'Plot Address', value: item => formatNull(item.farm_address) },
      { id: 'farm_coordinates', header: 'Coordinates', value: item => Array.isArray(item.farm_coordinates) && item.farm_coordinates.length > 0 ? `<span class="coord-badge">${item.farm_coordinates.length} points</span>` : '<span class="em-dash">&mdash;</span>' },

      { id: 'seed_id', header: 'Seedling ID', value: item => formatNull(item.seed_id) },
      { id: 'seed_ben_id', header: 'Seedling Ben ID', value: item => formatNull(item.seed_ben_id) },
      { id: 'seed_received', header: 'Received', value: item => formatNull(item.seed_received) },
      { id: 'seed_date_received', header: 'Date Received', value: item => formatDate(item.seed_date_received) },
      { id: 'seed_planted', header: 'Planted', value: item => formatNull(item.seed_planted) },
      { id: 'seed_plot_id', header: 'Seedling Plot ID', value: item => formatNull(item.seed_plot_id) },
      { id: 'seed_planting_date', header: 'Planting Date', value: item => formatDate(item.seed_planting_date) },

      { id: 'crop_id', header: 'Survey ID', value: item => formatNull(item.crop_id) },
      { id: 'crop_ben_id', header: 'Survey Ben ID', value: item => formatNull(item.crop_ben_id) },
      { id: 'crop_beneficiary', header: 'Survey Beneficiary', value: item => formatNull(item.crop_beneficiary) },
      { id: 'crop_survey_date', header: 'Survey Date', value: item => formatDate(item.crop_survey_date) },
      { id: 'crop_surveyer', header: 'Surveyer', value: item => formatNull(item.crop_surveyer) },
      { id: 'crop_alive', header: 'Alive Crops', value: item => formatNull(item.crop_alive) },
      { id: 'crop_dead', header: 'Dead Crops', value: item => formatNull(item.crop_dead) },
      { id: 'crop_plot', header: 'Survey Plot', value: item => formatNull(item.crop_plot) },

      { id: 'act_id', header: 'Activity ID', value: item => formatNull(item.act_id) },
      { id: 'act_type', header: 'Activity Type', value: item => formatNull(item.act_type) },
      { id: 'act_action', header: 'Action', value: item => formatNull(item.act_action) },
      { id: 'act_timestamp', header: 'Timestamp', value: item => formatDateTime(item.act_timestamp) },
      { id: 'act_user', header: 'User', value: item => formatNull(item.act_user) }
    ];

    let visibleCols = [];
    if (activeFilters && activeFilters.selectedAttributes && activeFilters.selectedAttributes.length > 0) {
      visibleCols = allCols.filter(col => activeFilters.selectedAttributes.includes(col.id));
    } else {
      // Default consolidated view columns
      const defaultIds = ['ben_id', 'ben_fullname', 'farm_plot_id', 'farm_hectares', 'seed_received', 'seed_planted', 'crop_alive', 'crop_dead'];
      visibleCols = allCols.filter(col => defaultIds.includes(col.id));
    }

    const consolidatedList = [];
    const benMap = {};
    allBeneficiaries.forEach(b => {
      benMap[b.beneficiaryId] = b;
    });

    const benWithPlots = new Set();
    allFarmPlots.forEach(plot => {
      const b = benMap[plot.beneficiaryId] || {};
      benWithPlots.add(plot.beneficiaryId);

      const plotSeedlings = allSeedlings.filter(s => s.plotId === plot.id);
      const plotCrops = allCropStatusList.filter(c => c.plotId === plot.id);

      const totalReceived = plotSeedlings.reduce((sum, s) => sum + parseInt(s.received || 0), 0);
      const totalPlanted = plotSeedlings.reduce((sum, s) => sum + parseInt(s.planted || 0), 0);
      const totalAlive = plotCrops.reduce((sum, c) => sum + parseInt(c.aliveCrops || 0), 0);
      const totalDead = plotCrops.reduce((sum, c) => sum + parseInt(c.deadCrops || 0), 0);

      const rawAddr = (plot.address || '').split(',').map(s => s.trim());
      const cleanPlotAddr = rawAddr.filter(s => s && s.toLowerCase() !== 'unknown').join(', ');

      const fullName = b.firstName ? `${b.firstName} ${b.middleName ? b.middleName + ' ' : ''}${b.lastName}` : (plot.beneficiaryName || '');
      const benAddr = [b.purok, b.barangay, b.municipality, b.province].filter(p => p && p.trim() !== '').join(', ');

      consolidatedList.push({
        ben_id: b.beneficiaryId || plot.beneficiaryId || null,
        ben_fullname: fullName || null,
        ben_gender: b.gender || null,
        ben_marital: b.maritalStatus || null,
        ben_birthdate: b.birthDate || null,
        ben_age: b.age || null,
        ben_cellphone: b.cellphone || null,
        ben_address: benAddr || null,

        farm_plot_id: plot.id || null,
        farm_beneficiary: plot.beneficiaryName || fullName || null,
        farm_hectares: plot.hectares || null,
        farm_address: cleanPlotAddr || benAddr || null,
        farm_coordinates: plot.coordinates || null,

        seed_id: plotSeedlings.length > 0 ? plotSeedlings[0].id : null,
        seed_ben_id: plotSeedlings.length > 0 ? plotSeedlings[0].beneficiaryId : null,
        seed_received: totalReceived || null,
        seed_date_received: plotSeedlings.length > 0 ? plotSeedlings[0].dateReceived : null,
        seed_planted: totalPlanted || null,
        seed_plot_id: plotSeedlings.length > 0 ? plotSeedlings[0].plotId : null,
        seed_planting_date: plotSeedlings.length > 0 ? plotSeedlings[0].dateOfPlantingStart : null,

        crop_id: plotCrops.length > 0 ? plotCrops[0].id : null,
        crop_ben_id: plotCrops.length > 0 ? plotCrops[0].beneficiaryId : null,
        crop_beneficiary: plotCrops.length > 0 ? plotCrops[0].beneficiaryName : null,
        crop_survey_date: plotCrops.length > 0 ? plotCrops[0].surveyDate : null,
        crop_surveyer: plotCrops.length > 0 ? plotCrops[0].surveyer : null,
        crop_alive: totalAlive || null,
        crop_dead: totalDead || null,
        crop_plot: plotCrops.length > 0 ? plotCrops[0].plotId : null
      });
    });

    allBeneficiaries.forEach(b => {
      if (benWithPlots.has(b.beneficiaryId)) return;

      const fullName = `${b.firstName || ''} ${b.middleName ? b.middleName + ' ' : ''}${b.lastName || ''}`.replace(/\s+/g, ' ').trim();
      const benAddr = [b.purok, b.barangay, b.municipality, b.province].filter(p => p && p.trim() !== '').join(', ');

      consolidatedList.push({
        ben_id: b.beneficiaryId || null,
        ben_fullname: fullName || null,
        ben_gender: b.gender || null,
        ben_marital: b.maritalStatus || null,
        ben_birthdate: b.birthDate || null,
        ben_age: b.age || null,
        ben_cellphone: b.cellphone || null,
        ben_address: benAddr || null,

        farm_plot_id: null,
        farm_beneficiary: null,
        farm_hectares: null,
        farm_address: null,
        farm_coordinates: null,

        seed_id: null,
        seed_ben_id: null,
        seed_received: null,
        seed_date_received: null,
        seed_planted: null,
        seed_plot_id: null,
        seed_planting_date: null,

        crop_id: null,
        crop_ben_id: null,
        crop_beneficiary: null,
        crop_survey_date: null,
        crop_surveyer: null,
        crop_alive: null,
        crop_dead: null,
        crop_plot: null
      });
    });

    let filtered = consolidatedList;
    const query = searchQuery.toLowerCase().trim();
    if (query) {
      filtered = filtered.filter(item => 
        (item.ben_id || '').toLowerCase().includes(query) ||
        (item.ben_fullname || '').toLowerCase().includes(query) ||
        (item.farm_plot_id || '').toLowerCase().includes(query) ||
        (item.farm_address || '').toLowerCase().includes(query)
      );
    }

    if (activeFilters) {
      if (activeFilters.selectedProvince) {
        filtered = filtered.filter(item => 
          (item.ben_address && item.ben_address.toLowerCase().includes(activeFilters.selectedProvince.toLowerCase())) ||
          (item.farm_address && item.farm_address.toLowerCase().includes(activeFilters.selectedProvince.toLowerCase()))
        );
      }
      if (activeFilters.selectedMunicipality) {
        filtered = filtered.filter(item => 
          (item.ben_address && item.ben_address.toLowerCase().includes(activeFilters.selectedMunicipality.toLowerCase())) ||
          (item.farm_address && item.farm_address.toLowerCase().includes(activeFilters.selectedMunicipality.toLowerCase()))
        );
      }
    }

    if (filtered.length === 0) {
      getTableContainer().innerHTML = `
        <div class="report-empty-state">
          <h3>No results found</h3>
          <p>Try different search or filter options.</p>
        </div>`;
      return;
    }

    const headerHtml = visibleCols.map(col => `<th>${col.header}</th>`).join('');
    const rowsHtml = filtered.map((item, idx) => {
      const tdHtml = visibleCols.map(col => `<td>${col.value(item)}</td>`).join('');
      return `<tr><td>${idx + 1}</td>${tdHtml}</tr>`;
    }).join('');

    getTableContainer().innerHTML = `
      <table>
        <thead>
          <tr>
            <th>#</th>
            ${headerHtml}
          </tr>
        </thead>
        <tbody>${rowsHtml}</tbody>
      </table>`;
  }

  function triggerTableRender() {
    if (!currentTab) {
      if (!activeFilters) {
        showNoTab();
        return;
      }
      if (allBeneficiaries.length === 0 || allFarmPlots.length === 0) {
        loadAllAndRenderConsolidatedTable();
      } else {
        renderConsolidatedTable();
      }
      return;
    }

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
  }

  // ── Event Listeners ───────────────────────────────────────────────────────

  document.addEventListener('tableTabChanged', (e) => {
    handleTabChange(e.detail.tab);
  });

  document.addEventListener('tableSearchChanged', (e) => {
    searchQuery = e.detail.query || '';
    triggerTableRender();
  });

  document.addEventListener('tableFiltersApplied', (e) => {
    activeFilters = e.detail.filters;
    triggerTableRender();
  });

  document.addEventListener('tableFiltersReset', () => {
    activeFilters = null;
    triggerTableRender();
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
      activeFilters = null;
      showNoTab();
      
      // Reset filter state
      const filterSectionWrapper = document.getElementById('filterSectionWrapper');
      if (filterSectionWrapper && typeof resetFilters === 'function') {
        resetFilters();
      }
      const filterContainer = document.getElementById('reportsFilterSectionContainer');
      if (filterContainer) {
        filterContainer.style.display = 'none';
      }
      
      // Reset tab buttons
      document.querySelectorAll('.table-tab-button').forEach(b => b.classList.remove('active'));
    }
  });

  // ── Excel/CSV Export Utility ─────────────────────────────────────────────

  function getCurrentFilteredData() {
    const query = searchQuery.toLowerCase().trim();
    
    if (!currentTab) {
      // Consolidated Report
      const consolidatedList = [];
      const benMap = {};
      allBeneficiaries.forEach(b => { benMap[b.beneficiaryId] = b; });
      const benWithPlots = new Set();
      
      allFarmPlots.forEach(plot => {
        const b = benMap[plot.beneficiaryId] || {};
        benWithPlots.add(plot.beneficiaryId);
        const plotSeedlings = allSeedlings.filter(s => s.plotId === plot.id);
        const plotCrops = allCropStatusList.filter(c => c.plotId === plot.id);
        const totalReceived = plotSeedlings.reduce((sum, s) => sum + parseInt(s.received || 0), 0);
        const totalPlanted = plotSeedlings.reduce((sum, s) => sum + parseInt(s.planted || 0), 0);
        const totalAlive = plotCrops.reduce((sum, c) => sum + parseInt(c.aliveCrops || 0), 0);
        const totalDead = plotCrops.reduce((sum, c) => sum + parseInt(c.deadCrops || 0), 0);
        const rawAddr = (plot.address || '').split(',').map(s => s.trim());
        const cleanPlotAddr = rawAddr.filter(s => s && s.toLowerCase() !== 'unknown').join(', ');
        const fullName = b.firstName ? `${b.firstName} ${b.middleName ? b.middleName + ' ' : ''}${b.lastName}` : (plot.beneficiaryName || '');
        const benAddr = [b.purok, b.barangay, b.municipality, b.province].filter(p => p && p.trim() !== '').join(', ');

        consolidatedList.push({
          ben_id: b.beneficiaryId || plot.beneficiaryId || null,
          ben_fullname: fullName || null,
          ben_gender: b.gender || null,
          ben_marital: b.maritalStatus || null,
          ben_birthdate: b.birthDate || null,
          ben_age: b.age || null,
          ben_cellphone: b.cellphone || null,
          ben_address: benAddr || null,
          farm_plot_id: plot.id || null,
          farm_beneficiary: plot.beneficiaryName || fullName || null,
          farm_hectares: plot.hectares || null,
          farm_address: cleanPlotAddr || benAddr || null,
          farm_coordinates: plot.coordinates || null,
          seed_id: plotSeedlings.length > 0 ? plotSeedlings[0].id : null,
          seed_ben_id: plotSeedlings.length > 0 ? plotSeedlings[0].beneficiaryId : null,
          seed_received: totalReceived || null,
          seed_date_received: plotSeedlings.length > 0 ? plotSeedlings[0].dateReceived : null,
          seed_planted: totalPlanted || null,
          seed_plot_id: plotSeedlings.length > 0 ? plotSeedlings[0].plotId : null,
          seed_planting_date: plotSeedlings.length > 0 ? plotSeedlings[0].dateOfPlantingStart : null,
          crop_id: plotCrops.length > 0 ? plotCrops[0].id : null,
          crop_ben_id: plotCrops.length > 0 ? plotCrops[0].beneficiaryId : null,
          crop_beneficiary: plotCrops.length > 0 ? plotCrops[0].beneficiaryName : null,
          crop_survey_date: plotCrops.length > 0 ? plotCrops[0].surveyDate : null,
          crop_surveyer: plotCrops.length > 0 ? plotCrops[0].surveyer : null,
          crop_alive: totalAlive || null,
          crop_dead: totalDead || null,
          crop_plot: plotCrops.length > 0 ? plotCrops[0].plotId : null
        });
      });

      allBeneficiaries.forEach(b => {
        if (benWithPlots.has(b.beneficiaryId)) return;
        const fullName = `${b.firstName || ''} ${b.middleName ? b.middleName + ' ' : ''}${b.lastName || ''}`.replace(/\s+/g, ' ').trim();
        const benAddr = [b.purok, b.barangay, b.municipality, b.province].filter(p => p && p.trim() !== '').join(', ');
        consolidatedList.push({
          ben_id: b.beneficiaryId || null,
          ben_fullname: fullName || null,
          ben_gender: b.gender || null,
          ben_marital: b.maritalStatus || null,
          ben_birthdate: b.birthDate || null,
          ben_age: b.age || null,
          ben_cellphone: b.cellphone || null,
          ben_address: benAddr || null,
          farm_plot_id: null,
          farm_beneficiary: null,
          farm_hectares: null,
          farm_address: null,
          farm_coordinates: null,
          seed_id: null,
          seed_ben_id: null,
          seed_received: null,
          seed_date_received: null,
          seed_planted: null,
          seed_plot_id: null,
          seed_planting_date: null,
          crop_id: null,
          crop_ben_id: null,
          crop_beneficiary: null,
          crop_survey_date: null,
          crop_surveyer: null,
          crop_alive: null,
          crop_dead: null,
          crop_plot: null
        });
      });

      let filtered = consolidatedList;
      if (query) {
        filtered = filtered.filter(item => 
          (item.ben_id || '').toLowerCase().includes(query) ||
          (item.ben_fullname || '').toLowerCase().includes(query) ||
          (item.farm_plot_id || '').toLowerCase().includes(query) ||
          (item.farm_address || '').toLowerCase().includes(query)
        );
      }
      if (activeFilters) {
        if (activeFilters.selectedProvince) {
          filtered = filtered.filter(item => 
            (item.ben_address && item.ben_address.toLowerCase().includes(activeFilters.selectedProvince.toLowerCase())) ||
            (item.farm_address && item.farm_address.toLowerCase().includes(activeFilters.selectedProvince.toLowerCase()))
          );
        }
        if (activeFilters.selectedMunicipality) {
          filtered = filtered.filter(item => 
            (item.ben_address && item.ben_address.toLowerCase().includes(activeFilters.selectedMunicipality.toLowerCase())) ||
            (item.farm_address && item.farm_address.toLowerCase().includes(activeFilters.selectedMunicipality.toLowerCase()))
          );
        }
      }
      return filtered;
    }

    if (currentTab === 'Beneficiary List') {
      let filtered = allBeneficiaries;
      if (query) {
        filtered = filtered.filter(b => {
          const fullName = `${b.firstName || ''} ${b.middleName || ''} ${b.lastName || ''}`.toLowerCase();
          const address = [b.purok, b.barangay, b.municipality, b.province].filter(p => p).join(', ').toLowerCase();
          return (
            (b.beneficiaryId || '').toLowerCase().includes(query) ||
            fullName.includes(query) ||
            (b.cellphone || '').toLowerCase().includes(query) ||
            address.includes(query)
          );
        });
      }
      if (activeFilters) {
        if (activeFilters.selectedGender) filtered = filtered.filter(b => b.gender === activeFilters.selectedGender);
        if (activeFilters.selectedMaritalStatus) filtered = filtered.filter(b => b.maritalStatus === activeFilters.selectedMaritalStatus);
        if (activeFilters.dateFrom) {
          const fromDate = new Date(activeFilters.dateFrom);
          filtered = filtered.filter(b => b.birthDate && new Date(b.birthDate) >= fromDate);
        }
        if (activeFilters.dateTo) {
          const toDate = new Date(activeFilters.dateTo);
          toDate.setHours(23, 59, 59, 999);
          filtered = filtered.filter(b => b.birthDate && new Date(b.birthDate) <= toDate);
        }
        if (activeFilters.selectedProvince) filtered = filtered.filter(b => b.province === activeFilters.selectedProvince);
        if (activeFilters.selectedMunicipality) filtered = filtered.filter(b => b.municipality === activeFilters.selectedMunicipality);
      }
      return filtered;
    }

    if (currentTab === 'Farm Location') {
      let filtered = allFarmPlots;
      if (query) {
        filtered = filtered.filter(p =>
          (p.id || '').toLowerCase().includes(query) ||
          (p.beneficiaryName || '').toLowerCase().includes(query) ||
          (p.address || '').toLowerCase().includes(query) ||
          (p.beneficiaryId || '').toLowerCase().includes(query)
        );
      }
      if (activeFilters) {
        if (activeFilters.hectaresMin) {
          const minH = parseFloat(activeFilters.hectaresMin);
          filtered = filtered.filter(p => p.hectares != null && parseFloat(p.hectares) >= minH);
        }
        if (activeFilters.hectaresMax) {
          const maxH = parseFloat(activeFilters.hectaresMax);
          filtered = filtered.filter(p => p.hectares != null && parseFloat(p.hectares) <= maxH);
        }
        if (activeFilters.selectedProvince) {
          filtered = filtered.filter(p => p.address && p.address.toLowerCase().includes(activeFilters.selectedProvince.toLowerCase()));
        }
        if (activeFilters.selectedMunicipality) {
          filtered = filtered.filter(p => p.address && p.address.toLowerCase().includes(activeFilters.selectedMunicipality.toLowerCase()));
        }
      }
      return filtered;
    }

    if (currentTab === 'Seedling Record') {
      let filtered = allSeedlings;
      if (query) {
        filtered = filtered.filter(s =>
          (s.beneficiaryId || '').toLowerCase().includes(query) ||
          (s.plotId || '').toLowerCase().includes(query)
        );
      }
      if (activeFilters) {
        if (activeFilters.dateFrom) {
          const fromDate = new Date(activeFilters.dateFrom);
          filtered = filtered.filter(s => s.dateReceived && new Date(s.dateReceived) >= fromDate);
        }
        if (activeFilters.dateTo) {
          const toDate = new Date(activeFilters.dateTo);
          toDate.setHours(23, 59, 59, 999);
          filtered = filtered.filter(s => s.dateReceived && new Date(s.dateReceived) <= toDate);
        }
      }
      return filtered;
    }

    if (currentTab === 'Crop Survey Status') {
      let filtered = allCropStatusList;
      if (query) {
        filtered = filtered.filter(c =>
          (c.beneficiaryId || '').toLowerCase().includes(query) ||
          (c.beneficiaryName || '').toLowerCase().includes(query) ||
          (c.surveyer || '').toLowerCase().includes(query) ||
          (c.plotId || '').toLowerCase().includes(query)
        );
      }
      if (activeFilters) {
        if (activeFilters.dateFrom) {
          const fromDate = new Date(activeFilters.dateFrom);
          filtered = filtered.filter(c => c.surveyDate && new Date(c.surveyDate) >= fromDate);
        }
        if (activeFilters.dateTo) {
          const toDate = new Date(activeFilters.dateTo);
          toDate.setHours(23, 59, 59, 999);
          filtered = filtered.filter(c => c.surveyDate && new Date(c.surveyDate) <= toDate);
        }
      }
      return filtered;
    }

    if (currentTab === 'Recent Activities') {
      let filtered = allRecentActivities;
      if (query) {
        filtered = filtered.filter(a =>
          (a.type || '').toLowerCase().includes(query) ||
          (a.action || '').toLowerCase().includes(query) ||
          (a.user || '').toLowerCase().includes(query)
        );
      }
      if (activeFilters) {
        if (activeFilters.dateFrom) {
          const fromDate = new Date(activeFilters.dateFrom);
          filtered = filtered.filter(a => a.timestamp && new Date(a.timestamp) >= fromDate);
        }
        if (activeFilters.dateTo) {
          const toDate = new Date(activeFilters.dateTo);
          toDate.setHours(23, 59, 59, 999);
          filtered = filtered.filter(a => a.timestamp && new Date(a.timestamp) <= toDate);
        }
      }
      return filtered;
    }

    return [];
  }

  const getCellValueByAttribute = (item, attrId) => {
    if (item[attrId] !== undefined) {
      if (attrId === 'ben_birthdate' || attrId === 'seed_date_received' || attrId === 'seed_planting_date' || attrId === 'crop_survey_date') {
        const val = item[attrId];
        if (!val) return '';
        const date = new Date(val);
        return isNaN(date.getTime()) ? val : date.toLocaleDateString();
      }
      if (attrId === 'act_timestamp') {
        const val = item[attrId];
        if (!val) return '';
        const date = new Date(val);
        return isNaN(date.getTime()) ? val : date.toLocaleString();
      }
      if (attrId === 'farm_coordinates') {
        return Array.isArray(item.farm_coordinates) && item.farm_coordinates.length > 0
          ? `${item.farm_coordinates.length} points`
          : '';
      }
      return item[attrId] !== null && item[attrId] !== '' ? item[attrId] : '';
    }

    switch (attrId) {
      case 'ben_id':
        return item.beneficiaryId || '';
      case 'ben_fullname':
        return `${item.firstName || ''} ${item.middleName || ''} ${item.lastName || ''}`.trim() || '';
      case 'ben_gender':
        return item.gender || '';
      case 'ben_birthdate':
        return item.birthDate ? new Date(item.birthDate).toLocaleDateString() : '';
      case 'ben_age':
        return item.age || '';
      case 'ben_cellphone':
        return item.cellphone || '';
      case 'ben_address':
        const benAddress = [item.purok, item.barangay, item.municipality, item.province]
          .filter(part => part && part.trim() !== '' && part.toLowerCase() !== 'unknown')
          .join(', ');
        return benAddress || '';
      case 'ben_marital':
        return item.maritalStatus || '';
      
      case 'farm_plot_id':
        return item.id || '';
      case 'farm_beneficiary':
        return item.beneficiaryName || '';
      case 'farm_hectares':
        return item.hectares || '';
      case 'farm_address':
        return item.address || '';
      case 'farm_coordinates':
        return `${item.coordinates?.length || 0} points`;
      
      case 'seed_id':
        return item.id || '';
      case 'seed_ben_id':
        return item.beneficiaryId || '';
      case 'seed_received':
        return item.received || '';
      case 'seed_date_received':
        return item.dateReceived ? new Date(item.dateReceived).toLocaleDateString() : '';
      case 'seed_planted':
        return item.planted || '';
      case 'seed_plot_id':
        return item.plotId || '';
      case 'seed_planting_date':
        return item.dateOfPlantingStart ? new Date(item.dateOfPlantingStart).toLocaleDateString() : '';
      
      case 'crop_id':
        return item.id || '';
      case 'crop_ben_id':
        return item.beneficiaryId || '';
      case 'crop_beneficiary':
        return item.beneficiaryName || '';
      case 'crop_survey_date':
        return item.surveyDate ? new Date(item.surveyDate).toLocaleDateString() : '';
      case 'crop_surveyer':
        return item.surveyer || '';
      case 'crop_alive':
        return item.aliveCrops || '';
      case 'crop_dead':
        return item.deadCrops || '';
      case 'crop_plot':
        return item.plotId || item.plot || '';
      
      case 'act_id':
        return item.id || '';
      case 'act_type':
        const typeMeta = {
          beneficiary: 'Coffee Beneficiary',
          crop: 'Crop Survey Status',
          seedling: 'Seedling Record',
          plot: 'Farm Plot Details'
        };
        return typeMeta[item.type] || item.type || 'System Activity';
      case 'act_action':
        return item.action || '';
      case 'act_timestamp':
        return item.timestamp ? new Date(item.timestamp).toLocaleString() : '';
      case 'act_user':
        return item.user || '';
      
      default:
        return '';
    }
  };

  const convertToCSVRow = (item, activeTab, selectedAttributes, attributeColumnMap) => {
    if (selectedAttributes && selectedAttributes.length > 0) {
      return selectedAttributes.map(attrId => getCellValueByAttribute(item, attrId));
    }
    
    let row = [];
    switch (activeTab) {
      case 'Beneficiary List':
        const address = [item.purok, item.barangay, item.municipality, item.province]
          .filter(part => part && part.trim() !== '')
          .join(', ');
        row = [
          item.beneficiaryId || '',
          `${item.firstName || ''} ${item.middleName || ''} ${item.lastName || ''}`.trim() || '',
          item.gender || '',
          item.maritalStatus || '',
          item.birthDate ? new Date(item.birthDate).toLocaleDateString() : '',
          item.age || '',
          item.cellphone || '',
          address || ''
        ];
        break;
      case 'Farm Location':
        row = [
          item.id || '',
          item.beneficiaryName || '',
          item.hectares || '',
          item.address || '',
          `${item.coordinates?.length || 0} points`
        ];
        break;
      case 'Seedling Record':
        row = [
          item.beneficiaryId || '',
          item.received || '',
          item.dateReceived ? new Date(item.dateReceived).toLocaleDateString() : '',
          item.planted || '',
          item.plotId || '',
          item.dateOfPlantingStart ? new Date(item.dateOfPlantingStart).toLocaleDateString() : '',
          item.dateOfPlantingEnd ? new Date(item.dateOfPlantingEnd).toLocaleDateString() : ''
        ];
        break;
      case 'Crop Survey Status':
        row = [
          item.beneficiaryId || '',
          item.beneficiaryName || '',
          item.surveyDate ? new Date(item.surveyDate).toLocaleDateString() : '',
          item.surveyer || '',
          item.aliveCrops || '',
          item.deadCrops || '',
          item.plot || ''
        ];
        break;
      case 'Recent Activities':
        const typeMeta = {
          beneficiary: 'Coffee Beneficiary',
          crop: 'Crop Survey Status',
          seedling: 'Seedling Record',
          plot: 'Farm Plot Details'
        };
        row = [
          typeMeta[item.type] || item.type || 'System Activity',
          item.action || '',
          item.timestamp ? new Date(item.timestamp).toLocaleString() : '',
          item.user || ''
        ];
        break;
      default:
        // Consolidated list defaults
        row = [
          item.ben_id || '',
          item.ben_fullname || '',
          item.farm_plot_id || '',
          item.farm_hectares || '',
          item.seed_received || '',
          item.seed_planted || '',
          item.crop_alive || '',
          item.crop_dead || ''
        ];
    }
    return row;
  };

  function exportToExcel(activeTab, data, selectedAttributes = null) {
    if (!data || data.length === 0) return;
    
    const attributeColumnMap = {
      // Beneficiary List
      'ben_id': { header: 'Beneficiary ID' },
      'ben_fullname': { header: 'Full Name' },
      'ben_gender': { header: 'Gender' },
      'ben_marital': { header: 'Marital Status' },
      'ben_birthdate': { header: 'Birth Date' },
      'ben_age': { header: 'Age' },
      'ben_cellphone': { header: 'Cellphone' },
      'ben_address': { header: 'Address' },

      // Farm Location
      'farm_plot_id': { header: 'Plot ID' },
      'farm_beneficiary': { header: 'Beneficiary' },
      'farm_hectares': { header: 'Hectares' },
      'farm_address': { header: 'Address' },
      'farm_coordinates': { header: 'Coordinates' },

      // Seedling Record
      'seed_id': { header: 'Seedling ID' },
      'seed_ben_id': { header: 'Beneficiary ID' },
      'seed_received': { header: 'Received' },
      'seed_date_received': { header: 'Date Received' },
      'seed_planted': { header: 'Planted' },
      'seed_plot_id': { header: 'Plot ID' },
      'seed_planting_date': { header: 'Planting Date' },

      // Crop Survey Status
      'crop_id': { header: 'Survey ID' },
      'crop_ben_id': { header: 'Beneficiary ID' },
      'crop_beneficiary': { header: 'Beneficiary Name' },
      'crop_survey_date': { header: 'Survey Date' },
      'crop_surveyer': { header: 'Surveyer Name' },
      'crop_alive': { header: 'Alive Crops' },
      'crop_dead': { header: 'Dead Crops' },
      'crop_plot': { header: 'Plot' },

      // Recent Activities
      'act_id': { header: 'Activity ID' },
      'act_type': { header: 'Type' },
      'act_action': { header: 'Action' },
      'act_timestamp': { header: 'Timestamp' },
      'act_user': { header: 'User' }
    };

    let headers = [];
    if (selectedAttributes && selectedAttributes.length > 0) {
      headers = ['#', ...selectedAttributes.map(attrId => attributeColumnMap[attrId]?.header).filter(Boolean)];
    } else {
      const headersMap = {
        'Beneficiary List': ['Beneficiary ID', 'Full Name', 'Gender', 'Marital Status', 'Birth Date', 'Age', 'Cellphone', 'Address'],
        'Farm Location': ['Plot ID', 'Beneficiary', 'Hectares', 'Address', 'Coordinates'],
        'Seedling Record': ['Beneficiary ID', 'Received', 'Date Received', 'Planted', 'Plot ID', 'Planting Date', 'End Date'],
        'Crop Survey Status': ['Beneficiary ID', 'Beneficiary Name', 'Survey Date', 'Surveyer Name', 'Alive Crops', 'Dead Crops', 'Plot'],
        'Recent Activities': ['Type', 'Action', 'Timestamp', 'User']
      };
      
      const defaultTab = activeTab || 'Consolidated Report';
      headers = ['#', ...(headersMap[defaultTab] || ['Beneficiary ID', 'Full Name', 'Plot ID', 'Hectares', 'Received', 'Planted', 'Alive Crops', 'Dead Crops'])];
    }

    const csvRows = [
      headers.join(','),
      ...data.map((item, index) => {
        let rowData;
        if (selectedAttributes && selectedAttributes.length > 0) {
          rowData = [index + 1, ...convertToCSVRow(item, activeTab, selectedAttributes, attributeColumnMap)];
        } else {
          rowData = [index + 1, ...convertToCSVRow(item, activeTab, null, null)];
        }
        
        return rowData.map(cell => {
          const cellStr = String(cell === null || cell === undefined || cell === '—' ? '' : cell);
          if (cellStr.includes(',') || cellStr.includes('"') || cellStr.includes('\n')) {
            return `"${cellStr.replace(/"/g, '""')}"`;
          }
          return cellStr;
        }).join(',');
      })
    ];

    const csvContent = csvRows.join('\n');
    const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
    const link = document.createElement('a');
    const url = URL.createObjectURL(blob);
    link.setAttribute('href', url);
    
    const filename = `${(activeTab || 'Consolidated_Report').replace(/\s+/g, '_')}_${new Date().toISOString().split('T')[0]}.csv`;
    link.setAttribute('download', filename);
    link.style.visibility = 'hidden';
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
    URL.revokeObjectURL(url);
  }

  const attributeColumnMap = {
    ben_id: { header: 'Beneficiary ID' },
    ben_fullname: { header: 'Full Name' },
    ben_gender: { header: 'Gender' },
    ben_marital: { header: 'Marital Status' },
    ben_birthdate: { header: 'Birth Date' },
    ben_age: { header: 'Age' },
    ben_cellphone: { header: 'Cellphone' },
    ben_address: { header: 'Address' },
    
    farm_plot_id: { header: 'Plot ID' },
    farm_beneficiary: { header: 'Beneficiary Name' },
    farm_hectares: { header: 'Hectares' },
    farm_address: { header: 'Plot Address' },
    farm_coordinates: { header: 'Coordinates' },
    
    seed_id: { header: 'Seedling ID' },
    seed_ben_id: { header: 'Seedling Ben ID' },
    seed_received: { header: 'Received' },
    seed_date_received: { header: 'Date Received' },
    seed_planted: { header: 'Planted' },
    seed_plot_id: { header: 'Seedling Plot ID' },
    seed_planting_date: { header: 'Planting Date' },
    
    crop_id: { header: 'Survey ID' },
    crop_ben_id: { header: 'Survey Ben ID' },
    crop_beneficiary: { header: 'Survey Beneficiary' },
    crop_survey_date: { header: 'Survey Date' },
    crop_surveyer: { header: 'Surveyer' },
    crop_alive: { header: 'Alive Crops' },
    crop_dead: { header: 'Dead Crops' },
    crop_plot: { header: 'Survey Plot' },
    
    act_id: { header: 'Activity ID' },
    act_type: { header: 'Activity Type' },
    act_action: { header: 'Action' },
    act_timestamp: { header: 'Timestamp' },
    act_user: { header: 'User' }
  };

  document.addEventListener('tableExportTriggered', (e) => {
    if (e.detail.type === 'excel') {
      const dataToExport = getCurrentFilteredData();
      const selectedAttrs = activeFilters ? activeFilters.selectedAttributes : null;
      exportToExcel(currentTab, dataToExport, selectedAttrs);
    } else if (e.detail.type === 'pdf') {
      const dataToExport = getCurrentFilteredData();
      const selectedAttrs = activeFilters ? activeFilters.selectedAttributes : null;
      if (typeof window.openPDFEditor === 'function') {
        window.openPDFEditor(currentTab, dataToExport, selectedAttrs, attributeColumnMap);
      }
    }
  });

  // Exposed globally so ReportTableTabs can call it directly within the user
  // gesture context (avoids browser download permission prompt on localhost)
  window.triggerReportExport = function(type) {
    if (type === 'excel') {
      const dataToExport = getCurrentFilteredData();
      const selectedAttrs = activeFilters ? activeFilters.selectedAttributes : null;
      exportToExcel(currentTab, dataToExport, selectedAttrs);
    } else if (type === 'pdf') {
      const dataToExport = getCurrentFilteredData();
      const selectedAttrs = activeFilters ? activeFilters.selectedAttributes : null;
      if (typeof window.openPDFEditor === 'function') {
        window.openPDFEditor(currentTab, dataToExport, selectedAttrs, attributeColumnMap);
      }
    }
  };
})();
</script>
