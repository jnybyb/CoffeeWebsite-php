<!-- Coffee Beneficiary Page -->
<style>
  /* ===============================
     HEADER SECTION
     =============================== */
  .page-header.beneficiary-header {
    padding: 1.6rem 1rem 1.4rem 1rem;
    background-color: var(--white, #ffffff);
    margin-bottom: 0;
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
    .page-header {
      padding: 1.2rem 0.8rem 1rem 0.8rem;
    }
    .page-title {
      font-size: 1.3rem;
    }
  }

  @media (max-width: 480px) {
    .page-header {
      padding: 1rem 0.5rem 0.8rem 0.5rem;
    }
    .page-title {
      font-size: 1.2rem;
    }
    .page-header .page-subtitle {
      font-size: 0.5rem;
    }
  }
</style>

<div class="page-header beneficiary-header">
  <h2 class="page-title">Coffee Beneficiaries</h2>
  <div class="page-subtitle">View and manage coffee farmer beneficiaries</div>
</div>

<?php include '../ui/BeneficiaryDataTable.php'; ?>

<script>
  const API_BASE_URL = 'http://localhost:5000/api';
  window.beneficiariesData = {}; // Full cache for details
  window.allFetchedBeneficiaries = []; // Backup of original array
  window.currentBeneficiaries = []; // Active array (filtered)
  window.currentPage = 1;
  window.pageSize = 13;

  /**
   * Fetch beneficiaries data and related collections from backend API in parallel
   */
  async function loadBeneficiaries() {
    const token = localStorage.getItem('authToken');
    if (!token) {
      window.location.href = '../../login.php';
      return;
    }

    const loadingState = document.getElementById('loadingState');
    const tableContent = document.getElementById('tableContent');
    const emptyState = document.getElementById('emptyState');
    const dataTableWrapper = document.querySelector('.data-table-wrapper');

    // Show loading state
    loadingState.classList.remove('hidden');
    tableContent.classList.add('hidden');
    emptyState.classList.add('hidden');
    dataTableWrapper.classList.remove('no-data');

    try {
      // Fetch beneficiaries and related data in parallel
      const [resBen, resPlots, resSeedlings, resCropStatus] = await Promise.all([
        fetch(`${API_BASE_URL}/beneficiaries`, { headers: { 'Authorization': `Bearer ${token}` } }),
        fetch(`${API_BASE_URL}/farm-plots`, { headers: { 'Authorization': `Bearer ${token}` } }).catch(e => { console.error('Error fetching farm plots:', e); return null; }),
        fetch(`${API_BASE_URL}/seedlings`, { headers: { 'Authorization': `Bearer ${token}` } }).catch(e => { console.error('Error fetching seedling records:', e); return null; }),
        fetch(`${API_BASE_URL}/crop-status`, { headers: { 'Authorization': `Bearer ${token}` } }).catch(e => { console.error('Error fetching crop statuses:', e); return null; })
      ]);

      // Handle unauthorized or expired token
      if (resBen.status === 401 || resBen.status === 403) {
        localStorage.removeItem('authToken');
        window.location.href = '../../login.php';
        return;
      }

      if (!resBen.ok) throw new Error('Failed to fetch beneficiaries list');

      let beneficiaries = await resBen.json();
      
      // Parse related datasets with robust fallbacks
      let farmPlots = [];
      if (resPlots && resPlots.ok) {
        try { farmPlots = await resPlots.json(); } catch(e) { console.error(e); }
      }
      let seedlings = [];
      if (resSeedlings && resSeedlings.ok) {
        try { seedlings = await resSeedlings.json(); } catch(e) { console.error(e); }
      }
      let cropStatusList = [];
      if (resCropStatus && resCropStatus.ok) {
        try { cropStatusList = await resCropStatus.json(); } catch(e) { console.error(e); }
      }

      loadingState.classList.add('hidden');

      // If backend wraps array in an object (e.g. { data: [...] } or { beneficiaries: [...] })
      if (beneficiaries && !Array.isArray(beneficiaries)) {
        if (Array.isArray(beneficiaries.data)) {
          beneficiaries = beneficiaries.data;
        } else if (Array.isArray(beneficiaries.beneficiaries)) {
          beneficiaries = beneficiaries.beneficiaries;
        } else {
          console.warn('API returned unexpected format:', beneficiaries);
          beneficiaries = []; // fallback
        }
      }

      // Enrich each beneficiary with their respective related records
      (beneficiaries || []).forEach(ben => {
        const idStr = ben.beneficiaryId || ben._id || 'N/A';
        
        // Filter plots, seedlings, and crop surveys
        ben.farms = farmPlots.filter(fp => fp.beneficiaryId === idStr);
        ben.seedlingRecords = seedlings.filter(s => s.beneficiaryId === idStr);
        ben.cropSurveys = cropStatusList.filter(cs => cs.beneficiaryId === idStr);
        
        // Calculate total seedlings received
        ben.totalSeedlings = ben.seedlingRecords.reduce((sum, s) => sum + (s.received || 0), 0);
      });

      // Populate caches
      window.allFetchedBeneficiaries = beneficiaries || [];
      window.currentBeneficiaries = [...window.allFetchedBeneficiaries];
      
      // Cache data for detail panel keyed by ID
      window.allFetchedBeneficiaries.forEach(ben => {
        const idStr = ben.beneficiaryId || ben._id || 'N/A';
        window.beneficiariesData[idStr] = ben;
      });

      if (window.currentBeneficiaries.length === 0) {
        emptyState.classList.remove('hidden');
        dataTableWrapper.classList.add('no-data');
        document.getElementById('paginationContainer').innerHTML = '';
      } else {
        tableContent.classList.remove('hidden');
        renderTablePage(1);
      }
    } catch (error) {
      console.error('Error fetching beneficiaries:', error);
      loadingState.classList.add('hidden');
      emptyState.classList.remove('hidden');
      dataTableWrapper.classList.add('no-data');
      document.getElementById('paginationContainer').innerHTML = '';
      
      const emptyMsg = emptyState.querySelector('p, .data-table-empty-message');
      if (emptyMsg) emptyMsg.textContent = 'Error loading data. Make sure backend is running.';
    }
  }

  /**
   * Navigate to specific page and re-render table and pagination
   */
  function renderTablePage(page) {
    const totalRecords = window.currentBeneficiaries.length;
    const totalPages = Math.max(1, Math.ceil(totalRecords / window.pageSize));
    window.currentPage = Math.min(Math.max(1, page), totalPages);

    const start = (window.currentPage - 1) * window.pageSize;
    const end = start + window.pageSize;
    const pageData = window.currentBeneficiaries.slice(start, end);

    const tableBody = document.getElementById('tableBody');
    renderTableRows(pageData, tableBody);
    renderPaginationControls();
  }

  /**
   * Render table rows dynamically from sliced data
   */
  function renderTableRows(beneficiaries, tableBody) {
    tableBody.innerHTML = '';
    
    beneficiaries.forEach(ben => {
      const idStr = ben.beneficiaryId || ben._id || 'N/A';
      
      const fullName = `${ben.firstName || ''} ${ben.lastName || ''}`.trim();
      const address = [ben.purok, ben.barangay, ben.municipality]
        .map(p => p ? p.trim() : '')
        .filter(p => p && p.toLowerCase() !== 'unknown')
        .join(', ');
      const farmCount = (ben.farms && ben.farms.length > 0) ? ben.farms.length : '—';
      const totalSeedlings = (ben.totalSeedlings && ben.totalSeedlings > 0) ? ben.totalSeedlings : '—';

      const initial = fullName.charAt(0).toUpperCase() || '?';
      const avatarHtml = ben.picture 
        ? `<img src="${API_BASE_URL.replace('/api', '')}${ben.picture}" alt="${fullName}" style="width:24px;height:24px;border-radius:50%;object-fit:cover;">`
        : `<div style="width:24px;height:24px;border-radius:50%;background:#e8f5e8;color:var(--dark-green);display:flex;align-items:center;justify-content:center;font-size:10px;font-weight:bold;">${initial}</div>`;

      const row = document.createElement('div');
      row.className = 'data-table-row';
      row.onclick = () => selectRow(row, idStr);
      
      row.innerHTML = `
        <div class="data-table-cell">${idStr}</div>
        <div class="data-table-cell">
          <div class="data-table-cell-avatar">
            ${avatarHtml}
            <span>${fullName}</span>
          </div>
        </div>
        <div class="data-table-cell">${address}</div>
        <div class="data-table-cell" style="justify-content: center;">${farmCount}</div>
        <div class="data-table-cell" style="justify-content: center;">${totalSeedlings}</div>
      `;
      
      tableBody.appendChild(row);
    });
  }

  /**
   * Generate pagination buttons identically to Pagination.php
   */
  function renderPaginationControls() {
    const container = document.getElementById('paginationContainer');
    const totalRecords = window.currentBeneficiaries.length;
    
    if (totalRecords === 0) {
      container.innerHTML = '';
      return;
    }

    const totalPages = Math.max(1, Math.ceil(totalRecords / window.pageSize));
    const start = totalRecords === 0 ? 0 : (window.currentPage - 1) * window.pageSize + 1;
    const end = Math.min(totalRecords, window.currentPage * window.pageSize);

    // Pagination algorithm matches PHP version exactly
    let pages = [];
    if (totalPages <= 7) {
      for (let i = 1; i <= totalPages; i++) pages.push(i);
    } else {
      pages.push(1, 2);
      if (window.currentPage <= 3) {
        pages.push(3);
        if (window.currentPage === 3) pages.push(4);
        pages.push('...', totalPages - 1, totalPages);
      } else if (window.currentPage >= totalPages - 2) {
        pages.push('...');
        if (window.currentPage === totalPages - 2) {
          pages.push(totalPages - 3, totalPages - 2);
        } else {
          pages.push(totalPages - 2);
        }
        pages.push(totalPages - 1, totalPages);
      } else {
        pages.push('...', window.currentPage - 1, window.currentPage, window.currentPage + 1, '...', totalPages - 1, totalPages);
      }
    }

    let buttonsHtml = pages.map(p => {
      if (p === '...') return `<span class="pagination-ellipsis">…</span>`;
      return `<button type="button" class="pagination-btn ${p === window.currentPage ? 'pagination-btn-active' : ''}" onclick="renderTablePage(${p})" ${p === window.currentPage ? 'aria-current="page"' : ''}>${p}</button>`;
    }).join('');

    container.innerHTML = `
      <div class="pagination-container">
        <div class="pagination-left">
          Items ${start}-${end} of ${totalRecords} entries
        </div>
        <div class="pagination-right">
          <div class="pagination-pager">
            <button type="button" class="pagination-btn pagination-btn-nav ${window.currentPage === 1 ? 'pagination-btn-disabled' : ''}" onclick="renderTablePage(${window.currentPage - 1})" ${window.currentPage === 1 ? 'disabled' : ''} aria-label="Previous page">‹</button>
            ${buttonsHtml}
            <button type="button" class="pagination-btn pagination-btn-nav ${window.currentPage === totalPages ? 'pagination-btn-disabled' : ''}" onclick="renderTablePage(${window.currentPage + 1})" ${window.currentPage === totalPages ? 'disabled' : ''} aria-label="Next page">›</button>
          </div>
        </div>
      </div>
    `;
  }

  /**
   * Filter backing array instead of DOM elements
   */
  function filterTable() {
    const searchInput = document.getElementById('searchInput');
    const searchTerm = searchInput ? searchInput.value.toLowerCase().trim() : '';

    if (!searchTerm) {
      window.currentBeneficiaries = [...window.allFetchedBeneficiaries];
    } else {
      window.currentBeneficiaries = window.allFetchedBeneficiaries.filter(ben => {
        const idStr = String(ben.beneficiaryId || ben._id || '').toLowerCase();
        const fullName = `${ben.firstName || ''} ${ben.lastName || ''}`.toLowerCase();
        const address = [ben.purok, ben.barangay, ben.municipality]
          .map(p => p ? p.trim() : '')
          .filter(p => p && p.toLowerCase() !== 'unknown')
          .join(' ')
          .toLowerCase();
        return idStr.includes(searchTerm) || fullName.includes(searchTerm) || address.includes(searchTerm);
      });
    }

    const emptyState = document.getElementById('emptyState');
    const dataTableWrapper = document.querySelector('.data-table-wrapper');
    const tableContent = document.getElementById('tableContent');

    if (window.currentBeneficiaries.length === 0) {
      emptyState.classList.remove('hidden');
      tableContent.classList.add('hidden');
      dataTableWrapper.classList.add('no-data');
      document.getElementById('paginationContainer').innerHTML = '';
    } else {
      emptyState.classList.add('hidden');
      tableContent.classList.remove('hidden');
      dataTableWrapper.classList.remove('no-data');
      renderTablePage(1); // Jump back to page 1 on search
    }
  }

  /**
   * Select a row and show detail panel
   */
  function selectRow(element, beneficiaryId) {
    document.querySelectorAll('.data-table-row').forEach(row => row.classList.remove('active'));
    element.classList.add('active');
    showDetailPanel(beneficiaryId);
  }

  /**
   * Show detail panel pulling from JS cache and dynamically rendering lists
   */
  function showDetailPanel(beneficiaryId) {
    window.activeBeneficiaryId = beneficiaryId;
    const overlay = document.getElementById('overlay');
    const panel = document.getElementById('detailPanel');
    const ben = window.beneficiariesData[beneficiaryId];
    
    if (ben) {
      document.getElementById('detailID').textContent = ben.beneficiaryId || ben._id || '-';
      document.getElementById('detailName').textContent = `${ben.firstName || ''} ${ben.lastName || ''}`.trim() || '-';
      const address = [ben.purok, ben.barangay, ben.municipality]
        .map(p => p ? p.trim() : '')
        .filter(p => p && p.toLowerCase() !== 'unknown')
        .join(', ');
      document.getElementById('detailAddress').textContent = address || '-';
      document.getElementById('detailGender').textContent = ben.gender || '-';
      document.getElementById('detailMaritalStatus').textContent = ben.maritalStatus || '-';
      
      let bdate = ben.birthDate ? new Date(ben.birthDate).toLocaleDateString() : '-';
      document.getElementById('detailBirthDate').textContent = bdate;
      document.getElementById('detailAge').textContent = ben.age || '-';
      
      document.getElementById('detailCellphone').textContent = ben.cellphone || '-';
      
      // Load Profile Image
      const detailPic = document.getElementById('detailPicture');
      const detailPlaceholder = document.getElementById('detailPicturePlaceholder');
      if (ben.picture) {
        detailPic.src = `${API_BASE_URL.replace('/api', '')}${ben.picture}`;
        detailPic.classList.remove('hidden');
        detailPlaceholder.classList.add('hidden');
      } else {
        detailPic.src = '';
        detailPic.classList.add('hidden');
        detailPlaceholder.classList.remove('hidden');
      }
      
      const editBtn = document.getElementById('detailBtnEdit');
      if (editBtn) {
        editBtn.onclick = () => openEditBeneficiaryModal(beneficiaryId);
      }
      
      const deleteBtn = document.getElementById('detailBtnDelete');
      if (deleteBtn) {
        deleteBtn.onclick = () => confirmDeleteBeneficiary(beneficiaryId);
      }

      const addSeedlingBtn = document.getElementById('detailBtnAddSeedling');
      if (addSeedlingBtn) {
        addSeedlingBtn.onclick = () => {
          openAddSeedlingRecordModal(ben);
        };
      }

      const addSurveyBtn = document.getElementById('detailBtnAddSurvey');
      if (addSurveyBtn) {
        addSurveyBtn.onclick = () => {
          openAddSurveyStatusModal(ben);
        };
      }

      // 1. RENDER FARM PLOTS
      const farmPlotsContainer = document.getElementById('detailFarmPlots');
      if (ben.farms && ben.farms.length > 0) {
        farmPlotsContainer.className = "farm-plots-container"; // Set flex layout class
        farmPlotsContainer.innerHTML = ben.farms.map(farm => {
          return `
            <div class="farm-plot-indicator" title="${parseFloat(farm.hectares || 0).toFixed(2)} Hectares" onclick="navigateToFarmPlot('${farm.id}')">
              <div class="farm-plot-icon-box">
                <svg stroke="currentColor" fill="none" stroke-width="2" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round" height="36" width="36" xmlns="http://www.w3.org/2000/svg"><path d="m12 8 6-3-6-3v10"></path><path d="m8 11.99-5.5 3.14a1 1 0 0 0 0 1.74l8.5 4.86a2 2 0 0 0 2 0l8.5-4.86a1 1 0 0 0 0-1.74L16 12"></path><path d="m6.49 12.85 11.02 6.3"></path><path d="M17.51 12.85 6.5 19.15"></path></svg>
              </div>
              <span class="farm-plot-id-label">${farm.id || 'N/A'}</span>
            </div>
          `;
        }).join('');
      } else {
        farmPlotsContainer.className = "section-content"; // Reset to standard empty state class
        farmPlotsContainer.innerHTML = `
          <div class="empty-state">
            <svg stroke="currentColor" fill="none" stroke-width="2" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round" height="32" width="32" xmlns="http://www.w3.org/2000/svg"><path d="m12 8 6-3-6-3v10"></path><path d="m8 11.99-5.5 3.14a1 1 0 0 0 0 1.74l8.5 4.86a2 2 0 0 0 2 0l8.5-4.86a1 1 0 0 0 0-1.74L16 12"></path><path d="m6.49 12.85 11.02 6.3"></path><path d="M17.51 12.85 6.5 19.15"></path></svg>
            <p>No farm plots available</p>
          </div>
        `;
      }

      // 2. RENDER COFFEE SEEDLING RECORDS
      const seedlingsContainer = document.getElementById('detailSeedlingRecords');
      if (ben.seedlingRecords && ben.seedlingRecords.length > 0) {
        // Sort strictly by database ID ascending to guarantee chronological ordering (oldest first, newest last)
        const sortedRecords = [...ben.seedlingRecords].sort((a, b) => (a.id || 0) - (b.id || 0));

        seedlingsContainer.innerHTML = sortedRecords.map((rec, index) => {
          const accordionId = `seedling-acc-${beneficiaryId}-${index}`;
          const dateRec     = rec.dateReceived       ? new Date(rec.dateReceived).toLocaleDateString(undefined,       { year: 'numeric', month: 'short', day: 'numeric' }) : 'N/A';
          const datePlantS  = rec.dateOfPlantingStart ? new Date(rec.dateOfPlantingStart).toLocaleDateString(undefined, { year: 'numeric', month: 'short', day: 'numeric' }) : 'N/A';
          const datePlantE  = rec.dateOfPlantingEnd   ? new Date(rec.dateOfPlantingEnd).toLocaleDateString(undefined,   { year: 'numeric', month: 'short', day: 'numeric' }) : 'N/A';
          const isFirst = index === 0;
          return `
            <div class="accordion-card" id="${accordionId}-card">
              <div class="accordion-header" onclick="toggleAccordion('${accordionId}')">
                <span class="accordion-header-title">Record #${index + 1}</span>
                <svg class="accordion-chevron ${isFirst ? 'open' : ''}" id="${accordionId}-chevron"
                     stroke="currentColor" fill="none" stroke-width="2.5" viewBox="0 0 24 24"
                     stroke-linecap="round" stroke-linejoin="round" xmlns="http://www.w3.org/2000/svg">
                  <polyline points="6 9 12 15 18 9"></polyline>
                </svg>
              </div>
              <div class="accordion-body ${isFirst ? 'open' : ''}" id="${accordionId}-body">
                <ul class="accordion-kv-list">
                  <li><span class="accordion-kv-key">Received:</span>      <span class="accordion-kv-val">${(rec.received || 0).toLocaleString()}</span></li>
                  <li><span class="accordion-kv-key">Date Received:</span> <span class="accordion-kv-val">${dateRec}</span></li>
                  <li><span class="accordion-kv-key">Planted:</span>       <span class="accordion-kv-val">${(rec.planted || 0).toLocaleString()}</span></li>
                  <li><span class="accordion-kv-key">Plot ID:</span>       <span class="accordion-kv-val" style="color:#2980b9;font-weight:700;">${rec.plotId || 'N/A'}</span></li>
                  <li><span class="accordion-kv-key">Planting Start:</span><span class="accordion-kv-val">${datePlantS}</span></li>
                  <li><span class="accordion-kv-key">Planting End:</span>  <span class="accordion-kv-val">${datePlantE}</span></li>
                </ul>
                 <div class="accordion-actions">
                  <button class="shared-ui-btn type-edit" onclick="editSeedlingRecord('${rec.id}', '${beneficiaryId}')">
                    <svg width="11" height="11" stroke="currentColor" fill="none" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                    Edit
                  </button>
                  <button class="shared-ui-btn type-delete" onclick="deleteSeedlingRecord('${rec.id}', '${beneficiaryId}')">
                    <svg width="11" height="11" stroke="currentColor" fill="none" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/><path d="M9 6V4h6v2"/></svg>
                    Delete
                  </button>
                </div>
              </div>
            </div>
          `;
        }).join('');
      } else {
        seedlingsContainer.innerHTML = `
          <div class="empty-state">
            <img src="../../assets/icons/seedling.png" alt="No records" />
            <p>No seedling records available</p>
          </div>
        `;
      }

      // 3. RENDER CROP SURVEY STATUS
      const surveysContainer = document.getElementById('detailCropSurvey');
      if (ben.cropSurveys && ben.cropSurveys.length > 0) {
        // Sort strictly by database ID ascending to guarantee chronological ordering (oldest first, newest last)
        const sortedSurveys = [...ben.cropSurveys].sort((a, b) => (a.id || 0) - (b.id || 0));

        surveysContainer.innerHTML = sortedSurveys.map((survey, index) => {
          const accordionId   = `survey-acc-${beneficiaryId}-${index}`;
          const alive         = survey.aliveCrops || 0;
          const dead          = survey.deadCrops  || 0;
          const surveyDate    = survey.surveyDate ? new Date(survey.surveyDate).toLocaleDateString(undefined, { year: 'numeric', month: 'short', day: 'numeric' }) : 'N/A';
          const isFirst       = index === 0;

          let picsHtml = '';
          if (survey.pictures && survey.pictures.length > 0) {
            picsHtml = `
                  <li>
                    <span class="accordion-kv-key">Photos:</span>
                    <span class="accordion-kv-val">
                      <div class="crop-survey-pics" style="margin-top:0.3rem;">` +
                        survey.pictures.map(pic => {
                          const picUrl = `${API_BASE_URL.replace('/api', '')}/uploads/${pic}`;
                          return `<img src="${picUrl}" class="crop-survey-thumbnail" onclick="showImagePreview('${picUrl}')" title="Click to view full image" />`;
                        }).join('') +
                      `</div>
                    </span>
                  </li>`;
          }

          return `
            <div class="accordion-card" id="${accordionId}-card">
              <div class="accordion-header" onclick="toggleAccordion('${accordionId}')">
                <span class="accordion-header-title">Survey #${index + 1}</span>
                <svg class="accordion-chevron ${isFirst ? 'open' : ''}" id="${accordionId}-chevron"
                     stroke="currentColor" fill="none" stroke-width="2.5" viewBox="0 0 24 24"
                     stroke-linecap="round" stroke-linejoin="round" xmlns="http://www.w3.org/2000/svg">
                   <polyline points="6 9 12 15 18 9"></polyline>
                </svg>
              </div>
              <div class="accordion-body ${isFirst ? 'open' : ''}" id="${accordionId}-body">
                <ul class="accordion-kv-list">
                  <li><span class="accordion-kv-key">Surveyor:</span>     <span class="accordion-kv-val">${survey.surveyer || 'Unknown'}</span></li>
                  <li><span class="accordion-kv-key">Survey Date:</span>  <span class="accordion-kv-val">${surveyDate}</span></li>
                  <li><span class="accordion-kv-key">Plot ID:</span>      <span class="accordion-kv-val" style="color:#2980b9;font-weight:700;">${survey.plotId || 'N/A'}</span></li>
                  <li><span class="accordion-kv-key">Alive Crops:</span>  <span class="accordion-kv-val" style="color:#2b8a3e;font-weight:700;">${alive.toLocaleString()}</span></li>
                  <li><span class="accordion-kv-key">Dead Crops:</span>   <span class="accordion-kv-val" style="color:#dc3545;font-weight:700;">${dead.toLocaleString()}</span></li>
                  ${picsHtml}
                </ul>
                <div class="accordion-actions">
                  <button class="shared-ui-btn type-edit" onclick="editCropSurvey('${survey.id}', '${beneficiaryId}')">
                    <svg width="11" height="11" stroke="currentColor" fill="none" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                    Edit
                  </button>
                  <button class="shared-ui-btn type-delete" onclick="deleteCropSurvey('${survey.id}', '${beneficiaryId}')">
                    <svg width="11" height="11" stroke="currentColor" fill="none" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/><path d="M9 6V4h6v2"/></svg>
                    Delete
                  </button>
                </div>
              </div>
            </div>
          `;
        }).join('');
      } else {
        surveysContainer.innerHTML = `
          <div class="empty-state">
            <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 24 24" height="32" width="32" xmlns="http://www.w3.org/2000/svg"><path fill="none" d="M0 0h24v24H0V0z"></path><path d="M19 3h-4.18C14.4 1.84 13.3 1 12 1c-1.3 0-2.4.84-2.82 2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-7 0c.55 0 1 .45 1 1s-.45 1-1 1-1-.45-1-1 .45-1 1-1zm2 14H7v-2h7v2zm3-4H7v-2h10v2zm0-4H7V7h10v2z"></path></svg>
            <p>No crop survey data available</p>
          </div>
        `;
      }
    }
    
    overlay.classList.remove('hidden');
    panel.classList.remove('hidden');
  }

  /**
   * Toggle accordion open/close
   */
  function toggleAccordion(accordionId) {
    const body    = document.getElementById(`${accordionId}-body`);
    const chevron = document.getElementById(`${accordionId}-chevron`);
    if (!body || !chevron) return;
    const isOpen = body.classList.contains('open');
    body.classList.toggle('open', !isOpen);
    chevron.classList.toggle('open', !isOpen);
  }

  /**
   * Edit seedling record - opens the Edit Coffee Seedling Record Modal
   */
  function editSeedlingRecord(seedlingId, beneficiaryId) {
    const ben = window.beneficiariesData[beneficiaryId];
    if (!ben) return;
    const rec = (ben.seedlingRecords || []).find(r => String(r.id) === String(seedlingId));
    if (!rec) return;
    
    openEditSeedlingRecordModal(rec, ben);
  }

  /**
   * Delete seedling record - shows confirmation prompt
   */
  function deleteSeedlingRecord(seedlingId, beneficiaryId) {
    if (typeof AlertModal !== 'undefined') {
      AlertModal.show({
        type: 'delete',
        title: 'Delete Seedling Record',
        message: 'Are you sure you want to delete this seedling record? This action cannot be undone.',
        showCancel: true,
        confirmText: 'Delete',
        cancelText: 'Cancel',
        onConfirm: () => {
          AlertModal.hide();
          executeDeleteSeedlingRecord(seedlingId, beneficiaryId);
        },
        onCancel: () => {
          AlertModal.hide();
        }
      });
    } else if (confirm('Are you sure you want to delete this seedling record?')) {
      executeDeleteSeedlingRecord(seedlingId, beneficiaryId);
    }
  }

  /**
   * Execute actual seedling record deletion
   */
  async function executeDeleteSeedlingRecord(seedlingId, beneficiaryId) {
    if (typeof LoadingModal !== 'undefined') {
      LoadingModal.show({ title: 'Deleting...', message: 'Removing seedling record...', spinnerColor: '#dc3545' });
    }
    
    try {
      const token = localStorage.getItem('authToken');
      const response = await fetch(`${API_BASE_URL}/seedlings/${seedlingId}`, {
        method: 'DELETE',
        headers: { 'Authorization': `Bearer ${token}` }
      });

      await new Promise(resolve => setTimeout(resolve, 1200));

      if (!response.ok) throw new Error('Failed to delete seedling record');
      
      if (typeof LoadingModal !== 'undefined') LoadingModal.hide();

      if (typeof AlertModal !== 'undefined') {
        AlertModal.show({
          type: 'success',
          title: 'Deleted!',
          message: 'Seedling record has been successfully deleted.',
          hideButton: true,
          autoClose: true,
          autoCloseDelay: 1500,
          borderRadius: 4
        });
      }

      await loadBeneficiaries(); // Reload data

      // Refresh detail panel in-place
      setTimeout(() => {
        if (typeof showDetailPanel === 'function') {
          showDetailPanel(beneficiaryId);
        }
      }, 100);
    } catch (error) {
      console.error('Error deleting seedling record:', error);
      if (typeof LoadingModal !== 'undefined') LoadingModal.hide();
      
      if (typeof AlertModal !== 'undefined') {
        AlertModal.show({
          type: 'error',
          title: 'Delete Failed',
          message: error.message || 'Error deleting seedling record. Please try again.'
        });
      } else {
        alert('Error deleting seedling record. Please try again.');
      }
    }
  }

  /**
   * Edit crop survey - opens the Edit Survey Status Record modal
   */
  function editCropSurvey(surveyId, beneficiaryId) {
    const ben = window.beneficiariesData[beneficiaryId];
    if (!ben) return;
    const rec = (ben.cropSurveys || []).find(r => String(r.id) === String(surveyId));
    if (!rec) return;
    
    openEditSurveyStatusModal(rec, ben);
  }

  /**
   * Delete crop survey - shows confirmation prompt
   */
  function deleteCropSurvey(surveyId, beneficiaryId) {
    if (typeof AlertModal !== 'undefined') {
      AlertModal.show({
        type: 'delete',
        title: 'Delete Crop Survey',
        message: 'Are you sure you want to delete this crop survey record? This action cannot be undone.',
        showCancel: true,
        confirmText: 'Delete',
        cancelText: 'Cancel',
        onConfirm: () => {
          AlertModal.hide();
          executeDeleteCropSurvey(surveyId, beneficiaryId);
        },
        onCancel: () => {
          AlertModal.hide();
        }
      });
    } else if (confirm('Are you sure you want to delete this crop survey record?')) {
      executeDeleteCropSurvey(surveyId, beneficiaryId);
    }
  }

  /**
   * Execute actual crop survey deletion
   */
  async function executeDeleteCropSurvey(surveyId, beneficiaryId) {
    if (typeof LoadingModal !== 'undefined') {
      LoadingModal.show({ title: 'Deleting...', message: 'Removing survey record...', spinnerColor: '#dc3545' });
    }
    
    try {
      const token = localStorage.getItem('authToken');
      const response = await fetch(`${API_BASE_URL}/crop-status/${surveyId}`, {
        method: 'DELETE',
        headers: { 'Authorization': `Bearer ${token}` }
      });

      await new Promise(resolve => setTimeout(resolve, 1200));

      if (!response.ok) throw new Error('Failed to delete survey record');
      
      if (typeof LoadingModal !== 'undefined') LoadingModal.hide();

      if (typeof AlertModal !== 'undefined') {
        AlertModal.show({
          type: 'success',
          title: 'Deleted!',
          message: 'Crop survey record has been successfully deleted.',
          hideButton: true,
          autoClose: true,
          autoCloseDelay: 1500,
          borderRadius: 4
        });
      }

      await loadBeneficiaries(); // Reload data

      // Refresh detail panel in-place
      setTimeout(() => {
        if (typeof showDetailPanel === 'function') {
          showDetailPanel(beneficiaryId);
        }
      }, 100);
    } catch (error) {
      console.error('Error deleting survey record:', error);
      if (typeof LoadingModal !== 'undefined') LoadingModal.hide();
      
      if (typeof AlertModal !== 'undefined') {
        AlertModal.show({
          type: 'error',
          title: 'Delete Failed',
          message: error.message || 'Error deleting crop survey. Please try again.'
        });
      } else {
        alert('Error deleting crop survey. Please try again.');
      }
    }
  }

  /**
   * Close detail panel
   */
  function closeDetailPanel() {
    window.activeBeneficiaryId = null;
    document.getElementById('overlay').classList.add('hidden');
    document.getElementById('detailPanel').classList.add('hidden');
    document.querySelectorAll('.data-table-row').forEach(row => row.classList.remove('active'));
  }

  /**
   * Navigate to the farm monitoring page and highlight the farm plot
   */
  function navigateToFarmPlot(plotId) {
    closeDetailPanel();

    // 1. Tell Sidebar to update active class to farm-monitoring
    window.dispatchEvent(new CustomEvent('navigateToPage', {
      detail: { page: 'farm-monitoring' }
    }));

    // 2. Tell MainContent to display farm-monitoring
    window.dispatchEvent(new CustomEvent('navigationChanged', {
      detail: { page: 'farm-monitoring' }
    }));

    // 3. Focus on the farm plot on the map and select the card in the list
    setTimeout(() => {
      if (window.allFarmPlots) {
        const plot = window.allFarmPlots.find(p => String(p.id) === String(plotId));
        if (plot) {
          // Switch to Farms tab to make farm cards visible
          const tabFarmsBtn = document.getElementById('tabFarmsBtn');
          if (tabFarmsBtn) {
            tabFarmsBtn.click();
          }

          // Highlight and scroll to the card element (without clicking to avoid opening the modal)
          const cards = document.querySelectorAll('.md-card');
          cards.forEach(card => {
            const cardName = card.querySelector('.md-name');
            if (cardName && cardName.textContent.trim() === String(plotId)) {
              document.querySelectorAll('.md-card').forEach(c => c.classList.remove('active'));
              card.classList.add('active');
              card.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }
          });

          // Focus Leaflet map and open the plot popup indicator on the map
          if (window.leafletMap && plot.polygon) {
            window.leafletMap.fitBounds(plot.polygon.getBounds(), { padding: [50, 50] });
            if (plot.marker) {
              plot.marker.openPopup();
            } else {
              plot.polygon.openPopup();
            }
          }
        }
      }
    }, 150);
  }

  /**
   * Handle import click
   */
  function handleImportClick() {
    document.getElementById('fileInput').click();
  }

  /**
   * Handle add record
   */
  function handleAddRecord() {
    if (typeof openAddBeneficiaryModal === 'function') {
      openAddBeneficiaryModal();
    } else {
      console.error('AddingNewBeneficiary modal script not loaded.');
    }
  }

  /**
   * Confirm deletion
   */
  function confirmDeleteBeneficiary(beneficiaryId) {
    const ben = window.beneficiariesData[beneficiaryId];
    const dbId = ben ? ben.id : null;
    if (!dbId) {
      console.error('Database ID not found for beneficiary:', beneficiaryId);
      return;
    }

    if (typeof AlertModal !== 'undefined') {
      AlertModal.show({
        type: 'delete',
        title: 'Delete Beneficiary',
        message: 'Are you sure you want to delete this beneficiary? This action cannot be undone.',
        showCancel: true,
        confirmText: 'Delete',
        cancelText: 'Cancel',
        onConfirm: () => {
          AlertModal.hide();
          executeDeleteBeneficiary(dbId);
        },
        onCancel: () => {
          AlertModal.hide();
        }
      });
    } else if (typeof LoadingModal !== 'undefined' && LoadingModal.showConfirm) {
      LoadingModal.showConfirm({
        title: 'Delete Beneficiary',
        message: 'Are you sure you want to delete this beneficiary? This action cannot be undone.',
        confirmText: 'Delete',
        confirmColor: '#dc3545',
        onConfirm: () => executeDeleteBeneficiary(dbId)
      });
    } else if (confirm('Are you sure you want to delete this beneficiary?')) {
      executeDeleteBeneficiary(dbId);
    }
  }

  /**
   * Execute actual deletion API call
   */
  async function executeDeleteBeneficiary(dbId) {
    if (typeof LoadingModal !== 'undefined') {
      LoadingModal.show({ title: 'Deleting...', message: 'Removing beneficiary record', spinnerColor: '#dc3545' });
    }
    
    try {
      const token = localStorage.getItem('authToken');
      const response = await fetch(`${API_BASE_URL}/beneficiaries/${dbId}`, {
        method: 'DELETE',
        headers: { 'Authorization': `Bearer ${token}` }
      });

      // Add a slight delay to ensure the loading modal is visible as requested
      await new Promise(resolve => setTimeout(resolve, 1200));

      if (!response.ok) throw new Error('Failed to delete beneficiary');
      
      if (typeof LoadingModal !== 'undefined') LoadingModal.hide();
      closeDetailPanel();
      loadBeneficiaries(); // Refresh list after deletion

      if (typeof AlertModalTypes !== 'undefined') {
        AlertModalTypes.showDeleteSuccess({
          title: 'Delete Successful',
          message: 'Beneficiary has been successfully deleted.'
        });
      }
    } catch (error) {
      console.error('Error deleting beneficiary:', error);
      if (typeof LoadingModal !== 'undefined') LoadingModal.hide();
      
      if (typeof AlertModal !== 'undefined') {
        AlertModal.show({
          type: 'error',
          title: 'Delete Failed',
          message: 'Error deleting beneficiary. Please try again.'
        });
      } else {
        alert('Error deleting beneficiary. Please try again.');
      }
    }
  }

  /**
   * Initialize event listeners and fetch data
   */
  document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('overlay').addEventListener('click', closeDetailPanel);
    loadBeneficiaries();
  });
</script>

<?php include_once '../ui/AddingNewBeneficiary.php'; ?>
<?php include_once '../ui/EditBenefeciaryDetails.php'; ?>
<?php include_once '../ui/AddNewSeedlingRecord.php'; ?>
<?php include_once '../ui/AddNewSurveyStatus.php'; ?>
<?php include_once '../ui/EditCoffeeSeedlingRecord.php'; ?>
<?php include_once '../ui/EditSurveyStatusRecord.php'; ?>
