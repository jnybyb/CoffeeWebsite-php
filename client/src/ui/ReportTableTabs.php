<?php
/**
 * TableTabs Component
 * Renders navigation tabs for different report types with search, filter, and export functionality
 */

$activeTab = $activeTab ?? 'Beneficiary List';
$tabs = ['Beneficiary List', 'Farm Location', 'Seedling Record', 'Crop Survey Status', 'Recent Activities'];
?>

<style>
.table-tabs-container {
  padding: 0rem;
  margin-bottom: 0.5rem;
  background-color: transparent;
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.table-tabs-nav {
  display: flex;
  gap: 0.5rem;
  flex: 1;
}

.table-tab-button {
  padding: 0.5rem 1rem;
  background-color: transparent;
  border: none;
  border-bottom: 2px solid transparent;
  color: #666;
  cursor: pointer;
  font-size: 0.7rem;
  font-weight: 500;
  transition: all 0.1s ease;
  border-radius: 4px 4px 0 0;
  white-space: nowrap;
  transform: scale(1);
  font-family: var(--font-main, 'Montserrat', sans-serif);
}

.table-tab-button.active {
  border-bottom: 2px solid var(--dark-green, #055035);
  color: var(--dark-green, #055035);
  font-weight: 600;
}

.table-tab-button:hover {
  background-color: #f0f9f0;
  color: var(--dark-green, #055035);
  transform: scale(1.05);
}

.table-tabs-actions {
  display: flex;
  align-items: center;
  gap: 0.5rem;
}

.table-tabs-search-wrapper {
  position: relative;
  display: flex;
  align-items: center;
}

.table-tabs-search-icon {
  position: absolute;
  left: 0.5rem;
  color: #666;
  pointer-events: none;
  width: 14px;
  height: 14px;
}

.table-tabs-search-input {
  padding: 0.4rem 0.7rem 0.4rem 2rem;
  border: 1px solid #d1d5db;
  border-radius: 4px;
  font-size: 0.6rem;
  width: 280px;
  outline: none;
  transition: all 0.2s ease;
  font-family: var(--font-main, 'Montserrat', sans-serif);
}

.table-tabs-search-input:focus {
  border-color: var(--dark-green, #055035);
  box-shadow: 0 0 0 2px rgba(44, 85, 48, 0.1);
}

.table-tabs-btn {
  display: flex;
  align-items: center;
  gap: 0.3rem;
  padding: 0.4rem 0.7rem;
  background-color: var(--white, #fff);
  color: var(--dark-green, #055035);
  border: 1px solid var(--dark-green, #055035);
  border-radius: 4px;
  cursor: pointer;
  font-size: 0.6rem;
  font-weight: 500;
  transition: all 0.1s ease;
  transform: scale(1);
  font-family: var(--font-main, 'Montserrat', sans-serif);
}

.table-tabs-btn:hover {
  transform: scale(1.05);
}

.table-tabs-btn-active {
  background-color: var(--dark-green, #055035);
  color: white;
  border: none;
}

.table-tabs-export-btn {
  transition: all 0.2s ease;
}

.table-tabs-export-btn:hover {
  background-color: var(--dark-green, #055035);
  color: white;
}

.table-tabs-export-dropdown {
  position: absolute;
  top: 100%;
  right: 0;
  margin-top: 0.25rem;
  background-color: white;
  border: 1px solid #e0e0e0;
  border-radius: 4px;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
  z-index: 1000;
  min-width: 150px;
  display: none;
}

.table-tabs-export-dropdown.show {
  display: block;
}

.table-tabs-dropdown-item {
  width: 100%;
  padding: 0.5rem 0.75rem;
  border: none;
  background: white;
  text-align: left;
  cursor: pointer;
  font-size: 0.65rem;
  display: flex;
  align-items: center;
  gap: 0.5rem;
  color: #333;
  transition: background-color 0.2s ease;
  font-family: var(--font-main, 'Montserrat', sans-serif);
}

.table-tabs-dropdown-item:hover {
  background-color: #f5f5f5;
}

/* SVG icon styles */
.tt-icon {
  width: 12px;
  height: 12px;
  fill: currentColor;
}
.tt-icon-lg {
  width: 14px;
  height: 14px;
}
</style>

<div class="table-tabs-container">
  <!-- Tab Navigation Section -->
  <div class="table-tabs-nav" id="tableTabsNav">
    <?php foreach ($tabs as $tab): ?>
      <button 
        class="table-tab-button <?php echo $activeTab === $tab ? 'active' : ''; ?>"
        onclick="handleTabChange(this, '<?php echo htmlspecialchars($tab); ?>')"
      >
        <?php echo htmlspecialchars($tab); ?>
      </button>
    <?php endforeach; ?>
  </div>
  
  <!-- Action Buttons Section: Search, Filter, Export -->
  <div class="table-tabs-actions">
    <!-- Search Bar -->
    <div class="table-tabs-search-wrapper">
      <svg class="table-tabs-search-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M416 208c0 45.9-14.9 88.3-40 122.7L502.6 457.4c12.5 12.5 12.5 32.8 0 45.3s-32.8 12.5-45.3 0L330.7 376c-34.4 25.2-76.8 40-122.7 40C93.1 416 0 322.9 0 208S93.1 0 208 0S416 93.1 416 208zM208 352a144 144 0 1 0 0-288 144 144 0 1 0 0 288z"/></svg>
      <input 
        type="text" 
        class="table-tabs-search-input" 
        placeholder="Search..."
        id="ttSearchInput"
      />
    </div>
    
    <!-- Filter Toggle Button -->
    <button class="table-tabs-btn" id="ttFilterBtn" onclick="toggleFilter()">
      <img src="../../assets/icons/filter.png" alt="Filter" style="width: 12px; height: 12px; object-fit: contain;" />
      <span id="ttFilterText">Add Filter</span>
    </button>

    <!-- Export Button -->
    <div style="position: relative;">
      <button class="table-tabs-btn table-tabs-export-btn" onclick="toggleExportDropdown(event)">
        <img src="../../assets/icons/export.png" alt="Export" style="width: 12px; height: 12px; object-fit: contain;" />
        <span>Export</span>
        <svg class="tt-icon" id="ttExportArrow" style="transition: transform 0.2s;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M233.4 406.6c12.5 12.5 32.8 12.5 45.3 0l192-192c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L256 338.7 86.6 169.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3l192 192z"/></svg>
      </button>
      
      <!-- Export Dropdown Menu -->
      <div class="table-tabs-export-dropdown" id="ttExportDropdown">
        <button class="table-tabs-dropdown-item" onclick="handleExport('excel')">
          <svg class="tt-icon-lg" style="color: #107C41;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><path fill="currentColor" d="M64 0C28.7 0 0 28.7 0 64V448c0 35.3 28.7 64 64 64H320c35.3 0 64-28.7 64-64V160H256c-17.7 0-32-14.3-32-32V0H64zM256 0V128H384L256 0zM155.7 250.2L192 302.5l36.3-52.3c7.6-10.9 22.8-13.6 33.7-6s13.6 22.8 6 33.7l-55.3 79.7 55.3 79.7c7.6 10.9 4.9 26.1-6 33.7s-26.1 4.9-33.7-6L192 412.8l-36.3 52.3c-7.6 10.9-22.8 13.6-33.7 6s-13.6-22.8-6-33.7l55.3-79.7-55.3-79.7c-7.6-10.9-4.9-26.1 6-33.7s26.1-4.9 33.7 6z"/></svg>
          <span>Export as Excel</span>
        </button>
        <button class="table-tabs-dropdown-item" onclick="handleExport('pdf')">
          <svg class="tt-icon-lg" style="color: #DC3545;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M64 464l48 0 0 48-48 0c-35.3 0-64-28.7-64-64L0 64C0 28.7 28.7 0 64 0L229.5 0c17 0 33.3 6.7 45.3 18.7l90.5 90.5c12 12 18.7 28.3 18.7 45.3L384 304l-48 0 0-144-80 0c-17.7 0-32-14.3-32-32l0-80L64 48c-8.8 0-16 7.2-16 16l0 384c0 8.8 7.2 16 16 16zM176 352h32c30.9 0 56 25.1 56 56s-25.1 56-56 56H192v32c0 8.8-7.2 16-16 16s-16-7.2-16-16V352zm32 80c13.3 0 24-10.7 24-24s-10.7-24-24-24H192v48h16zm96-80h32c26.5 0 48 21.5 48 48v64c0 26.5-21.5 48-48 48H304c-8.8 0-16-7.2-16-16V352zm32 128c8.8 0 16-7.2 16-16V400c0-8.8-7.2-16-16-16H320v96h16zm80-112c0-8.8 7.2-16 16-16h48c8.8 0 16 7.2 16 16s-7.2 16-16 16H448v32h32c8.8 0 16 7.2 16 16s-7.2 16-16 16H448v48c0 8.8-7.2 16-16 16s-16-7.2-16-16V368zM256 0v128h128L256 0z"/></svg>
          <span>Export as PDF</span>
        </button>
      </div>
    </div>
  </div>
</div>

<script>
  let isTableFilterActive = false;

  function handleTabChange(buttonElem, tabName) {
    // Deselect if already active, else select
    const isCurrentlyActive = buttonElem.classList.contains('active');
    
    // Remove active class from all tabs
    const tabs = document.querySelectorAll('.table-tab-button');
    tabs.forEach(tab => tab.classList.remove('active'));

    if (!isCurrentlyActive) {
      buttonElem.classList.add('active');
      // Dispatch custom event for tab change
      document.dispatchEvent(new CustomEvent('tableTabChanged', { detail: { tab: tabName } }));
    } else {
      // Dispatch event for clearing tab
      document.dispatchEvent(new CustomEvent('tableTabChanged', { detail: { tab: null } }));
    }
  }

  function toggleFilter() {
    isTableFilterActive = !isTableFilterActive;
    const filterBtn = document.getElementById('ttFilterBtn');
    const filterText = document.getElementById('ttFilterText');
    
    if (isTableFilterActive) {
      filterBtn.classList.add('table-tabs-btn-active');
      filterText.innerText = 'Clear Filter';
    } else {
      filterBtn.classList.remove('table-tabs-btn-active');
      filterText.innerText = 'Add Filter';
    }
    
    // Dispatch event
    document.dispatchEvent(new CustomEvent('tableFilterToggled', { detail: { isActive: isTableFilterActive } }));
  }

  function toggleExportDropdown(event) {
    event.stopPropagation();
    const dropdown = document.getElementById('ttExportDropdown');
    dropdown.classList.toggle('show');
    
    const arrow = document.getElementById('ttExportArrow');
    if (dropdown.classList.contains('show')) {
      arrow.style.transform = 'rotate(180deg)';
    } else {
      arrow.style.transform = 'rotate(0deg)';
    }
  }

  function handleExport(type) {
    const dropdown = document.getElementById('ttExportDropdown');
    dropdown.classList.remove('show');
    document.getElementById('ttExportArrow').style.transform = 'rotate(0deg)';
    
    // Dispatch event
    document.dispatchEvent(new CustomEvent('tableExportTriggered', { detail: { type: type } }));
  }

  // Close dropdown when clicking outside
  document.addEventListener('click', function(event) {
    const dropdown = document.getElementById('ttExportDropdown');
    if (dropdown && dropdown.classList.contains('show')) {
      dropdown.classList.remove('show');
      document.getElementById('ttExportArrow').style.transform = 'rotate(0deg)';
    }
  });

  // Handle search input
  const ttSearchInput = document.getElementById('ttSearchInput');
  if (ttSearchInput) {
    ttSearchInput.addEventListener('input', function(e) {
      document.dispatchEvent(new CustomEvent('tableSearchChanged', { detail: { query: e.target.value } }));
    });
  }
</script>
