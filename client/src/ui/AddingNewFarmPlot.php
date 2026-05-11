<?php
/**
 * AddingNewFarmPlot Component
 * 
 * Usage:
 * include_once '../ui/AddingNewFarmPlot.php';
 * 
 * To open:
 * openAddFarmPlotModal(optionalBeneficiariesArray, optionalSelectedBeneficiaryId);
 */
?>

<style>
.add-plot-modal-overlay {
  position: fixed;
  top: 0; left: 0; right: 0; bottom: 0;
  background-color: rgba(0, 0, 0, 0.75);
  display: flex;
  justify-content: center;
  align-items: center;
  z-index: 1000;
  opacity: 0;
  visibility: hidden;
  transition: opacity 0.3s ease, visibility 0.3s ease;
}

.add-plot-modal-overlay.active {
  opacity: 1;
  visibility: visible;
}

.add-plot-form-container {
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

.add-plot-modal-overlay.active .add-plot-form-container {
  transform: scale(1);
}

.add-plot-content-area {
  overflow-y: auto;
  scrollbar-width: thin;
  padding: 0 0.75rem;
  flex: 1;
}

.add-plot-content-area::-webkit-scrollbar {
  width: 6px;
}
.add-plot-content-area::-webkit-scrollbar-track {
  background: #f1f1f1;
  border-radius: 3px;
}
.add-plot-content-area::-webkit-scrollbar-thumb {
  background: #c1c1c1;
  border-radius: 3px;
}
.add-plot-content-area::-webkit-scrollbar-thumb:hover {
  background: #a8a8a8;
}

.add-plot-header {
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

.add-plot-close-btn {
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

.add-plot-close-btn:hover {
  background-color: var(--border-gray, #e9ecef);
}

.add-plot-label {
  font-weight: 500;
  font-size: 11px;
  margin-bottom: 0.1rem;
  display: block;
  color: var(--dark-green, #055035);
}

.add-plot-readonly-input {
  width: 100%;
  padding: 6px 10px;
  border-radius: 4px;
  border: 1px solid var(--border-gray, #e9ecef);
  font-size: 11px;
  margin-bottom: 0;
  background: var(--white, #ffffff);
  color: var(--dark-text, #333);
  cursor: not-allowed;
  height: 30px;
  box-sizing: border-box;
}

.add-plot-button-row {
  display: flex;
  gap: 0.75rem;
  justify-content: flex-end;
  padding-top: 0.75rem;
  border-top: 1px solid rgba(0, 0, 0, 0.035);
}

.add-plot-coord-row {
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

.add-plot-remove-btn {
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

.add-plot-remove-btn:hover {
  color: var(--danger-red, #b00020);
}

.add-plot-section-title {
  font-size: 11px;
  font-weight: 600;
  color: var(--dark-green, #055035);
  margin-top: 12px;
}

.add-plot-point-title {
  font-size: 10px;
  font-weight: 600;
  color: var(--dark-green, #055035);
  margin-bottom: 2px;
}

.add-plot-form-body {
  padding: 1rem;
  display: flex;
  flex-direction: column;
  gap: 12px;
}

.add-plot-two-col {
  display: flex;
  gap: 6px;
}

.add-plot-two-col > div {
  flex: 1;
}
</style>

<div class="add-plot-modal-overlay" id="addFarmPlotModal">
  <form class="add-plot-form-container" id="addFarmPlotForm" onsubmit="handleFarmPlotSubmit(event)">
    <div class="add-plot-header">
      <h2 style="color: var(--dark-green, #055035); margin: 0; font-size: 1.2rem; font-weight: 700;">Add Farm Plot</h2>
      <button type="button" class="add-plot-close-btn" onclick="closeAddFarmPlotModal()">×</button>
    </div>

    <div class="add-plot-content-area">
      <div class="add-plot-form-body">
        
        <div class="add-plot-two-col">
          <div>
            <?php
            // Reusing the FormField Component
            $fieldType = 'select';
            $fieldName = 'beneficiaryId';
            $fieldLabel = 'Beneficiary Full Name';
            $fieldPlaceholder = 'Select beneficiary';
            $fieldOptions = []; // Left empty, populated by JS
            $fieldRequired = true;
            include __DIR__ . '/FormField.php';
            ?>
          </div>
          <div>
            <label class="add-plot-label">Beneficiary ID</label>
            <input class="add-plot-readonly-input" id="plotBeneficiaryId" readonly tabindex="-1" />
          </div>
        </div>

        <div>
          <label class="add-plot-label">Address</label>
          <input class="add-plot-readonly-input" id="plotBeneficiaryAddress" readonly tabindex="-1" />
        </div>

        <div>
          <label class="add-plot-label">Plot ID</label>
          <input class="add-plot-readonly-input" id="plotGeneratedId" value="Auto-generated" readonly tabindex="-1" title="Plot ID will be automatically generated" />
        </div>

        <div>
          <div class="add-plot-section-title">Plot Boundary Coordinates</div>
          <p style="font-size: 8.5px; color: var(--dark-text, #333); margin-bottom: 10px;">
            Add coordinate points to define the plot boundary. Minimum 4 points required.
          </p>
          
          <div id="plotCoordinatesContainer">
            <!-- Coordinates rendered here dynamically via JS -->
          </div>
          
          <?php
          // Reusing the Button Component
          $btnType = 'add-coordinate';
          $btnOnClick = 'addCoordinateField()';
          include __DIR__ . '/Button.php';
          ?>
          
          <div id="plotCoordinatesError" style="color: var(--danger-red, #b00020); font-size: 10px; margin-top: 6px; display: none;"></div>
        </div>

        <div class="add-plot-button-row" style="padding: 1rem 0 1rem 1rem;">
          <?php
          $btnType = 'cancel';
          $btnOnClick = 'closeAddFarmPlotModal()';
          $btnStyles = 'font-size: 11px; padding: 10px 18px; border-radius: 5px;';
          include __DIR__ . '/Button.php';
          
          $btnType = 'save';
          $btnText = 'Save Plot';
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
  let plotCoordinatesCount = 0;
  
  function openAddFarmPlotModal(beneficiariesList = [], selectedBeneficiaryId = null) {
    document.getElementById('addFarmPlotModal').classList.add('active');
    
    // Reset form
    document.getElementById('addFarmPlotForm').reset();
    document.getElementById('plotCoordinatesContainer').innerHTML = '';
    plotCoordinatesCount = 0;
    
    // Add 4 initial points
    for(let i = 0; i < 4; i++) {
        addCoordinateField();
    }

    // Populate select field if beneficiaries provided
    const selectEl = document.querySelector('select[name="beneficiaryId"]');
    if (selectEl && beneficiariesList.length > 0) {
        selectEl.innerHTML = '<option value="" disabled selected>Select beneficiary</option>';
        beneficiariesList.forEach(b => {
            const opt = document.createElement('option');
            opt.value = b.id || b.beneficiaryId;
            opt.textContent = b.name || b.fullName || `${b.firstName || ''} ${b.lastName || ''}`.trim();
            // Store data for easy retrieval
            opt.dataset.address = b.address || [b.purok, b.barangay, b.municipality, b.province].filter(Boolean).join(', ');
            opt.dataset.benId = b.beneficiaryId || b.id;
            selectEl.appendChild(opt);
        });

        if (selectedBeneficiaryId) {
            selectEl.value = selectedBeneficiaryId;
            handleBeneficiaryChange({ target: selectEl });
        }
    }
  }

  function closeAddFarmPlotModal() {
    document.getElementById('addFarmPlotModal').classList.remove('active');
  }

  function handleBeneficiaryChange(e) {
    const option = e.target.options[e.target.selectedIndex];
    if (option && option.value) {
        document.getElementById('plotBeneficiaryId').value = option.dataset.benId || '';
        document.getElementById('plotBeneficiaryAddress').value = option.dataset.address || '';
        
        // Mock ID generation (e.g., B001-PL01)
        const numMatch = option.dataset.benId ? option.dataset.benId.match(/\d+/) : null;
        const num = numMatch ? numMatch[0] : '000';
        document.getElementById('plotGeneratedId').value = `B${num}-PL01`;
    } else {
        document.getElementById('plotBeneficiaryId').value = '';
        document.getElementById('plotBeneficiaryAddress').value = '';
        document.getElementById('plotGeneratedId').value = 'Auto-generated';
    }
  }

  // Attach change event
  const benSelect = document.querySelector('select[name="beneficiaryId"]');
  if (benSelect) {
      benSelect.addEventListener('change', handleBeneficiaryChange);
  }

  function addCoordinateField() {
    const container = document.getElementById('plotCoordinatesContainer');
    const index = plotCoordinatesCount++;
    
    const div = document.createElement('div');
    div.className = 'add-plot-coord-row';
    div.id = `coord-row-${index}`;
    
    // Output raw HTML using the classes defined in FormField.php
    let html = `
      <div style="display: flex; flex-direction: column; gap: 6px; flex: 1;">
        <div class="add-plot-point-title">Point ${index + 1}</div>
        <div style="display: flex; gap: 6px; align-items: flex-start;">
          <div style="flex: 1">
            <label class="shared-form-label" style="font-size: 9px; margin-bottom: 2px;">Latitude</label>
            <input type="text" name="lat-${index}" class="shared-form-input" placeholder=" " required />
          </div>
          <div style="flex: 1">
            <label class="shared-form-label" style="font-size: 9px; margin-bottom: 2px;">Longitude</label>
            <input type="text" name="lng-${index}" class="shared-form-input" placeholder=" " required />
          </div>
          <div style="flex: 0.7">
            <label class="shared-form-label" style="font-size: 9px; margin-bottom: 2px;">Elevation (m)</label>
            <input type="number" name="elevation-${index}" class="shared-form-input" placeholder=" " />
          </div>
        </div>
      </div>
    `;

    html += `
      <button type="button" class="add-plot-remove-btn" title="Remove coordinate" onclick="removeCoordinateField(${index})">×</button>
    `;

    div.innerHTML = html;
    container.appendChild(div);
    updateRemoveButtons();
  }

  function removeCoordinateField(index) {
    const container = document.getElementById('plotCoordinatesContainer');
    if (container.children.length > 4) {
      const row = document.getElementById(`coord-row-${index}`);
      if (row) {
        container.removeChild(row);
        updateRemoveButtons();
      }
    } else {
        const err = document.getElementById('plotCoordinatesError');
        err.textContent = "At least 4 coordinate points are required to define a plot boundary.";
        err.style.display = 'block';
        setTimeout(() => err.style.display = 'none', 3000);
    }
  }

  function updateRemoveButtons() {
    const container = document.getElementById('plotCoordinatesContainer');
    const btns = container.querySelectorAll('.add-plot-remove-btn');
    if (container.children.length <= 4) {
        btns.forEach(btn => btn.style.display = 'none');
    } else {
        btns.forEach(btn => btn.style.display = 'flex');
    }
    
    // Update labels to sequential numbers
    const pointTitles = container.querySelectorAll('.add-plot-point-title');
    pointTitles.forEach((title, idx) => {
        title.textContent = `Point ${idx + 1}`;
    });
  }

  // Convert DMS to Decimal (Ported from React)
  function dmsToDecimal(dmsString) {
    if (!dmsString) return null;
    const cleanStr = String(dmsString).trim();
    const regex = /([0-9.]+)\s*°\s*([0-9.]+)?\s*'?\s*([0-9.]+)?\s*"?\s*([NSEW])?/i;
    const match = cleanStr.match(regex);
    if (!match) return null;
    const degrees = parseFloat(match[1] || 0);
    const minutes = match[2] ? parseFloat(match[2]) : 0;
    const seconds = match[3] ? parseFloat(match[3]) : 0;
    const direction = (match[4] || '').toUpperCase();
    let decimal = degrees + minutes / 60 + seconds / 3600;
    if (direction === 'S' || direction === 'W') decimal *= -1;
    return decimal;
  }

  function handleFarmPlotSubmit(e) {
    e.preventDefault();
    const errorEl = document.getElementById('plotCoordinatesError');
    errorEl.style.display = 'none';

    const benId = document.getElementById('plotBeneficiaryId').value;
    if (!benId) {
        errorEl.textContent = "Please select a beneficiary.";
        errorEl.style.display = 'block';
        return;
    }

    // In a real application, you would iterate over the coordinates, convert DMS -> Decimal,
    // and submit via AJAX (fetch). For now, we simulate the save flow:
    if (typeof ModalTypes !== 'undefined') {
        ModalTypes.showSaving({ title: 'Saving plot...', message: 'Please wait while we save your farm plot' });
        
        setTimeout(() => {
            ModalTypes.hide();
            if (typeof AlertModal !== 'undefined') {
                AlertModal.show({
                    type: 'success',
                    title: 'Plot Saved Successfully!',
                    message: 'The farm plot has been added.',
                    hideButton: true,
                    autoClose: true,
                    autoCloseDelay: 2000
                });
            }
            closeAddFarmPlotModal();
        }, 1500);
    } else {
        alert("Plot saved successfully!");
        closeAddFarmPlotModal();
    }
  }
</script>
