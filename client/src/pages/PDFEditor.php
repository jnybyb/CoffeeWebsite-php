<!-- PDF Document Editor Page -->
<style>
  .pdf-editor-wrapper {
    display: flex;
    flex-direction: column;
    height: calc(100vh - 70px);
    overflow: hidden;
    background-color: #ffffff;
    font-family: var(--font-main, 'Montserrat', sans-serif);
  }

  .pdf-editor-header {
    padding: 1.6rem 1rem 0.5rem 1rem;
    background-color: var(--white, #ffffff);
    display: flex;
    justify-content: space-between;
    align-items: flex-end;
    flex-shrink: 0;
  }

  .pdf-editor-header .title-area h2 {
    color: var(--dark-green, #055035);
    font-size: 1.25rem;
    font-weight: 600;
    margin: 0;
  }

  .pdf-editor-header .title-area .subtitle {
    color: var(--dark-brown, #6b4423);
    font-size: 0.65rem;
    margin-top: 0.2rem;
    font-weight: 500;
  }

  .pdf-editor-header .actions-area {
    display: flex;
    gap: 0.5rem;
    align-items: center;
  }

  .pdf-btn {
    padding: 0.4rem 1.3rem;
    border-radius: 4px;
    cursor: pointer;
    font-size: 0.65rem;
    font-weight: 500;
    display: flex;
    align-items: center;
    gap: 6px;
    transition: all 0.1s ease;
    border: 1px solid transparent;
  }

  .pdf-btn-back {
    background-color: var(--white, #ffffff);
    color: var(--dark-green, #055035);
    border-color: var(--dark-green, #055035);
  }

  .pdf-btn-back:hover {
    transform: scale(1.03);
    background-color: #f0f7f4;
  }

  .pdf-btn-export {
    background-color: var(--dark-green, #055035);
    color: white;
    border-color: var(--dark-green, #055035);
  }

  .pdf-btn-export:hover:not(:disabled) {
    transform: scale(1.03);
    background-color: #044029;
  }

  .pdf-btn-export:disabled {
    opacity: 0.7;
    cursor: not-allowed;
  }

  .pdf-editor-content {
    flex: 1;
    display: flex;
    gap: 0;
    padding: 0;
    overflow: hidden;
    background-color: #ffffff;
  }

  .pdf-editor-sidebar {
    width: 320px;
    background: #ffffff;
    padding: 1.5rem;
    overflow-y: auto;
    flex-shrink: 0;
    border-right: 1px solid #e9ecef;
  }

  .pdf-editor-sidebar h3 {
    margin: 0 0 1rem 0;
    font-size: 0.8rem;
    color: #2c5530;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
  }

  .pdf-editor-preview-panel {
    flex: 1;
    background-color: #ffffff;
    overflow: hidden;
    display: flex;
    flex-direction: column;
    padding: 1.5rem;
  }

  .pdf-preview-card {
    flex: 1;
    background-color: #ffffff;
    border-radius: 8px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
    overflow-y: auto;
    padding: 2.5rem;
    display: flex;
    justify-content: center;
    align-items: flex-start;
  }

  .pdf-editor-preview-container {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 30px;
  }

  /* Real-looking page preview sheets */
  .pdf-preview-page {
    background: white;
    box-shadow: 0 4px 15px rgba(0,0,0,0.15);
    box-sizing: border-box;
    page-break-after: always;
    display: flex;
    flex-direction: column;
    overflow: hidden;
    position: relative;
  }

  .pdf-preview-page h2 {
    color: #2c5530;
    font-size: 15px;
    margin: 0 0 4px 0;
    font-weight: 600;
  }

  .pdf-preview-page .page-meta {
    color: #666;
    font-size: 9px;
    margin: 0 0 15px 0;
  }

  .pdf-preview-page table {
    width: 100%;
    border-collapse: collapse;
    border: 1px solid #dee2e6;
  }

  .pdf-preview-page th {
    background-color: #2c5530;
    color: white;
    font-weight: 600;
    padding: 6px 8px;
    text-align: left;
    border: 1px solid #dee2e6;
    white-space: normal;
    word-break: break-word;
  }

  .pdf-preview-page td {
    padding: 5px 8px;
    border: 1px solid #dee2e6;
    color: #333;
    white-space: normal;
    word-break: break-word;
  }

  .pdf-preview-page tr:nth-child(even) {
    background-color: #f8f9fa;
  }

  .pdf-preview-page .page-footer {
    position: absolute;
    bottom: 12px;
    left: 0;
    right: 0;
    text-align: center;
    font-size: 8px;
    color: #999;
  }

  /* Form controls */
  .pdf-form-group {
    margin-bottom: 1rem;
  }

  .pdf-form-group label {
    display: block;
    margin-bottom: 0.35rem;
    font-size: 0.65rem;
    font-weight: 600;
    color: #333;
  }

  .pdf-input-text {
    width: 100%;
    padding: 0.4rem 0.6rem;
    border: 1px solid #ccc;
    border-radius: 4px;
    font-size: 0.7rem;
    box-sizing: border-box;
    font-family: inherit;
  }

  .pdf-input-text:focus {
    border-color: var(--dark-green, #055035);
    outline: none;
  }

  .pdf-btn-group {
    display: flex;
    gap: 0.4rem;
  }

  .pdf-btn-toggle {
    flex: 1;
    padding: 0.4rem;
    background-color: white;
    color: #333;
    border: 1px solid #ccc;
    border-radius: 4px;
    cursor: pointer;
    font-size: 0.65rem;
    font-weight: 500;
    transition: all 0.15s ease;
    font-family: inherit;
  }

  .pdf-btn-toggle.active {
    background-color: #2c5530;
    color: white;
    border-color: #2c5530;
  }

  .pdf-select {
    width: 100%;
    padding: 0.4rem 0.6rem;
    border: 1px solid #ccc;
    border-radius: 4px;
    font-size: 0.7rem;
    cursor: pointer;
    background-color: white;
    font-family: inherit;
  }

  .pdf-select:focus {
    border-color: var(--dark-green, #055035);
    outline: none;
  }

  .pdf-range {
    width: 100%;
    accent-color: #2c5530;
    cursor: pointer;
  }

  .pdf-margin-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 0.5rem;
  }

  .pdf-margin-input {
    width: 100%;
    padding: 0.35rem;
    border: 1px solid #ccc;
    border-radius: 4px;
    font-size: 0.65rem;
    box-sizing: border-box;
    font-family: inherit;
  }

  .pdf-margin-input:focus {
    border-color: var(--dark-green, #055035);
    outline: none;
  }

  .pdf-info-box {
    padding: 0.6rem;
    background-color: #f0f9f0;
    border-radius: 4px;
    border: 1px solid #d0e8d0;
    margin-top: 1.2rem;
  }

  .pdf-info-box p {
    margin: 0;
    font-size: 0.6rem;
    color: #2c5530;
    line-height: 1.4;
  }
</style>

<!-- Load jsPDF and AutoTable from CDNs -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.8.2/jspdf.plugin.autotable.min.js"></script>

<div class="pdf-editor-wrapper">
  <!-- Header -->
  <div class="pdf-editor-header">
    <div class="title-area">
      <h2>PDF Document Editor</h2>
      <div class="subtitle">Customize your document before exporting</div>
    </div>
    <div class="actions-area">
      <button class="pdf-btn pdf-btn-back" onclick="closePDFEditor()">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" style="width: 11px; height: 11px; fill: currentColor;"><path d="M9.4 233.4c-12.5 12.5-12.5 32.8 0 45.3l160 160c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L109.3 288H480c17.7 0 32-14.3 32-32s-14.3-32-32-32H109.3l105.4-105.4c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0l-160 160z"/></svg>
        <span>Back to Reports</span>
      </button>
      <button class="pdf-btn pdf-btn-export" id="pdfExportBtn" onclick="triggerPDFExport()">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" style="width: 11px; height: 11px; fill: currentColor;"><path d="M0 64C0 28.7 28.7 0 64 0H224V128c0 17.7 14.3 32 32 32H384V288H216c-13.3 0-24 10.7-24 24s10.7 24 24 24H384V448c0 35.3-28.7 64-64 64H64c-35.3 0-64-28.7-64-64V64zm384 64H256V0L384 128zM176 352h32c8.8 0 16 7.2 16 16s-7.2 16-16 16H176v32c0 8.8-7.2 16-16 16s-16-7.2-16-16V336c0-8.8 7.2-16 16-16zm-32 32h16v-16h-16v16zm144-48h32c26.5 0 48 21.5 48 48s-21.5 48-48 48H272v16c0 8.8-7.2 16-16 16s-16-7.2-16-16V336c0-26.5 21.5-48 48-48zm32 48h-16v32h16c8.8 0 16-7.2 16-16s-7.2-16-16-16z"/></svg>
        <span id="pdfExportBtnText">Export PDF</span>
      </button>
    </div>
  </div>

  <!-- Main Content Area -->
  <div class="pdf-editor-content">
    <!-- Sidebar Panel -->
    <div class="pdf-editor-sidebar">
      <h3>Document Settings</h3>

      <!-- Document Title -->
      <div class="pdf-form-group">
        <label for="pdfTitleInput">Document Title</label>
        <input type="text" id="pdfTitleInput" class="pdf-input-text" value="Report" />
      </div>

      <!-- Orientation -->
      <div class="pdf-form-group">
        <label>Orientation</label>
        <div class="pdf-btn-group">
          <button class="pdf-btn-toggle" id="pdfOrientPortraitBtn" onclick="setPDFOrientation('portrait')">Portrait</button>
          <button class="pdf-btn-toggle active" id="pdfOrientLandscapeBtn" onclick="setPDFOrientation('landscape')">Landscape</button>
        </div>
      </div>

      <!-- Paper Size -->
      <div class="pdf-form-group">
        <label for="pdfPaperSizeSelect">Paper Size</label>
        <select id="pdfPaperSizeSelect" class="pdf-select" onchange="setPDFPaperSize(this.value)">
          <option value="a4">A4 (210 × 297 mm)</option>
          <option value="a3">A3 (297 × 420 mm)</option>
          <option value="letter">Letter (8.5 × 11 in)</option>
          <option value="legal">Legal (8.5 × 14 in)</option>
        </select>
      </div>

      <!-- Font Size -->
      <div class="pdf-form-group">
        <label id="pdfFontSizeLabel" for="pdfFontSizeRange">Font Size: 8px</label>
        <input type="range" id="pdfFontSizeRange" class="pdf-range" min="6" max="12" value="8" oninput="setPDFFontSize(this.value)" />
      </div>

      <!-- Margins -->
      <div class="pdf-form-group">
        <label>Margins (mm)</label>
        <div class="pdf-margin-grid">
          <div>
            <label style="font-size: 0.55rem; color: #666; margin-bottom: 0.15rem;" for="pdfMarginTop">Top</label>
            <input type="number" id="pdfMarginTop" class="pdf-margin-input" value="25.4" oninput="setPDFMargin('top', this.value)" />
          </div>
          <div>
            <label style="font-size: 0.55rem; color: #666; margin-bottom: 0.15rem;" for="pdfMarginBottom">Bottom</label>
            <input type="number" id="pdfMarginBottom" class="pdf-margin-input" value="25.4" oninput="setPDFMargin('bottom', this.value)" />
          </div>
          <div>
            <label style="font-size: 0.55rem; color: #666; margin-bottom: 0.15rem;" for="pdfMarginLeft">Left</label>
            <input type="number" id="pdfMarginLeft" class="pdf-margin-input" value="25.4" oninput="setPDFMargin('left', this.value)" />
          </div>
          <div>
            <label style="font-size: 0.55rem; color: #666; margin-bottom: 0.15rem;" for="pdfMarginRight">Right</label>
            <input type="number" id="pdfMarginRight" class="pdf-margin-input" value="25.4" oninput="setPDFMargin('right', this.value)" />
          </div>
        </div>
      </div>

      <!-- Tip Panel -->
      <div class="pdf-info-box">
        <p>
          <strong>💡 Tip:</strong> Adjust document parameters on the fly.
          The preview updates in real-time. Export when your design looks correct.
        </p>
      </div>
    </div>

    <!-- Live Preview Panel -->
    <div class="pdf-editor-preview-panel">
      <div class="pdf-preview-card">
        <div class="pdf-editor-preview-container" id="pdfPreviewContainer"></div>
      </div>
    </div>
  </div>
</div>

<script>
  let pdfState = {
    activeTab: '',
    data: [],
    selectedAttributes: null,
    attributeColumnMap: null,
    orientation: 'landscape',
    paperSize: 'a4',
    fontSize: 8,
    margins: { top: 25.4, bottom: 25.4, left: 25.4, right: 25.4 },
    title: 'Report',
    isExporting: false
  };

  const pdfHeadersMap = {
    'Beneficiary List': ['#', 'Beneficiary ID', 'Full Name', 'Gender', 'Marital Status', 'Birth Date', 'Age', 'Cellphone', 'Address'],
    'Farm Location': ['#', 'Plot ID', 'Beneficiary', 'Hectares', 'Address', 'Coordinates'],
    'Seedling Record': ['#', 'Beneficiary ID', 'Received', 'Date Received', 'Planted', 'Plot ID', 'Planting Date', 'End Date'],
    'Crop Survey Status': ['#', 'Beneficiary ID', 'Beneficiary Name', 'Survey Date', 'Surveyer Name', 'Alive Crops', 'Dead Crops', 'Plot'],
    'Recent Activities': ['#', 'Type', 'Action', 'Timestamp', 'User']
  };

  // Convert a data row to matching values
  function getPDFCellValue(item, attrId) {
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
      case 'ben_id': return item.beneficiaryId || '';
      case 'ben_fullname': return `${item.firstName || ''} ${item.middleName || ''} ${item.lastName || ''}`.trim() || '';
      case 'ben_gender': return item.gender || '';
      case 'ben_birthdate': return item.birthDate ? new Date(item.birthDate).toLocaleDateString() : '';
      case 'ben_age': return item.age || '';
      case 'ben_cellphone': return item.cellphone || '';
      case 'ben_address':
        const benAddress = [item.purok, item.barangay, item.municipality, item.province]
          .filter(part => part && part.trim() !== '' && part.toLowerCase() !== 'unknown')
          .join(', ');
        return benAddress || '';
      case 'ben_marital': return item.maritalStatus || '';
      case 'farm_plot_id': return item.id || '';
      case 'farm_beneficiary': return item.beneficiaryName || '';
      case 'farm_hectares': return item.hectares || '';
      case 'farm_address': return item.address || '';
      case 'farm_coordinates': return `${item.coordinates?.length || 0} points`;
      case 'seed_id': return item.id || '';
      case 'seed_ben_id': return item.beneficiaryId || '';
      case 'seed_received': return item.received || '';
      case 'seed_date_received': return item.dateReceived ? new Date(item.dateReceived).toLocaleDateString() : '';
      case 'seed_planted': return item.planted || '';
      case 'seed_plot_id': return item.plotId || '';
      case 'seed_planting_date': return item.dateOfPlantingStart ? new Date(item.dateOfPlantingStart).toLocaleDateString() : '';
      case 'crop_id': return item.id || '';
      case 'crop_ben_id': return item.beneficiaryId || '';
      case 'crop_beneficiary': return item.beneficiaryName || '';
      case 'crop_survey_date': return item.surveyDate ? new Date(item.surveyDate).toLocaleDateString() : '';
      case 'crop_surveyer': return item.surveyer || '';
      case 'crop_alive': return item.aliveCrops || '';
      case 'crop_dead': return item.deadCrops || '';
      case 'crop_plot': return item.plotId || item.plot || '';
      case 'act_id': return item.id || '';
      case 'act_type':
        const typeMeta = {
          beneficiary: 'Coffee Beneficiary',
          crop: 'Crop Survey Status',
          seedling: 'Seedling Record',
          plot: 'Farm Plot Details'
        };
        return typeMeta[item.type] || item.type || 'System Activity';
      case 'act_action': return item.action || '';
      case 'act_timestamp': return item.timestamp ? new Date(item.timestamp).toLocaleString() : '';
      case 'act_user': return item.user || '';
      default: return '';
    }
  }

  const formatTimestamp = (timestamp) => {
    if (!timestamp) return '—';
    const date = new Date(timestamp);
    return date.toLocaleString('en-US', {
      month: 'numeric',
      day: 'numeric',
      year: 'numeric',
      hour: 'numeric',
      minute: '2-digit',
      hour12: true
    });
  };

  const getActivityTitle = (type) => {
    switch (type) {
      case 'beneficiary':
        return 'Coffee Beneficiary';
      case 'crop':
        return 'Crop Survey Status';
      case 'seedling':
        return 'Seedling Record';
      case 'plot':
        return 'Farm Monitoring';
      case 'report':
        return 'Reports';
      default:
        return 'Reports';
    }
  };

  const convertToPDFRow = (item, activeTab) => {
    let row = [];
    
    switch (activeTab) {
      case 'Beneficiary List':
        const address = [item.purok, item.barangay, item.municipality, item.province]
          .filter(part => part && part.trim() !== '')
          .join(', ');
        row = [
          item.beneficiaryId || '—',
          `${item.firstName || ''} ${item.middleName || ''} ${item.lastName || ''}`.trim() || '—',
          item.gender || '—',
          item.maritalStatus || '—',
          item.birthDate ? new Date(item.birthDate).toLocaleDateString() : '—',
          item.age || '—',
          item.cellphone || '—',
          address || '—'
        ];
        break;
      case 'Farm Location':
        row = [
          item.id || '—',
          item.beneficiaryName || '—',
          item.hectares || '—',
          item.address || '—',
          `${item.coordinates?.length || 0} points`
        ];
        break;
      case 'Seedling Record':
        row = [
          item.beneficiaryId || '—',
          item.received || 0,
          item.dateReceived ? new Date(item.dateReceived).toLocaleDateString() : '—',
          item.planted || 0,
          item.plotId || '—',
          item.dateOfPlantingStart ? new Date(item.dateOfPlantingStart).toLocaleDateString() : '—',
          item.dateOfPlantingEnd ? new Date(item.dateOfPlantingEnd).toLocaleDateString() : '—'
        ];
        break;
      case 'Crop Survey Status':
        row = [
          item.beneficiaryId || '—',
          item.beneficiaryName || '—',
          item.surveyDate ? new Date(item.surveyDate).toLocaleDateString() : '—',
          item.surveyer || '—',
          item.aliveCrops || 0,
          item.deadCrops || 0,
          item.plot || '—'
        ];
        break;
      case 'Recent Activities':
        row = [
          getActivityTitle(item.type),
          item.action || '—',
          formatTimestamp(item.timestamp),
          item.user || 'Admin'
        ];
        break;
      default:
        row = [
          item.ben_id || '—',
          item.ben_fullname || '—',
          item.farm_plot_id || '—',
          item.farm_hectares || '—',
          item.seed_received || '—',
          item.seed_planted || '—',
          item.crop_alive || '—',
          item.crop_dead || '—'
        ];
    }
    return row;
  };

  function convertItemToPDFRow(item, index) {
    if (pdfState.selectedAttributes && pdfState.selectedAttributes.length > 0) {
      return [
        index + 1,
        ...pdfState.selectedAttributes.map(attrId => getPDFCellValue(item, attrId))
      ];
    }

    return convertToPDFRow(item, pdfState.activeTab);
  }

  // Real-time Preview Renderer
  function renderPDFPreview() {
    const container = document.getElementById('pdfPreviewContainer');
    if (!container) return;

    if (!pdfState.data || pdfState.data.length === 0) {
      container.innerHTML = '<div style="color: #666; font-size: 0.9rem; padding: 2rem;">No data available to preview</div>';
      return;
    }

    // Determine headers
    let headers = [];
    if (pdfState.selectedAttributes && pdfState.selectedAttributes.length > 0 && pdfState.attributeColumnMap) {
      headers = ['#', ...pdfState.selectedAttributes.map(attrId => pdfState.attributeColumnMap[attrId]?.header).filter(Boolean)];
    } else {
      const defaultTab = pdfState.activeTab || 'Consolidated Report';
      const headersMap = {
        'Beneficiary List': ['Beneficiary ID', 'Full Name', 'Gender', 'Marital Status', 'Birth Date', 'Age', 'Cellphone', 'Address'],
        'Farm Location': ['Plot ID', 'Beneficiary', 'Hectares', 'Address', 'Coordinates'],
        'Seedling Record': ['Beneficiary ID', 'Received', 'Date Received', 'Planted', 'Plot ID', 'Planting Date', 'End Date'],
        'Crop Survey Status': ['Beneficiary ID', 'Beneficiary Name', 'Survey Date', 'Surveyer Name', 'Alive Crops', 'Dead Crops', 'Plot'],
        'Recent Activities': ['Type', 'Action', 'Timestamp', 'User']
      };
      headers = headersMap[defaultTab] || ['Beneficiary ID', 'Full Name', 'Plot ID', 'Hectares', 'Received', 'Planted', 'Alive Crops', 'Dead Crops'];
    }

    const tableRows = pdfState.data.map((item, idx) => convertItemToPDFRow(item, idx));

    // Page configurations
    const paperDimensions = {
      'a4': { portrait: { w: 210, h: 297 }, landscape: { w: 297, h: 210 } },
      'a3': { portrait: { w: 297, h: 420 }, landscape: { w: 420, h: 297 } },
      'letter': { portrait: { w: 215.9, h: 279.4 }, landscape: { w: 279.4, h: 215.9 } },
      'legal': { portrait: { w: 215.9, h: 355.6 }, landscape: { w: 355.6, h: 215.9 } }
    };

    const dimensions = paperDimensions[pdfState.paperSize][pdfState.orientation];
    const widthMm = dimensions.w;
    const heightMm = dimensions.h;

    // Create a temporary container to measure row heights dynamically
    const tempDiv = document.createElement('div');
    tempDiv.style.position = 'absolute';
    tempDiv.style.left = '-9999px';
    tempDiv.style.top = '-9999px';
    tempDiv.style.visibility = 'hidden';
    tempDiv.style.width = `${widthMm}mm`;
    tempDiv.style.pointerEvents = 'none';
    document.body.appendChild(tempDiv);

    tempDiv.innerHTML = `
      <div class="pdf-preview-page" style="
        width: ${widthMm}mm;
        height: ${heightMm}mm;
        padding: ${pdfState.margins.top}mm ${pdfState.margins.right}mm ${pdfState.margins.bottom}mm ${pdfState.margins.left}mm;
        display: flex;
        flex-direction: column;
      ">
        <h2>${pdfState.title}</h2>
        <div class="page-meta">Generated: ${new Date().toLocaleString()}</div>
        <div id="tempTableContainer" style="flex: 1; overflow: hidden;">
          <table style="font-size: ${pdfState.fontSize}px; width: 100%; border-collapse: collapse;">
            <thead id="tempThead">
              <tr>
                ${headers.map(h => `<th>${h}</th>`).join('')}
              </tr>
            </thead>
            <tbody id="tempTbody">
            </tbody>
          </table>
        </div>
      </div>
    `;

    const tempTableContainer = tempDiv.querySelector('#tempTableContainer');
    const tempThead = tempDiv.querySelector('#tempThead');
    const tempTbody = tempDiv.querySelector('#tempTbody');

    // Available table height is the container clientHeight minus 10px buffer to prevent any edge spillover
    const maxTbodyHeight = tempTableContainer.clientHeight - tempThead.clientHeight - 10;

    // Measure each row's height
    const rowHeights = [];
    tableRows.forEach((row) => {
      const tr = document.createElement('tr');
      tr.innerHTML = row.map(cell => {
        const val = cell === null || cell === undefined || cell === '—' ? '' : cell;
        return `<td>${val}</td>`;
      }).join('');
      tempTbody.appendChild(tr);
      rowHeights.push(tr.offsetHeight || tr.clientHeight || 20);
    });

    // Remove the temporary division
    document.body.removeChild(tempDiv);

    // Group rows into dynamic pages based on cumulative heights
    const pages = [];
    let currentPage = [];
    let currentHeight = 0;

    for (let i = 0; i < tableRows.length; i++) {
      const rowHeight = rowHeights[i];
      if (currentHeight + rowHeight > maxTbodyHeight && currentPage.length > 0) {
        pages.push(currentPage);
        currentPage = [tableRows[i]];
        currentHeight = rowHeight;
      } else {
        currentPage.push(tableRows[i]);
        currentHeight += rowHeight;
      }
    }
    if (currentPage.length > 0) {
      pages.push(currentPage);
    }

    const totalPages = pages.length;
    let pagesHTML = '';

    pages.forEach((pageRows, pageNum) => {
      pagesHTML += `
        <div class="pdf-preview-page" style="
          width: ${widthMm}mm;
          height: ${heightMm}mm;
          padding: ${pdfState.margins.top}mm ${pdfState.margins.right}mm ${pdfState.margins.bottom}mm ${pdfState.margins.left}mm;
        ">
          <h2>${pdfState.title}</h2>
          <div class="page-meta">Generated: ${new Date().toLocaleString()}</div>
          
          <div style="flex: 1; overflow: hidden;">
            <table style="font-size: ${pdfState.fontSize}px;">
              <thead>
                <tr>
                  ${headers.map(h => `<th>${h}</th>`).join('')}
                </tr>
              </thead>
              <tbody>
                ${pageRows.map(row => `
                  <tr>
                    ${row.map(cell => {
                      const val = cell === null || cell === undefined || cell === '—' ? '' : cell;
                      return `<td>${val}</td>`;
                    }).join('')}
                  </tr>
                `).join('')}
              </tbody>
            </table>
          </div>
          
          <div class="page-footer">
            Page ${pageNum + 1} of ${totalPages}
          </div>
        </div>
      `;
    });

    container.innerHTML = pagesHTML;
  }

  // Setting handlers
  function setPDFOrientation(orientation) {
    pdfState.orientation = orientation;
    document.getElementById('pdfOrientPortraitBtn').classList.toggle('active', orientation === 'portrait');
    document.getElementById('pdfOrientLandscapeBtn').classList.toggle('active', orientation === 'landscape');
    renderPDFPreview();
  }

  function setPDFPaperSize(size) {
    pdfState.paperSize = size;
    renderPDFPreview();
  }

  function setPDFFontSize(size) {
    pdfState.fontSize = parseInt(size);
    document.getElementById('pdfFontSizeLabel').innerText = `Font Size: ${size}px`;
    renderPDFPreview();
  }

  function setPDFMargin(side, val) {
    pdfState.margins[side] = parseFloat(val) || 0;
    renderPDFPreview();
  }

  // Register real-time title changes
  document.getElementById('pdfTitleInput').addEventListener('input', (e) => {
    pdfState.title = e.target.value;
    renderPDFPreview();
  });

  // Global handler to load editor state
  window.openPDFEditor = function(activeTab, data, selectedAttributes, attributeColumnMap) {
    pdfState.activeTab = activeTab || '';
    pdfState.data = data || [];
    pdfState.selectedAttributes = selectedAttributes || null;
    pdfState.attributeColumnMap = attributeColumnMap || null;
    pdfState.title = activeTab ? `${activeTab} Report` : 'Consolidated Database Report';
    
    // Set default title input value
    document.getElementById('pdfTitleInput').value = pdfState.title;
    
    // Adjust default orientation based on tab/selected attrs length
    if (activeTab === 'Beneficiary List' || !activeTab) {
      setPDFOrientation('landscape');
    } else {
      setPDFOrientation('portrait');
    }
    
    // Show PDF Editor section first, so container has layout/dimensions
    window.dispatchEvent(new CustomEvent('navigationChanged', { detail: { page: 'pdf-editor' } }));

    renderPDFPreview();
  };

  function closePDFEditor() {
    // Navigate back to reports
    window.dispatchEvent(new CustomEvent('navigationChanged', { detail: { page: 'reports' } }));
    window.dispatchEvent(new CustomEvent('navigateToPage', { detail: { page: 'reports' } }));
  }

  // High-fidelity jsPDF export
  async function triggerPDFExport() {
    if (!pdfState.data || pdfState.data.length === 0) {
      alert('No data available to export');
      return;
    }

    const exportBtn = document.getElementById('pdfExportBtn');
    const exportText = document.getElementById('pdfExportBtnText');
    exportBtn.disabled = true;
    exportText.innerText = 'Exporting...';

    try {
      const { jsPDF } = window.jspdf;
      
      // Determine headers
      let headers = [];
      if (pdfState.selectedAttributes && pdfState.selectedAttributes.length > 0 && pdfState.attributeColumnMap) {
        headers = ['#', ...pdfState.selectedAttributes.map(attrId => pdfState.attributeColumnMap[attrId]?.header).filter(Boolean)];
      } else {
        const defaultTab = pdfState.activeTab || 'Consolidated Report';
        const headersMap = {
          'Beneficiary List': ['Beneficiary ID', 'Full Name', 'Gender', 'Marital Status', 'Birth Date', 'Age', 'Cellphone', 'Address'],
          'Farm Location': ['Plot ID', 'Beneficiary', 'Hectares', 'Address', 'Coordinates'],
          'Seedling Record': ['Beneficiary ID', 'Received', 'Date Received', 'Planted', 'Plot ID', 'Planting Date', 'End Date'],
          'Crop Survey Status': ['Beneficiary ID', 'Beneficiary Name', 'Survey Date', 'Surveyer Name', 'Alive Crops', 'Dead Crops', 'Plot'],
          'Recent Activities': ['Type', 'Action', 'Timestamp', 'User']
        };
        headers = headersMap[defaultTab] || ['Beneficiary ID', 'Full Name', 'Plot ID', 'Hectares', 'Received', 'Planted', 'Alive Crops', 'Dead Crops'];
      }

      const tableData = pdfState.data.map((item, idx) => {
        const row = convertItemToPDFRow(item, idx);
        return row.map(cell => cell === null || cell === undefined || cell === '—' ? '' : cell);
      });

      // Paper sizes mapping
      const paperSizes = {
        'a4': [210, 297],
        'a3': [297, 420],
        'letter': [215.9, 279.4],
        'legal': [215.9, 355.6]
      };

      const [w, h] = paperSizes[pdfState.paperSize] || paperSizes['a4'];
      const width = pdfState.orientation === 'landscape' ? Math.max(w, h) : Math.min(w, h);
      const height = pdfState.orientation === 'landscape' ? Math.min(w, h) : Math.max(w, h);

      const doc = new jsPDF({
        orientation: pdfState.orientation,
        unit: 'mm',
        format: [width, height]
      });

      // Add header title & date timestamp
      const timestamp = new Date().toLocaleString();
      
      const drawHeader = (docInstance) => {
        docInstance.setFontSize(16);
        docInstance.setTextColor(44, 85, 48); // Dark green color
        docInstance.text(pdfState.title, pdfState.margins.left, 15);
        
        docInstance.setFontSize(10);
        docInstance.setTextColor(100, 100, 100);
        docInstance.text(`Generated: ${timestamp}`, pdfState.margins.left, 22);
      };

      drawHeader(doc);

      // Width calculation map for default views
      const getColumnStyles = (activeTab, availableWidth) => {
        if (pdfState.selectedAttributes && pdfState.selectedAttributes.length > 0) {
          const colCount = pdfState.selectedAttributes.length + 1; // including '#'
          const indexColWidth = Math.min(12, availableWidth * 0.08); // Max 12mm for index column
          const remainingWidth = availableWidth - indexColWidth;
          const equalWidth = remainingWidth / (colCount - 1);
          
          const styles = {
            0: { cellWidth: indexColWidth }
          };
          for (let i = 1; i < colCount; i++) {
            styles[i] = { cellWidth: equalWidth };
          }
          return styles;
        }

        switch (activeTab) {
          case 'Beneficiary List':
            return {
              0: { cellWidth: availableWidth * 0.12 }, // Beneficiary ID
              1: { cellWidth: availableWidth * 0.18 }, // Full Name
              2: { cellWidth: availableWidth * 0.08 }, // Gender
              3: { cellWidth: availableWidth * 0.11 }, // Marital Status
              4: { cellWidth: availableWidth * 0.12 }, // Birth Date
              5: { cellWidth: availableWidth * 0.06 }, // Age
              6: { cellWidth: availableWidth * 0.12 }, // Cellphone
              7: { cellWidth: availableWidth * 0.21 }  // Address
            };
          case 'Farm Location':
            return {
              0: { cellWidth: availableWidth * 0.15 }, // Plot ID
              1: { cellWidth: availableWidth * 0.25 }, // Beneficiary
              2: { cellWidth: availableWidth * 0.12 }, // Hectares
              3: { cellWidth: availableWidth * 0.33 }, // Address
              4: { cellWidth: availableWidth * 0.15 }  // Coordinates
            };
          case 'Seedling Record':
            return {
              0: { cellWidth: availableWidth * 0.15 }, // Beneficiary ID
              1: { cellWidth: availableWidth * 0.10 }, // Received
              2: { cellWidth: availableWidth * 0.15 }, // Date Received
              3: { cellWidth: availableWidth * 0.10 }, // Planted
              4: { cellWidth: availableWidth * 0.15 }, // Plot ID
              5: { cellWidth: availableWidth * 0.17 }, // Planting Date
              6: { cellWidth: availableWidth * 0.18 }  // End Date
            };
          case 'Crop Survey Status':
            return {
              0: { cellWidth: availableWidth * 0.13 }, // Beneficiary ID
              1: { cellWidth: availableWidth * 0.20 }, // Beneficiary Name
              2: { cellWidth: availableWidth * 0.13 }, // Survey Date
              3: { cellWidth: availableWidth * 0.17 }, // Surveyer Name
              4: { cellWidth: availableWidth * 0.12 }, // Alive Crops
              5: { cellWidth: availableWidth * 0.12 }, // Dead Crops
              6: { cellWidth: availableWidth * 0.13 }  // Plot
            };
          case 'Recent Activities':
            return {
              0: { cellWidth: availableWidth * 0.20 }, // Type
              1: { cellWidth: availableWidth * 0.40 }, // Action
              2: { cellWidth: availableWidth * 0.25 }, // Timestamp
              3: { cellWidth: availableWidth * 0.15 }  // User
            };
          default:
            // Consolidated default view (8 columns)
            // ['ben_id', 'ben_fullname', 'farm_plot_id', 'farm_hectares', 'seed_received', 'seed_planted', 'crop_alive', 'crop_dead']
            return {
              0: { cellWidth: availableWidth * 0.12 }, // Beneficiary ID
              1: { cellWidth: availableWidth * 0.18 }, // Full Name
              2: { cellWidth: availableWidth * 0.12 }, // Plot ID
              3: { cellWidth: availableWidth * 0.10 }, // Hectares
              4: { cellWidth: availableWidth * 0.12 }, // Received
              5: { cellWidth: availableWidth * 0.12 }, // Planted
              6: { cellWidth: availableWidth * 0.12 }, // Alive
              7: { cellWidth: availableWidth * 0.12 }  // Dead
            };
        }
      };

      // Call autoTable (global plugin)
      doc.autoTable({
        head: [headers],
        body: tableData,
        startY: 28,
        styles: {
          fontSize: pdfState.fontSize,
          cellPadding: 2,
          overflow: 'linebreak',
          lineColor: [224, 224, 224],
          lineWidth: 0.1
        },
        headStyles: {
          fillColor: [44, 85, 48], // Dark green
          textColor: [255, 255, 255],
          fontStyle: 'bold',
          halign: 'left'
        },
        alternateRowStyles: {
          fillColor: [248, 249, 250]
        },
        columnStyles: getColumnStyles(pdfState.activeTab, width - pdfState.margins.left - pdfState.margins.right),
        margin: {
          top: pdfState.margins.top,
          bottom: pdfState.margins.bottom,
          left: pdfState.margins.left,
          right: pdfState.margins.right
        },
        didDrawPage: (data) => {
          if (data.pageNumber > 1) {
            drawHeader(doc);
          }
          
          // Page counter
          const pageCount = doc.internal.getNumberOfPages();
          const pageSize = doc.internal.pageSize;
          const pageHeight = pageSize.height ? pageSize.height : pageSize.getHeight();
          
          doc.setFontSize(8);
          doc.setTextColor(150);
          doc.text(
            `Page ${data.pageNumber} of ${pageCount}`,
            pageSize.width / 2,
            pageHeight - 10,
            { align: 'center' }
          );
        }
      });

      const filename = `${pdfState.title.replace(/\s+/g, '_')}_${new Date().toISOString().split('T')[0]}.pdf`;
      doc.save(filename);
    } catch (err) {
      console.error(err);
      alert('Failed to generate PDF document.');
    } finally {
      exportBtn.disabled = false;
      exportText.innerText = 'Export PDF';
    }
  }
</script>
