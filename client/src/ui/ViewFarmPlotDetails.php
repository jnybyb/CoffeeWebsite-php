<?php
/**
 * ViewFarmPlotDetails Component
 * 
 * Usage:
 * include_once '../ui/ViewFarmPlotDetails.php';
 * 
 * To open:
 * openViewFarmPlotDetailsModal(plot, allPlots, allBeneficiaries, onDeleteSuccessCallback);
 */
?>

<style>
.view-plot-modal-overlay {
  position: fixed;
  top: 0; left: 0; right: 0; bottom: 0;
  background-color: rgba(0, 0, 0, 0.60);
  display: flex;
  justify-content: center;
  align-items: center;
  z-index: 1000;
  opacity: 0;
  visibility: hidden;
  transition: opacity 0.3s ease, visibility 0.3s ease;
}

.view-plot-modal-overlay.active {
  opacity: 1;
  visibility: visible;
}

.view-plot-form-container {
  background-color: var(--white, #ffffff);
  border-radius: 5px;
  min-width: 450px;
  max-width: 500px;
  width: 85%;
  max-height: 90vh;
  box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
  position: relative;
  display: flex;
  flex-direction: column;
  transform: scale(0.95);
  transition: transform 0.3s ease;
  overflow: hidden;
}

.view-plot-modal-overlay.active .view-plot-form-container {
  transform: scale(1);
}

.view-plot-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  border-bottom: .5px solid var(--border-gray, #e9ecef);
  padding: 1.4rem 1.4rem;
  background: var(--white, #ffffff);
  position: sticky;
  border-radius: 5px;
  top: 0;
  z-index: 10;
}

.view-plot-close-btn {
  background: none;
  border: none;
  font-size: 30px;
  color: var(--gray-icon, #6c757d);
  cursor: pointer;
  padding: 0;
  width: 28px;
  height: 28px;
  display: flex;
  align-items: center;
  justify-content: center;
  border-radius: 50%;
  transition: background-color 0.2s;
}

.view-plot-close-btn:hover {
  background-color: var(--border-gray, #e9ecef);
}

.view-plot-content-area {
  padding: 0 0.75rem;
  overflow-y: auto;
  flex: 1;
  display: flex;
  flex-direction: column;
  scrollbar-width: thin;
}

.view-plot-body {
  padding: 1rem;
  display: flex;
  flex-direction: column;
  gap: 12px;
}

.view-plot-section {
  padding: 0;
}

.view-plot-section-title {
  font-size: 12px;
  font-weight: 600;
  color: var(--dark-green, #055035);
  margin-bottom: 6px;
}

.view-plot-profile-card {
  display: flex;
  align-items: center;
  gap: 12px;
  padding: 12px;
  background-color: rgba(0, 0, 0, 0.035);
  border-radius: 4px;
  border: 1px solid var(--border-gray, #e9ecef);
}

.view-plot-profile-avatar {
  width: 45px;
  height: 45px;
  border-radius: 50%;
  border: 2px solid var(--dark-green, #055035);
  object-fit: cover;
  background-color: var(--light-gray, #f5f5f5);
  display: flex;
  align-items: center;
  justify-content: center;
  color: #888;
  font-size: 14px;
  font-weight: bold;
  overflow: hidden;
  transition: transform 0.2s ease;
}

.view-plot-profile-avatar img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.view-plot-profile-avatar.clickable {
  cursor: pointer;
}

.view-plot-profile-avatar.clickable:hover {
  transform: scale(1.05);
}

.view-plot-profile-info {
  flex: 1;
}

.view-plot-beneficiary-name {
  font-size: 12px;
  font-weight: 600;
  color: var(--dark-green, #055035);
  margin-bottom: 4px;
}

.view-plot-beneficiary-id {
  font-size: 10px;
  color: #888;
  margin-bottom: 3px;
  font-weight: 500;
  display: flex;
  align-items: center;
  gap: 4px;
}

.view-plot-address {
  font-size: 10px;
  color: #666;
  line-height: 1.4;
  display: flex;
  align-items: flex-start;
  gap: 4px;
}

.view-plot-coordinates-container {
  padding: 10px;
  background-color: rgba(0, 0, 0, 0.035);
  border-radius: 4px;
  border: 1px solid var(--border-gray, #e9ecef);
  max-height: 240px;
  overflow-y: auto;
  font-size: 11px;
}

.view-plot-table {
  width: 100%;
  border-collapse: collapse;
}

.view-plot-table th {
  text-align: left;
  padding: 6px 8px;
  font-size: 10px;
  color: #888;
  border-bottom: 1px solid var(--border-gray, #e9ecef);
}

.view-plot-table td {
  padding: 6px 8px;
  font-size: 10px;
  border-bottom: 1px solid var(--light-gray, #f5f5f5);
}

.view-plot-other-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(90px, 1fr));
  gap: 10px;
  padding: 8px 0;
}

.view-plot-other-card {
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 10px;
  padding: 16px 12px;
  background-color: var(--white, #ffffff);
  border-radius: 6px;
  border: 1px solid var(--light-gray, #f5f5f5);
  transition: all 0.2s ease;
  cursor: pointer;
  min-height: 110px;
  justify-content: center;
}

.view-plot-other-card:hover {
  border-color: var(--dark-green, #055035);
  transform: translateY(-2px);
  box-shadow: 0 4px 12px rgba(5, 80, 53, 0.15);
}

.view-plot-other-card-icon {
  display: flex;
  align-items: center;
  justify-content: center;
  width: 48px;
  height: 48px;
  border-radius: 6px;
  background-color: rgba(5, 80, 53, 0.1);
  color: var(--dark-green, #055035);
}

.view-plot-other-card-title {
  font-size: 10px;
  font-weight: 600;
  color: #333;
  text-align: center;
  word-break: break-word;
  width: 100%;
}

.view-plot-actions {
  display: flex;
  gap: 12px;
  justify-content: flex-end;
  padding-top: 0.75rem;
  margin-top: 12px;
  border-top: 1px solid rgba(0, 0, 0, 0.035);
}

.view-plot-btn {
  padding: 10px 18px;
  border-radius: 5px;
  font-size: 12px;
  font-weight: 600;
  cursor: pointer;
  border: none;
  transition: opacity 0.2s ease;
}

.view-plot-btn:hover {
  opacity: 0.9;
}

.view-plot-btn.btn-edit {
  background-color: var(--dark-green, #055035);
  color: var(--white, #ffffff);
}

.view-plot-btn.btn-delete {
  background-color: var(--error-red, #b00020);
  color: var(--white, #ffffff);
}

/* Image Preview Styles */
.view-plot-img-preview-overlay {
  position: fixed;
  top: 0; left: 0; right: 0; bottom: 0;
  background: rgba(0, 0, 0, 0.85);
  z-index: 2000;
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 20px;
}

.view-plot-img-preview-close {
  position: absolute;
  top: 20px;
  right: 30px;
  background: rgba(255, 255, 255, 0.9);
  border: none;
  border-radius: 50%;
  width: 40px;
  height: 40px;
  font-size: 24px;
  color: #333;
  cursor: pointer;
  display: flex;
  align-items: center;
  justify-content: center;
  transition: all 0.2s ease;
  font-weight: bold;
  z-index: 2001;
}

.view-plot-img-preview-close:hover {
  background-color: #ffffff;
  transform: scale(1.1);
}

.view-plot-img-preview-content {
  max-width: 90%;
  max-height: 90%;
  border-radius: 8px;
  box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
  object-fit: contain;
}
</style>

<div class="view-plot-modal-overlay" id="viewPlotModalOverlay">
  <div class="view-plot-form-container">
    
    <!-- Header -->
    <div class="view-plot-header">
      <h2 style="margin: 0; font-size: 1.2rem; font-weight: 700;">
        <span style="color: var(--dark-green);">Plot:</span> <span id="viewPlotTitleId">N/A</span>
      </h2>
      <button 
        type="button" 
        class="view-plot-close-btn" 
        id="viewPlotCloseBtn"
        aria-label="Close"
      >
        &times;
      </button>
    </div>

    <!-- Scrollable Content -->
    <div class="view-plot-content-area">
      <div class="view-plot-body">
        
        <!-- Beneficiary Information -->
        <div class="view-plot-section">
          <div class="view-plot-section-title">Beneficiary Information</div>
          <div class="view-plot-profile-card">
            <div class="view-plot-profile-avatar" id="viewPlotAvatar">
              <!-- Avatar Img or initials -->
            </div>
            <div class="view-plot-profile-info">
              <div class="view-plot-beneficiary-name" id="viewPlotBeneficiaryName">Unknown Beneficiary</div>
              <div class="view-plot-beneficiary-id">
                <svg width="10" height="10" fill="currentColor" viewBox="0 0 24 24"><path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-7 3c1.66 0 3 1.34 3 3s-1.34 3-3 3-3-1.34-3-3 1.34-3 3-3zm6 12H6v-1.5c0-1.99 4-3 6-3s6 1.01 6 3V18z"/></svg>
                <span id="viewPlotBeneficiaryId">N/A</span>
              </div>
              <div class="view-plot-address">
                <svg width="10" height="10" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/></svg>
                <span id="viewPlotAddress">Address not available</span>
              </div>
            </div>
          </div>
        </div>

        <!-- Plot Coordinates -->
        <div class="view-plot-section">
          <div class="view-plot-section-title">Plot Coordinates</div>
          <div id="viewPlotCoordinatesContainer">
            <!-- Table rendered dynamically -->
          </div>
        </div>

        <!-- Other Farm Plots -->
        <div class="view-plot-section">
          <div class="view-plot-section-title">Other Farm Plots</div>
          <div class="view-plot-other-grid" id="viewPlotOtherGrid">
            <!-- Other plots rendered here -->
          </div>
        </div>

        <!-- Action Buttons -->
        <div class="view-plot-actions">
          <button class="view-plot-btn btn-edit" id="viewPlotEditBtn">Edit Plot</button>
          <button class="view-plot-btn btn-delete" id="viewPlotDeleteBtn">Delete Plot</button>
        </div>

      </div>
    </div>

  </div>
</div>

<!-- Image Preview Modal -->
<div class="view-plot-img-preview-overlay" id="viewPlotImgPreview" style="display: none;">
  <button type="button" class="view-plot-img-preview-close" id="viewPlotImgPreviewClose">&times;</button>
  <img class="view-plot-img-preview-content" id="viewPlotImgPreviewContent" alt="Beneficiary Profile">
</div>

<script>
(function() {
  const overlay = document.getElementById('viewPlotModalOverlay');
  const closeBtn = document.getElementById('viewPlotCloseBtn');
  const editBtn = document.getElementById('viewPlotEditBtn');
  const deleteBtn = document.getElementById('viewPlotDeleteBtn');
  const avatarEl = document.getElementById('viewPlotAvatar');
  const imgPreview = document.getElementById('viewPlotImgPreview');
  const imgPreviewClose = document.getElementById('viewPlotImgPreviewClose');
  const imgPreviewContent = document.getElementById('viewPlotImgPreviewContent');

  let currentPlot = null;
  let allPlots = [];
  let allBeneficiaries = [];
  let deleteSuccessCallback = null;

  // Convert decimal coordinates to DMS format for display
  const toDMS = (decimal, isLat) => {
    if (decimal === null || decimal === undefined || isNaN(decimal)) return '';
    const abs = Math.abs(Number(decimal));
    const degrees = Math.floor(abs);
    const minutesFloat = (abs - degrees) * 60;
    const minutes = Math.floor(minutesFloat);
    const seconds = (minutesFloat - minutes) * 60;
    const dir = isLat ? (decimal >= 0 ? 'N' : 'S') : (decimal >= 0 ? 'E' : 'W');
    const secFixed = seconds.toFixed(2);
    return `${degrees}° ${minutes}' ${secFixed}" ${dir}`;
  };

  const getInitials = (name) => {
    if (!name) return '??';
    return name.split(' ')
      .map(word => word.charAt(0))
      .join('')
      .toUpperCase()
      .slice(0, 2);
  };

  const closeViewPlotModal = () => {
    overlay.classList.remove('active');
  };

  closeBtn.addEventListener('click', closeViewPlotModal);
  overlay.addEventListener('click', (e) => {
    if (e.target === overlay) closeViewPlotModal();
  });

  // Image Preview functionality
  avatarEl.addEventListener('click', () => {
    if (currentPlot && currentPlot.beneficiaryPicture) {
      const apiUrl = typeof API_BASE_URL !== 'undefined' ? API_BASE_URL : 'http://localhost:5000/api';
      imgPreviewContent.src = `${apiUrl.replace('/api', '')}${currentPlot.beneficiaryPicture}`;
      imgPreview.style.display = 'flex';
    }
  });

  imgPreviewClose.addEventListener('click', () => {
    imgPreview.style.display = 'none';
  });

  imgPreview.addEventListener('click', (e) => {
    if (e.target === imgPreview) {
      imgPreview.style.display = 'none';
    }
  });

  // Edit plot action
  editBtn.addEventListener('click', () => {
    closeViewPlotModal();
    if (typeof openEditFarmPlotModal === 'function') {
      openEditFarmPlotModal(currentPlot, allBeneficiaries, () => {
        if (deleteSuccessCallback) {
          deleteSuccessCallback();
        }
      });
    } else {
      console.error('EditFarmPlotModal script not loaded.');
      if (typeof AlertModal !== 'undefined') {
        AlertModal.show({
          type: 'error',
          title: 'Error',
          message: 'Edit modal not available.'
        });
      } else {
        alert('Edit modal not available.');
      }
    }
  });

  // Delete plot functionality
  deleteBtn.addEventListener('click', () => {
    const plotId = currentPlot.id || currentPlot.plotId;
    if (typeof AlertModal !== 'undefined') {
      AlertModal.show({
        type: 'delete',
        title: 'Delete Plot?',
        message: `Are you sure you want to delete plot ${plotId}? This action cannot be undone.`,
        showCancel: true,
        confirmText: 'Delete',
        cancelText: 'Cancel',
        onConfirm: () => {
          AlertModal.hide();
          executeDeletePlot(plotId);
        },
        onCancel: () => {
          AlertModal.hide();
        }
      });
    } else if (confirm(`Are you sure you want to delete plot ${plotId}? This action cannot be undone.`)) {
      executeDeletePlot(plotId);
    }
  });

  const executeDeletePlot = async (plotId) => {
    const apiUrl = typeof API_BASE_URL !== 'undefined' ? API_BASE_URL : 'http://localhost:5000/api';
    
    if (typeof LoadingModal !== 'undefined') {
      LoadingModal.show({ title: 'Deleting...', message: 'Removing farm plot boundary...', spinnerColor: '#dc3545' });
    }

    try {
      const token = localStorage.getItem('authToken');
      const response = await fetch(`${apiUrl}/farm-plots/${plotId}`, {
        method: 'DELETE',
        headers: { 'Authorization': `Bearer ${token}` }
      });

      // Display loading for 1s
      await new Promise(resolve => setTimeout(resolve, 1000));

      if (!response.ok) {
        throw new Error('Delete operation failed');
      }

      if (typeof LoadingModal !== 'undefined') LoadingModal.hide();

      if (typeof AlertModal !== 'undefined') {
        AlertModal.show({
          type: 'success',
          title: 'Deleted!',
          message: 'Farm plot boundary has been successfully deleted.',
          hideButton: true,
          autoClose: true,
          autoCloseDelay: 1200,
          borderRadius: 4
        });
        await new Promise(resolve => setTimeout(resolve, 1200));
      }

      closeViewPlotModal();
      if (deleteSuccessCallback) {
        deleteSuccessCallback();
      }
    } catch (error) {
      console.error('Error deleting plot:', error);
      if (typeof LoadingModal !== 'undefined') LoadingModal.hide();

      if (typeof AlertModal !== 'undefined') {
        AlertModal.show({
          type: 'error',
          title: 'Delete Failed',
          message: error.message || 'An unexpected error occurred while deleting the plot.'
        });
      } else {
        alert('Delete failed. Please try again.');
      }
    }
  };

  const renderPlotDetailsInModal = (plot) => {
    currentPlot = plot;
    const apiUrl = typeof API_BASE_URL !== 'undefined' ? API_BASE_URL : 'http://localhost:5000/api';

    // Title
    document.getElementById('viewPlotTitleId').textContent = plot.id || plot.plotId || 'N/A';

    // Beneficiary info
    document.getElementById('viewPlotBeneficiaryName').textContent = plot.beneficiaryName || 'Unknown Beneficiary';
    document.getElementById('viewPlotBeneficiaryId').textContent = plot.beneficiaryId || 'N/A';
    document.getElementById('viewPlotAddress').textContent = plot.address || 'Address not available';

    // Profile picture/initials
    avatarEl.innerHTML = '';
    avatarEl.classList.remove('clickable');
    if (plot.beneficiaryPicture) {
      avatarEl.classList.add('clickable');
      const img = document.createElement('img');
      img.src = `${apiUrl.replace('/api', '')}${plot.beneficiaryPicture}`;
      img.alt = 'Profile';
      avatarEl.appendChild(img);
    } else {
      avatarEl.textContent = getInitials(plot.beneficiaryName);
    }

    // Render coordinates table
    const coordsContainer = document.getElementById('viewPlotCoordinatesContainer');
    if (plot.coordinates && Array.isArray(plot.coordinates) && plot.coordinates.length > 0) {
      coordsContainer.className = 'view-plot-coordinates-container';
      
      let rowsHtml = plot.coordinates.map((c, i) => `
        <tr>
          <td>${i + 1}</td>
          <td>${toDMS(c.lat, true)}</td>
          <td>${toDMS(c.lng, false)}</td>
          <td>${c.elevation !== null && c.elevation !== undefined ? c.elevation + 'm' : 'N/A'}</td>
        </tr>
      `).join('');

      coordsContainer.innerHTML = `
        <table class="view-plot-table">
          <thead>
            <tr>
              <th>Point</th>
              <th>Latitude (DMS)</th>
              <th>Longitude (DMS)</th>
              <th>Elevation (m)</th>
            </tr>
          </thead>
          <tbody>
            ${rowsHtml}
          </tbody>
        </table>
      `;
    } else {
      coordsContainer.className = '';
      coordsContainer.innerHTML = '<div style="font-size: 11px; color: #888;">No coordinates available</div>';
    }

    // Render other farm plots
    const otherGrid = document.getElementById('viewPlotOtherGrid');
    otherGrid.innerHTML = '';

    // Find other plots belonging to the same beneficiary (excluding this one)
    const otherPlots = allPlots.filter(p => p.beneficiaryId === plot.beneficiaryId && p.id !== plot.id);

    if (otherPlots.length > 0) {
      otherPlots.forEach(p => {
        const plotCard = document.createElement('div');
        plotCard.className = 'view-plot-other-card';
        plotCard.innerHTML = `
          <div class="view-plot-other-card-icon">
            <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25"/></svg>
          </div>
          <div class="view-plot-other-card-title">${p.id || p.plotId || 'N/A'}</div>
        `;

        plotCard.addEventListener('click', () => {
          renderPlotDetailsInModal(p);
        });

        otherGrid.appendChild(plotCard);
      });
    } else {
      otherGrid.innerHTML = `
        <div style="grid-column: 1 / -1; font-size: 11px; color: #888; text-align: center; padding: 10px 0;">
          No other farm plots
        </div>
      `;
    }
  };

  // Expose function globally to trigger this modal
  window.openViewFarmPlotDetailsModal = (plot, allPlotsData, allBeneficiariesData, onDeleteSuccess) => {
    allPlots = allPlotsData || [];
    allBeneficiaries = allBeneficiariesData || [];
    deleteSuccessCallback = onDeleteSuccess;

    renderPlotDetailsInModal(plot);

    overlay.classList.add('active');
  };
})();
</script>
