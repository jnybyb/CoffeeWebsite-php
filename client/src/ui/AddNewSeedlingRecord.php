<?php
/**
 * AddNewSeedlingRecord Component
 * 
 * Usage:
 * include_once '../ui/AddNewSeedlingRecord.php';
 * 
 * To open:
 * openAddSeedlingRecordModal(selectedBeneficiary);
 */
?>
<style>
.add-seedling-modal-overlay {
  position: fixed;
  top: 0; left: 0; right: 0; bottom: 0;
  background-color: rgba(0, 0, 0, 0.75);
  display: flex;
  justify-content: center;
  align-items: center;
  z-index: 11000; /* Higher than sheets/drawers but lower than standard AlertModal */
  opacity: 0;
  visibility: hidden;
  transition: opacity 0.3s ease, visibility 0.3s ease;
}
.add-seedling-modal-overlay.active {
  opacity: 1;
  visibility: visible;
}
.add-seedling-form-container {
  background-color: var(--white, #ffffff);
  border-radius: 5px;
  max-width: 500px;
  width: 90%;
  max-height: 90vh;
  box-shadow: 0 8px 32px rgba(0, 0, 0, 0.5);
  position: relative;
  display: flex;
  flex-direction: column;
  transform: scale(0.95);
  transition: transform 0.3s ease;
}
.add-seedling-modal-overlay.active .add-seedling-form-container {
  transform: scale(1);
}
.add-seedling-header {
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
.add-seedling-close-btn {
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
.add-seedling-close-btn:hover {
  background-color: var(--border-gray, #e9ecef);
}
.add-seedling-content-area {
  overflow-y: auto;
  scrollbar-width: thin;
  padding: 0 0.75rem;
  flex: 1;
}
.add-seedling-content-area::-webkit-scrollbar { width: 6px; }
.add-seedling-content-area::-webkit-scrollbar-track { background: #f1f1f1; border-radius: 3px; }
.add-seedling-content-area::-webkit-scrollbar-thumb { background: #c1c1c1; border-radius: 3px; }
.add-seedling-content-area::-webkit-scrollbar-thumb:hover { background: #a8a8a8; }
</style>

<div class="add-seedling-modal-overlay" id="addSeedlingRecordModal">
  <form class="add-seedling-form-container" id="addSeedlingRecordForm" onsubmit="handleSeedlingRecordSubmit(event)">
    <div class="add-seedling-header">
      <h2 style="color: var(--dark-green, #055035); margin: 0; font-size: 1.2rem; font-weight: 700;">Add New Seedling Record</h2>
      <button type="button" class="add-seedling-close-btn" onclick="closeAddSeedlingRecordModal()">×</button>
    </div>

    <div class="add-seedling-content-area">
      <div style="padding: 1rem; display: flex; flex-direction: column; gap: 12px;">
        
        <!-- Error Message Banner -->
        <div id="seedlingSubmitError" style="background-color: #fde8e8; border: 1px solid #f8b4b4; color: #9b1c1c; padding: 0.75rem 1rem; border-radius: 6px; font-size: 11px; display: none; align-items: center; gap: 8px;">
          <svg style="flex-shrink: 0;" width="14" height="14" viewBox="0 0 20 20" fill="#9b1c1c">
            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
          </svg>
          <span id="seedlingSubmitErrorText"></span>
        </div>

        <!-- Beneficiary Name and ID Row -->
        <div style="display: flex; gap: 12px; margin-bottom: 12px;">
          <div style="flex: 1;">
            <?php
            $fieldType = 'select'; $fieldName = 'beneficiaryName'; $fieldLabel = 'Beneficiary'; $fieldPlaceholder = 'Select Beneficiary'; $fieldRequired = true;
            $fieldOptions = [];
            include __DIR__ . '/FormField.php';
            ?>
          </div>
          <div style="flex: 1;">
            <div>
              <label class="shared-form-label">Beneficiary ID</label>
              <input type="text" name="beneficiaryId" readonly class="shared-form-input age-input" placeholder="Auto-populated" tabindex="-1" />
            </div>
          </div>
        </div>

        <!-- Received Seedlings and Date Received Row -->
        <div style="display: flex; gap: 12px; margin-bottom: 12px;">
          <div style="flex: 1;">
            <?php
            $fieldType = 'number'; $fieldName = 'received'; $fieldLabel = 'Received Seedlings'; $fieldPlaceholder = 'Enter number'; $fieldRequired = true; $fieldMin = 1;
            include __DIR__ . '/FormField.php';
            ?>
          </div>
          <div style="flex: 1;">
            <?php
            $fieldType = 'date'; $fieldName = 'dateReceived'; $fieldLabel = 'Date Received'; $fieldRequired = true;
            include __DIR__ . '/FormField.php';
            ?>
          </div>
        </div>

        <!-- Planted Seedlings -->
        <div style="margin-bottom: 12px;">
          <?php
          $fieldType = 'number'; $fieldName = 'planted'; $fieldLabel = 'Planted Seedlings'; $fieldPlaceholder = 'Enter number'; $fieldRequired = true; $fieldMin = 1;
          include __DIR__ . '/FormField.php';
          ?>
        </div>

        <!-- Plot ID Selection -->
        <div style="margin-bottom: 12px;">
          <?php
          $fieldType = 'select'; $fieldName = 'plotId'; $fieldLabel = 'Plot ID'; $fieldPlaceholder = 'Select Plot ID';
          $fieldOptions = [];
          include __DIR__ . '/FormField.php';
          ?>
        </div>

        <!-- Planting Date Range -->
        <div style="margin-bottom: 12px;">
          <label class="shared-form-label">Date of Planting *</label>
          <div style="display: flex; gap: 12px;">
            <div style="flex: 1;">
              <?php
              $fieldType = 'date'; $fieldName = 'dateOfPlantingStart'; $fieldLabel = ''; $fieldRequired = false;
              include __DIR__ . '/FormField.php';
              ?>
              <p style="font-size: 10px; color: #6c757d; margin: 4px 0 0 0;">Start Date</p>
            </div>
            <div style="flex: 1;">
              <?php
              $fieldType = 'date'; $fieldName = 'dateOfPlantingEnd'; $fieldLabel = '';
              include __DIR__ . '/FormField.php';
              ?>
              <p style="font-size: 10px; color: #6c757d; margin: 4px 0 0 0;">End Date (Optional)</p>
            </div>
          </div>
          <p style="color: var(--placeholder-text, #a8a8a8); font-size: 11px; margin: 6px 0 0 0;">If planting spanned multiple days, provide an end date.</p>
        </div>

        <!-- Action Buttons -->
        <div style="display: flex; gap: 0.75rem; justify-content: flex-end; padding-top: 0.75rem; border-top: 1px solid rgba(0,0,0,0.035); margin-top: 12px; margin-bottom: 12px;">
          <?php
          $btnType = 'cancel'; $btnOnClick = 'closeAddSeedlingRecordModal()'; $btnStyles = 'font-size: 11px; padding: 10px 18px; border-radius: 5px;';
          include __DIR__ . '/Button.php';
          
          $btnType = 'save'; $btnText = 'Save'; $btnSubmit = true; $btnStyles = 'font-size: 11px; padding: 10px 18px; border-radius: 5px;';
          include __DIR__ . '/Button.php';
          ?>
        </div>

      </div>
    </div>
  </form>
</div>

<script>
  function showSeedlingError(message) {
    const errorEl = document.getElementById('seedlingSubmitError');
    const errorTextEl = document.getElementById('seedlingSubmitErrorText');
    if (errorEl && errorTextEl) {
      errorTextEl.textContent = message;
      errorEl.style.display = 'flex';
      
      const scrollArea = document.querySelector('.add-seedling-content-area');
      if (scrollArea) {
        scrollArea.scrollTop = 0;
      }
    }
  }

  function hideSeedlingError() {
    const errorEl = document.getElementById('seedlingSubmitError');
    if (errorEl) {
      errorEl.style.display = 'none';
    }
  }

  function openAddSeedlingRecordModal(selectedBeneficiary) {
    const form = document.getElementById('addSeedlingRecordForm');
    form.reset();
    hideSeedlingError();
    
    form.querySelectorAll('.shared-form-input, .shared-form-select').forEach(el => {
      el.classList.remove('error');
    });

    const benNameSelect = form.querySelector('select[name="beneficiaryName"]');
    const benIdInput = form.querySelector('input[name="beneficiaryId"]');
    const plotSelect = form.querySelector('select[name="plotId"]');
    
    if (selectedBeneficiary) {
      const firstName = selectedBeneficiary.firstName || '';
      const middleName = selectedBeneficiary.middleName || '';
      const lastName = selectedBeneficiary.lastName || '';
      const fullName = `${firstName} ${middleName} ${lastName}`.trim().replace(/\s+/g, ' ') || selectedBeneficiary.fullName || 'N/A';
      const idStr = selectedBeneficiary.beneficiaryId || selectedBeneficiary._id || 'N/A';
      
      benNameSelect.innerHTML = `<option value="${idStr}" selected>${fullName}</option>`;
      benNameSelect.disabled = true;
      benIdInput.value = idStr;
      
      loadPlotOptions(idStr, selectedBeneficiary.farms);
    } else {
      benNameSelect.innerHTML = '<option value="" disabled selected>Select Beneficiary</option>';
      benNameSelect.disabled = false;
      benIdInput.value = '';
      
      plotSelect.innerHTML = '<option value="" disabled selected>Select beneficiary first</option>';
      plotSelect.disabled = true;
      
      populateBeneficiaryDropdown();
    }
    
    document.getElementById('addSeedlingRecordModal').classList.add('active');
  }

  function closeAddSeedlingRecordModal() {
    document.getElementById('addSeedlingRecordModal').classList.remove('active');
  }

  function loadPlotOptions(beneficiaryId, preloadedFarms) {
    const plotSelect = document.querySelector('#addSeedlingRecordForm select[name="plotId"]');
    if (!plotSelect) return;
    
    plotSelect.innerHTML = '<option value="" disabled selected>Select Plot ID</option>';
    plotSelect.disabled = true;

    if (preloadedFarms && preloadedFarms.length > 0) {
      preloadedFarms.forEach(farm => {
        const opt = document.createElement('option');
        opt.value = farm.id || farm.plotId || farm._id;
        opt.textContent = farm.id || farm.plotId || farm._id;
        opt.style.color = '#333';
        plotSelect.appendChild(opt);
      });
      plotSelect.disabled = false;
    } else {
      const apiUrl = typeof API_BASE_URL !== 'undefined' ? API_BASE_URL : 'http://localhost:5000/api';
      const token = localStorage.getItem('authToken');
      fetch(`${apiUrl}/farm-plots`, {
        headers: { 'Authorization': `Bearer ${token}` }
      })
      .then(res => res.json())
      .then(plots => {
        const beneficiaryPlots = plots.filter(plot => plot.beneficiaryId === beneficiaryId);
        if (beneficiaryPlots.length > 0) {
          beneficiaryPlots.forEach(plot => {
            const opt = document.createElement('option');
            opt.value = plot.id || plot._id;
            opt.textContent = plot.id || plot._id;
            opt.style.color = '#333';
            plotSelect.appendChild(opt);
          });
          plotSelect.disabled = false;
        } else {
          plotSelect.innerHTML = '<option value="" disabled selected>No plots available</option>';
        }
      })
      .catch(err => {
        console.error('Error fetching farm plots:', err);
        plotSelect.innerHTML = '<option value="" disabled selected>Error loading plots</option>';
      });
    }
  }

  function populateBeneficiaryDropdown() {
    const benNameSelect = document.querySelector('#addSeedlingRecordForm select[name="beneficiaryName"]');
    if (!benNameSelect) return;

    if (window.allFetchedBeneficiaries && window.allFetchedBeneficiaries.length > 0) {
      benNameSelect.innerHTML = '<option value="" disabled selected>Select Beneficiary</option>';
      window.allFetchedBeneficiaries.forEach(ben => {
        const firstName = ben.firstName || '';
        const middleName = ben.middleName || '';
        const lastName = ben.lastName || '';
        const fullName = `${firstName} ${middleName} ${lastName}`.trim().replace(/\s+/g, ' ') || ben.fullName || 'N/A';
        const idStr = ben.beneficiaryId || ben._id || 'N/A';
        
        const opt = document.createElement('option');
        opt.value = idStr;
        opt.textContent = fullName;
        opt.style.color = '#333';
        benNameSelect.appendChild(opt);
      });
    }
  }

  // Handle dropdown selection
  document.querySelector('#addSeedlingRecordForm select[name="beneficiaryName"]').addEventListener('change', (e) => {
    const idStr = e.target.value;
    const benIdInput = document.querySelector('#addSeedlingRecordForm input[name="beneficiaryId"]');
    if (benIdInput) {
      benIdInput.value = idStr;
    }
    const ben = (window.allFetchedBeneficiaries || []).find(b => (b.beneficiaryId || b._id) === idStr);
    loadPlotOptions(idStr, ben ? ben.farms : null);
  });

  async function handleSeedlingRecordSubmit(e) {
    e.preventDefault();
    const form = e.target;
    hideSeedlingError();
    
    form.querySelectorAll('.shared-form-input, .shared-form-select').forEach(el => {
      el.classList.remove('error');
    });

    const beneficiaryId = form.elements['beneficiaryId'].value;
    const received = form.elements['received'].value;
    const dateReceived = form.elements['dateReceived'].value;
    const planted = form.elements['planted'].value;
    const plotId = form.elements['plotId'].value;
    const dateOfPlantingStart = form.elements['dateOfPlantingStart'].value;
    const dateOfPlantingEnd = form.elements['dateOfPlantingEnd'].value;

    let hasError = false;

    if (!beneficiaryId) {
      form.elements['beneficiaryName'].classList.add('error');
      hasError = true;
    }
    if (!received || parseInt(received) <= 0) {
      form.elements['received'].classList.add('error');
      hasError = true;
    }
    if (!dateReceived) {
      form.elements['dateReceived'].classList.add('error');
      hasError = true;
    }
    if (!planted || parseInt(planted) <= 0) {
      form.elements['planted'].classList.add('error');
      hasError = true;
    } else if (parseInt(planted) > parseInt(received)) {
      form.elements['planted'].classList.add('error');
      showSeedlingError('Planted seedlings cannot exceed received seedlings.');
      hasError = true;
    }
    if (!dateOfPlantingStart) {
      form.elements['dateOfPlantingStart'].classList.add('error');
      hasError = true;
    } else if (dateReceived && dateOfPlantingStart < dateReceived) {
      form.elements['dateOfPlantingStart'].classList.add('error');
      showSeedlingError('Date of planting cannot be before date received.');
      hasError = true;
    }
    if (dateOfPlantingEnd && dateOfPlantingStart && dateOfPlantingEnd < dateOfPlantingStart) {
      form.elements['dateOfPlantingEnd'].classList.add('error');
      showSeedlingError('End date cannot be before start date.');
      hasError = true;
    }

    if (hasError) {
      const errorEl = document.getElementById('seedlingSubmitError');
      if (errorEl.style.display !== 'flex') {
        showSeedlingError('Please fill out all required fields correctly.');
      }
      return;
    }

    const token = localStorage.getItem('authToken');
    if (!token) {
        window.location.href = '../../login.php';
        return;
    }

    const apiUrl = typeof API_BASE_URL !== 'undefined' ? API_BASE_URL : 'http://localhost:5000/api';
    
    if (typeof LoadingModal !== 'undefined') {
        LoadingModal.show({ title: 'Saving...', message: 'Adding seedling record...' });
    }

    try {
        const response = await fetch(`${apiUrl}/seedlings`, {
            method: 'POST',
            headers: {
                'Authorization': `Bearer ${token}`,
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                beneficiaryId,
                received: parseInt(received),
                dateReceived,
                planted: parseInt(planted),
                plotId: plotId || null,
                dateOfPlantingStart,
                dateOfPlantingEnd: dateOfPlantingEnd || null
            })
        });

        await new Promise(resolve => setTimeout(resolve, 1200));

        if (!response.ok) {
            const errorData = await response.json().catch(() => ({}));
            throw new Error(errorData.error || errorData.message || 'Failed to add seedling record');
        }

        if (typeof LoadingModal !== 'undefined') {
            LoadingModal.hide();
        }
        
        closeAddSeedlingRecordModal();

        if (typeof AlertModal !== 'undefined') {
            AlertModal.show({
                type: 'success',
                title: 'Success!',
                message: 'Seedling record has been added successfully.',
                hideButton: true,
                autoClose: true,
                autoCloseDelay: 1500,
                borderRadius: 4
            });
        }

        if (typeof loadBeneficiaries === 'function') {
            loadBeneficiaries();
        }
        
        if (typeof window.activeBeneficiaryId !== 'undefined' && window.activeBeneficiaryId) {
            setTimeout(() => {
                if (typeof window.showDetailPanel === 'function') {
                    window.showDetailPanel(window.activeBeneficiaryId);
                } else if (typeof window.showBeneficiaryDetails === 'function') {
                    window.showBeneficiaryDetails(window.activeBeneficiaryId);
                }
            }, 100);
        }
    } catch (error) {
        if (typeof LoadingModal !== 'undefined') {
            LoadingModal.hide();
        }
        
        showSeedlingError(error.message || 'An error occurred while saving the seedling record.');
    }
  }
</script>
