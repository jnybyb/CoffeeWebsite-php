<!-- Beneficiary Detail Panel Component -->
<div class="data-table-overlay hidden" id="overlay" onclick="closeDetailPanel()"></div>
<div class="data-table-detail-panel hidden" id="detailPanel">
  
  <div class="detail-panel-header">
    <h3>Beneficiary Information</h3>
    <button class="detail-panel-close" onclick="closeDetailPanel()">×</button>
  </div>

  <div class="detail-panel-body">
    <!-- Profile Info -->
    <div class="profile-section">
      <div class="profile-image-container">
        <img id="detailPicture" src="" alt="Profile" class="profile-image hidden" onclick="showImagePreview(this.src)" style="cursor: pointer;" title="Click to view full image" />
        <div id="detailPicturePlaceholder" class="profile-placeholder">
          <!-- Fallback user icon -->
          <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 496 512" height="70px" width="70px" xmlns="http://www.w3.org/2000/svg"><path d="M248 8C111 8 0 119 0 256s111 248 248 248 248-111 248-248S385 8 248 8zm0 96c48.6 0 88 39.4 88 88s-39.4 88-88 88-88-39.4-88-88 39.4-88 88-88zm0 344c-58.7 0-111.3-26.6-146.5-68.2 18.8-35.4 55.6-59.8 98.5-59.8 2.4 0 4.8.4 7.1 1.1 13 4.2 26.6 6.9 40.9 6.9 14.3 0 28-2.7 40.9-6.9 2.3-.7 4.7-1.1 7.1-1.1 42.9 0 79.7 24.4 98.5 59.8C359.3 421.4 306.7 448 248 448z"></path></svg>
        </div>
      </div>
      <h2 id="detailName">-</h2>
      <p id="detailID">-</p>
      
      <div class="action-buttons">
        <?php
        $btnType = 'edit';
        $btnText = 'Edit';
        $btnId = 'detailBtnEdit';
        $btnSvgIcon = '<svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 24 24" height="10px" width="10px" xmlns="http://www.w3.org/2000/svg"><path fill="none" stroke="#2c5530" stroke-width="2" d="M14,4 L20,10 L14,4 Z M22.2942268,5.29422684 L18.7057732,1.70577316 C18.3152488,1.31524884 17.682084,1.31524884 17.2915596,1.70577316 L2.5,16.5 L2,22 L7.5,21.5 L22.2942268,6.70577316 C22.6847512,6.31524884 22.6847512,5.682084 22.2942268,5.29422684 Z M3,19 L5,21 L3,19 Z M7,15 L9,17 L7,15 Z"></path></svg>';
        include __DIR__ . '/Button.php';

        $btnType = 'delete';
        $btnText = 'Delete';
        $btnId = 'detailBtnDelete';
        $btnSvgIcon = '<svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 256 256" height="10px" width="10px" xmlns="http://www.w3.org/2000/svg"><path d="M216,48H176V40a24,24,0,0,0-24-24H104A24,24,0,0,0,80,40v8H40a8,8,0,0,0,0,16h8V208a16,16,0,0,0,16,16H192a16,16,0,0,0,16-16V64h8a8,8,0,0,0,0-16ZM96,40a8,8,0,0,1,8-8h48a8,8,0,0,1,8,8v8H96Zm96,168H64V64H192ZM112,104v64a8,8,0,0,1-16,0V104a8,8,0,0,1,16,0Zm48,0v64a8,8,0,0,1-16,0V104a8,8,0,0,1,16,0Z"></path></svg>';
        include __DIR__ . '/Button.php';
        ?>
      </div>
    </div>

    <!-- Personal Information -->
    <div class="info-section">
      <div class="section-title">
        <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 496 512" height="14" width="14" xmlns="http://www.w3.org/2000/svg"><path d="M248 8C111 8 0 119 0 256s111 248 248 248 248-111 248-248S385 8 248 8zm0 96c48.6 0 88 39.4 88 88s-39.4 88-88 88-88-39.4-88-88 39.4-88 88-88zm0 344c-58.7 0-111.3-26.6-146.5-68.2 18.8-35.4 55.6-59.8 98.5-59.8 2.4 0 4.8.4 7.1 1.1 13 4.2 26.6 6.9 40.9 6.9 14.3 0 28-2.7 40.9-6.9 2.3-.7 4.7-1.1 7.1-1.1 42.9 0 79.7 24.4 98.5 59.8C359.3 421.4 306.7 448 248 448z"></path></svg>
        <span>Personal Information</span>
      </div>
      <div class="info-list">
        <div class="info-row">
          <div class="info-label">Gender:</div>
          <div class="info-value" id="detailGender">-</div>
        </div>
        <div class="info-row">
          <div class="info-label">Marital Status:</div>
          <div class="info-value" id="detailMaritalStatus">-</div>
        </div>
        <div class="info-row">
          <div class="info-label">Birth Date:</div>
          <div class="info-value" id="detailBirthDate">-</div>
        </div>
        <div class="info-row">
          <div class="info-label">Age:</div>
          <div class="info-value" id="detailAge">-</div>
        </div>
        <div class="info-row">
          <div class="info-label">Cellphone Num.:</div>
          <div class="info-value" id="detailCellphone">-</div>
        </div>
        <div class="info-row">
          <div class="info-label">Address:</div>
          <div class="info-value" id="detailAddress">-</div>
        </div>
      </div>
    </div>

    <div class="divider"></div>

    <!-- Farm Plots -->
    <div class="info-section min-h-200">
      <div class="section-title">
        <svg stroke="currentColor" fill="none" stroke-width="2" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round" height="14" width="14" xmlns="http://www.w3.org/2000/svg"><path d="m12 8 6-3-6-3v10"></path><path d="m8 11.99-5.5 3.14a1 1 0 0 0 0 1.74l8.5 4.86a2 2 0 0 0 2 0l8.5-4.86a1 1 0 0 0 0-1.74L16 12"></path><path d="m6.49 12.85 11.02 6.3"></path><path d="M17.51 12.85 6.5 19.15"></path></svg>
        <span>Farm Plots</span>
      </div>
      <div id="detailFarmPlots" class="section-content">
        <div class="empty-state">
          <svg stroke="currentColor" fill="none" stroke-width="2" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round" height="32" width="32" xmlns="http://www.w3.org/2000/svg"><path d="m12 8 6-3-6-3v10"></path><path d="m8 11.99-5.5 3.14a1 1 0 0 0 0 1.74l8.5 4.86a2 2 0 0 0 2 0l8.5-4.86a1 1 0 0 0 0-1.74L16 12"></path><path d="m6.49 12.85 11.02 6.3"></path><path d="M17.51 12.85 6.5 19.15"></path></svg>
          <p>No farm plots available</p>
        </div>
      </div>
    </div>

    <div class="divider"></div>

    <!-- Coffee Seedling Records -->
    <div class="info-section min-h-200">
      <div class="section-header">
        <div class="section-title mb-0">
          <img src="../../assets/icons/seedling.png" alt="Coffee Seedling" style="width: 14px; height: 14px; object-fit: contain;" />
          <span>Coffee Seedling Records</span>
        </div>
        <button class="btn-add" id="detailBtnAddSeedling">
          <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 24 24" height="8" width="8" xmlns="http://www.w3.org/2000/svg"><path d="M11 11V5H13V11H19V13H13V19H11V13H5V11H11Z"></path></svg>
          <span>Add Seedling Record</span>
        </button>
      </div>
      <div id="detailSeedlingRecords" class="section-content-margin">
        <div class="empty-state">
          <img src="../../assets/icons/seedling.png" alt="No records" />
          <p>No seedling records available</p>
        </div>
      </div>
    </div>

    <div class="divider"></div>

    <!-- Crop Survey Status -->
    <div class="info-section min-h-200">
      <div class="section-header">
        <div class="section-title mb-0">
          <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 24 24" height="14" width="14" xmlns="http://www.w3.org/2000/svg"><path fill="none" d="M0 0h24v24H0V0z"></path><path d="M19 3h-4.18C14.4 1.84 13.3 1 12 1c-1.3 0-2.4.84-2.82 2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-7 0c.55 0 1 .45 1 1s-.45 1-1 1-1-.45-1-1 .45-1 1-1zm2 14H7v-2h7v2zm3-4H7v-2h10v2zm0-4H7V7h10v2z"></path></svg>
          <span>Crop Survey Status</span>
        </div>
        <button class="btn-add" id="detailBtnAddSurvey">
          <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 24 24" height="8" width="8" xmlns="http://www.w3.org/2000/svg"><path d="M11 11V5H13V11H19V13H13V19H11V13H5V11H11Z"></path></svg>
          <span>Add Survey Record</span>
        </button>
      </div>
      <div id="detailCropSurvey" class="section-content-margin">
        <div class="empty-state">
          <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 24 24" height="32" width="32" xmlns="http://www.w3.org/2000/svg"><path fill="none" d="M0 0h24v24H0V0z"></path><path d="M19 3h-4.18C14.4 1.84 13.3 1 12 1c-1.3 0-2.4.84-2.82 2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-7 0c.55 0 1 .45 1 1s-.45 1-1 1-1-.45-1-1 .45-1 1-1zm2 14H7v-2h7v2zm3-4H7v-2h10v2zm0-4H7V7h10v2z"></path></svg>
          <p>No crop survey data available</p>
        </div>
      </div>
    </div>
  </div>
</div>

<style>
  /* Detail Panel Styles */
  .data-table-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: rgba(0, 0, 0, 0.3); /* Slightly darkened for better contrast */
    z-index: 9999;
  }

  .data-table-overlay.hidden,
  .data-table-detail-panel.hidden,
  .hidden {
    display: none !important;
  }

  .data-table-detail-panel {
    position: absolute;
    top: 0;
    right: 0;
    bottom: 0;
    width: 480px;
    height: 100%;
    background-color: var(--white);
    border-left: 2px solid var(--dark-green);
    border-top: 2px solid var(--dark-green);
    border-bottom: 2px solid var(--dark-green);
    box-shadow: -4px 0 15px rgba(0, 0, 0, 0.1);
    z-index: 10000;
    display: flex;
    flex-direction: column;
    overflow-y: hidden;
  }

  .data-table-detail-panel.hidden {
    display: none;
  }

  .detail-panel-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1rem 1.2rem;
    border-bottom: 1px solid #e9ecef;
    background-color: var(--white);
    z-index: 10;
  }

  .detail-panel-header h3 {
    font-size: 0.85rem;
    font-weight: 700;
    color: var(--dark-green);
    margin: 0;
  }

  .detail-panel-close {
    background: transparent;
    border: none;
    font-size: 1.8rem;
    color: var(--dark-green);
    cursor: pointer;
    padding: 0;
    line-height: 1;
    transition: color 0.2s ease;
  }

  .detail-panel-close:hover {
    color: #044029;
  }

  .detail-panel-body {
    flex: 1;
    overflow-y: auto;
    scrollbar-width: thin;
    padding: 2rem 1rem;
  }

  .profile-section {
    display: flex;
    flex-direction: column;
    align-items: center;
    margin-bottom: 1.5rem;
    text-align: center;
  }

  .profile-image-container {
    margin-bottom: 0.5rem;
    display: flex;
    justify-content: center;
  }

  .profile-image {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    border: 3px solid white;
    object-fit: cover;
    box-shadow: 0 2px 6px rgba(0,0,0,0.15);
  }

  .profile-placeholder {
    display: flex;
    justify-content: center;
    padding-top: 1rem;
    align-items: center;
    width: 80px;
    height: 80px;
    border-radius: 50%;
    border: 1px solid white;
    background-color: #f1f3f5;
    box-shadow: 0 2px 6px rgba(0,0,0,0.15);
    color: #adb5bd;
  }

  #detailName {
    font-size: 0.75rem;
    font-weight: 600;
    color: #2c3e50;
    margin: 0 0 0.3rem 0;
  }

  #detailID {
    font-size: 0.65rem;
    color: #6c757d;
    margin: 0 0 0.8rem 0;
  }

  .action-buttons {
    display: flex;
    justify-content: center;
    gap: 0.7rem;
  }

  .action-buttons button {
    background-color: white;
    border-radius: 4px;
    font-size: 0.6rem;
    padding: 0.2rem 1rem;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 0.2rem;
    font-weight: 500;
  }

  .btn-edit {
    color: var(--dark-green);
    border: 1px solid var(--dark-green);
  }

  .btn-delete {
    color: #dc3545;
    border: 1px solid #dc3545;
  }

  .info-section {
    margin-bottom: 1.5rem;
  }

  .info-section.min-h-200 {
    min-height: 200px;
  }

  .section-title {
    font-size: 0.8rem;
    font-weight: 600;
    color: #2c5530;
    margin-bottom: 1rem;
    display: flex;
    align-items: center;
    gap: 0.3rem;
  }

  .section-title.mb-0 {
    margin-bottom: 0;
  }

  .section-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 0.6rem;
  }

  .btn-add {
    padding: 0.35rem 0.5rem;
    background-color: var(--dark-green);
    color: white;
    border: 1px solid var(--dark-green);
    border-radius: 3px;
    cursor: pointer;
    font-size: 0.6rem;
    font-weight: 500;
    display: flex;
    align-items: center;
    gap: 3px;
  }

  .info-list {
    margin-left: 1.5rem;
  }

  .info-row {
    display: flex;
    align-items: flex-start;
    gap: 0.5rem;
    margin-bottom: 0.6rem;
  }

  .info-label {
    color: var(--dark-gray, #495057);
    font-size: 0.7rem;
    font-weight: 700;
    min-width: 100px;
  }

  .info-value {
    color: var(--dark-green);
    font-size: 0.7rem;
    font-weight: 500;
    flex: 1;
  }

  .divider {
    height: 1px;
    background-color: #e9ecef;
    margin: 1rem 0;
  }

  .section-content {
    margin-left: 0.8rem;
  }

  .section-content-margin {
    margin-left: 1.5rem;
    margin-right: 1rem;
  }

  .empty-state {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    text-align: center;
    padding: 1.5rem 0.8rem;
    color: #8a94a6;
    font-size: 0.65rem;
    gap: 0.5rem;
    margin-top: 1rem;
  }

  .empty-state svg, .empty-state img {
    color: #b0bac9;
    width: 32px;
    height: 32px;
    object-fit: contain;
    flex-shrink: 0;
  }

  .empty-state img {
    opacity: 0.35;
    filter: grayscale(100%);
  }

  .empty-state p {
    margin: 0;
  }

  @media (max-width: 1024px) {
    .data-table-detail-panel {
      width: 350px;
    }
  }

  @media (max-width: 768px) {
    .data-table-detail-panel {
      width: 100%;
    }
  }
  /* Enriched lists styling inside detail panel */
  .detail-item-card {
    background-color: #f8f9fa;
    border: 1px solid #e9ecef;
    border-radius: 6px;
    padding: 0.8rem;
    margin-bottom: 0.8rem;
    box-shadow: 0 1px 3px rgba(0,0,0,0.02);
    transition: all 0.2s ease;
  }
  .detail-item-card:hover {
    box-shadow: 0 2px 5px rgba(0,0,0,0.05);
    background-color: #f1f3f5;
  }
  .detail-card-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 0.4rem;
  }
  .detail-card-title {
    font-size: 0.7rem;
    font-weight: 700;
    color: var(--dark-green);
  }
  .detail-card-subtitle {
    font-size: 0.6rem;
    color: #6c757d;
  }
  .detail-card-body {
    display: flex;
    flex-wrap: wrap;
    gap: 0.6rem;
    font-size: 0.65rem;
    color: #495057;
    width: 100%;
  }
  .detail-metric {
    display: flex;
    flex-direction: column;
    min-width: 80px;
    flex: 1;
  }
  .detail-metric-label {
    font-size: 0.55rem;
    color: #868e96;
    text-transform: uppercase;
    font-weight: 600;
  }
  .detail-metric-value {
    font-size: 0.7rem;
    font-weight: 700;
    color: var(--dark-green);
  }
  .detail-badge-pill {
    background-color: #e8f5e8;
    color: var(--dark-green);
    padding: 2px 6px;
    border-radius: 10px;
    font-size: 0.55rem;
    font-weight: 600;
  }
  .coord-pill {
    background-color: #e9ecef;
    color: #495057;
    padding: 2px 6px;
    border-radius: 4px;
    font-size: 0.55rem;
    font-family: monospace;
    display: inline-block;
    margin-top: 0.2rem;
  }

  .crop-survey-pics {
    display: flex;
    flex-wrap: wrap;
    gap: 0.4rem;
    margin-top: 0.6rem;
    width: 100%;
  }
  .crop-survey-thumbnail {
    width: 50px;
    height: 50px;
    object-fit: cover;
    border-radius: 4px;
    cursor: pointer;
    border: 1px solid #dee2e6;
    transition: transform 0.2s ease;
  }
  .crop-survey-thumbnail:hover {
    transform: scale(1.08);
  }
  
  /* Farm Plot Indicator Card Styles */
  .farm-plots-container {
    display: flex;
    flex-wrap: wrap;
    gap: 1.2rem;
    margin-top: 0.8rem;
    margin-left: 0.8rem;
  }
  .farm-plot-indicator {
    display: flex;
    flex-direction: column;
    align-items: center;
    width: 80px;
    cursor: pointer;
  }
  .farm-plot-icon-box {
    width: 80px;
    height: 80px;
    background-color: #f4fcf7;
    border: 1.5px solid #d1ebd8;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.2s ease;
  }
  .farm-plot-icon-box:hover {
    background-color: #e8f7ec;
    border-color: var(--dark-green);
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);
  }
  .farm-plot-icon-box svg {
    color: var(--dark-green);
    width: 36px;
    height: 36px;
  }
  .farm-plot-id-label {
    margin-top: 0.5rem;
    font-size: 0.65rem;
    font-weight: 700;
    color: var(--dark-green);
    text-align: center;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    width: 100%;
  }

  /* ── Accordion card (seedling records & crop surveys) ── */
  .accordion-card {
    border: 1px solid #e0ebe3;
    border-radius: 8px;
    margin-bottom: 0.55rem;
    overflow: hidden;
    background: #fff;
  }
  .accordion-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0.65rem 0.9rem;
    cursor: pointer;
    user-select: none;
    background: #f8faf8;
    transition: background 0.15s;
  }
  .accordion-header:hover {
    background: #eef5ee;
  }
  .accordion-header-title {
    font-size: 0.7rem;
    font-weight: 700;
    color: var(--dark-green);
  }
  .accordion-chevron {
    width: 16px;
    height: 16px;
    color: var(--dark-green);
    transition: transform 0.25s ease;
    flex-shrink: 0;
  }
  .accordion-chevron.open {
    transform: rotate(180deg);
  }
  .accordion-body {
    display: none;
    padding: 0.75rem 0.9rem 0.6rem;
    border-top: 1px solid #e0ebe3;
    background: #fff;
  }
  .accordion-body.open {
    display: block;
  }
  /* Key-value row list */
  .accordion-kv-list {
    list-style: none;
    padding: 0;
    margin: 0 0 0.75rem;
  }
  .accordion-kv-list li {
    display: flex;
    gap: 0.5rem;
    padding: 0.22rem 0;
    font-size: 0.68rem;
    color: #333;
    border-bottom: 1px solid #f1f3f1;
  }
  .accordion-kv-list li:last-child {
    border-bottom: none;
  }
  .accordion-kv-key {
    font-weight: 700;
    color: #444;
    min-width: 110px;
    flex-shrink: 0;
  }
  .accordion-kv-val {
    color: #555;
  }
  /* Action buttons row */
  .accordion-actions {
    display: flex;
    justify-content: flex-end;
    gap: 0.5rem;
    margin-top: 0.4rem;
  }
</style>

<!-- Image Preview Overlay Modal -->
<div id="imagePreviewOverlay" class="image-preview-overlay hidden" onclick="closeImagePreview()">
  <span class="image-preview-close" onclick="closeImagePreview()">&times;</span>
  <img class="image-preview-content" id="imagePreviewImg" onclick="event.stopPropagation()">
</div>

<style>
  /* Image Preview Overlay */
  .image-preview-overlay {
    position: fixed;
    top: 0; left: 0; right: 0; bottom: 0;
    background-color: rgba(0, 0, 0, 0.85);
    display: none;
    justify-content: center;
    align-items: center;
    z-index: 20000;
    opacity: 0;
    transition: opacity 0.25s ease;
  }
  .image-preview-overlay.active {
    opacity: 1;
  }
  .image-preview-content {
    max-width: 90%;
    max-height: 90%;
    border-radius: 6px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.5);
    transform: scale(0.9);
    transition: transform 0.25s ease;
  }
  .image-preview-overlay.active .image-preview-content {
    transform: scale(1);
  }
  .image-preview-close {
    position: absolute;
    top: 20px;
    right: 30px;
    color: #fff;
    font-size: 40px;
    font-weight: bold;
    cursor: pointer;
    transition: 0.2s;
    user-select: none;
  }
  .image-preview-close:hover {
    color: #bbb;
  }
</style>

<script>
  function showImagePreview(src) {
    const overlay = document.getElementById('imagePreviewOverlay');
    const img = document.getElementById('imagePreviewImg');
    if (overlay && img) {
      img.src = src;
      overlay.style.display = 'flex';
      void overlay.offsetWidth; // Force reflow
      overlay.classList.add('active');
      overlay.classList.remove('hidden');
    }
  }
  function closeImagePreview() {
    const overlay = document.getElementById('imagePreviewOverlay');
    if (overlay) {
      overlay.classList.remove('active');
      setTimeout(() => {
        overlay.style.display = 'none';
        overlay.classList.add('hidden');
      }, 250);
    }
  }
</script>
