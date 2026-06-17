<!-- Trend Monitoring Component -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<style>
  /* ===============================
     TREND MONITORING
     =============================== */

  .trend-container {
    background: var(--white, #ffffff);
    padding: 1rem;
    border-radius: 6px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
    border: 1px solid var(--border-gray, #e6e6e6);
    height: 100%;
    display: flex;
    flex-direction: column;
  }

  .trend-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 0.5rem;
    flex-wrap: wrap;
    margin-bottom: 0.75rem;
  }

  .trend-title {
    color: var(--dark-green, #055035);
    font-size: 0.9rem;
    font-weight: 600;
    margin: 0;
  }

  .trend-controls {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    flex: 1;
    justify-content: flex-end;
    flex-wrap: wrap;
  }

  .search-wrapper {
    position: relative;
    display: flex;
    align-items: center;
  }

  .search-icon {
    position: absolute;
    left: 0.5rem;
    font-size: 0.9rem;
    color: #aaa;
    pointer-events: none;
    width: 14px;
    height: 14px;
  }

  .trend-search {
    width: 270px;
    padding: 0.4rem 2rem;
    font-size: 0.75rem;
    color: var(--dark-green, #055035);
    background-color: var(--white, #ffffff);
    border: 1px solid var(--border-gray, #e6e6e6);
    border-radius: 4px;
    outline: none;
    font-family: inherit;
  }

  .search-suggestions {
    position: absolute;
    top: 100%;
    left: 0;
    right: 0;
    background: var(--white, #ffffff);
    border: 1px solid var(--border-gray, #e6e6e6);
    border-radius: 4px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    max-height: 200px;
    overflow-y: auto;
    z-index: 1010;
    margin-top: 4px;
  }

  .search-suggestions.hidden {
    display: none;
  }

  .search-suggestion-item {
    padding: 0.5rem 0.75rem;
    font-size: 0.75rem;
    cursor: pointer;
    color: var(--dark-green, #055035);
    transition: background-color 0.2s;
    text-align: left;
  }

  .search-suggestion-item:hover {
    background-color: #f0f7f4;
  }

  .search-suggestion-empty {
    padding: 0.5rem 0.75rem;
    font-size: 0.75rem;
    color: #999;
    font-style: italic;
    text-align: left;
  }

  .trend-select {
    padding: 0.4rem 0.6rem;
    font-size: 0.75rem;
    color: var(--dark-green, #055035);
    background-color: var(--white, #ffffff);
    border: 1px solid var(--border-gray, #e6e6e6);
    border-radius: 4px;
    cursor: pointer;
    outline: none;
    font-family: inherit;
  }

  .trend-legend {
    display: flex;
    justify-content: center;
    gap: 1.5rem;
    flex-wrap: wrap;
  }

  .legend-item {
    display: flex;
    align-items: center;
    font-size: 0.7rem;
    color: var(--dark-text, #333333);
  }

  .legend-dot {
    width: 8px;
    height: 8px;
    border-radius: 50%;
    margin-right: 0.4rem;
  }

  .dot-teal { background-color: #008080; } /* var(--teal) */
  .dot-success { background-color: #28a745; } /* var(--success) */
  .dot-danger { background-color: #dc3545; } /* var(--danger-red) */

  @media (max-width: 768px) {
    .trend-controls {
      justify-content: flex-start;
    }
    .search-wrapper, .trend-search {
      width: 100%;
    }
  }
</style>

<div class="trend-container">
  <div class="trend-header">
    <h3 class="trend-title">Trend Monitoring</h3>

    <div class="trend-controls">
      <!-- Beneficiary Search Bar -->
      <div class="search-wrapper">
        <svg class="search-icon" viewBox="0 0 20 20" fill="currentColor">
          <path fill-rule="evenodd" d="M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z" clip-rule="evenodd" />
        </svg>
        <input type="text" id="trendSearchInput" class="trend-search" placeholder="Search beneficiary..." autocomplete="off">
        <div id="trendSearchSuggestions" class="search-suggestions hidden"></div>
      </div>

      <!-- Time Period Filter -->
      <select id="trendTimePeriod" class="trend-select">
        <option value="yearly">Yearly</option>
        <option value="monthly" selected>Monthly</option>
        <option value="weekly">Weekly</option>
      </select>

      <!-- Data Filter -->
      <select id="trendDataFilter" class="trend-select">
        <option value="all">All Data</option>
        <option value="seedlings">Seedlings Only</option>
        <option value="alive">Alive Crops Only</option>
        <option value="dead">Dead Crops Only</option>
      </select>
    </div>
  </div>

  <!-- Chart Area -->
  <div style="flex: 1; min-height: 280px; position: relative; margin-bottom: 1rem; width: 100%;">
    <canvas id="trendChart"></canvas>
  </div>

  <!-- Legend -->
  <div class="trend-legend">
    <div class="legend-item">
      <div class="legend-dot dot-teal"></div>
      <span>Coffee Seedlings</span>
    </div>
    <div class="legend-item">
      <div class="legend-dot dot-success"></div>
      <span>Alive Crops</span>
    </div>
    <div class="legend-item">
      <div class="legend-dot dot-danger"></div>
      <span>Dead Crops</span>
    </div>
  </div>
</div>

<script>
  (function() {
    const API_BASE_URL = 'http://localhost:5000/api';
    let chartInstance = null;
    let dashboardBeneficiaries = [];
    let selectedBeneficiaryId = null;

    // Cache elements
    const searchInput = document.getElementById('trendSearchInput');
    const suggestionsBox = document.getElementById('trendSearchSuggestions');
    const dataFilter = document.getElementById('trendDataFilter');
    const timePeriod = document.getElementById('trendTimePeriod');

    // Fetch and initialize/update chart
    async function loadChartData() {
      const token = localStorage.getItem('authToken');
      if (!token) return;

      try {
        const period = timePeriod ? timePeriod.value : 'monthly';
        let url = `${API_BASE_URL}/statistics/chart-data?period=${period}`;
        if (selectedBeneficiaryId) {
          url += `&beneficiaryId=${selectedBeneficiaryId}`;
        }

        const response = await fetch(url, {
          headers: {
            'Authorization': `Bearer ${token}`
          }
        });

        if (!response.ok) {
          throw new Error('Failed to fetch chart data');
        }

        const chartData = await response.json();
        renderChart(chartData);
      } catch (error) {
        console.error('Error loading chart data:', error);
      }
    }

    // Initialize/Render the Chart.js instance
    function renderChart(dataList) {
      const ctx = document.getElementById('trendChart');
      if (!ctx) return;

      const labels = dataList.map(item => item.month);
      const seedlingData = dataList.map(item => item.seedlings || 0);
      const aliveData = dataList.map(item => item.aliveCrops || 0);
      const deadData = dataList.map(item => item.deadCrops || 0);

      const datasets = [
        {
          label: 'Coffee Seedlings',
          data: seedlingData,
          borderColor: '#008080', // Teal
          backgroundColor: 'rgba(0, 128, 128, 0.05)',
          borderWidth: 3,
          tension: 0.3,
          fill: true,
          hidden: false
        },
        {
          label: 'Alive Crops',
          data: aliveData,
          borderColor: '#28a745', // Success Green
          backgroundColor: 'rgba(40, 167, 69, 0.05)',
          borderWidth: 3,
          tension: 0.3,
          fill: true,
          hidden: false
        },
        {
          label: 'Dead Crops',
          data: deadData,
          borderColor: '#dc3545', // Danger Red
          backgroundColor: 'rgba(220, 53, 69, 0.05)',
          borderWidth: 3,
          tension: 0.3,
          fill: true,
          hidden: false
        }
      ];

      // If chart already exists, update data and redraw
      if (chartInstance) {
        chartInstance.data.labels = labels;
        chartInstance.data.datasets.forEach((ds, index) => {
          ds.data = datasets[index].data;
        });
        applyDatasetFilter(); // Apply current data view filter settings
        chartInstance.update();
        return;
      }

      // Create new chart instance
      chartInstance = new Chart(ctx, {
        type: 'line',
        data: {
          labels: labels,
          datasets: datasets
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          plugins: {
            legend: {
              display: false // Hide default legend to use custom legend
            },
            tooltip: {
              mode: 'index',
              intersect: false,
              padding: 10,
              backgroundColor: 'rgba(5, 80, 53, 0.95)',
              titleFont: { family: 'Montserrat', size: 12, weight: 'bold' },
              bodyFont: { family: 'Montserrat', size: 11 },
              callbacks: {
                label: function(context) {
                  let label = context.dataset.label || '';
                  if (label) {
                    label += ': ';
                  }
                  if (context.parsed.y !== null) {
                    label += context.parsed.y.toLocaleString();
                  }
                  return label;
                }
              }
            }
          },
          interaction: {
            mode: 'nearest',
            axis: 'x',
            intersect: false
          },
          scales: {
            x: {
              grid: {
                display: false
              },
              ticks: {
                font: { family: 'Montserrat', size: 10 }
              }
            },
            y: {
              beginAtZero: true,
              grid: {
                color: '#f0f0f0'
              },
              ticks: {
                font: { family: 'Montserrat', size: 10 },
                callback: function(value) {
                  return value.toLocaleString();
                }
              }
            }
          }
        }
      });

      applyDatasetFilter();
    }

    // Apply visibility filter based on #trendDataFilter dropdown selection
    function applyDatasetFilter() {
      if (!chartInstance) return;

      const value = dataFilter.value;
      chartInstance.data.datasets.forEach((ds, index) => {
        if (value === 'all') {
          chartInstance.setDatasetVisibility(index, true);
        } else if (value === 'seedlings') {
          chartInstance.setDatasetVisibility(index, index === 0);
        } else if (value === 'alive') {
          chartInstance.setDatasetVisibility(index, index === 1);
        } else if (value === 'dead') {
          chartInstance.setDatasetVisibility(index, index === 2);
        }
      });
      chartInstance.update();
    }

    // Fetch full beneficiary list once to enable search autocomplete functionality
    async function loadBeneficiaries() {
      const token = localStorage.getItem('authToken');
      if (!token) return;

      try {
        const response = await fetch(`${API_BASE_URL}/beneficiaries`, {
          headers: { 'Authorization': `Bearer ${token}` }
        });

        if (!response.ok) throw new Error('Failed to fetch beneficiaries');
        let data = await response.json();
        
        if (data && !Array.isArray(data)) {
          data = data.data || data.beneficiaries || [];
        }
        dashboardBeneficiaries = data || [];
      } catch (error) {
        console.error('Error loading beneficiaries for search:', error);
      }
    }

    // Render suggestions dropdown list
    function renderSuggestions(query) {
      suggestionsBox.innerHTML = '';
      
      const normalizedQuery = query.toLowerCase().trim();
      if (!normalizedQuery) {
        suggestionsBox.classList.add('hidden');
        return;
      }

      const filtered = dashboardBeneficiaries.filter(b => {
        const nameParts = [b.firstName, b.middleName, b.lastName].filter(Boolean);
        const fullName = nameParts.join(' ').toLowerCase();
        const benId = String(b.beneficiaryId || '').toLowerCase();
        return fullName.includes(normalizedQuery) || benId.includes(normalizedQuery);
      });

      if (filtered.length === 0) {
        const emptyDiv = document.createElement('div');
        emptyDiv.className = 'search-suggestion-empty';
        emptyDiv.textContent = 'No beneficiaries found';
        suggestionsBox.appendChild(emptyDiv);
      } else {
        filtered.forEach(b => {
          const nameParts = [b.firstName, b.middleName, b.lastName].filter(Boolean);
          const fullName = nameParts.join(' ').trim();
          const benId = b.beneficiaryId || 'N/A';
          const label = `[${benId}] ${fullName}`;
          const item = document.createElement('div');
          item.className = 'search-suggestion-item';
          item.textContent = label;
          item.addEventListener('click', () => {
            searchInput.value = label;
            selectedBeneficiaryId = b.id; // DB ID (integer)
            suggestionsBox.classList.add('hidden');
            loadChartData();
          });
          suggestionsBox.appendChild(item);
        });
      }
      suggestionsBox.classList.remove('hidden');
    }

    // Wire up UI event listeners
    function setupEventListeners() {
      // Data dropdown filter
      if (dataFilter) {
        dataFilter.addEventListener('change', applyDatasetFilter);
      }

      // Search typing
      if (searchInput) {
        searchInput.addEventListener('input', (e) => {
          renderSuggestions(e.target.value);
          
          // If search is fully cleared, reset filter and reload the default chart
          if (!e.target.value.trim()) {
            selectedBeneficiaryId = null;
            loadChartData();
          }
        });

        // Handle Enter key in search input
        searchInput.addEventListener('keydown', (e) => {
          if (e.key === 'Enter') {
            const query = searchInput.value.toLowerCase().trim();
            if (!query) {
              selectedBeneficiaryId = null;
              loadChartData();
              suggestionsBox.classList.add('hidden');
              return;
            }

            const firstMatch = dashboardBeneficiaries.find(b => {
              const nameParts = [b.firstName, b.middleName, b.lastName].filter(Boolean);
              const fullName = nameParts.join(' ').toLowerCase();
              const benId = String(b.beneficiaryId || '').toLowerCase();
              return fullName.includes(query) || benId.includes(query);
            });

            if (firstMatch) {
              const nameParts = [firstMatch.firstName, firstMatch.middleName, firstMatch.lastName].filter(Boolean);
              const fullName = nameParts.join(' ').trim();
              const benId = firstMatch.beneficiaryId || 'N/A';
              searchInput.value = `[${benId}] ${fullName}`;
              selectedBeneficiaryId = firstMatch.id;
              loadChartData();
            }
            suggestionsBox.classList.add('hidden');
          }
        });

        // Hide suggestions when clicking outside
        document.addEventListener('click', (e) => {
          if (!searchInput.contains(e.target) && !suggestionsBox.contains(e.target)) {
            suggestionsBox.classList.add('hidden');
          }
        });

        // Show suggestions on focus if query is entered
        searchInput.addEventListener('focus', () => {
          if (searchInput.value.trim()) {
            renderSuggestions(searchInput.value);
          }
        });
      }

      // Time period filter
      if (timePeriod) {
        timePeriod.addEventListener('change', () => {
          loadChartData();
        });
      }

      // Listen for custom navigation event to refresh metrics and charts
      window.addEventListener('navigationChanged', (event) => {
        if (event.detail && event.detail.page === 'dashboard') {
          loadChartData();
        }
      });
    }

    // Startup sequence
    async function initialize() {
      setupEventListeners();
      await loadBeneficiaries();
      await loadChartData();
    }

    // Initialize when DOM is ready
    document.addEventListener('DOMContentLoaded', initialize);

    // Also load immediately if page is already loaded (single-page include context)
    if (document.readyState === 'complete' || document.readyState === 'interactive') {
      initialize();
    }
  })();
</script>
