<?php
/**
 * FilterSection Component
 * Renders dynamic filter options for different report types
 */
$activeTab = $activeTab ?? '';
?>

<style>
  .filter-section-wrapper {
    padding: 1rem 0.7rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    flex-wrap: wrap;
    border: 1px solid #d1d5db;
    border-radius: 4px;
    margin-bottom: 0.5rem;
    background-color: var(--white, #ffffff);
    font-family: var(--font-main, 'Montserrat', sans-serif);
  }

  .filter-field-group {
    display: flex;
    flex-direction: column;
    gap: 0.15rem;
    position: relative;
  }

  .filter-label {
    font-size: 0.6rem;
    color: #666;
    font-weight: 500;
  }

  .filter-select, .filter-input {
    padding: 0.3rem 0.4rem;
    border: 1px solid #d1d5db;
    border-radius: 4px;
    font-size: 0.65rem;
    outline: none;
    background-color: white;
    color: #1f2937;
    font-family: var(--font-main, 'Montserrat', sans-serif);
  }

  .filter-select {
    cursor: pointer;
  }

  .filter-select:disabled {
    cursor: not-allowed;
    background-color: #f3f4f6;
  }

  .filter-btn-trigger {
    padding: 0.3rem 0.4rem;
    border: 1px solid #d1d5db;
    border-radius: 4px;
    font-size: 0.65rem;
    width: 150px;
    cursor: pointer;
    background-color: white;
    color: #9ca3af;
    display: flex;
    justify-content: space-between;
    align-items: center;
    text-align: left;
    font-family: var(--font-main, 'Montserrat', sans-serif);
  }

  .filter-btn-trigger.has-value {
    color: #1f2937;
  }

  .filter-dropdown-menu {
    position: absolute;
    top: 100%;
    left: 0;
    margin-top: 0.25rem;
    background-color: white;
    border: 1px solid #d1d5db;
    border-radius: 4px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    z-index: 1000;
    width: 280px;
    max-height: 400px;
    overflow: auto;
    display: none;
  }

  .filter-dropdown-menu.show {
    display: block;
  }

  .filter-dropdown-group-label {
    display: flex;
    align-items: center;
    padding: 0.5rem 0.75rem;
    background-color: #f3f4f6;
    font-size: 0.6rem;
    font-weight: 600;
    color: #4b5563;
    border-bottom: 1px solid #e5e7eb;
    cursor: pointer;
    user-select: none;
  }

  .filter-dropdown-item-label {
    display: flex;
    align-items: center;
    padding: 0.5rem 0.75rem;
    padding-left: 2rem;
    cursor: pointer;
    font-size: 0.65rem;
    color: #374151;
    background-color: white;
    transition: background-color 0.15s ease;
    user-select: none;
  }

  .filter-dropdown-item-label.selected {
    background-color: #f0f9f0;
  }

  .filter-dropdown-item-label:hover:not(.selected) {
    background-color: #f9fafb;
  }

  .filter-checkbox {
    margin-right: 0.5rem;
    cursor: pointer;
    accent-color: var(--dark-green, #055035);
  }

  .filter-dropdown-footer {
    padding: 0.5rem 0.75rem;
    border-top: 1px solid #e5e7eb;
    display: flex;
    justify-content: space-between;
    align-items: center;
    background-color: #f9fafb;
    position: sticky;
    bottom: 0;
    z-index: 1;
  }

  .filter-footer-btn-link {
    padding: 0.2rem 0.5rem;
    font-size: 0.6rem;
    background-color: transparent;
    color: var(--dark-green, #055035);
    border: none;
    cursor: pointer;
    font-weight: 500;
    transition: all 0.1s ease;
    transform: scale(1);
    font-family: var(--font-main, 'Montserrat', sans-serif);
  }

  .filter-footer-btn-link.danger {
    color: #dc3545;
  }

  .filter-footer-btn-link:hover {
    transform: scale(1.1);
  }

  .filter-footer-btn-ok {
    padding: 0.3rem 0.8rem;
    font-size: 0.6rem;
    background-color: var(--dark-green, #055035);
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-weight: 500;
    transition: all 0.1s ease;
    transform: scale(1);
    font-family: var(--font-main, 'Montserrat', sans-serif);
  }

  .filter-footer-btn-ok:hover {
    transform: scale(1.05);
  }

  .filter-apply-btn {
    padding: 0.4rem 1rem;
    background-color: var(--dark-green, #055035);
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 0.65rem;
    font-weight: 500;
    width: auto;
    transition: all 0.1s ease;
    transform: scale(1);
    font-family: var(--font-main, 'Montserrat', sans-serif);
  }

  .filter-apply-btn:hover {
    transform: scale(1.05);
  }

  .filter-range-container {
    display: flex;
    gap: 0.3rem;
    align-items: center;
  }

  /* Utility classes */
  .filter-hidden {
    display: none !important;
  }
</style>

<div class="filter-section-wrapper" id="filterSectionWrapper">
  <!-- Multi-select Attribute Dropdown - Hidden for Recent Activities -->
  <div class="filter-field-group" id="attributeDropdownGroup">
    <span class="filter-label">All Attributes</span>
    <button class="filter-btn-trigger" id="attributeDropdownBtn" onclick="toggleFilterAttributeDropdown(event)">
      <span id="selectedAttributesCount">Select attributes</span>
      <!-- Arrow down SVG -->
      <svg id="attributeArrowDown" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
      <!-- Arrow up SVG -->
      <svg id="attributeArrowUp" class="filter-hidden" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="18 15 12 9 6 15"></polyline></svg>
    </button>

    <!-- Dropdown Menu -->
    <div class="filter-dropdown-menu" id="attributeDropdownMenu">
      <!-- Group: Beneficiary List -->
      <div class="filter-table-group" data-table="Beneficiary List">
        <label class="filter-dropdown-group-label">
          <input type="checkbox" class="filter-checkbox group-checkbox" onchange="toggleTableAttributes('Beneficiary List', this)" />
          <span>Beneficiary List</span>
        </label>
        <div class="filter-group-items">
          <label class="filter-dropdown-item-label" data-attr="ben_id">
            <input type="checkbox" class="filter-checkbox attr-checkbox" value="ben_id" onchange="handleAttributeCheckboxChange(this)" />
            <span>Beneficiary ID</span>
          </label>
          <label class="filter-dropdown-item-label" data-attr="ben_fullname">
            <input type="checkbox" class="filter-checkbox attr-checkbox" value="ben_fullname" onchange="handleAttributeCheckboxChange(this)" />
            <span>Full Name</span>
          </label>
          <label class="filter-dropdown-item-label" data-attr="ben_gender">
            <input type="checkbox" class="filter-checkbox attr-checkbox" value="ben_gender" onchange="handleAttributeCheckboxChange(this)" />
            <span>Gender</span>
          </label>
          <label class="filter-dropdown-item-label" data-attr="ben_birthdate">
            <input type="checkbox" class="filter-checkbox attr-checkbox" value="ben_birthdate" onchange="handleAttributeCheckboxChange(this)" />
            <span>Birth Date</span>
          </label>
          <label class="filter-dropdown-item-label" data-attr="ben_age">
            <input type="checkbox" class="filter-checkbox attr-checkbox" value="ben_age" onchange="handleAttributeCheckboxChange(this)" />
            <span>Age</span>
          </label>
          <label class="filter-dropdown-item-label" data-attr="ben_cellphone">
            <input type="checkbox" class="filter-checkbox attr-checkbox" value="ben_cellphone" onchange="handleAttributeCheckboxChange(this)" />
            <span>Cellphone</span>
          </label>
          <label class="filter-dropdown-item-label" data-attr="ben_address">
            <input type="checkbox" class="filter-checkbox attr-checkbox" value="ben_address" onchange="handleAttributeCheckboxChange(this)" />
            <span>Address</span>
          </label>
          <label class="filter-dropdown-item-label" data-attr="ben_marital">
            <input type="checkbox" class="filter-checkbox attr-checkbox" value="ben_marital" onchange="handleAttributeCheckboxChange(this)" />
            <span>Marital Status</span>
          </label>
        </div>
      </div>

      <!-- Group: Farm Location -->
      <div class="filter-table-group" data-table="Farm Location">
        <label class="filter-dropdown-group-label">
          <input type="checkbox" class="filter-checkbox group-checkbox" onchange="toggleTableAttributes('Farm Location', this)" />
          <span>Farm Location</span>
        </label>
        <div class="filter-group-items">
          <label class="filter-dropdown-item-label" data-attr="farm_plot_id">
            <input type="checkbox" class="filter-checkbox attr-checkbox" value="farm_plot_id" onchange="handleAttributeCheckboxChange(this)" />
            <span>Plot ID</span>
          </label>
          <label class="filter-dropdown-item-label" data-attr="farm_beneficiary">
            <input type="checkbox" class="filter-checkbox attr-checkbox" value="farm_beneficiary" onchange="handleAttributeCheckboxChange(this)" />
            <span>Farm Beneficiary</span>
          </label>
          <label class="filter-dropdown-item-label" data-attr="farm_hectares">
            <input type="checkbox" class="filter-checkbox attr-checkbox" value="farm_hectares" onchange="handleAttributeCheckboxChange(this)" />
            <span>Hectares</span>
          </label>
          <label class="filter-dropdown-item-label" data-attr="farm_address">
            <input type="checkbox" class="filter-checkbox attr-checkbox" value="farm_address" onchange="handleAttributeCheckboxChange(this)" />
            <span>Address</span>
          </label>
          <label class="filter-dropdown-item-label" data-attr="farm_coordinates">
            <input type="checkbox" class="filter-checkbox attr-checkbox" value="farm_coordinates" onchange="handleAttributeCheckboxChange(this)" />
            <span>Coordinates</span>
          </label>
        </div>
      </div>

      <!-- Group: Seedling Record -->
      <div class="filter-table-group" data-table="Seedling Record">
        <label class="filter-dropdown-group-label">
          <input type="checkbox" class="filter-checkbox group-checkbox" onchange="toggleTableAttributes('Seedling Record', this)" />
          <span>Seedling Record</span>
        </label>
        <div class="filter-group-items">
          <label class="filter-dropdown-item-label" data-attr="seed_id">
            <input type="checkbox" class="filter-checkbox attr-checkbox" value="seed_id" onchange="handleAttributeCheckboxChange(this)" />
            <span>Seedling ID</span>
          </label>
          <label class="filter-dropdown-item-label" data-attr="seed_ben_id">
            <input type="checkbox" class="filter-checkbox attr-checkbox" value="seed_ben_id" onchange="handleAttributeCheckboxChange(this)" />
            <span>Seedling Beneficiary ID</span>
          </label>
          <label class="filter-dropdown-item-label" data-attr="seed_received">
            <input type="checkbox" class="filter-checkbox attr-checkbox" value="seed_received" onchange="handleAttributeCheckboxChange(this)" />
            <span>Seedlings Received</span>
          </label>
          <label class="filter-dropdown-item-label" data-attr="seed_date_received">
            <input type="checkbox" class="filter-checkbox attr-checkbox" value="seed_date_received" onchange="handleAttributeCheckboxChange(this)" />
            <span>Date Received</span>
          </label>
          <label class="filter-dropdown-item-label" data-attr="seed_planted">
            <input type="checkbox" class="filter-checkbox attr-checkbox" value="seed_planted" onchange="handleAttributeCheckboxChange(this)" />
            <span>Seedlings Planted</span>
          </label>
          <label class="filter-dropdown-item-label" data-attr="seed_plot_id">
            <input type="checkbox" class="filter-checkbox attr-checkbox" value="seed_plot_id" onchange="handleAttributeCheckboxChange(this)" />
            <span>Seedling Plot ID</span>
          </label>
          <label class="filter-dropdown-item-label" data-attr="seed_planting_date">
            <input type="checkbox" class="filter-checkbox attr-checkbox" value="seed_planting_date" onchange="handleAttributeCheckboxChange(this)" />
            <span>Planting Date</span>
          </label>
        </div>
      </div>

      <!-- Group: Crop Survey Status -->
      <div class="filter-table-group" data-table="Crop Survey Status">
        <label class="filter-dropdown-group-label">
          <input type="checkbox" class="filter-checkbox group-checkbox" onchange="toggleTableAttributes('Crop Survey Status', this)" />
          <span>Crop Survey Status</span>
        </label>
        <div class="filter-group-items">
          <label class="filter-dropdown-item-label" data-attr="crop_id">
            <input type="checkbox" class="filter-checkbox attr-checkbox" value="crop_id" onchange="handleAttributeCheckboxChange(this)" />
            <span>Survey ID</span>
          </label>
          <label class="filter-dropdown-item-label" data-attr="crop_ben_id">
            <input type="checkbox" class="filter-checkbox attr-checkbox" value="crop_ben_id" onchange="handleAttributeCheckboxChange(this)" />
            <span>Beneficiary ID</span>
          </label>
          <label class="filter-dropdown-item-label" data-attr="crop_survey_date">
            <input type="checkbox" class="filter-checkbox attr-checkbox" value="crop_survey_date" onchange="handleAttributeCheckboxChange(this)" />
            <span>Survey Date</span>
          </label>
          <label class="filter-dropdown-item-label" data-attr="crop_surveyer">
            <input type="checkbox" class="filter-checkbox attr-checkbox" value="crop_surveyer" onchange="handleAttributeCheckboxChange(this)" />
            <span>Surveyer</span>
          </label>
          <label class="filter-dropdown-item-label" data-attr="crop_beneficiary">
            <input type="checkbox" class="filter-checkbox attr-checkbox" value="crop_beneficiary" onchange="handleAttributeCheckboxChange(this)" />
            <span>Crop Beneficiary</span>
          </label>
          <label class="filter-dropdown-item-label" data-attr="crop_alive">
            <input type="checkbox" class="filter-checkbox attr-checkbox" value="crop_alive" onchange="handleAttributeCheckboxChange(this)" />
            <span>Alive Crops</span>
          </label>
          <label class="filter-dropdown-item-label" data-attr="crop_dead">
            <input type="checkbox" class="filter-checkbox attr-checkbox" value="crop_dead" onchange="handleAttributeCheckboxChange(this)" />
            <span>Dead Crops</span>
          </label>
          <label class="filter-dropdown-item-label" data-attr="crop_plot">
            <input type="checkbox" class="filter-checkbox attr-checkbox" value="crop_plot" onchange="handleAttributeCheckboxChange(this)" />
            <span>Crop Plot</span>
          </label>
        </div>
      </div>

      <!-- Group: Recent Activities -->
      <div class="filter-table-group" data-table="Recent Activities">
        <label class="filter-dropdown-group-label">
          <input type="checkbox" class="filter-checkbox group-checkbox" onchange="toggleTableAttributes('Recent Activities', this)" />
          <span>Recent Activities</span>
        </label>
        <div class="filter-group-items">
          <label class="filter-dropdown-item-label" data-attr="act_id">
            <input type="checkbox" class="filter-checkbox attr-checkbox" value="act_id" onchange="handleAttributeCheckboxChange(this)" />
            <span>Activity ID</span>
          </label>
          <label class="filter-dropdown-item-label" data-attr="act_type">
            <input type="checkbox" class="filter-checkbox attr-checkbox" value="act_type" onchange="handleAttributeCheckboxChange(this)" />
            <span>Activity Type</span>
          </label>
          <label class="filter-dropdown-item-label" data-attr="act_action">
            <input type="checkbox" class="filter-checkbox attr-checkbox" value="act_action" onchange="handleAttributeCheckboxChange(this)" />
            <span>Action</span>
          </label>
          <label class="filter-dropdown-item-label" data-attr="act_timestamp">
            <input type="checkbox" class="filter-checkbox attr-checkbox" value="act_timestamp" onchange="handleAttributeCheckboxChange(this)" />
            <span>Timestamp</span>
          </label>
          <label class="filter-dropdown-item-label" data-attr="act_user">
            <input type="checkbox" class="filter-checkbox attr-checkbox" value="act_user" onchange="handleAttributeCheckboxChange(this)" />
            <span>User</span>
          </label>
        </div>
      </div>

      <!-- Dropdown Footer -->
      <div class="filter-dropdown-footer">
        <div style="display: flex; gap: 0.5rem;">
          <button class="filter-footer-btn-link" id="filterSelectAllBtn" onclick="toggleSelectAllAttributes(event)">Select All</button>
          <button class="filter-footer-btn-link danger" onclick="clearAllAttributes(event)">Clear</button>
        </div>
        <button class="filter-footer-btn-ok" onclick="closeFilterAttributeDropdown(event)">OK</button>
      </div>
    </div>
  </div>

  <!-- Tab-Specific Filters -->
  
  <!-- Tab Specific: Beneficiary List -->
  <div class="filter-field-group filter-tab-specific filter-tab-beneficiary filter-hidden">
    <span class="filter-label">Gender</span>
    <select class="filter-select" id="filterGender" style="width: 110px;">
      <option value="">All gender</option>
      <option value="Male">Male</option>
      <option value="Female">Female</option>
    </select>
  </div>
  <div class="filter-field-group filter-tab-specific filter-tab-beneficiary filter-hidden">
    <span class="filter-label">Marital Status</span>
    <select class="filter-select" id="filterMaritalStatus" style="width: 120px;">
      <option value="">All status</option>
      <option value="Single">Single</option>
      <option value="Married">Married</option>
      <option value="Widowed">Widowed</option>
      <option value="Separated">Separated</option>
    </select>
  </div>
  <div class="filter-field-group filter-tab-specific filter-tab-beneficiary filter-hidden">
    <span class="filter-label">Birthdate</span>
    <div class="filter-range-container">
      <input type="date" class="filter-input" id="filterBirthdateFrom" style="width: 120px;" />
      <span class="filter-label">-</span>
      <input type="date" class="filter-input" id="filterBirthdateTo" style="width: 120px;" />
    </div>
  </div>

  <!-- Tab Specific: Farm Location -->
  <div class="filter-field-group filter-tab-specific filter-tab-farm filter-hidden">
    <span class="filter-label">Hectares</span>
    <div class="filter-range-container">
      <input type="number" min="0" step="0.01" placeholder="Min" class="filter-input" id="filterHectaresMin" style="width: 70px;" />
      <span class="filter-label">-</span>
      <input type="number" min="0" step="0.01" placeholder="Max" class="filter-input" id="filterHectaresMax" style="width: 70px;" />
    </div>
  </div>

  <!-- Tab Specific: Seedling Record -->
  <div class="filter-field-group filter-tab-specific filter-tab-seedling filter-hidden">
    <span class="filter-label">Date Range</span>
    <div class="filter-range-container">
      <input type="date" class="filter-input" id="filterSeedlingDateFrom" style="width: 120px;" />
      <span class="filter-label">-</span>
      <input type="date" class="filter-input" id="filterSeedlingDateTo" style="width: 120px;" />
    </div>
  </div>

  <!-- Tab Specific: Crop Survey Status -->
  <div class="filter-field-group filter-tab-specific filter-tab-crop filter-hidden">
    <span class="filter-label">Date Range</span>
    <div class="filter-range-container">
      <input type="date" class="filter-input" id="filterCropDateFrom" style="width: 120px;" />
      <span class="filter-label">-</span>
      <input type="date" class="filter-input" id="filterCropDateTo" style="width: 120px;" />
    </div>
  </div>

  <!-- Tab Specific: Recent Activities -->
  <div class="filter-field-group filter-tab-specific filter-tab-recent filter-hidden">
    <span class="filter-label">Date Range</span>
    <div class="filter-range-container">
      <input type="date" class="filter-input" id="filterRecentDateFrom" style="width: 120px;" />
      <span class="filter-label">-</span>
      <input type="date" class="filter-input" id="filterRecentDateTo" style="width: 120px;" />
    </div>
  </div>

  <!-- Province Filter (Address) - Hidden for Seedling Record, Crop Survey Status, and Recent Activities -->
  <div class="filter-field-group" id="provinceFilterGroup">
    <span class="filter-label">Province</span>
    <select class="filter-select" id="filterProvince" style="width: 130px;" onchange="handleFilterProvinceChange(this.value)">
      <option value="">All province</option>
    </select>
  </div>

  <!-- Municipality Filter (Address) - Hidden for Seedling Record, Crop Survey Status, and Recent Activities -->
  <div class="filter-field-group" id="municipalityFilterGroup">
    <span class="filter-label">Municipality</span>
    <select class="filter-select" id="filterMunicipality" style="width: 130px;" disabled>
      <option value="">All municipality</option>
    </select>
  </div>

  <!-- Action Buttons -->
  <div class="filter-field-group">
    <span class="filter-label" style="color: transparent; user-select: none;">.</span>
    <button class="filter-apply-btn" onclick="applyFilters()">Apply</button>
  </div>
</div>

<script>
  let filterState = {
    dateFrom: '',
    dateTo: '',
    selectedProvince: '',
    selectedMunicipality: '',
    selectedStatus: '',
    selectedGender: '',
    selectedMaritalStatus: '',
    selectedAttributes: [],
    plotIdSearch: '',
    hectaresMin: '',
    hectaresMax: '',
    seedlingSearch: '',
    cropSearch: '',
    recentSearch: '',
    beneficiarySearch: '',
    activeTab: '<?php echo htmlspecialchars($activeTab); ?>'
  };

  let filterProvincesCached = [];

  // Init filter UI based on PHP activeTab
  document.addEventListener('DOMContentLoaded', () => {
    updateFilterTabSpecificVisibility(filterState.activeTab);
    loadFilterProvinces();
  });

  // Listen to tab changes on the reports page
  document.addEventListener('tableTabChanged', (e) => {
    const newTab = e.detail.tab;
    filterState.activeTab = newTab || '';
    updateFilterTabSpecificVisibility(filterState.activeTab);
  });

  // Listen to filter toggling on the reports page
  document.addEventListener('tableFilterToggled', (e) => {
    const container = document.getElementById('reportsFilterSectionContainer');
    if (!container) return;
    if (e.detail.isActive) {
      container.style.display = 'block';
    } else {
      container.style.display = 'none';
      resetFilters();
    }
  });

  // Close dropdown on click outside
  document.addEventListener('mousedown', (event) => {
    const dropdownMenu = document.getElementById('attributeDropdownMenu');
    const dropdownBtn = document.getElementById('attributeDropdownBtn');
    
    if (dropdownMenu && dropdownMenu.classList.contains('show')) {
      if (!dropdownMenu.contains(event.target) && !dropdownBtn.contains(event.target)) {
        closeFilterAttributeDropdown();
      }
    }
  });

  function toggleFilterAttributeDropdown(event) {
    if (event) event.stopPropagation();
    const menu = document.getElementById('attributeDropdownMenu');
    const arrowDown = document.getElementById('attributeArrowDown');
    const arrowUp = document.getElementById('attributeArrowUp');
    
    const isOpen = menu.classList.toggle('show');
    if (isOpen) {
      arrowDown.classList.add('filter-hidden');
      arrowUp.classList.remove('filter-hidden');
    } else {
      arrowDown.classList.remove('filter-hidden');
      arrowUp.classList.add('filter-hidden');
    }
  }

  function closeFilterAttributeDropdown(event) {
    if (event) event.stopPropagation();
    const menu = document.getElementById('attributeDropdownMenu');
    const arrowDown = document.getElementById('attributeArrowDown');
    const arrowUp = document.getElementById('attributeArrowUp');
    
    menu.classList.remove('show');
    arrowDown.classList.remove('filter-hidden');
    arrowUp.classList.add('filter-hidden');
  }

  function updateFilterTabSpecificVisibility(tabName) {
    // 1. Hide all tab-specific filter fields
    document.querySelectorAll('.filter-tab-specific').forEach(el => el.classList.add('filter-hidden'));

    const attributeDropdownGroup = document.getElementById('attributeDropdownGroup');
    const provinceGroup = document.getElementById('provinceFilterGroup');
    const municipalityGroup = document.getElementById('municipalityFilterGroup');

    // 2. Show/hide only the matching group inside the attribute dropdown
    document.querySelectorAll('.filter-table-group').forEach(group => {
      const groupTab = group.getAttribute('data-table');
      // No tab: show all groups; tab selected: show only matching group
      group.style.display = (!tabName || groupTab === tabName) ? '' : 'none';
    });

    // 3. Clear attribute selections whenever the tab changes (avoid stale picks)
    clearAllAttributes();

    // 4. No tab selected: show only All Attributes dropdown (hide Province/Municipality)
    if (!tabName) {
      attributeDropdownGroup.classList.remove('filter-hidden');
      provinceGroup.classList.add('filter-hidden');
      municipalityGroup.classList.add('filter-hidden');
      return;
    }

    // 5. Hide/show Attribute Dropdown (hidden only for Recent Activities)
    if (tabName === 'Recent Activities') {
      attributeDropdownGroup.classList.add('filter-hidden');
    } else {
      attributeDropdownGroup.classList.remove('filter-hidden');
    }

    // 6. Hide/show Province/Municipality (hidden for Seedling Record, Crop Survey Status, Recent Activities)
    const addressTabsToHide = ['Seedling Record', 'Crop Survey Status', 'Recent Activities'];
    if (addressTabsToHide.includes(tabName)) {
      provinceGroup.classList.add('filter-hidden');
      municipalityGroup.classList.add('filter-hidden');
    } else {
      provinceGroup.classList.remove('filter-hidden');
      municipalityGroup.classList.remove('filter-hidden');
    }

    // 7. Show corresponding tab-specific filter fields
    if (tabName === 'Beneficiary List') {
      document.querySelectorAll('.filter-tab-beneficiary').forEach(el => el.classList.remove('filter-hidden'));
    } else if (tabName === 'Farm Location') {
      document.querySelectorAll('.filter-tab-farm').forEach(el => el.classList.remove('filter-hidden'));
    } else if (tabName === 'Seedling Record') {
      document.querySelectorAll('.filter-tab-seedling').forEach(el => el.classList.remove('filter-hidden'));
    } else if (tabName === 'Crop Survey Status') {
      document.querySelectorAll('.filter-tab-crop').forEach(el => el.classList.remove('filter-hidden'));
    } else if (tabName === 'Recent Activities') {
      document.querySelectorAll('.filter-tab-recent').forEach(el => el.classList.remove('filter-hidden'));
    }
  }

  // Address fetching logic
  async function loadFilterProvinces() {
    if (filterProvincesCached.length > 0) return;
    
    try {
      const apiUrl = typeof API_BASE_URL !== 'undefined' ? API_BASE_URL : 'http://localhost:5000/api';
      const token = localStorage.getItem('authToken');
      const response = await fetch(`${apiUrl}/addresses/provinces`, {
        headers: { 'Authorization': `Bearer ${token}` }
      });
      if (response.ok) {
        filterProvincesCached = await response.json();
        const select = document.getElementById('filterProvince');
        select.innerHTML = '<option value="">All province</option>';
        filterProvincesCached.forEach(p => {
          const opt = document.createElement('option');
          opt.value = p;
          opt.textContent = p;
          select.appendChild(opt);
        });
      }
    } catch (err) {
      console.error('Failed to load filter provinces', err);
    }
  }

  async function handleFilterProvinceChange(province) {
    filterState.selectedProvince = province;
    filterState.selectedMunicipality = '';
    
    const munSelect = document.getElementById('filterMunicipality');
    munSelect.innerHTML = '<option value="">All municipality</option>';
    munSelect.disabled = true;
    
    if (!province) return;

    try {
      const apiUrl = typeof API_BASE_URL !== 'undefined' ? API_BASE_URL : 'http://localhost:5000/api';
      const token = localStorage.getItem('authToken');
      const response = await fetch(`${apiUrl}/addresses/municipalities/${encodeURIComponent(province)}`, {
        headers: { 'Authorization': `Bearer ${token}` }
      });
      if (response.ok) {
        const municipalities = await response.json();
        municipalities.forEach(m => {
          const opt = document.createElement('option');
          opt.value = m;
          opt.textContent = m;
          munSelect.appendChild(opt);
        });
        munSelect.disabled = false;
      }
    } catch (err) {
      console.error('Failed to load filter municipalities', err);
    }
  }

  // Attribute Checkbox Handlers
  function handleAttributeCheckboxChange(checkbox) {
    const attrId = checkbox.value;
    const labelEl = checkbox.closest('.filter-dropdown-item-label');
    
    if (checkbox.checked) {
      if (!filterState.selectedAttributes.includes(attrId)) {
        filterState.selectedAttributes.push(attrId);
      }
      labelEl.classList.add('selected');
    } else {
      filterState.selectedAttributes = filterState.selectedAttributes.filter(id => id !== attrId);
      labelEl.classList.remove('selected');
    }
    
    updateSelectedAttributesLabel();
    updateGroupCheckboxState(checkbox.closest('.filter-table-group'));
  }

  function updateSelectedAttributesLabel() {
    const labelSpan = document.getElementById('selectedAttributesCount');
    const triggerBtn = document.getElementById('attributeDropdownBtn');
    
    if (filterState.selectedAttributes.length > 0) {
      labelSpan.textContent = `${filterState.selectedAttributes.length} selected`;
      triggerBtn.classList.add('has-value');
    } else {
      labelSpan.textContent = 'Select attributes';
      triggerBtn.classList.remove('has-value');
    }
  }

  function updateGroupCheckboxState(groupEl) {
    if (!groupEl) return;
    const itemCheckboxes = groupEl.querySelectorAll('.attr-checkbox');
    const groupCheckbox = groupEl.querySelector('.group-checkbox');
    
    let allChecked = true;
    itemCheckboxes.forEach(cb => {
      if (!cb.checked) allChecked = false;
    });
    
    groupCheckbox.checked = allChecked;
  }

  function toggleTableAttributes(tableName, groupCheckbox) {
    const groupEl = groupCheckbox.closest('.filter-table-group');
    const itemCheckboxes = groupEl.querySelectorAll('.attr-checkbox');
    const checkAll = groupCheckbox.checked;
    
    itemCheckboxes.forEach(cb => {
      cb.checked = checkAll;
      const attrId = cb.value;
      const labelEl = cb.closest('.filter-dropdown-item-label');
      
      if (checkAll) {
        if (!filterState.selectedAttributes.includes(attrId)) {
          filterState.selectedAttributes.push(attrId);
        }
        labelEl.classList.add('selected');
      } else {
        filterState.selectedAttributes = filterState.selectedAttributes.filter(id => id !== attrId);
        labelEl.classList.remove('selected');
      }
    });
    
    updateSelectedAttributesLabel();
  }

  function toggleSelectAllAttributes(event) {
    if (event) event.preventDefault();
    
    const checkboxes = document.querySelectorAll('.attr-checkbox');
    const allAttrIds = Array.from(checkboxes).map(cb => cb.value);
    
    const isAllSelected = filterState.selectedAttributes.length === allAttrIds.length;
    const btn = document.getElementById('filterSelectAllBtn');
    
    if (isAllSelected) {
      clearAllAttributes(event);
      btn.textContent = 'Select All';
    } else {
      filterState.selectedAttributes = [...allAttrIds];
      checkboxes.forEach(cb => {
        cb.checked = true;
        cb.closest('.filter-dropdown-item-label').classList.add('selected');
      });
      document.querySelectorAll('.group-checkbox').forEach(cb => cb.checked = true);
      btn.textContent = 'Deselect All';
      updateSelectedAttributesLabel();
    }
  }

  function clearAllAttributes(event) {
    if (event) event.preventDefault();
    
    filterState.selectedAttributes = [];
    document.querySelectorAll('.attr-checkbox, .group-checkbox').forEach(cb => cb.checked = false);
    document.querySelectorAll('.filter-dropdown-item-label').forEach(el => el.classList.remove('selected'));
    document.getElementById('filterSelectAllBtn').textContent = 'Select All';
    
    updateSelectedAttributesLabel();
  }

  // Reset all filters
  function resetFilters() {
    filterState.dateFrom = '';
    filterState.dateTo = '';
    filterState.selectedProvince = '';
    filterState.selectedMunicipality = '';
    filterState.selectedStatus = '';
    filterState.selectedGender = '';
    filterState.selectedMaritalStatus = '';
    filterState.selectedAttributes = [];
    filterState.plotIdSearch = '';
    filterState.hectaresMin = '';
    filterState.hectaresMax = '';
    filterState.seedlingSearch = '';
    filterState.cropSearch = '';
    filterState.recentSearch = '';
    filterState.beneficiarySearch = '';

    const inputsToReset = [
      'filterGender', 'filterMaritalStatus', 'filterProvince',
      'filterBirthdateFrom', 'filterBirthdateTo',
      'filterHectaresMin', 'filterHectaresMax',
      'filterSeedlingDateFrom', 'filterSeedlingDateTo',
      'filterCropDateFrom', 'filterCropDateTo',
      'filterRecentDateFrom', 'filterRecentDateTo'
    ];
    
    inputsToReset.forEach(id => {
      const el = document.getElementById(id);
      if (el) el.value = '';
    });
    
    const munSelect = document.getElementById('filterMunicipality');
    if (munSelect) {
      munSelect.innerHTML = '<option value="">All municipality</option>';
      munSelect.disabled = true;
    }

    clearAllAttributes();
    
    document.dispatchEvent(new CustomEvent('tableFiltersReset'));
  }

  // Apply filters
  function applyFilters() {
    const tab = filterState.activeTab;
    
    filterState.selectedProvince = document.getElementById('filterProvince').value;
    filterState.selectedMunicipality = document.getElementById('filterMunicipality').value;
    
    if (tab === 'Beneficiary List') {
      filterState.selectedGender = document.getElementById('filterGender').value;
      filterState.selectedMaritalStatus = document.getElementById('filterMaritalStatus').value;
      filterState.dateFrom = document.getElementById('filterBirthdateFrom').value;
      filterState.dateTo = document.getElementById('filterBirthdateTo').value;
    } else if (tab === 'Farm Location') {
      filterState.hectaresMin = document.getElementById('filterHectaresMin').value;
      filterState.hectaresMax = document.getElementById('filterHectaresMax').value;
    } else if (tab === 'Seedling Record') {
      filterState.dateFrom = document.getElementById('filterSeedlingDateFrom').value;
      filterState.dateTo = document.getElementById('filterSeedlingDateTo').value;
    } else if (tab === 'Crop Survey Status') {
      filterState.dateFrom = document.getElementById('filterCropDateFrom').value;
      filterState.dateTo = document.getElementById('filterCropDateTo').value;
    } else if (tab === 'Recent Activities') {
      filterState.dateFrom = document.getElementById('filterRecentDateFrom').value;
      filterState.dateTo = document.getElementById('filterRecentDateTo').value;
    }
    
    document.dispatchEvent(new CustomEvent('tableFiltersApplied', {
      detail: { filters: { ...filterState } }
    }));
  }
</script>
