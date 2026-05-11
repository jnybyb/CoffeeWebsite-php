<?php
/**
 * AddingNewBeneficiary Component
 * 
 * Usage:
 * include_once '../ui/AddingNewBeneficiary.php';
 * 
 * To open:
 * openAddBeneficiaryModal();
 */
?>
<style>
.add-ben-modal-overlay {
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
.add-ben-modal-overlay.active {
  opacity: 1;
  visibility: visible;
}
.add-ben-form-container {
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
.add-ben-modal-overlay.active .add-ben-form-container {
  transform: scale(1);
}
.add-ben-header {
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
.add-ben-close-btn {
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
.add-ben-close-btn:hover {
  background-color: var(--border-gray, #e9ecef);
}
.add-ben-content-area {
  overflow-y: auto;
  scrollbar-width: thin;
  padding: 0 0.75rem;
  flex: 1;
}
.add-ben-content-area::-webkit-scrollbar { width: 6px; }
.add-ben-content-area::-webkit-scrollbar-track { background: #f1f1f1; border-radius: 3px; }
.add-ben-content-area::-webkit-scrollbar-thumb { background: #c1c1c1; border-radius: 3px; }
.add-ben-content-area::-webkit-scrollbar-thumb:hover { background: #a8a8a8; }

.add-ben-section-title {
  color: var(--black, #000);
  margin-bottom: 1.5rem;
  font-size: 0.9rem;
  font-weight: 600;
}

.add-ben-picture-container {
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
.add-ben-picture-preview {
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
.add-ben-picture-preview img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  border-radius: 50%;
}
.add-ben-file-input {
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

<div class="add-ben-modal-overlay" id="addBeneficiaryModal">
  <form class="add-ben-form-container" id="addBeneficiaryForm" onsubmit="handleBeneficiarySubmit(event)">
    <div class="add-ben-header">
      <h2 style="color: var(--dark-green, #055035); margin: 0; font-size: 1.2rem; font-weight: 700;">Add Beneficiary Record</h2>
      <button type="button" class="add-ben-close-btn" onclick="closeAddBeneficiaryModal()">×</button>
    </div>

    <div class="add-ben-content-area">
      <div style="padding: 1rem; display: flex; flex-direction: column; gap: 12px;">
        
        <div>
          <h3 class="add-ben-section-title" style="margin-bottom: 0.5rem;">Personal Information</h3>
          
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
            
            <div class="add-ben-picture-container">
              <div class="add-ben-picture-preview" id="picturePreviewContainer">
                <svg width="48" height="48" viewBox="0 0 24 24" fill="#6c757d">
                  <circle cx="12" cy="8" r="4"/>
                  <path d="M12 14c-4.418 0-8 1.79-8 4v2h16v-2c0-2.21-3.582-4-8-4z"/>
                </svg>
              </div>
              <div style="width: 100%; text-align: center;">
                <input type="file" name="picture" accept="image/*" class="add-ben-file-input" onchange="handlePictureChange(event)" />
                <p style="font-size: 8px; color: #6c757d; margin: 0;">Upload profile picture</p>
              </div>
            </div>
          </div>

          <div style="display: flex; gap: 6px; margin-bottom: 12px;">
            <div style="flex: 1;">
              <?php
              $fieldType = 'select'; $fieldName = 'gender'; $fieldLabel = 'Gender'; $fieldPlaceholder = 'Select gender';
              $fieldOptions = ['Male' => 'Male', 'Female' => 'Female', 'Other' => 'Other'];
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
          <h3 class="add-ben-section-title" style="margin-bottom: 0.5rem;">Address Information</h3>
          
          <div style="display: flex; gap: 6px; flex-wrap: wrap;">
            <div style="flex: 1 1 calc(50% - 3px);">
              <?php
              $fieldType = 'select'; $fieldName = 'province'; $fieldLabel = 'Province'; $fieldPlaceholder = 'Select province';
              $fieldOptions = ['Davao Oriental' => 'Davao Oriental']; 
              include __DIR__ . '/FormField.php';
              ?>
            </div>
            <div style="flex: 1 1 calc(50% - 3px);">
              <?php
              $fieldType = 'select'; $fieldName = 'municipality'; $fieldLabel = 'Municipality'; $fieldPlaceholder = 'Select municipality';
              $fieldOptions = ['Manay' => 'Manay', 'Tarragona' => 'Tarragona', 'Caraga' => 'Caraga']; 
              include __DIR__ . '/FormField.php';
              ?>
            </div>
            <div style="flex: 1 1 calc(50% - 3px);">
              <?php
              $fieldType = 'select'; $fieldName = 'barangay'; $fieldLabel = 'Barangay'; $fieldPlaceholder = 'Select barangay';
              $fieldOptions = ['Taocanga' => 'Taocanga', 'San Ignacio' => 'San Ignacio']; 
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

        <div id="benSubmitError" style="color: var(--danger-red, #b00020); font-size: 10px; margin-top: 6px; text-align: center; display: none;"></div>

        <div style="display: flex; gap: 0.75rem; justify-content: flex-end; padding-top: 0.75rem; border-top: 1px solid rgba(0,0,0,0.035); margin-top: 12px;">
          <?php
          $btnType = 'cancel'; $btnOnClick = 'closeAddBeneficiaryModal()'; $btnStyles = 'font-size: 11px; padding: 10px 18px; border-radius: 5px;';
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
  function openAddBeneficiaryModal() {
    document.getElementById('addBeneficiaryForm').reset();
    document.getElementById('picturePreviewContainer').innerHTML = `
      <svg width="48" height="48" viewBox="0 0 24 24" fill="#6c757d">
        <circle cx="12" cy="8" r="4"/>
        <path d="M12 14c-4.418 0-8 1.79-8 4v2h16v-2c0-2.21-3.582-4-8-4z"/>
      </svg>
    `;
    document.getElementById('benSubmitError').style.display = 'none';
    
    // Clear Age field
    const ageInputs = document.querySelectorAll('.age-input');
    ageInputs.forEach(input => input.value = '—');
    
    document.getElementById('addBeneficiaryModal').classList.add('active');
  }

  function closeAddBeneficiaryModal() {
    document.getElementById('addBeneficiaryModal').classList.remove('active');
  }

  function handlePictureChange(event) {
    const file = event.target.files[0];
    const previewContainer = document.getElementById('picturePreviewContainer');
    
    if (file && file.type.startsWith('image/')) {
      const reader = new FileReader();
      reader.onload = function(e) {
        previewContainer.innerHTML = `<img src="${e.target.result}" alt="Preview" style="width: 100%; height: 100%; object-fit: cover; border-radius: 50%;" />`;
      };
      reader.readAsDataURL(file);
    } else {
      previewContainer.innerHTML = `
        <svg width="48" height="48" viewBox="0 0 24 24" fill="#6c757d">
          <circle cx="12" cy="8" r="4"/>
          <path d="M12 14c-4.418 0-8 1.79-8 4v2h16v-2c0-2.21-3.582-4-8-4z"/>
        </svg>
      `;
    }
  }

  function handleBeneficiarySubmit(e) {
    e.preventDefault();
    const form = e.target;
    const errorEl = document.getElementById('benSubmitError');
    errorEl.style.display = 'none';
    
    // Basic JS validation
    const cell = form.elements['cellphone'].value;
    if (cell && cell.trim() && !/^09\d{9}$/.test(cell)) {
        errorEl.textContent = 'Please enter a valid Philippine mobile number (09XXXXXXXXX)';
        errorEl.style.display = 'block';
        return;
    }

    // Mock Submit
    if (typeof ModalTypes !== 'undefined') {
        ModalTypes.showSaving({ title: 'Saving', message: 'Adding beneficiary record...' });
        
        setTimeout(() => {
            ModalTypes.hide();
            if (typeof AlertModal !== 'undefined') {
                AlertModal.show({
                    type: 'success',
                    title: 'Success!',
                    message: 'Beneficiary record has been added successfully.',
                    hideButton: true,
                    autoClose: true,
                    autoCloseDelay: 1500,
                    borderRadius: 4
                });
            }
            closeAddBeneficiaryModal();
        }, 1500);
    } else {
        alert("Beneficiary added successfully!");
        closeAddBeneficiaryModal();
    }
  }
</script>
