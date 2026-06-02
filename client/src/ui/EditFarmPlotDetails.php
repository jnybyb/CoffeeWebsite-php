<?php
/**
 * EditFarmPlotDetails Component
 * 
 * Usage:
 * include_once '../ui/EditFarmPlotDetails.php';
 * 
 * To open:
 * openEditFarmPlotModal(plot, allBeneficiaries, onSaveSuccessCallback);
 */
?>

<style>
.edit-plot-modal-overlay {
  position: fixed;
  top: 0; left: 0; right: 0; bottom: 0;
  background-color: rgba(0, 0, 0, 0.75);
  display: flex;
  justify-content: center;
  align-items: center;
  z-index: 11000; /* Stacking order should match top dialogs */
  opacity: 0;
  visibility: hidden;
  transition: opacity 0.3s ease, visibility 0.3s ease;
}

.edit-plot-modal-overlay.active {
  opacity: 1;
  visibility: visible;
}

.edit-plot-form-container {
  background-color: var(--white, #ffffff);
  border-radius: 5px;
  max-width: 450px;
  width: 85%;
  max-height: 90vh;
  box-shadow: 0 8px 32px rgba(0, 0, 0, 0.5);
  position: relative;
  display: flex;
  flex-direction: column;
  transform: scale(0.95);
  transition: transform 0.3s ease;
}

.edit-plot-modal-overlay.active .edit-plot-form-container {
  transform: scale(1);
}

.edit-plot-content-area {
  overflow-y: auto;
  scrollbar-width: thin;
  padding: 0 0.75rem;
  flex: 1;
}

.edit-plot-content-area::-webkit-scrollbar {
  width: 6px;
}
.edit-plot-content-area::-webkit-scrollbar-track {
  background: #f1f1f1;
  border-radius: 3px;
}
.edit-plot-content-area::-webkit-scrollbar-thumb {
  background: #c1c1c1;
  border-radius: 3px;
}
.edit-plot-content-area::-webkit-scrollbar-thumb:hover {
  background: #a8a8a8;
}

.edit-plot-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  border-bottom: .5px solid var(--border-gray, #e9ecef);
  padding: 1.4rem 1.4rem;
  background: var(--white, #ffffff);
  position: sticky;
  border-radius: 5px 5px 0 0;
  top: 0;
  z-index: 10;
}

.edit-plot-close-btn {
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

.edit-plot-close-btn:hover {
  background-color: var(--border-gray, #e9ecef);
}

.edit-plot-readonly-input {
  width: 100%;
  padding: 6px 10px;
  border-radius: 4px;
  border: 1px solid var(--border-gray, #e9ecef);
  font-size: 11px;
  margin-bottom: 0;
  background: rgba(0, 0, 0, 0.035);
  color: var(--dark-text, #333);
  cursor: not-allowed;
  height: 30px;
  box-sizing: border-box;
}

.edit-plot-button-row {
  display: flex;
  gap: 0.75rem;
  justify-content: flex-end;
  padding-top: 0.75rem;
  border-top: 1px solid rgba(0, 0, 0, 0.035);
}

.edit-plot-coord-row {
  display: flex;
  gap: 6px;
  align-items: flex-start;
  padding: 6px 10px;
  background-color: rgba(5, 80, 53, 0.08);
  border-radius: 4px;
  margin-bottom: 6px;
  border: 1px solid var(--border-gray, #e9ecef);
  position: relative;
}

.edit-plot-remove-btn {
  background: none;
  border: none;
  border-radius: 4px;
  padding: 3px 6px;
  color: var(--dark-green, #055035);
  cursor: pointer;
  font-size: 18px;
  font-weight: 400;
  min-width: 20px;
  height: 20px;
  display: flex;
  align-items: center;
  justify-content: center;
  transition: all 0.2s ease;
  position: absolute;
  top: 6px;
  right: 10px;
}

.edit-plot-remove-btn:hover {
  color: var(--danger-red, #b00020);
}

.edit-plot-section-title {
  font-size: 11px;
  font-weight: 600;
  color: var(--dark-green, #055035);
  margin-top: 12px;
}

.edit-plot-point-title {
  font-size: 10px;
  font-weight: 600;
  color: var(--dark-green, #055035);
  margin-bottom: 2px;
}

.edit-plot-form-body {
  padding: 1rem;
  display: flex;
  flex-direction: column;
  gap: 12px;
}

.edit-plot-two-col {
  display: flex;
  gap: 6px;
}

.edit-plot-two-col > div {
  flex: 1;
}
</style>

<div class="edit-plot-modal-overlay" id="editFarmPlotModal">
  <form class="edit-plot-form-container" id="editFarmPlotForm" onsubmit="handleEditFarmPlotSubmit(event)">
    <input type="hidden" name="editPlotId" id="editPlotId" />

    <div class="edit-plot-header">
      <h2 style="color: var(--dark-green, #055035); margin: 0; font-size: 1.2rem; font-weight: 700;">
        Edit Plot: <span id="editPlotTitleId">N/A</span>
      </h2>
      <button type="button" class="edit-plot-close-btn" onclick="closeEditFarmPlotModal()">×</button>
    </div>

    <div class="edit-plot-content-area">
      <div class="edit-plot-form-body">
        
        <div class="edit-plot-two-col">
          <div>
            <?php
            $fieldType = 'select';
            $fieldName = 'editPlotBeneficiaryName';
            $fieldLabel = 'Beneficiary Full Name';
            $fieldPlaceholder = 'Select beneficiary';
            $fieldOptions = [];
            $fieldRequired = true;
            $fieldDisabled = true;
            include __DIR__ . '/FormField.php';
            ?>
          </div>
          <div>
            <label class="shared-form-label" style="font-weight: 500; font-size: 11px; margin-bottom: 0.1rem; display: block; color: var(--dark-green, #055035);">Beneficiary ID</label>
            <input class="edit-plot-readonly-input" id="editPlotBeneficiaryId" readonly tabindex="-1" />
          </div>
        </div>

        <div>
          <label class="shared-form-label" style="font-weight: 500; font-size: 11px; margin-bottom: 0.1rem; display: block; color: var(--dark-green, #055035);">Address</label>
          <input class="edit-plot-readonly-input" id="editPlotBeneficiaryAddress" readonly tabindex="-1" />
        </div>

        <div>
          <div class="edit-plot-section-title">Plot Boundary Coordinates</div>
          <p style="font-size: 8.5px; color: var(--dark-text, #333); margin-bottom: 10px;">
            Edit coordinate points to define the plot boundary. Minimum 4 points required.
          </p>
          
          <div id="editPlotCoordinatesContainer">
            <!-- Coordinates rendered dynamically via JS -->
          </div>
          
          <?php
          $btnType = 'add-coordinate';
          $btnOnClick = 'addEditPlotCoordinateField()';
          include __DIR__ . '/Button.php';
          ?>
          
          <div id="editPlotCoordinatesError" style="color: var(--danger-red, #b00020); font-size: 10px; margin-top: 6px; display: none;"></div>
        </div>

        <div class="edit-plot-button-row" style="padding: 1rem 0 1rem 1rem;">
          <?php
          $btnType = 'cancel';
          $btnOnClick = 'closeEditFarmPlotModal()';
          $btnStyles = 'font-size: 11px; padding: 10px 18px; border-radius: 5px;';
          include __DIR__ . '/Button.php';
          
          $btnType = 'save';
          $btnText = 'Update Plot';
          $btnId = 'editPlotSubmitBtn';
          $btnSubmit = true;
          $btnStyles = 'font-size: 11px; padding: 10px 18px; border-radius: 5px;';
          include __DIR__ . '/Button.php';
          ?>
        </div>

      </div>
    </div>
  </form>
</div>

<script>
  let editPlotCoordinatesCount = 0;
  let editPlotInitialData = null;
  let editPlotOnSaveSuccess = null;

  function escapeHtml(str) {
    if (!str) return '';
    return String(str)
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;')
        .replace(/"/g, '&quot;')
        .replace(/'/g, '&#039;');
  }

  // Convert DMS (Degrees Minutes Seconds) format to Decimal Degrees
  function dmsToDecimal(dmsString) {
    if (!dmsString) return null;
    
    const cleanStr = String(dmsString).trim();
    
    // Match DMS format: 7°15'20.4"N or 126°20'36.5"E
    const regex = /([0-9.]+)\s*°\s*([0-9.]+)?\s*'?\s*([0-9.]+)?\s*"?\s*([NSEW])?/i;
    const match = cleanStr.match(regex);
    
    if (!match) return null;
    
    const degrees = parseFloat(match[1] || 0);
    const minutes = match[2] ? parseFloat(match[2]) : 0;
    const seconds = match[3] ? parseFloat(match[3]) : 0;
    const direction = (match[4] || '').toUpperCase();
    
    let decimal = degrees + minutes / 60 + seconds / 3600;
    
    if (direction === 'S' || direction === 'W') {
      decimal *= -1;
    }
    
    return decimal;
  }

  // Convert Decimal Degrees to DMS format for display
  function decimalToDMS(decimal, isLatitude = true) {
    if (decimal === null || decimal === undefined || isNaN(decimal)) return '';
    
    const absDecimal = Math.abs(decimal);
    const degrees = Math.floor(absDecimal);
    const minutesDecimal = (absDecimal - degrees) * 60;
    const minutes = Math.floor(minutesDecimal);
    const seconds = (minutesDecimal - minutes) * 60;
    
    let direction = '';
    if (isLatitude) {
      direction = decimal >= 0 ? 'N' : 'S';
    } else {
      direction = decimal >= 0 ? 'E' : 'W';
    }
    
    return `${degrees}°${minutes}'${seconds.toFixed(1)}"${direction}`;
  }

  // Detect whether coordinate string is in DMS or decimal format
  function detectCoordinateFormat(coordString) {
    if (!coordString) return 'decimal';
    
    if (coordString.includes('°') || coordString.includes("'") || coordString.includes('"')) {
      return 'dms';
    }
    
    const decimal = parseFloat(coordString);
    if (!isNaN(decimal)) {
      return 'decimal';
    }
    
    return 'unknown';
  }

  function openEditFarmPlotModal(plot, beneficiariesList = [], onSaveSuccess = null) {
    editPlotOnSaveSuccess = onSaveSuccess;
    
    // Open the overlay
    document.getElementById('editFarmPlotModal').classList.add('active');
    document.getElementById('editPlotTitleId').textContent = plot.id || plot.plotId || 'N/A';
    document.getElementById('editPlotId').value = plot.id || plot.plotId || '';
    
    // Populate select field with only the selected beneficiary and disable it
    const selectEl = document.querySelector('select[name="editPlotBeneficiaryName"]');
    if (selectEl) {
        const fullName = plot.beneficiaryName || 'Unknown Beneficiary';
        const benId = plot.beneficiaryId || '';
        selectEl.innerHTML = `<option value="${benId}" selected>${fullName}</option>`;
        selectEl.disabled = true;
        
        // Setup dataset for address and ID inputs
        const opt = selectEl.options[0];
        opt.dataset.benId = benId;
        opt.dataset.address = plot.address || 'Address not available';
    }
    
    // Update labels/details
    updateEditPlotBeneficiaryDetails();
    
    // Populate coordinates
    const container = document.getElementById('editPlotCoordinatesContainer');
    container.innerHTML = '';
    editPlotCoordinatesCount = 0;
    
    let coords = plot.coordinates || [];
    let formattedCoords = coords.map(c => ({
        lat: decimalToDMS(c.lat, true),
        lng: decimalToDMS(c.lng, false),
        elevation: c.elevation !== null && c.elevation !== undefined ? String(c.elevation) : ''
    }));
    
    // Minimum 4 points
    while (formattedCoords.length < 4) {
        formattedCoords.push({ lat: '', lng: '', elevation: '' });
    }
    
    formattedCoords.forEach(c => {
        addEditPlotCoordinateField(c.lat, c.lng, c.elevation);
    });
    
    // Store initial data for change detection
    editPlotInitialData = {
        beneficiaryId: document.getElementById('editPlotBeneficiaryId').value,
        coordinates: getEditPlotCoordinatesState()
    };
    
    // Enable/disable update button
    checkEditPlotForChanges();
    
    // Attach change listener to beneficiary select
    if (selectEl) {
        selectEl.removeEventListener('change', updateEditPlotBeneficiaryDetails);
        selectEl.addEventListener('change', updateEditPlotBeneficiaryDetails);
        selectEl.removeEventListener('change', checkEditPlotForChanges);
        selectEl.addEventListener('change', checkEditPlotForChanges);
    }
  }

  function closeEditFarmPlotModal() {
    document.getElementById('editFarmPlotModal').classList.remove('active');
  }

  function updateEditPlotBeneficiaryDetails() {
    const selectEl = document.querySelector('select[name="editPlotBeneficiaryName"]');
    const option = selectEl ? selectEl.options[selectEl.selectedIndex] : null;
    if (option && option.value) {
        document.getElementById('editPlotBeneficiaryId').value = option.dataset.benId || '';
        document.getElementById('editPlotBeneficiaryAddress').value = option.dataset.address || '';
    } else {
        document.getElementById('editPlotBeneficiaryId').value = '';
        document.getElementById('editPlotBeneficiaryAddress').value = '';
    }
  }

  function getEditPlotCoordinatesState() {
    const coords = [];
    const container = document.getElementById('editPlotCoordinatesContainer');
    const rows = container.querySelectorAll('.edit-plot-coord-row');
    rows.forEach(row => {
        const latInput = row.querySelector('input[name^="edit-lat-"]');
        const lngInput = row.querySelector('input[name^="edit-lng-"]');
        const elevInput = row.querySelector('input[name^="edit-elevation-"]');
        
        coords.push({
            lat: latInput ? latInput.value.trim() : '',
            lng: lngInput ? lngInput.value.trim() : '',
            elevation: elevInput ? elevInput.value.trim() : ''
        });
    });
    return coords;
  }

  function checkEditPlotForChanges() {
    const currentCoords = getEditPlotCoordinatesState();
    
    const submitBtn = document.getElementById('editPlotSubmitBtn');
    if (!submitBtn) return;
    
    if (!editPlotInitialData) {
        submitBtn.disabled = true;
        return;
    }
    
    const coordsChanged = JSON.stringify(currentCoords) !== JSON.stringify(editPlotInitialData.coordinates);
    
    submitBtn.disabled = !coordsChanged;
  }

  function addEditPlotCoordinateField(lat = '', lng = '', elevation = '') {
    const container = document.getElementById('editPlotCoordinatesContainer');
    const index = editPlotCoordinatesCount++;
    
    const div = document.createElement('div');
    div.className = 'edit-plot-coord-row';
    div.id = `edit-coord-row-${index}`;
    
    let html = `
      <div style="display: flex; flex-direction: column; gap: 6px; flex: 1;">
        <div class="edit-plot-point-title">Point ${index + 1}</div>
        <div style="display: flex; gap: 6px; align-items: flex-start;">
          <div style="flex: 1">
            <label class="shared-form-label" style="font-size: 9px; margin-bottom: 2px;">Latitude</label>
            <input type="text" name="edit-lat-${index}" class="shared-form-input" placeholder=" " value="${escapeHtml(lat)}" required />
          </div>
          <div style="flex: 1">
            <label class="shared-form-label" style="font-size: 9px; margin-bottom: 2px;">Longitude</label>
            <input type="text" name="edit-lng-${index}" class="shared-form-input" placeholder=" " value="${escapeHtml(lng)}" required />
          </div>
          <div style="flex: 0.7">
            <label class="shared-form-label" style="font-size: 9px; margin-bottom: 2px;">Elevation (m)</label>
            <input type="number" name="edit-elevation-${index}" class="shared-form-input" placeholder=" " value="${escapeHtml(elevation)}" />
          </div>
        </div>
      </div>
    `;

    html += `
      <button type="button" class="edit-plot-remove-btn" title="Remove coordinate" onclick="removeEditPlotCoordinateField(${index})">×</button>
    `;

    div.innerHTML = html;
    container.appendChild(div);
    
    // Listen for changes
    div.querySelectorAll('input').forEach(input => {
        input.addEventListener('input', checkEditPlotForChanges);
    });
    
    updateEditPlotRemoveButtons();
    checkEditPlotForChanges();
  }

  function removeEditPlotCoordinateField(index) {
    const container = document.getElementById('editPlotCoordinatesContainer');
    if (container.children.length > 4) {
      const row = document.getElementById(`edit-coord-row-${index}`);
      if (row) {
        container.removeChild(row);
        updateEditPlotRemoveButtons();
        checkEditPlotForChanges();
      }
    } else {
        const err = document.getElementById('editPlotCoordinatesError');
        err.textContent = "At least 4 coordinate points are required to define a plot boundary.";
        err.style.display = 'block';
        setTimeout(() => err.style.display = 'none', 3000);
    }
  }

  function updateEditPlotRemoveButtons() {
    const container = document.getElementById('editPlotCoordinatesContainer');
    const btns = container.querySelectorAll('.edit-plot-remove-btn');
    if (container.children.length <= 4) {
        btns.forEach(btn => btn.style.display = 'none');
    } else {
        btns.forEach(btn => btn.style.display = 'flex');
    }
    
    // Update point titles sequentially
    const pointTitles = container.querySelectorAll('.edit-plot-point-title');
    pointTitles.forEach((title, idx) => {
        title.textContent = `Point ${idx + 1}`;
    });
  }

  async function handleEditFarmPlotSubmit(e) {
    e.preventDefault();
    const errorEl = document.getElementById('editPlotCoordinatesError');
    errorEl.style.display = 'none';

    const plotId = document.getElementById('editPlotId').value;
    const beneficiaryId = document.getElementById('editPlotBeneficiaryId').value;
    
    if (!beneficiaryId) {
        errorEl.textContent = "Please select a beneficiary.";
        errorEl.style.display = 'block';
        return;
    }

    const currentCoords = getEditPlotCoordinatesState();
    const validCoords = currentCoords.filter(c => c.lat !== '' && c.lng !== '');
    
    if (validCoords.length < 4) {
        errorEl.textContent = "At least 4 coordinate points are required to define a plot boundary.";
        errorEl.style.display = 'block';
        return;
    }

    const convertedCoordinates = [];
    try {
        for (let i = 0; i < validCoords.length; i++) {
            const coord = validCoords[i];
            let lat, lng;
            
            // Validate and convert latitude
            const latFormat = detectCoordinateFormat(coord.lat);
            if (latFormat === 'dms') {
                lat = dmsToDecimal(coord.lat);
            } else if (latFormat === 'decimal') {
                lat = parseFloat(coord.lat);
            } else {
                throw new Error(`Invalid latitude format at Point ${i + 1}`);
            }
            
            // Validate and convert longitude
            const lngFormat = detectCoordinateFormat(coord.lng);
            if (lngFormat === 'dms') {
                lng = dmsToDecimal(coord.lng);
            } else if (lngFormat === 'decimal') {
                lng = parseFloat(coord.lng);
            } else {
                throw new Error(`Invalid longitude format at Point ${i + 1}`);
            }
            
            if (isNaN(lat) || lat < -90 || lat > 90) {
                throw new Error(`Invalid latitude value at Point ${i + 1} (must be between -90 and 90)`);
            }
            if (isNaN(lng) || lng < -180 || lng > 180) {
                throw new Error(`Invalid longitude value at Point ${i + 1} (must be between -180 and 180)`);
            }
            
            const elevation = coord.elevation ? parseInt(coord.elevation, 10) : null;
            convertedCoordinates.push({ lat, lng, elevation });
        }
    } catch (err) {
        errorEl.textContent = err.message;
        errorEl.style.display = 'block';
        return;
    }

    const apiUrl = typeof API_BASE_URL !== 'undefined' ? API_BASE_URL : 'http://localhost:5000/api';
    const token = localStorage.getItem('authToken');
    if (!token) {
        window.location.href = '../../login.php';
        return;
    }

    if (typeof LoadingModal !== 'undefined') {
        LoadingModal.show({ title: 'Updating...', message: 'Updating farm plot boundaries...' });
    }

    try {
        const response = await fetch(`${apiUrl}/farm-plots/${plotId}`, {
            method: 'PUT',
            headers: {
                'Authorization': `Bearer ${token}`,
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                beneficiaryId: beneficiaryId,
                coordinates: convertedCoordinates
            })
        });

        // 1 second delay to simulate loading smoothly
        await new Promise(resolve => setTimeout(resolve, 1000));

        if (!response.ok) {
            const errData = await response.json().catch(() => ({}));
            throw new Error(errData.error || errData.message || 'Failed to update farm plot');
        }

        if (typeof LoadingModal !== 'undefined') {
            LoadingModal.hide();
        }

        closeEditFarmPlotModal();

        if (typeof AlertModal !== 'undefined') {
            AlertModal.show({
                type: 'success',
                title: 'Updated Successfully!',
                message: 'Farm plot has been updated successfully.',
                hideButton: true,
                autoClose: true,
                autoCloseDelay: 2000,
                borderRadius: 4
            });
        }

        if (editPlotOnSaveSuccess) {
            editPlotOnSaveSuccess();
        }
    } catch (err) {
        if (typeof LoadingModal !== 'undefined') {
            LoadingModal.hide();
        }
        errorEl.textContent = err.message || 'An error occurred while updating the farm plot.';
        errorEl.style.display = 'block';
    }
  }
</script>
