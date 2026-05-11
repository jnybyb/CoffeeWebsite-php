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
   * Fetch beneficiaries data from backend API
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
      const response = await fetch(`${API_BASE_URL}/beneficiaries`, {
        headers: { 'Authorization': `Bearer ${token}` }
      });

      // Handle unauthorized or expired token
      if (response.status === 401 || response.status === 403) {
        localStorage.removeItem('authToken');
        window.location.href = '../../login.php';
        return;
      }

      if (!response.ok) throw new Error('Failed to fetch data');

      let beneficiaries = await response.json();
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
      const address = [ben.purok, ben.barangay, ben.municipality].filter(Boolean).join(', ') || 'Unknown';
      const farmCount = ben.farms ? ben.farms.length : 0;
      const totalSeedlings = ben.totalSeedlings || 0;

      const initial = fullName.charAt(0).toUpperCase() || '?';
      const avatarHtml = ben.picture 
        ? `<img src="${ben.picture}" alt="${fullName}" style="width:24px;height:24px;border-radius:50%;object-fit:cover;">`
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
        const address = String([ben.purok, ben.barangay, ben.municipality].filter(Boolean).join(' ')).toLowerCase();
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
   * Show detail panel pulling from JS cache
   */
  function showDetailPanel(beneficiaryId) {
    const overlay = document.getElementById('overlay');
    const panel = document.getElementById('detailPanel');
    const ben = window.beneficiariesData[beneficiaryId];
    
    if (ben) {
      document.getElementById('detailID').textContent = ben.beneficiaryId || ben._id || '-';
      document.getElementById('detailName').textContent = `${ben.firstName || ''} ${ben.lastName || ''}`.trim() || '-';
      document.getElementById('detailAddress').textContent = [ben.purok, ben.barangay, ben.municipality].filter(Boolean).join(', ') || '-';
      document.getElementById('detailGender').textContent = ben.gender || '-';
      
      let bdate = ben.birthDate ? new Date(ben.birthDate).toLocaleDateString() : '-';
      document.getElementById('detailBirthDate').textContent = bdate;
      
      document.getElementById('detailCellphone').textContent = ben.cellphoneNumber || '-';
    }
    
    overlay.classList.remove('hidden');
    panel.classList.remove('hidden');
  }

  /**
   * Close detail panel
   */
  function closeDetailPanel() {
    document.getElementById('overlay').classList.add('hidden');
    document.getElementById('detailPanel').classList.add('hidden');
    document.querySelectorAll('.data-table-row').forEach(row => row.classList.remove('active'));
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
   * Initialize event listeners and fetch data
   */
  document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('overlay').addEventListener('click', closeDetailPanel);
    loadBeneficiaries();
  });
</script>

<?php include_once '../ui/AddingNewBeneficiary.php'; ?>
