<?php
/**
 * AddNewSurveyStatus Component
 * 
 * Usage:
 * include_once '../ui/AddNewSurveyStatus.php';
 * 
 * To open:
 * openAddSurveyStatusModal(selectedBeneficiary);
 */
?>
<style>
.add-survey-modal-overlay {
  position: fixed;
  top: 0; left: 0; right: 0; bottom: 0;
  background-color: rgba(0, 0, 0, 0.75);
  display: flex;
  justify-content: center;
  align-items: center;
  z-index: 11000; /* Same stacking as AddNewSeedlingRecord */
  opacity: 0;
  visibility: hidden;
  transition: opacity 0.3s ease, visibility 0.3s ease;
}
.add-survey-modal-overlay.active {
  opacity: 1;
  visibility: visible;
}
.add-survey-form-container {
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
.add-survey-modal-overlay.active .add-survey-form-container {
  transform: scale(1);
}
.add-survey-header {
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
.add-survey-close-btn {
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
.add-survey-close-btn:hover {
  background-color: var(--border-gray, #e9ecef);
}
.add-survey-content-area {
  overflow-y: auto;
  scrollbar-width: thin;
  padding: 0 0.75rem;
  flex: 1;
}
.add-survey-content-area::-webkit-scrollbar { width: 6px; }
.add-survey-content-area::-webkit-scrollbar-track { background: #f1f1f1; border-radius: 3px; }
.add-survey-content-area::-webkit-scrollbar-thumb { background: #c1c1c1; border-radius: 3px; }
.add-survey-content-area::-webkit-scrollbar-thumb:hover { background: #a8a8a8; }
</style>

<div class="add-survey-modal-overlay" id="addSurveyStatusModal">
  <form class="add-survey-form-container" id="addSurveyStatusForm" onsubmit="handleSurveyStatusSubmit(event)">
    <div class="add-survey-header">
      <h2 style="color: var(--dark-green, #055035); margin: 0; font-size: 1.2rem; font-weight: 700;">Add New Survey Status</h2>
      <button type="button" class="add-survey-close-btn" onclick="closeAddSurveyStatusModal()">×</button>
    </div>

    <div class="add-survey-content-area">
      <div style="padding: 1rem; display: flex; flex-direction: column; gap: 12px;">
        
        <!-- Error Message Banner -->
        <div id="surveySubmitError" style="background-color: #fde8e8; border: 1px solid #f8b4b4; color: #9b1c1c; padding: 0.75rem 1rem; border-radius: 6px; font-size: 11px; display: none; align-items: center; gap: 8px;">
          <svg style="flex-shrink: 0;" width="14" height="14" viewBox="0 0 20 20" fill="#9b1c1c">
            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
          </svg>
          <span id="surveySubmitErrorText"></span>
        </div>

        <!-- Beneficiary Name and ID Row -->
        <div style="display: flex; gap: 12px; margin-bottom: 12px;">
          <div style="flex: 1;">
            <?php
            $fieldType = 'select'; $fieldName = 'surveyBeneficiaryName'; $fieldLabel = 'Beneficiary'; $fieldPlaceholder = 'Select Beneficiary'; $fieldRequired = true;
            $fieldOptions = [];
            include __DIR__ . '/FormField.php';
            ?>
          </div>
          <div style="flex: 1;">
            <div>
              <label class="shared-form-label">Beneficiary ID</label>
              <input type="text" name="surveyBeneficiaryId" readonly class="shared-form-input age-input" placeholder="Auto-populated" tabindex="-1" />
            </div>
          </div>
        </div>

        <!-- Survey Date and Surveyor Row -->
        <div style="display: flex; gap: 12px; margin-bottom: 12px;">
          <div style="flex: 1;">
            <?php
            $fieldType = 'date'; $fieldName = 'surveyDate'; $fieldLabel = 'Survey Date'; $fieldRequired = true;
            include __DIR__ . '/FormField.php';
            ?>
          </div>
          <div style="flex: 1;">
            <?php
            $fieldType = 'text'; $fieldName = 'surveyer'; $fieldLabel = 'Surveyer'; $fieldPlaceholder = 'Enter surveyor name'; $fieldRequired = true;
            include __DIR__ . '/FormField.php';
            ?>
          </div>
        </div>

        <!-- Alive Crops and Dead Crops Row -->
        <div style="display: flex; gap: 12px; margin-bottom: 12px;">
          <div style="flex: 1;">
            <?php
            $fieldType = 'number'; $fieldName = 'aliveCrops'; $fieldLabel = 'Number of Alive Crops'; $fieldPlaceholder = 'Enter number'; $fieldRequired = true; $fieldMin = 1;
            include __DIR__ . '/FormField.php';
            ?>
          </div>
          <div style="flex: 1;">
            <?php
            $fieldType = 'number'; $fieldName = 'deadCrops'; $fieldLabel = 'Number of Dead Crops'; $fieldPlaceholder = 'Enter number'; $fieldRequired = true; $fieldMin = 0;
            include __DIR__ . '/FormField.php';
            ?>
          </div>
        </div>

        <!-- Plot ID Dropdown -->
        <div style="margin-bottom: 12px;">
          <?php
          $fieldType = 'select'; $fieldName = 'surveyPlotId'; $fieldLabel = 'Plot ID'; $fieldPlaceholder = 'Select Plot ID';
          $fieldOptions = [];
          include __DIR__ . '/FormField.php';
          ?>
        </div>

        <!-- Pictures Multi-upload Grid -->
        <div style="margin-bottom: 12px;">
          <label class="shared-form-label">Pictures (Optional)</label>
          <input id="survey-pictures-input" type="file" multiple accept="image/*" onchange="handleSurveyFileChange(event)" style="display: none;" />
          <div id="surveyPicturesGrid" style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 8px; margin-top: 8px;">
            <!-- Thumbnails will render here -->
            <label for="survey-pictures-input" id="surveyPicturesAddLabel" style="cursor: pointer; display: flex; flex-direction: column; justify-content: center; align-items: center; border: 1.5px dashed var(--dark-green, #055035); border-radius: 6px; color: var(--dark-green, #055035); font-size: 13px; font-weight: 500; aspect-ratio: 1/1; margin: 0; background: transparent;">
              <span style="font-size: 18px; margin-bottom: 2px;">+</span>
              <span>Add</span>
            </label>
          </div>
          <div id="surveyPicturesCount" style="font-size: 11px; color: var(--placeholder-text, #a8a8a8); margin-top: 6px; display: none;"></div>
        </div>

        <!-- Action Buttons -->
        <div style="display: flex; gap: 0.75rem; justify-content: flex-end; padding-top: 0.75rem; border-top: 1px solid rgba(0,0,0,0.035); margin-top: 12px; margin-bottom: 12px;">
          <?php
          $btnType = 'cancel'; $btnOnClick = 'closeAddSurveyStatusModal()'; $btnStyles = 'font-size: 11px; padding: 10px 18px; border-radius: 5px;';
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
  let selectedSurveyFiles = [];
  let surveyMaxSeedlings = 0;
  let surveyMinDateString = '';

  function showSurveyError(message) {
    const errorEl = document.getElementById('surveySubmitError');
    const errorTextEl = document.getElementById('surveySubmitErrorText');
    if (errorEl && errorTextEl) {
      errorTextEl.textContent = message;
      errorEl.style.display = 'flex';
      
      const scrollArea = document.querySelector('.add-survey-content-area');
      if (scrollArea) {
        scrollArea.scrollTop = 0;
      }
    }
  }

  function hideSurveyError() {
    const errorEl = document.getElementById('surveySubmitError');
    if (errorEl) {
      errorEl.style.display = 'none';
    }
  }

  function handleSurveyFileChange(e) {
    const files = Array.from(e.target.files || []);
    if (!files.length) return;
    
    selectedSurveyFiles = [...selectedSurveyFiles, ...files].slice(0, 10);
    renderSurveyPicturesGrid();
    e.target.value = null;
  }

  function renderSurveyPicturesGrid() {
    const grid = document.getElementById('surveyPicturesGrid');
    const addLabel = document.getElementById('surveyPicturesAddLabel');
    const countDiv = document.getElementById('surveyPicturesCount');
    
    grid.querySelectorAll('.survey-thumbnail-card').forEach(el => el.remove());
    
    selectedSurveyFiles.forEach((file, index) => {
      const src = URL.createObjectURL(file);
      
      const card = document.createElement('div');
      card.className = 'survey-thumbnail-card';
      card.style.position = 'relative';
      card.style.width = '100%';
      card.style.aspectRatio = '1/1';
      card.style.backgroundColor = 'var(--pagination-hover, #f8f9fa)';
      card.style.border = '1px solid var(--border-gray, #e9ecef)';
      card.style.borderRadius = '6px';
      card.style.overflow = 'hidden';
      
      card.innerHTML = `
        <img src="${src}" alt="Selected ${index + 1}" style="position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover;" />
        <button type="button" onclick="removeSurveyFile(${index})" title="Remove"
          style="position: absolute; top: 4px; right: 4px; width: 18px; height: 18px; border-radius: 50%; background: rgba(0,0,0,0.6); color: #fff; border: none; cursor: pointer; display: flex; align-items: center; justify-content: center; font-size: 12px; line-height: 1; padding: 0;">×</button>
      `;
      
      grid.insertBefore(card, addLabel);
    });
    
    if (selectedSurveyFiles.length >= 10) {
      addLabel.style.display = 'none';
    } else {
      addLabel.style.display = 'flex';
    }
    
    if (selectedSurveyFiles.length > 0) {
      countDiv.style.display = 'block';
      countDiv.textContent = `${selectedSurveyFiles.length}/10 selected`;
    } else {
      countDiv.style.display = 'none';
    }
  }

  function removeSurveyFile(index) {
    selectedSurveyFiles = selectedSurveyFiles.filter((_, i) => i !== index);
    renderSurveyPicturesGrid();
  }

  function openAddSurveyStatusModal(selectedBeneficiary) {
    const form = document.getElementById('addSurveyStatusForm');
    form.reset();
    selectedSurveyFiles = [];
    renderSurveyPicturesGrid();
    hideSurveyError();
    
    form.querySelectorAll('.shared-form-input, .shared-form-select').forEach(el => {
      el.classList.remove('error');
    });

    const benNameSelect = form.querySelector('select[name="surveyBeneficiaryName"]');
    const benIdInput = form.querySelector('input[name="surveyBeneficiaryId"]');
    const plotSelect = form.querySelector('select[name="surveyPlotId"]');
    
    if (selectedBeneficiary) {
      const idStr = selectedBeneficiary.beneficiaryId || selectedBeneficiary._id || '';
      const firstName = selectedBeneficiary.firstName || '';
      const middleName = selectedBeneficiary.middleName || '';
      const lastName = selectedBeneficiary.lastName || '';
      const fullName = `${firstName} ${middleName} ${lastName}`.trim().replace(/\s+/g, ' ') || selectedBeneficiary.fullName || 'N/A';
      
      benNameSelect.innerHTML = `<option value="${idStr}" selected>${fullName}</option>`;
      benNameSelect.disabled = true;
      benIdInput.value = idStr;
      
      // Load plots & seedling rules
      loadSurveyPlotOptions(idStr, selectedBeneficiary.farms);
      computeSurveySeedlingRules(selectedBeneficiary.seedlingRecords);
    } else {
      benNameSelect.innerHTML = '<option value="" disabled selected>Select Beneficiary</option>';
      benNameSelect.disabled = false;
      benIdInput.value = '';
      plotSelect.innerHTML = '<option value="">Select beneficiary first</option>';
      
      surveyMaxSeedlings = 0;
      surveyMinDateString = '';
      
      // Load beneficiaries for dropdown
      if (window.allFetchedBeneficiaries && window.allFetchedBeneficiaries.length > 0) {
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

    const modal = document.getElementById('addSurveyStatusModal');
    modal.classList.add('active');
  }

  function closeAddSurveyStatusModal() {
    const modal = document.getElementById('addSurveyStatusModal');
    modal.classList.remove('active');
  }

  function loadSurveyPlotOptions(beneficiaryId, farms) {
    const plotSelect = document.querySelector('#addSurveyStatusForm select[name="surveyPlotId"]');
    plotSelect.innerHTML = '';
    
    if (farms && farms.length > 0) {
      const defaultOpt = document.createElement('option');
      defaultOpt.value = '';
      defaultOpt.textContent = 'Select Plot ID (Optional)';
      plotSelect.appendChild(defaultOpt);
      
      farms.forEach(farm => {
        const opt = document.createElement('option');
        opt.value = farm.id;
        opt.textContent = farm.id;
        opt.style.color = '#333';
        plotSelect.appendChild(opt);
      });
    } else {
      plotSelect.innerHTML = '<option value="">No plots available</option>';
    }
  }

  function computeSurveySeedlingRules(seedlingRecords) {
    const dateInput = document.querySelector('#addSurveyStatusForm input[name="surveyDate"]');
    const aliveInput = document.querySelector('#addSurveyStatusForm input[name="aliveCrops"]');
    
    if (seedlingRecords && seedlingRecords.length > 0) {
      // 1. Calculate max limit for alive crops
      surveyMaxSeedlings = seedlingRecords.reduce((sum, s) => sum + (parseInt(s.received) || 0), 0);
      aliveInput.placeholder = `Enter number (Max: ${surveyMaxSeedlings})`;
      aliveInput.max = surveyMaxSeedlings;
      
      // 2. Calculate earliest seedling date for min Date attribute
      const releaseDates = seedlingRecords
        .map(s => s.dateReceived)
        .filter(Boolean)
        .map(d => d.split('T')[0]);
        
      if (releaseDates.length > 0) {
        surveyMinDateString = releaseDates.reduce((min, d) => (d < min ? d : min), releaseDates[0]);
        dateInput.min = surveyMinDateString;
      } else {
        surveyMinDateString = '';
        dateInput.removeAttribute('min');
      }
    } else {
      surveyMaxSeedlings = 0;
      aliveInput.placeholder = 'Enter number';
      aliveInput.removeAttribute('max');
      surveyMinDateString = '';
      dateInput.removeAttribute('min');
    }
  }

  // Handle dropdown selection
  document.querySelector('#addSurveyStatusForm select[name="surveyBeneficiaryName"]').addEventListener('change', (e) => {
    const idStr = e.target.value;
    const benIdInput = document.querySelector('#addSurveyStatusForm input[name="surveyBeneficiaryId"]');
    if (benIdInput) {
      benIdInput.value = idStr;
    }
    const ben = (window.allFetchedBeneficiaries || []).find(b => (b.beneficiaryId || b._id) === idStr);
    
    if (ben) {
      loadSurveyPlotOptions(idStr, ben.farms);
      computeSurveySeedlingRules(ben.seedlingRecords);
    } else {
      loadSurveyPlotOptions(idStr, null);
      computeSurveySeedlingRules(null);
    }
  });

  async function handleSurveyStatusSubmit(e) {
    e.preventDefault();
    const form = e.target;
    hideSurveyError();
    
    form.querySelectorAll('.shared-form-input, .shared-form-select').forEach(el => {
      el.classList.remove('error');
    });

    const beneficiaryId = form.elements['surveyBeneficiaryId'].value;
    const surveyDate = form.elements['surveyDate'].value;
    const surveyer = form.elements['surveyer'].value;
    const aliveCrops = form.elements['aliveCrops'].value;
    const deadCrops = form.elements['deadCrops'].value;
    const plotId = form.elements['surveyPlotId'].value;

    let hasError = false;

    if (!beneficiaryId) {
      form.elements['surveyBeneficiaryName'].classList.add('error');
      hasError = true;
    }
    
    if (!surveyDate) {
      form.elements['surveyDate'].classList.add('error');
      hasError = true;
    } else if (surveyMinDateString && surveyDate < surveyMinDateString) {
      form.elements['surveyDate'].classList.add('error');
      showSurveyError('Survey date cannot be before the first seedling release date.');
      hasError = true;
    }
    
    if (!surveyer) {
      form.elements['surveyer'].classList.add('error');
      hasError = true;
    }
    
    const aliveVal = parseInt(aliveCrops);
    const deadVal = parseInt(deadCrops || 0);
    
    if (!aliveCrops || aliveVal <= 0) {
      form.elements['aliveCrops'].classList.add('error');
      hasError = true;
    }
    
    if (deadCrops === '' || deadVal < 0) {
      form.elements['deadCrops'].classList.add('error');
      hasError = true;
    }
    
    if (!hasError) {
      const totalCrops = aliveVal + deadVal;
      if (totalCrops > surveyMaxSeedlings) {
        form.elements['aliveCrops'].classList.add('error');
        form.elements['deadCrops'].classList.add('error');
        showSurveyError(`The total alive (${aliveVal}) and dead (${deadVal}) crops exceeds the given seedling count of ${surveyMaxSeedlings}.`);
        hasError = true;
      }
    }

    if (hasError) {
      const errorEl = document.getElementById('surveySubmitError');
      if (errorEl.style.display !== 'flex') {
        showSurveyError('Please fill out all required fields correctly.');
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
        LoadingModal.show({ title: 'Saving...', message: 'Saving survey status record...' });
    }

    // Build Multipart Form Data to support uploading pictures files
    const formDataPayload = new FormData();
    formDataPayload.append('beneficiaryId', beneficiaryId);
    formDataPayload.append('surveyDate', surveyDate);
    formDataPayload.append('surveyer', surveyer);
    formDataPayload.append('aliveCrops', aliveVal);
    formDataPayload.append('deadCrops', deadVal);
    formDataPayload.append('plotId', plotId || '');
    
    selectedSurveyFiles.forEach(file => {
      formDataPayload.append('pictures', file);
    });

    try {
        const response = await fetch(`${apiUrl}/crop-status`, {
            method: 'POST',
            headers: {
                'Authorization': `Bearer ${token}`
                // Note: Content-Type header must NOT be set when sending FormData as the browser sets it automatically with the boundary!
            },
            body: formDataPayload
        });

        await new Promise(resolve => setTimeout(resolve, 1200));

        if (!response.ok) {
            const errorData = await response.json().catch(() => ({}));
            throw new Error(errorData.error || errorData.message || 'Failed to add survey status record');
        }

        if (typeof LoadingModal !== 'undefined') {
            LoadingModal.hide();
        }
        
        closeAddSurveyStatusModal();

        if (typeof AlertModal !== 'undefined') {
            AlertModal.show({
                type: 'success',
                title: 'Success!',
                message: 'Survey status has been added successfully.',
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
        
        showSurveyError(error.message || 'An error occurred while saving the survey status record.');
    }
  }
</script>
