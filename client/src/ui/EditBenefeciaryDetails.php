<?php
/**
 * EditBenefeciaryDetails Component
 * 
 * Usage:
 * include_once '../ui/EditBenefeciaryDetails.php';
 * 
 * To open:
 * openEditBeneficiaryModal(beneficiaryId);
 */
?>
<style>
.edit-ben-modal-overlay {
  position: fixed;
  top: 0; left: 0; right: 0; bottom: 0;
  background-color: rgba(0, 0, 0, 0.75);
  display: flex;
  justify-content: center;
  align-items: center;
  z-index: 10001;
  opacity: 0;
  visibility: hidden;
  transition: opacity 0.3s ease, visibility 0.3s ease;
}
.edit-ben-modal-overlay.active {
  opacity: 1;
  visibility: visible;
}
.edit-ben-form-container {
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
.edit-ben-modal-overlay.active .edit-ben-form-container {
  transform: scale(1);
}
.edit-ben-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  border-bottom: .5px solid var(--border-gray, #e9ecef);
  padding: 1.4rem 1rem;
  background: var(--white, #ffffff);
  position: sticky;
  border-radius: 5px 5px 0 0;
  top: 0;
  z-index: 10;
}
.edit-ben-close-btn {
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
.edit-ben-close-btn:hover {
  background-color: var(--border-gray, #e9ecef);
}
.edit-ben-content-area {
  overflow-y: auto;
  scrollbar-width: thin;
  padding: 0 0.75rem;
  flex: 1;
}
.edit-ben-content-area::-webkit-scrollbar { width: 6px; }
.edit-ben-content-area::-webkit-scrollbar-track { background: #f1f1f1; border-radius: 3px; }
.edit-ben-content-area::-webkit-scrollbar-thumb { background: #c1c1c1; border-radius: 3px; }
.edit-ben-content-area::-webkit-scrollbar-thumb:hover { background: #a8a8a8; }

.edit-ben-section-title {
  color: var(--black, #000);
  margin-bottom: 1.5rem;
  font-size: 0.9rem;
  font-weight: 600;
}

.edit-ben-picture-container {
  min-width: 150px;
  max-width: 150px;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: space-between;
  gap: .5rem;
  padding: 12px;
  background-color: rgba(0, 0, 0, 0.03);
  border-radius: 4px;
  border: 1px solid var(--border-gray, #e9ecef);
}
.edit-ben-picture-preview {
  width: 70px;
  height: 70px;
  border-radius: 50%;
  background-color: white;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 40px;
  border: 1px solid var(--border-gray, #e9ecef);
  overflow: hidden;
}
.edit-ben-picture-preview img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  border-radius: 50%;
}
.edit-ben-file-input {
  width: 100%;
  display: block;
  margin: 0 auto 6px auto;
  border: 1px solid var(--border-gray, #e9ecef);
  border-radius: 4px;
  font-size: 8px;
  background: white;
  cursor: pointer;
  box-sizing: border-box;
  text-align: center;
  padding: 4px;
}
</style>

<div class="edit-ben-modal-overlay" id="editBeneficiaryModal">
  <form class="edit-ben-form-container" id="editBeneficiaryForm" onsubmit="handleEditBeneficiarySubmit(event)">
    <!-- DB auto-increment ID to put in the API request path -->
    <input type="hidden" name="id" id="editBenDbId" />
    <input type="hidden" name="originalPicture" id="editOriginalPicture" />

    <div class="edit-ben-header">
      <h2 style="color: var(--dark-green, #055035); margin: 0; font-size: 1.2rem; font-weight: 700;">Edit Beneficiary Record</h2>
      <button type="button" class="edit-ben-close-btn" onclick="closeEditBeneficiaryModal()">×</button>
    </div>

    <div class="edit-ben-content-area">
      <div style="padding: 1rem; display: flex; flex-direction: column; gap: 12px;">
        
        <div>
          <h3 class="edit-ben-section-title" style="margin-bottom: 0.5rem;">Personal Information</h3>
          
          <div style="display: flex; gap: 12px; align-items: stretch; margin-bottom: 12px;">
            <div style="flex: 1; display: flex; flex-direction: column; gap: 7px;">
              <?php
              $fieldType = 'text'; $fieldName = 'firstName'; $fieldLabel = 'First Name'; $fieldPlaceholder = 'Enter first name'; $fieldRequired = true;
              include __DIR__ . '/FormField.php';
              
              $fieldType = 'text'; $fieldName = 'middleName'; $fieldLabel = 'Middle Name'; $fieldPlaceholder = 'Enter middle name (optional)'; $fieldRequired = false;
              include __DIR__ . '/FormField.php';
              
              $fieldType = 'text'; $fieldName = 'lastName'; $fieldLabel = 'Last Name'; $fieldPlaceholder = 'Enter last name'; $fieldRequired = true;
              include __DIR__ . '/FormField.php';
              ?>
            </div>
            
            <div class="edit-ben-picture-container">
              <div class="edit-ben-picture-preview" id="editPicturePreviewContainer">
                <svg width="48" height="48" viewBox="0 0 24 24" fill="#6c757d">
                  <circle cx="12" cy="8" r="4"/>
                  <path d="M12 14c-4.418 0-8 1.79-8 4v2h16v-2c0-2.21-3.582-4-8-4z"/>
                </svg>
              </div>
              <div style="width: 100%; text-align: center;">
                <input type="file" name="picture" accept="image/*" class="edit-ben-file-input" onchange="handleEditPictureChange(event)" />
                <p style="font-size: 8px; color: #6c757d; margin: 0;">Upload new profile picture</p>
              </div>
            </div>
          </div>

          <div style="display: flex; gap: 6px; margin-bottom: 12px;">
            <div style="flex: 1;">
              <?php
              $fieldType = 'select'; $fieldName = 'gender'; $fieldLabel = 'Gender'; $fieldPlaceholder = 'Select gender';
              $fieldOptions = ['Male' => 'Male', 'Female' => 'Female'];
              include __DIR__ . '/FormField.php';
              ?>
            </div>
            <div style="flex: 1;">
              <?php
              $fieldType = 'select'; $fieldName = 'maritalStatus'; $fieldLabel = 'Marital Status'; $fieldPlaceholder = 'Select status';
              $fieldOptions = ['Single' => 'Single', 'Married' => 'Married', 'Widowed' => 'Widowed', 'Separated' => 'Separated'];
              include __DIR__ . '/FormField.php';
              ?>
            </div>
          </div>

          <?php
          $fieldType = 'date'; $fieldName = 'birthDate'; $fieldLabel = 'Birth Date'; $fieldShowAge = true;
          include __DIR__ . '/FormField.php';
          
          $fieldType = 'text'; $fieldName = 'cellphone'; $fieldLabel = 'Cellphone Number'; $fieldPlaceholder = '09XXXXXXXXX';
          include __DIR__ . '/FormField.php';
          ?>
        </div>

        <div style="margin-top: 12px;">
          <h3 class="edit-ben-section-title" style="margin-bottom: 0.5rem;">Address Information</h3>
          
          <div style="display: flex; gap: 6px; flex-wrap: wrap;">
            <div style="flex: 1 1 calc(50% - 3px);">
              <?php
              $fieldType = 'select'; $fieldName = 'province'; $fieldLabel = 'Province'; $fieldPlaceholder = 'Select province';
              $fieldOptions = []; 
              include __DIR__ . '/FormField.php';
              ?>
            </div>
            <div style="flex: 1 1 calc(50% - 3px);">
              <?php
              $fieldType = 'select'; $fieldName = 'municipality'; $fieldLabel = 'Municipality'; $fieldPlaceholder = 'Select municipality';
              $fieldOptions = []; 
              $fieldDisabled = true;
              include __DIR__ . '/FormField.php';
              ?>
            </div>
            <div style="flex: 1 1 calc(50% - 3px);">
              <?php
              $fieldType = 'select'; $fieldName = 'barangay'; $fieldLabel = 'Barangay'; $fieldPlaceholder = 'Select barangay';
              $fieldOptions = []; 
              $fieldDisabled = true;
              include __DIR__ . '/FormField.php';
              ?>
            </div>
            <div style="flex: 1 1 calc(50% - 3px);">
              <?php
              $fieldType = 'text'; $fieldName = 'purok'; $fieldLabel = 'Purok'; $fieldPlaceholder = 'Enter purok'; $fieldRequired = true;
              include __DIR__ . '/FormField.php';
              ?>
            </div>
          </div>
        </div>

        <div id="editBenSubmitError" style="color: var(--danger-red, #b00020); font-size: 10px; margin-top: 6px; text-align: center; display: none;"></div>

        <div style="display: flex; gap: 0.75rem; justify-content: flex-end; padding-top: 0.75rem; border-top: 1px solid rgba(0,0,0,0.035); margin-top: 12px;">
          <?php
          $btnType = 'cancel'; $btnOnClick = 'closeEditBeneficiaryModal()'; $btnStyles = 'font-size: 11px; padding: 10px 18px; border-radius: 5px;';
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
  let cachedEditProvinces = [];

  async function loadEditProvinces(selectedProvince = null, selectedMunicipality = null, selectedBarangay = null) {
    const provinceSelect = document.querySelector('#editBeneficiaryForm select[name="province"]');
    if (!provinceSelect) return;
    
    if (cachedEditProvinces.length === 0) {
      try {
        const apiUrl = typeof API_BASE_URL !== 'undefined' ? API_BASE_URL : 'http://localhost:5000/api';
        const token = localStorage.getItem('authToken');
        const response = await fetch(`${apiUrl}/addresses/provinces`, {
            headers: { 'Authorization': `Bearer ${token}` }
        });
        if (response.ok) {
            cachedEditProvinces = await response.json();
        }
      } catch (err) {
        console.error('Failed to load provinces', err);
      }
    }
    
    const defaultOption = provinceSelect.options[0];
    provinceSelect.innerHTML = '';
    provinceSelect.appendChild(defaultOption);
    
    cachedEditProvinces.forEach(prov => {
        const opt = document.createElement('option');
        opt.value = prov;
        opt.textContent = prov;
        opt.style.color = '#333';
        provinceSelect.appendChild(opt);
    });

    if (selectedProvince) {
      provinceSelect.value = selectedProvince;
      await loadEditMunicipalities(selectedProvince, selectedMunicipality, selectedBarangay);
    }
  }

  async function loadEditMunicipalities(province, selectedMunicipality = null, selectedBarangay = null) {
    const municipalitySelect = document.querySelector('#editBeneficiaryForm select[name="municipality"]');
    if (!municipalitySelect) return;
    const defaultOption = municipalitySelect.options[0];
    municipalitySelect.innerHTML = '';
    municipalitySelect.appendChild(defaultOption);
    municipalitySelect.disabled = true;
    
    if (!province) return;
    
    try {
        const apiUrl = typeof API_BASE_URL !== 'undefined' ? API_BASE_URL : 'http://localhost:5000/api';
        const token = localStorage.getItem('authToken');
        const response = await fetch(`${apiUrl}/addresses/municipalities/${encodeURIComponent(province)}`, {
            headers: { 'Authorization': `Bearer ${token}` }
        });
        if (response.ok) {
            const municipalities = await response.json();
            municipalities.forEach(mun => {
                const opt = document.createElement('option');
                opt.value = mun;
                opt.textContent = mun;
                opt.style.color = '#333';
                municipalitySelect.appendChild(opt);
            });
            municipalitySelect.disabled = false;
            
            if (selectedMunicipality) {
              municipalitySelect.value = selectedMunicipality;
              await loadEditBarangays(province, selectedMunicipality, selectedBarangay);
            }
        }
    } catch (err) {
        console.error('Failed to load municipalities', err);
    }
  }

  async function loadEditBarangays(province, municipality, selectedBarangay = null) {
    const barangaySelect = document.querySelector('#editBeneficiaryForm select[name="barangay"]');
    if (!barangaySelect) return;
    const defaultOption = barangaySelect.options[0];
    barangaySelect.innerHTML = '';
    barangaySelect.appendChild(defaultOption);
    barangaySelect.disabled = true;
    
    if (!province || !municipality) return;
    
    try {
        const apiUrl = typeof API_BASE_URL !== 'undefined' ? API_BASE_URL : 'http://localhost:5000/api';
        const token = localStorage.getItem('authToken');
        const response = await fetch(`${apiUrl}/addresses/barangays/${encodeURIComponent(province)}/${encodeURIComponent(municipality)}`, {
            headers: { 'Authorization': `Bearer ${token}` }
        });
        if (response.ok) {
            const barangays = await response.json();
            barangays.forEach(brgy => {
                const opt = document.createElement('option');
                opt.value = brgy;
                opt.textContent = brgy;
                opt.style.color = '#333';
                barangaySelect.appendChild(opt);
            });
            barangaySelect.disabled = false;
            
            if (selectedBarangay) {
              barangaySelect.value = selectedBarangay;
            }
        }
    } catch (err) {
        console.error('Failed to load barangays', err);
    }
  }

  // Set up event listeners for cascading selects in the Edit form
  const editBenForm = document.getElementById('editBeneficiaryForm');
  if (editBenForm) {
      editBenForm.addEventListener('change', (e) => {
          if (e.target.name === 'province') {
              const prov = e.target.value;
              const municipalitySelect = editBenForm.querySelector('select[name="municipality"]');
              if (municipalitySelect) {
                  municipalitySelect.selectedIndex = 0;
                  municipalitySelect.disabled = true;
              }
              const barangaySelect = editBenForm.querySelector('select[name="barangay"]');
              if (barangaySelect) {
                  barangaySelect.selectedIndex = 0;
                  barangaySelect.disabled = true;
              }
              if (prov) loadEditMunicipalities(prov);
          } else if (e.target.name === 'municipality') {
              const mun = e.target.value;
              const prov = editBenForm.querySelector('select[name="province"]').value;
              const barangaySelect = editBenForm.querySelector('select[name="barangay"]');
              if (barangaySelect) {
                  barangaySelect.selectedIndex = 0;
                  barangaySelect.disabled = true;
              }
              if (prov && mun) loadEditBarangays(prov, mun);
          }
      });
  }

  function showFieldError(inputElement, errorMessage) {
    if (!inputElement) return;
    inputElement.classList.add('error');
    
    let parent = inputElement.closest('.select-wrapper');
    if (parent) {
        parent = parent.parentElement;
    } else {
        parent = inputElement.closest('div');
    }
    if (!parent) return;
    
    let errorSpan = parent.querySelector('.shared-form-error-text');
    if (!errorSpan) {
        errorSpan = document.createElement('span');
        errorSpan.className = 'shared-form-error-text';
        parent.appendChild(errorSpan);
    }
    errorSpan.textContent = errorMessage;
    errorSpan.style.display = 'block';
  }

  function clearFormErrors(form) {
    if (!form) return;
    form.querySelectorAll('.shared-form-input, .shared-form-select').forEach(el => {
        el.classList.remove('error');
    });
    form.querySelectorAll('.shared-form-error-text').forEach(el => {
        el.style.display = 'none';
        el.textContent = '';
    });
  }

  function validateBeneficiaryForm(form) {
    clearFormErrors(form);
    let isValid = true;

    const showError = (fieldName, message) => {
        const input = form.elements[fieldName];
        if (input) {
            showFieldError(input, message);
            isValid = false;
        }
    };

    const firstName = form.elements['firstName'].value.trim();
    if (!firstName) {
        showError('firstName', 'First name is required');
    }

    const lastName = form.elements['lastName'].value.trim();
    if (!lastName) {
        showError('lastName', 'Last name is required');
    }

    const gender = form.elements['gender'].value;
    if (!gender) {
        showError('gender', 'Gender is required');
    }

    const maritalStatus = form.elements['maritalStatus'].value;
    if (!maritalStatus) {
        showError('maritalStatus', 'Marital status is required');
    }

    const birthDate = form.elements['birthDate'].value;
    if (!birthDate) {
        showError('birthDate', 'Birth date is required');
    }

    const cellphone = form.elements['cellphone'].value.trim();
    if (cellphone && !/^09\d{9}$/.test(cellphone)) {
        showError('cellphone', 'Please enter a valid Philippine mobile number (09XXXXXXXXX)');
    }

    const province = form.elements['province'].value;
    if (!province) {
        showError('province', 'Province is required');
    }

    const municipality = form.elements['municipality'].value;
    if (!municipality) {
        showError('municipality', 'Municipality is required');
    }

    const barangay = form.elements['barangay'].value;
    if (!barangay) {
        showError('barangay', 'Barangay is required');
    }

    const purok = form.elements['purok'].value.trim();
    if (!purok) {
        showError('purok', 'Purok is required');
    }

    return isValid;
  }

  async function openEditBeneficiaryModal(beneficiaryId) {
    const ben = window.beneficiariesData[beneficiaryId];
    if (!ben) return;

    document.getElementById('editBeneficiaryForm').reset();
    clearFormErrors(document.getElementById('editBeneficiaryForm'));
    document.getElementById('editBenDbId').value = ben.id || '';
    document.getElementById('editOriginalPicture').value = ben.picture || '';
    document.getElementById('editBenSubmitError').style.display = 'none';

    // Populate standard text fields
    const form = document.getElementById('editBeneficiaryForm');
    form.elements['firstName'].value = ben.firstName || '';
    form.elements['middleName'].value = ben.middleName || '';
    form.elements['lastName'].value = ben.lastName || '';
    form.elements['gender'].value = ben.gender || '';
    form.elements['maritalStatus'].value = ben.maritalStatus || '';
    form.elements['birthDate'].value = ben.birthDate || '';
    form.elements['cellphone'].value = ben.cellphone || '';
    form.elements['purok'].value = ben.purok || '';

    // Calculate age (trigger change event or calculate directly)
    const dateInput = form.elements['birthDate'];
    if (dateInput) {
      const event = new Event('change');
      dateInput.dispatchEvent(event);
    }

    // Populate profile picture preview
    const previewContainer = document.getElementById('editPicturePreviewContainer');
    if (ben.picture) {
      const apiUrl = typeof API_BASE_URL !== 'undefined' ? API_BASE_URL : 'http://localhost:5000/api';
      const imgUrl = `${apiUrl.replace('/api', '')}${ben.picture}`;
      previewContainer.innerHTML = `<img src="${imgUrl}" alt="Preview" style="width: 100%; height: 100%; object-fit: cover; border-radius: 50%;" />`;
    } else {
      previewContainer.innerHTML = `
        <svg width="48" height="48" viewBox="0 0 24 24" fill="#6c757d">
          <circle cx="12" cy="8" r="4"/>
          <path d="M12 14c-4.418 0-8 1.79-8 4v2h16v-2c0-2.21-3.582-4-8-4z"/>
        </svg>
      `;
    }

    // Reset and load cascading dropdowns for address
    const municipalitySelect = form.querySelector('select[name="municipality"]');
    if (municipalitySelect) { municipalitySelect.disabled = true; municipalitySelect.selectedIndex = 0; }
    const barangaySelect = form.querySelector('select[name="barangay"]');
    if (barangaySelect) { barangaySelect.disabled = true; barangaySelect.selectedIndex = 0; }

    // Start cascaded loading of address dropdowns
    await loadEditProvinces(ben.province, ben.municipality, ben.barangay);

    document.getElementById('editBeneficiaryModal').classList.add('active');
  }

  function closeEditBeneficiaryModal() {
    document.getElementById('editBeneficiaryModal').classList.remove('active');
  }

  function handleEditPictureChange(event) {
    const file = event.target.files[0];
    const previewContainer = document.getElementById('editPicturePreviewContainer');
    
    if (file && file.type.startsWith('image/')) {
      const reader = new FileReader();
      reader.onload = function(e) {
        previewContainer.innerHTML = `<img src="${e.target.result}" alt="Preview" style="width: 100%; height: 100%; object-fit: cover; border-radius: 50%;" />`;
      };
      reader.readAsDataURL(file);
    } else {
      // Re-populate with original picture if it exists
      const originalPic = document.getElementById('editOriginalPicture').value;
      if (originalPic) {
        const apiUrl = typeof API_BASE_URL !== 'undefined' ? API_BASE_URL : 'http://localhost:5000/api';
        const imgUrl = `${apiUrl.replace('/api', '')}${originalPic}`;
        previewContainer.innerHTML = `<img src="${imgUrl}" alt="Preview" style="width: 100%; height: 100%; object-fit: cover; border-radius: 50%;" />`;
      } else {
        previewContainer.innerHTML = `
          <svg width="48" height="48" viewBox="0 0 24 24" fill="#6c757d">
            <circle cx="12" cy="8" r="4"/>
            <path d="M12 14c-4.418 0-8 1.79-8 4v2h16v-2c0-2.21-3.582-4-8-4z"/>
          </svg>
        `;
      }
    }
  }

  async function handleEditBeneficiarySubmit(e) {
    e.preventDefault();
    const form = e.target;
    const errorEl = document.getElementById('editBenSubmitError');
    errorEl.style.display = 'none';
    
    // Validate form fields dynamically
    if (!validateBeneficiaryForm(form)) {
        const firstError = form.querySelector('.shared-form-input.error, .shared-form-select.error');
        if (firstError) {
            firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
            firstError.focus();
        }
        return;
    }

    const token = localStorage.getItem('authToken');
    if (!token) {
        window.location.href = '../../login.php';
        return;
    }

    const dbId = document.getElementById('editBenDbId').value;
    if (!dbId) {
        errorEl.textContent = 'Error: Beneficiary ID is missing.';
        errorEl.style.display = 'block';
        return;
    }

    const formData = new FormData(form);
    const apiUrl = typeof API_BASE_URL !== 'undefined' ? API_BASE_URL : 'http://localhost:5000/api';

    // 1. Display LoadingModal (above the Edit Modal)
    if (typeof ModalTypes !== 'undefined') {
        ModalTypes.showSaving({ title: 'Saving', message: 'Saving beneficiary changes...' });
    } else if (typeof LoadingModal !== 'undefined') {
        LoadingModal.show({ title: 'Saving...', message: 'Saving beneficiary changes', spinnerColor: '#055035' });
    }

    try {
        const response = await fetch(`${apiUrl}/beneficiaries/${dbId}`, {
            method: 'PUT',
            headers: {
                'Authorization': `Bearer ${token}`
            },
            body: formData
        });

        // Add a slight delay to ensure the loading modal is visible as requested
        await new Promise(resolve => setTimeout(resolve, 1200));

        if (!response.ok) {
            const errorData = await response.json().catch(() => ({}));
            throw new Error(errorData.error || errorData.message || 'Failed to update beneficiary');
        }

        // 2. Hide loading and close edit modal BEFORE showing success AlertModal
        if (typeof LoadingModal !== 'undefined') {
            LoadingModal.hide();
        }
        
        closeEditBeneficiaryModal();

        // Close details panel as the data has updated
        if (typeof closeDetailPanel === 'function') {
            closeDetailPanel();
        }

        if (typeof AlertModal !== 'undefined') {
            AlertModal.show({
                type: 'success',
                title: 'Success!',
                message: 'Beneficiary record has been updated successfully.',
                hideButton: true,
                autoClose: true,
                autoCloseDelay: 1500,
                borderRadius: 4
            });
        } else {
            alert("Beneficiary updated successfully!");
        }

        // Refresh the table if the function exists
        if (typeof loadBeneficiaries === 'function') {
            loadBeneficiaries();
        }
    } catch (error) {
        // Hide loading
        if (typeof LoadingModal !== 'undefined') {
            LoadingModal.hide();
        }
        
        if (errorEl) {
            errorEl.textContent = error.message || 'An error occurred while updating the beneficiary.';
            errorEl.style.display = 'block';
            errorEl.scrollIntoView({ behavior: 'smooth', block: 'center' });
        } else {
            alert("Error: " + (error.message || 'An error occurred while updating.'));
        }
    }
  }
</script>
