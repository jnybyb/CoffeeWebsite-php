<?php
/**
 * EditSurveyStatusRecord Component
 * 
 * Usage:
 * include_once '../ui/EditSurveyStatusRecord.php';
 * 
 * To open:
 * openEditSurveyStatusModal(surveyRecord, selectedBeneficiary);
 */
?>
<style>
.edit-survey-modal-overlay {
  position: fixed;
  top: 0; left: 0; right: 0; bottom: 0;
  background-color: rgba(0, 0, 0, 0.75);
  display: flex;
  justify-content: center;
  align-items: center;
  z-index: 11000; /* Mirror AddNewSurveyStatus stack */
  opacity: 0;
  visibility: hidden;
  transition: opacity 0.3s ease, visibility 0.3s ease;
}
.edit-survey-modal-overlay.active {
  opacity: 1;
  visibility: visible;
}
.edit-survey-form-container {
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
.edit-survey-modal-overlay.active .edit-survey-form-container {
  transform: scale(1);
}
.edit-survey-header {
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
.edit-survey-close-btn {
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
.edit-survey-close-btn:hover {
  background-color: var(--border-gray, #e9ecef);
}
.edit-survey-content-area {
  overflow-y: auto;
  scrollbar-width: thin;
  padding: 0 0.75rem;
  flex: 1;
}
.edit-survey-content-area::-webkit-scrollbar { width: 6px; }
.edit-survey-content-area::-webkit-scrollbar-track { background: #f1f1f1; border-radius: 3px; }
.edit-survey-content-area::-webkit-scrollbar-thumb { background: #c1c1c1; border-radius: 3px; }
.edit-survey-content-area::-webkit-scrollbar-thumb:hover { background: #a8a8a8; }
</style>

<div class="edit-survey-modal-overlay" id="editSurveyStatusModal">
  <form class="edit-survey-form-container" id="editSurveyStatusForm" onsubmit="handleEditSurveyStatusSubmit(event)">
    <input type="hidden" name="editSurveyId" id="editSurveyId" />

    <div class="edit-survey-header">
      <h2 style="color: var(--dark-green, #055035); margin: 0; font-size: 1.2rem; font-weight: 700;">Edit Survey Status</h2>
      <button type="button" class="edit-survey-close-btn" onclick="closeEditSurveyStatusModal()">×</button>
    </div>

    <div class="edit-survey-content-area">
      <div style="padding: 1rem; display: flex; flex-direction: column; gap: 12px;">
        
        <!-- Error Message Banner -->
        <div id="editSurveySubmitError" style="background-color: #fde8e8; border: 1px solid #f8b4b4; color: #9b1c1c; padding: 0.75rem 1rem; border-radius: 6px; font-size: 11px; display: none; align-items: center; gap: 8px;">
          <svg style="flex-shrink: 0;" width="14" height="14" viewBox="0 0 20 20" fill="#9b1c1c">
            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
          </svg>
          <span id="editSurveySubmitErrorText"></span>
        </div>

        <!-- Beneficiary Name and ID Row -->
        <div style="display: flex; gap: 12px; margin-bottom: 12px;">
          <div style="flex: 1;">
            <?php
            $fieldType = 'select'; $fieldName = 'editSurveyBeneficiaryName'; $fieldLabel = 'Beneficiary'; $fieldPlaceholder = 'Select Beneficiary'; $fieldRequired = true;
            $fieldOptions = [];
            include __DIR__ . '/FormField.php';
            ?>
          </div>
          <div style="flex: 1;">
            <div>
              <label class="shared-form-label">Beneficiary ID</label>
              <input type="text" name="editSurveyBeneficiaryId" readonly class="shared-form-input age-input" placeholder="Auto-populated" tabindex="-1" />
            </div>
          </div>
        </div>

        <!-- Survey Date and Surveyor Row -->
        <div style="display: flex; gap: 12px; margin-bottom: 12px;">
          <div style="flex: 1;">
            <?php
            $fieldType = 'date'; $fieldName = 'editSurveyDate'; $fieldLabel = 'Survey Date'; $fieldRequired = true;
            include __DIR__ . '/FormField.php';
            ?>
          </div>
          <div style="flex: 1;">
            <?php
            $fieldType = 'text'; $fieldName = 'editSurveyer'; $fieldLabel = 'Surveyer'; $fieldPlaceholder = 'Enter surveyor name'; $fieldRequired = true;
            include __DIR__ . '/FormField.php';
            ?>
          </div>
        </div>

        <!-- Alive Crops and Dead Crops Row -->
        <div style="display: flex; gap: 12px; margin-bottom: 12px;">
          <div style="flex: 1;">
            <?php
            $fieldType = 'number'; $fieldName = 'editSurveyAliveCrops'; $fieldLabel = 'Number of Alive Crops'; $fieldPlaceholder = 'Enter number'; $fieldRequired = true; $fieldMin = 1;
            include __DIR__ . '/FormField.php';
            ?>
          </div>
          <div style="flex: 1;">
            <?php
            $fieldType = 'number'; $fieldName = 'editSurveyDeadCrops'; $fieldLabel = 'Number of Dead Crops'; $fieldPlaceholder = 'Enter number'; $fieldRequired = true; $fieldMin = 0;
            include __DIR__ . '/FormField.php';
            ?>
          </div>
        </div>

        <!-- Plot ID Selection -->
        <div style="margin-bottom: 12px;">
          <?php
          $fieldType = 'select'; $fieldName = 'editSurveyPlotId'; $fieldLabel = 'Plot ID'; $fieldPlaceholder = 'Select Plot ID';
          $fieldOptions = [];
          include __DIR__ . '/FormField.php';
          ?>
        </div>

        <!-- Pictures Multi-upload Grid -->
        <div style="margin-bottom: 12px;">
          <label class="shared-form-label">Pictures (Optional)</label>
          <input id="edit-survey-pictures-input" type="file" multiple accept="image/*" onchange="handleEditSurveyFileChange(event)" style="display: none;" />
          <div id="editSurveyPicturesGrid" style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 8px; margin-top: 8px;">
            <!-- Existing and New Thumbnails will render here -->
            <label for="edit-survey-pictures-input" id="editSurveyPicturesAddLabel" style="cursor: pointer; display: flex; flex-direction: column; justify-content: center; align-items: center; border: 1.5px dashed var(--dark-green, #055035); border-radius: 6px; color: var(--dark-green, #055035); font-size: 13px; font-weight: 500; aspect-ratio: 1/1; margin: 0; background: transparent;">
              <span style="font-size: 18px; margin-bottom: 2px;">+</span>
              <span>Add</span>
            </label>
          </div>
          <div id="editSurveyPicturesCount" style="font-size: 11px; color: var(--placeholder-text, #a8a8a8); margin-top: 6px; display: none;"></div>
        </div>

        <!-- Action Buttons -->
        <div style="display: flex; gap: 0.75rem; justify-content: flex-end; padding-top: 0.75rem; border-top: 1px solid rgba(0,0,0,0.035); margin-top: 12px; margin-bottom: 12px;">
          <?php
          $btnType = 'cancel'; $btnOnClick = 'closeEditSurveyStatusModal()'; $btnStyles = 'font-size: 11px; padding: 10px 18px; border-radius: 5px;';
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
  let selectedEditSurveyFiles = [];
  let existingSurveyPicturesToKeep = [];
  let editSurveyMaxSeedlings = 0;
  let editSurveyMinDateString = '';

  function showEditSurveyError(message) {
    const errorEl = document.getElementById('editSurveySubmitError');
    const errorTextEl = document.getElementById('editSurveySubmitErrorText');
    if (errorEl && errorTextEl) {
      errorTextEl.textContent = message;
      errorEl.style.display = 'flex';
      
      const scrollArea = document.querySelector('.edit-survey-content-area');
      if (scrollArea) {
        scrollArea.scrollTop = 0;
      }
    }
  }

  function hideEditSurveyError() {
    const errorEl = document.getElementById('editSurveySubmitError');
    if (errorEl) {
      errorEl.style.display = 'none';
    }
  }

  function handleEditSurveyFileChange(e) {
    const files = Array.from(e.target.files || []);
    if (!files.length) return;
    
    selectedEditSurveyFiles = [...selectedEditSurveyFiles, ...files].slice(0, 10 - existingSurveyPicturesToKeep.length);
    renderEditSurveyPicturesGrid();
    e.target.value = null;
  }

  function renderEditSurveyPicturesGrid() {
    const grid = document.getElementById('editSurveyPicturesGrid');
    const addLabel = document.getElementById('editSurveyPicturesAddLabel');
    const countDiv = document.getElementById('editSurveyPicturesCount');
    
    grid.querySelectorAll('.survey-thumbnail-card').forEach(el => el.remove());
    
    const apiUrl = typeof API_BASE_URL !== 'undefined' ? API_BASE_URL : 'http://localhost:5000/api';
    const baseUrl = apiUrl.replace('/api', '');

    // 1. Render Existing Kept Images
    existingSurveyPicturesToKeep.forEach((filename, index) => {
      const src = `${baseUrl}/uploads/${filename}`;
      
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
        <img src="${src}" alt="Existing ${index + 1}" style="position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover;" />
        <button type="button" onclick="removeExistingSurveyPicture(${index})" title="Remove"
          style="position: absolute; top: 4px; right: 4px; width: 18px; height: 18px; border-radius: 50%; background: rgba(0,0,0,0.6); color: #fff; border: none; cursor: pointer; display: flex; align-items: center; justify-content: center; font-size: 12px; line-height: 1; padding: 0;">×</button>
      `;
      
      grid.insertBefore(card, addLabel);
    });

    // 2. Render Newly Selected Images
    selectedEditSurveyFiles.forEach((file, index) => {
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
        <img src="${src}" alt="New ${index + 1}" style="position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover; border-top: 1.5px solid var(--dark-green, #055035);" />
        <button type="button" onclick="removeNewSurveyFile(${index})" title="Remove"
          style="position: absolute; top: 4px; right: 4px; width: 18px; height: 18px; border-radius: 50%; background: rgba(0,0,0,0.6); color: #fff; border: none; cursor: pointer; display: flex; align-items: center; justify-content: center; font-size: 12px; line-height: 1; padding: 0;">×</button>
      `;
      
      grid.insertBefore(card, addLabel);
    });
    
    const totalCount = existingSurveyPicturesToKeep.length + selectedEditSurveyFiles.length;
    if (totalCount >= 10) {
      addLabel.style.display = 'none';
    } else {
      addLabel.style.display = 'flex';
    }
    
    if (totalCount > 0) {
      countDiv.style.display = 'block';
      countDiv.textContent = `${totalCount}/10 selected (${existingSurveyPicturesToKeep.length} existing, ${selectedEditSurveyFiles.length} new)`;
    } else {
      countDiv.style.display = 'none';
    }
  }

  function removeExistingSurveyPicture(index) {
    existingSurveyPicturesToKeep = existingSurveyPicturesToKeep.filter((_, i) => i !== index);
    renderEditSurveyPicturesGrid();
  }

  function removeNewSurveyFile(index) {
    selectedEditSurveyFiles = selectedEditSurveyFiles.filter((_, i) => i !== index);
    renderEditSurveyPicturesGrid();
  }

  function openEditSurveyStatusModal(record, selectedBeneficiary) {
    const form = document.getElementById('editSurveyStatusForm');
    form.reset();
    selectedEditSurveyFiles = [];
    existingSurveyPicturesToKeep = Array.isArray(record.pictures) ? [...record.pictures] : [];
    
    renderEditSurveyPicturesGrid();
    hideEditSurveyError();
    
    form.querySelectorAll('.shared-form-input, .shared-form-select').forEach(el => {
      el.classList.remove('error');
    });

    const surveyIdInput = document.getElementById('editSurveyId');
    const benNameSelect = form.querySelector('select[name="editSurveyBeneficiaryName"]');
    const benIdInput = form.querySelector('input[name="editSurveyBeneficiaryId"]');
    const plotSelect = form.querySelector('select[name="editSurveyPlotId"]');

    surveyIdInput.value = record.id;
    
    // Format dates to YYYY-MM-DD for standard date inputs
    const formatDateForInput = (dStr) => {
      if (!dStr) return '';
      return dStr.split('T')[0];
    };

    form.elements['editSurveyDate'].value = formatDateForInput(record.surveyDate);
    form.elements['editSurveyer'].value = record.surveyer || '';
    form.elements['editSurveyAliveCrops'].value = record.aliveCrops || '';
    form.elements['editSurveyDeadCrops'].value = record.deadCrops || '';

    if (selectedBeneficiary) {
      const firstName = selectedBeneficiary.firstName || '';
      const middleName = selectedBeneficiary.middleName || '';
      const lastName = selectedBeneficiary.lastName || '';
      const fullName = `${firstName} ${middleName} ${lastName}`.trim().replace(/\s+/g, ' ') || selectedBeneficiary.fullName || 'N/A';
      const idStr = selectedBeneficiary.beneficiaryId || selectedBeneficiary._id || 'N/A';
      
      benNameSelect.innerHTML = `<option value="${idStr}" selected>${fullName}</option>`;
      benNameSelect.disabled = true;
      benIdInput.value = idStr;
      
      loadEditSurveyPlotOptions(idStr, selectedBeneficiary.farms, record.plotId);
      computeEditSurveySeedlingRules(selectedBeneficiary.seedlingRecords);
    }

    document.getElementById('editSurveyStatusModal').classList.add('active');
  }

  function closeEditSurveyStatusModal() {
    document.getElementById('editSurveyStatusModal').classList.remove('active');
  }

  function loadEditSurveyPlotOptions(beneficiaryId, preloadedFarms, selectedPlotId) {
    const plotSelect = document.querySelector('#editSurveyStatusForm select[name="editSurveyPlotId"]');
    if (!plotSelect) return;
    
    plotSelect.innerHTML = '<option value="" disabled>Select Plot ID</option>';
    plotSelect.disabled = true;

    const appendPlotOpts = (farms) => {
      const defaultOpt = document.createElement('option');
      defaultOpt.value = '';
      defaultOpt.textContent = 'Select Plot ID (Optional)';
      plotSelect.appendChild(defaultOpt);

      farms.forEach(farm => {
        const opt = document.createElement('option');
        const fId = farm.id || farm.plotId || farm._id;
        opt.value = fId;
        opt.textContent = fId;
        opt.style.color = '#333';
        if (selectedPlotId && String(fId) === String(selectedPlotId)) {
          opt.selected = true;
        }
        plotSelect.appendChild(opt);
      });
      plotSelect.disabled = false;
    };

    if (preloadedFarms && preloadedFarms.length > 0) {
      appendPlotOpts(preloadedFarms);
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
          appendPlotOpts(beneficiaryPlots);
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

  function computeEditSurveySeedlingRules(seedlingRecords) {
    const dateInput = document.querySelector('#editSurveyStatusForm input[name="editSurveyDate"]');
    const aliveInput = document.querySelector('#editSurveyStatusForm input[name="editSurveyAliveCrops"]');
    
    if (seedlingRecords && seedlingRecords.length > 0) {
      editSurveyMaxSeedlings = seedlingRecords.reduce((sum, s) => sum + (parseInt(s.received) || 0), 0);
      aliveInput.placeholder = `Enter number (Max: ${editSurveyMaxSeedlings})`;
      aliveInput.max = editSurveyMaxSeedlings;
      
      const releaseDates = seedlingRecords
        .map(s => s.dateReceived)
        .filter(Boolean)
        .map(d => d.split('T')[0]);
        
      if (releaseDates.length > 0) {
        editSurveyMinDateString = releaseDates.reduce((min, d) => (d < min ? d : min), releaseDates[0]);
        dateInput.min = editSurveyMinDateString;
      } else {
        editSurveyMinDateString = '';
        dateInput.removeAttribute('min');
      }
    } else {
      editSurveyMaxSeedlings = 0;
      aliveInput.placeholder = 'Enter number';
      aliveInput.removeAttribute('max');
      editSurveyMinDateString = '';
      dateInput.removeAttribute('min');
    }
  }

  async function handleEditSurveyStatusSubmit(e) {
    e.preventDefault();
    const form = e.target;
    hideEditSurveyError();
    
    form.querySelectorAll('.shared-form-input, .shared-form-select').forEach(el => {
      el.classList.remove('error');
    });

    const surveyId = document.getElementById('editSurveyId').value;
    const beneficiaryId = form.elements['editSurveyBeneficiaryId'].value;
    const surveyDate = form.elements['editSurveyDate'].value;
    const surveyer = form.elements['editSurveyer'].value;
    const aliveCrops = form.elements['editSurveyAliveCrops'].value;
    const deadCrops = form.elements['editSurveyDeadCrops'].value;
    const plotId = form.elements['editSurveyPlotId'].value;

    let hasError = false;

    if (!beneficiaryId) {
      form.elements['editSurveyBeneficiaryName'].classList.add('error');
      hasError = true;
    }
    
    if (!surveyDate) {
      form.elements['editSurveyDate'].classList.add('error');
      hasError = true;
    } else if (editSurveyMinDateString && surveyDate < editSurveyMinDateString) {
      form.elements['editSurveyDate'].classList.add('error');
      showEditSurveyError('Survey date cannot be before the first seedling release date.');
      hasError = true;
    }
    
    if (!surveyer) {
      form.elements['editSurveyer'].classList.add('error');
      hasError = true;
    }
    
    const aliveVal = parseInt(aliveCrops);
    const deadVal = parseInt(deadCrops || 0);
    
    if (!aliveCrops || aliveVal <= 0) {
      form.elements['editSurveyAliveCrops'].classList.add('error');
      hasError = true;
    }
    
    if (deadCrops === '' || deadVal < 0) {
      form.elements['editSurveyDeadCrops'].classList.add('error');
      hasError = true;
    }
    
    if (!hasError) {
      const totalCrops = aliveVal + deadVal;
      if (totalCrops > editSurveyMaxSeedlings) {
        form.elements['editSurveyAliveCrops'].classList.add('error');
        form.elements['editSurveyDeadCrops'].classList.add('error');
        showEditSurveyError(`The total alive (${aliveVal}) and dead (${deadVal}) crops exceeds the given seedling count of ${editSurveyMaxSeedlings}.`);
        hasError = true;
      }
    }

    if (hasError) {
      const errorEl = document.getElementById('editSurveySubmitError');
      if (errorEl.style.display !== 'flex') {
        showEditSurveyError('Please fill out all required fields correctly.');
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
        LoadingModal.show({ title: 'Saving...', message: 'Updating survey status record...' });
    }

    // Build Multipart Form Data
    const formDataPayload = new FormData();
    formDataPayload.append('beneficiaryId', beneficiaryId);
    formDataPayload.append('surveyDate', surveyDate);
    formDataPayload.append('surveyer', surveyer);
    formDataPayload.append('aliveCrops', aliveVal);
    formDataPayload.append('deadCrops', deadVal);
    formDataPayload.append('plotId', plotId || '');
    formDataPayload.append('existingPictures', JSON.stringify(existingSurveyPicturesToKeep));
    
    selectedEditSurveyFiles.forEach(file => {
      formDataPayload.append('pictures', file);
    });

    try {
        const response = await fetch(`${apiUrl}/crop-status/${surveyId}`, {
            method: 'PUT',
            headers: {
                'Authorization': `Bearer ${token}`
            },
            body: formDataPayload
        });

        await new Promise(resolve => setTimeout(resolve, 1200));

        if (!response.ok) {
            const errorData = await response.json().catch(() => ({}));
            throw new Error(errorData.error || errorData.message || 'Failed to update survey status record');
        }

        if (typeof LoadingModal !== 'undefined') {
            LoadingModal.hide();
        }
        
        closeEditSurveyStatusModal();

        if (typeof AlertModal !== 'undefined') {
            AlertModal.show({
                type: 'success',
                title: 'Success!',
                message: 'Survey status has been updated successfully.',
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
        
        showEditSurveyError(error.message || 'An error occurred while saving the survey status record.');
    }
  }
</script>
