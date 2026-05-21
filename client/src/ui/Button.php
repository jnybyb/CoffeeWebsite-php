<?php
/**
 * Reusable Button Component
 * 
 * Usage Example:
 * $btnType = 'save'; // 'add', 'cancel', 'save', 'view-mode', 'add-coordinate', 'action', 'edit', 'delete'
 * $btnText = 'Save Changes';
 * $btnOnClick = 'submitForm()';
 * $btnDisabled = false;
 * $btnSize = 'medium'; // 'small', 'medium', 'large'
 * $btnIconSrc = '../../assets/icons/save.png'; // optional
 * $btnStyles = 'margin-top: 10px;'; // optional inline styles
 * include '../ui/Button.php';
 */

if (!defined('BUTTON_STYLES_INCLUDED')) {
    define('BUTTON_STYLES_INCLUDED', true);
?>
<style>
    /* Base styles for all buttons */
    .shared-ui-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        font-family: var(--font-main, 'Montserrat', sans-serif);
        font-weight: 500;
        cursor: pointer;
        transition: all 0.2s ease;
        outline: none;
        box-sizing: border-box;
    }
    
    .shared-ui-btn:disabled {
        cursor: not-allowed;
        opacity: 0.6;
    }

    /* Policy: No hover effects for background, only click animation (scale down) */
    .shared-ui-btn:active:not(:disabled) {
        transform: scale(0.96);
    }

    /* Size variations */
    .shared-ui-btn.size-small {
        padding: 4px 10px;
        font-size: 10px;
        border-radius: 4px;
    }
    .shared-ui-btn.size-medium {
        padding: 10px 20px;
        font-size: 13px;
        border-radius: 6px;
    }
    .shared-ui-btn.size-large {
        padding: 12px 24px;
        font-size: 13px;
        border-radius: 8px;
    }

    /* Type variations */
    .shared-ui-btn.type-add {
        border: 1px solid var(--border-gray, #ddd);
        background-color: var(--dark-green, #055035);
        color: var(--white, #ffffff);
    }

    .shared-ui-btn.type-action {
        border: 1px solid var(--border-gray, #ddd);
        background-color: var(--white, #ffffff);
        color: #333;
    }
    
    .shared-ui-btn.type-cancel {
        border: 1px solid var(--dark-green, #055035);
        background-color: var(--white, #ffffff);
        color: var(--dark-green, #055035);
    }
    
    .shared-ui-btn.type-save {
        border: none;
        background-color: var(--dark-green, #055035);
        color: var(--white, #ffffff);
    }

    .shared-ui-btn.type-view-mode {
        padding: 0.4rem 0.7rem;
        border: 1px solid var(--border-gray, #ddd);
        background-color: var(--white, #ffffff);
        color: #666;
        font-size: 0.6rem;
        border-radius: 4px;
        gap: 5px;
    }
    .shared-ui-btn.type-view-mode.is-active {
        background-color: var(--dark-green, #055035);
        color: var(--white, #ffffff);
    }

    .shared-ui-btn.type-add-coordinate {
        padding: 5px 10px;
        font-size: 10px;
        border-radius: 4px;
        gap: 4px;
        border: 1px solid var(--dark-green, #055035);
        background-color: var(--pagination-hover, #e8f5e8);
        color: var(--dark-green, #055035);
        margin-top: 6px;
    }

    /* Outlined edit button — green border, no background */
    .shared-ui-btn.type-edit {
        border: 1.5px solid var(--dark-green, #055035);
        background-color: var(--white, #ffffff);
        color: var(--dark-green, #055035);
        padding: 4px 12px;
        font-size: 0.62rem;
        border-radius: 5px;
        gap: 4px;
    }
    .shared-ui-btn.type-edit:active:not(:disabled) {
        background-color: var(--dark-green, #055035);
        color: var(--white, #ffffff);
    }

    /* Outlined delete button — red border, no background */
    .shared-ui-btn.type-delete {
        border: 1.5px solid #dc3545;
        background-color: var(--white, #ffffff);
        color: #dc3545;
        padding: 4px 12px;
        font-size: 0.62rem;
        border-radius: 5px;
        gap: 4px;
    }
    .shared-ui-btn.type-delete:active:not(:disabled) {
        background-color: #dc3545;
        color: var(--white, #ffffff);
    }

    /* Icon styles */
    .shared-ui-btn-icon {
        display: flex;
        align-items: center;
    }
    .shared-ui-btn-icon img {
        width: 1.2em;
        height: 1.2em;
        object-fit: contain;
    }
</style>
<?php
}

// Map variables (fallbacks to avoid undefined variable warnings)
$cBtnType = $btnType ?? 'action'; // add, cancel, save, view-mode, add-coordinate, action, edit, delete
$cBtnSize = $btnSize ?? 'medium';
$cBtnText = $btnText ?? '';
$cBtnDisabled = $btnDisabled ?? false;
$cBtnOnClick = $btnOnClick ?? '';
$cBtnIconSrc = $btnIconSrc ?? '';
$cBtnSvgIcon = $btnSvgIcon ?? ''; // Raw SVG string (optional, used by edit/delete types)
$cBtnIsActive = $btnIsActive ?? false; // For view-mode
$cBtnSubmit = $btnSubmit ?? false;
$cBtnStyles = $btnStyles ?? '';
$cBtnId = $btnId ?? '';

// Determine default text based on type if empty
if ($cBtnText === '') {
    if ($cBtnType === 'cancel') $cBtnText = 'Cancel';
    elseif ($cBtnType === 'save') $cBtnText = 'Save';
    elseif ($cBtnType === 'add-coordinate') $cBtnText = '+ Add Coordinate Point';
}

// Build classes
$classes = ['shared-ui-btn', 'type-' . $cBtnType];
$noSizeTypes = ['view-mode', 'add-coordinate', 'edit', 'delete'];
if (!in_array($cBtnType, $noSizeTypes)) {
    $classes[] = 'size-' . $cBtnSize;
}
if ($cBtnIsActive) {
    $classes[] = 'is-active';
}

$classString = implode(' ', $classes);

// Build attributes
$disabledAttr = $cBtnDisabled ? 'disabled' : '';
$onClickAttr = (!empty($cBtnOnClick) && !$cBtnDisabled) ? 'onclick="' . htmlspecialchars($cBtnOnClick) . '"' : '';
$typeAttr = ($cBtnSubmit || $cBtnType === 'save') ? 'type="submit"' : 'type="button"';
$styleAttr = !empty($cBtnStyles) ? 'style="' . htmlspecialchars($cBtnStyles) . '"' : '';
$idAttr = !empty($cBtnId) ? 'id="' . htmlspecialchars($cBtnId) . '"' : '';
?>

<button <?= $typeAttr ?> <?= $idAttr ?> class="<?= $classString ?>" <?= $disabledAttr ?> <?= $onClickAttr ?> <?= $styleAttr ?>>
    <?php if (!empty($cBtnSvgIcon)): ?>
        <?= $cBtnSvgIcon ?>
    <?php elseif (!empty($cBtnIconSrc)): ?>
        <span class="shared-ui-btn-icon">
            <img src="<?= htmlspecialchars($cBtnIconSrc) ?>" alt="icon" />
        </span>
    <?php endif; ?>
    <?= htmlspecialchars($cBtnText) ?>
</button>

<?php
// Clean up variables so they don't bleed into the next include
unset(
    $btnType, $btnSize, $btnText, $btnDisabled, $btnOnClick,
    $btnIconSrc, $btnSvgIcon, $btnIsActive, $btnSubmit, $btnStyles, $btnId
);
?>
