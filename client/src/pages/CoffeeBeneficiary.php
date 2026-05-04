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

<?php include '../ui/DataTable.php'; ?>

<script>
  /**
   * Filter table rows based on search input
   */
  function filterTable() {
    const searchInput = document.getElementById('searchInput');
    if (!searchInput) return;
    const searchTerm = searchInput.value.toLowerCase();

    const rows = document.querySelectorAll('.data-table-row');
    let visibleRows = 0;

    rows.forEach(row => {
      const text = row.textContent.toLowerCase();
      if (text.includes(searchTerm)) {
        row.style.display = '';
        visibleRows++;
      } else {
        row.style.display = 'none';
      }
    });

    // Show empty state if no rows visible
    const emptyState = document.getElementById('emptyState');
    if (visibleRows === 0 && searchTerm.length > 0) {
      emptyState.classList.remove('hidden');
    } else {
      emptyState.classList.add('hidden');
    }
  }

  /**
   * Select a row and show detail panel
   */
  function selectRow(element, beneficiaryId) {
    // Remove active class from all rows
    document.querySelectorAll('.data-table-row').forEach(row => {
      row.classList.remove('active');
    });
    
    // Add active class to selected row
    element.classList.add('active');
    
    // Show detail panel with data
    showDetailPanel(beneficiaryId);
  }

  /**
   * Show detail panel
   */
  function showDetailPanel(beneficiaryId) {
    const overlay = document.getElementById('overlay');
    const panel = document.getElementById('detailPanel');
    const row = document.querySelector(`[onclick*="${beneficiaryId}"]`);
    
    if (!row) return;
    
    const cells = row.querySelectorAll('.data-table-cell');
    
    // Populate detail panel
    document.getElementById('detailID').textContent = cells[0].textContent.trim() || '-';
    document.getElementById('detailName').textContent = cells[1].querySelector('span')?.textContent.trim() || '-';
    document.getElementById('detailAddress').textContent = cells[2].textContent.trim() || '-';
    document.getElementById('detailGender').textContent = '-';
    document.getElementById('detailBirthDate').textContent = '-';
    document.getElementById('detailCellphone').textContent = '-';
    
    overlay.classList.remove('hidden');
    panel.classList.remove('hidden');
  }

  /**
   * Close detail panel
   */
  function closeDetailPanel() {
    const overlay = document.getElementById('overlay');
    const panel = document.getElementById('detailPanel');
    const rows = document.querySelectorAll('.data-table-row');
    
    overlay.classList.add('hidden');
    panel.classList.add('hidden');
    rows.forEach(row => row.classList.remove('active'));
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
    alert('Add Record modal will open here');
  }

  /**
   * Initialize event listeners
   */
  document.addEventListener('DOMContentLoaded', function() {
    // Close detail panel when overlay is clicked
    document.getElementById('overlay').addEventListener('click', closeDetailPanel);
  });
</script>
