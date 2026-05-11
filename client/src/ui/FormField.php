<?php
/**
 * Reusable Form Fields Component
 * 
 * Usage Example:
 * $fieldType = 'text'; // 'text', 'select', 'date', 'beneficiary-card'
 * $fieldName = 'first_name';
 * $fieldLabel = 'First Name';
 * $fieldValue = 'John';
 * $fieldPlaceholder = 'Enter your first name';
 * $fieldRequired = true;
 * include '../ui/FormField.php';
 */

if (!defined('FORM_STYLES_INCLUDED')) {
    define('FORM_STYLES_INCLUDED', true);
?>
<style>
    .shared-form-label {
        display: block;
        margin-bottom: 0.1rem;
        font-weight: 500;
        color: var(--dark-green, #055035);
        font-size: 11px;
    }
    .shared-form-input, .shared-form-select {
        width: 100%;
        padding: 6px 10px;
        border-radius: 6px;
        font-size: 11px;
        box-sizing: border-box;
        transition: border-color 0.2s ease;
        height: 32px;
        border: 1px solid var(--border-gray, #ccc);
        background-color: var(--white, #ffffff);
        color: var(--dark-text, #333);
    }
    .shared-form-select {
        padding: 8px 32px 8px 12px;
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
        cursor: pointer;
    }
    .shared-form-select:disabled {
        background-color: var(--light-gray, #f5f5f5);
        cursor: not-allowed;
        color: #adb5bd;
    }
    .shared-form-input.error, .shared-form-select.error {
        border-color: var(--danger-red, #b00020);
    }
    .shared-form-error-text {
        color: var(--danger-red, #b00020);
        font-size: 10px;
        margin-top: 4px;
        display: block;
    }
    .select-wrapper {
        position: relative;
    }
    .select-arrow {
        position: absolute;
        right: 12px;
        top: 50%;
        transform: translateY(-50%);
        pointer-events: none;
        font-size: 11px;
        color: var(--text-gray, #6c757d);
    }
    .date-field-container {
        display: flex;
        gap: 6px;
        margin-bottom: 12px;
    }
    .date-field-flex {
        flex: 1;
    }
    .age-input {
        background-color: rgba(0, 0, 0, 0.03);
        color: var(--dark-text, #333);
        cursor: not-allowed;
    }
    .beneficiary-card {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 0.5rem;
        background-color: #f8f9fa;
        border-radius: 4px;
        border: 1px solid #e8f5e8;
    }
    .beneficiary-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid #e8f5e8;
    }
    .beneficiary-avatar-placeholder {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background-color: #e8f5e8;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1rem;
        color: #6c757d;
    }
    .beneficiary-name {
        font-size: 0.75rem;
        font-weight: 600;
        color: #2c5530;
    }
    .beneficiary-id {
        font-size: 0.625rem;
        color: #6c757d;
    }
</style>
<?php
}

// Map variables (fallbacks to avoid undefined variable warnings)
$currentFieldType = $fieldType ?? 'text';
$currentFieldName = $fieldName ?? '';
$currentFieldLabel = $fieldLabel ?? '';
$currentFieldValue = $fieldValue ?? '';
$currentFieldPlaceholder = $fieldPlaceholder ?? '';
$currentFieldRequired = $fieldRequired ?? false;
$currentFieldError = $fieldError ?? '';
$currentFieldOptions = $fieldOptions ?? []; // For select fields
$currentFieldDisabled = $fieldDisabled ?? false;

// Helpers
$errorClass = !empty($currentFieldError) ? ' error' : '';
$requiredMark = $currentFieldRequired ? '*' : '';

switch ($currentFieldType) {
    case 'select':
        ?>
        <div>
            <label class="shared-form-label"><?= htmlspecialchars($currentFieldLabel) ?> <?= $requiredMark ?></label>
            <div class="select-wrapper">
                <select 
                    name="<?= htmlspecialchars($currentFieldName) ?>" 
                    class="shared-form-select<?= $errorClass ?>" 
                    <?= $currentFieldDisabled ? 'disabled' : '' ?>
                >
                    <option value="" disabled <?= $currentFieldValue === '' ? 'selected' : '' ?> style="color: #adb5bd;">
                        <?= htmlspecialchars($currentFieldPlaceholder ?: "Select " . strtolower($currentFieldLabel)) ?>
                    </option>
                    <?php foreach ($currentFieldOptions as $optValue => $optLabel): ?>
                        <?php 
                            // Support both associative array ['val' => 'Label'] and sequential array ['Label']
                            $val = is_int($optValue) ? $optLabel : $optValue;
                            $lbl = $optLabel;
                            $selected = ((string)$currentFieldValue === (string)$val) ? 'selected' : '';
                        ?>
                        <option value="<?= htmlspecialchars($val) ?>" <?= $selected ?> style="color: #333;">
                            <?= htmlspecialchars($lbl) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <span class="select-arrow">▼</span>
            </div>
            <?php if (!empty($currentFieldError)): ?>
                <span class="shared-form-error-text"><?= htmlspecialchars($currentFieldError) ?></span>
            <?php endif; ?>
        </div>
        <?php
        break;

    case 'date':
        $showAge = $fieldShowAge ?? false;
        // Generate a unique ID for the inputs if age is shown
        $dateId = 'date_' . md5(uniqid(rand(), true));
        $ageId = 'age_' . md5(uniqid(rand(), true));
        ?>
        <div class="date-field-container">
            <div class="date-field-flex">
                <label class="shared-form-label"><?= htmlspecialchars($currentFieldLabel) ?> <?= $requiredMark ?></label>
                <input 
                    type="date" 
                    id="<?= $dateId ?>"
                    name="<?= htmlspecialchars($currentFieldName) ?>" 
                    value="<?= htmlspecialchars($currentFieldValue) ?>" 
                    class="shared-form-input<?= $errorClass ?>"
                />
                <?php if (!empty($currentFieldError)): ?>
                    <span class="shared-form-error-text"><?= htmlspecialchars($currentFieldError) ?></span>
                <?php endif; ?>
            </div>
            <?php if ($showAge): ?>
                <div class="date-field-flex">
                    <label class="shared-form-label">Age</label>
                    <input 
                        type="text" 
                        id="<?= $ageId ?>"
                        value="—" 
                        readonly 
                        class="shared-form-input age-input" 
                        tabindex="-1"
                    />
                </div>
                <!-- Inline JS for real-time age calculation -->
                <script>
                    (function() {
                        const dateInput = document.getElementById('<?= $dateId ?>');
                        const ageInput = document.getElementById('<?= $ageId ?>');
                        if (dateInput && ageInput) {
                            const calculateAge = (dobString) => {
                                if (!dobString) return '—';
                                const dob = new Date(dobString);
                                if (isNaN(dob.getTime())) return '—';
                                const diff_ms = Date.now() - dob.getTime();
                                const age_dt = new Date(diff_ms); 
                                return Math.abs(age_dt.getUTCFullYear() - 1970);
                            };
                            
                            ageInput.value = calculateAge(dateInput.value);
                            dateInput.addEventListener('change', (e) => {
                                ageInput.value = calculateAge(e.target.value);
                            });
                        }
                    })();
                </script>
            <?php endif; ?>
        </div>
        <?php
        break;

    case 'beneficiary-card':
        $benPicture = $fieldPicture ?? '';
        $benName = $fieldBenName ?? 'Unknown';
        $benId = $fieldBenId ?? 'N/A';
        
        $imgSrc = null;
        if (!empty($benPicture)) {
            if (strpos($benPicture, 'http') === 0) {
                $imgSrc = $benPicture;
            } elseif (strpos($benPicture, '/') !== 0) {
                $imgSrc = "http://localhost:5000/uploads/" . $benPicture;
            } else {
                $imgSrc = "http://localhost:5000" . $benPicture;
            }
        }
        ?>
        <div class="beneficiary-card">
            <?php if ($imgSrc): ?>
                <img src="<?= htmlspecialchars($imgSrc) ?>" alt="Beneficiary" class="beneficiary-avatar" />
            <?php else: ?>
                <div class="beneficiary-avatar-placeholder">👤</div>
            <?php endif; ?>
            <div style="flex: 1;">
                <div class="beneficiary-name"><?= htmlspecialchars($benName) ?></div>
                <div class="beneficiary-id">ID: <?= htmlspecialchars($benId) ?></div>
            </div>
        </div>
        <?php
        break;

    default: // text, number, email, password, etc.
        ?>
        <div>
            <label class="shared-form-label"><?= htmlspecialchars($currentFieldLabel) ?> <?= $requiredMark ?></label>
            <input 
                type="<?= htmlspecialchars($currentFieldType) ?>" 
                name="<?= htmlspecialchars($currentFieldName) ?>" 
                value="<?= htmlspecialchars($currentFieldValue) ?>" 
                class="shared-form-input<?= $errorClass ?>" 
                placeholder="<?= htmlspecialchars($currentFieldPlaceholder) ?>"
                <?= $currentFieldType === 'number' ? 'min="0"' : '' ?>
            />
            <?php if (!empty($currentFieldError)): ?>
                <span class="shared-form-error-text"><?= htmlspecialchars($currentFieldError) ?></span>
            <?php endif; ?>
        </div>
        <?php
        break;
}

// Clean up variables so they don't bleed into the next include
unset(
    $fieldType, $fieldName, $fieldLabel, $fieldValue, $fieldPlaceholder, 
    $fieldRequired, $fieldError, $fieldOptions, $fieldDisabled, 
    $fieldShowAge, $fieldPicture, $fieldBenName, $fieldBenId
);
?>
