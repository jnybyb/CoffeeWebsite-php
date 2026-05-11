<?php
/**
 * NoDataDisplay Component
 * 
 * Usage Example (Generic):
 * $noDataIcon = '<svg>...</svg>'; // HTML/SVG string
 * $noDataTitle = 'No data found';
 * $noDataSubtitle = 'Please try again later';
 * $noDataHeight = '100%';
 * $noDataPadding = '2rem';
 * include '../ui/NoDataDisplay.php';
 * 
 * Usage Example (Specialized):
 * $noDataType = 'farm-plots'; // or 'recent-activities'
 * include '../ui/NoDataDisplay.php';
 */

$cNoDataType = $noDataType ?? 'generic';
$cIcon = $noDataIcon ?? '';
$cTitle = $noDataTitle ?? '';
$cSubtitle = $noDataSubtitle ?? '';
$cIconSize = $noDataIconSize ?? 40;
$cIconColor = $noDataIconColor ?? '#6c757d';
$cHeight = $noDataHeight ?? '100%';
$cPadding = $noDataPadding ?? '2rem';

// Inline SVGs for specialized components matching react-icons (MdLocationOff, BiHistory)
$svgLocationOff = '<svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 24 24" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg"><path fill="none" d="M0 0h24v24H0z"></path><path d="M12 6.5A2.5 2.5 0 0 1 14.5 9c0 .74-.33 1.39-.83 1.85l3.63 3.63c.98-1.86 1.7-3.8 1.7-5.48 0-3.87-3.13-7-7-7-1.98 0-3.76.83-5.04 2.15l3.19 3.19c.32-.81 1.09-1.34 1.85-1.34zM3.28 4L2 5.27l3.18 3.18C4.58 9.81 4 11.23 4 13c0 5.25 7 13 7 13s1.67-1.85 3.38-4.35L18.73 22l1.27-1.27L3.28 4z"></path></svg>';
$svgHistory = '<svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 24 24" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg"><path d="M12 2C6.486 2 2 6.486 2 12s4.486 10 10 10 10-4.486 10-10S17.514 2 12 2zm0 18c-4.411 0-8-3.589-8-8s3.589-8 8-8 8 3.589 8 8-3.589 8-8 8z"></path><path d="M13 7h-2v5.414l3.293 3.293 1.414-1.414L13 11.586z"></path></svg>';

if ($cNoDataType === 'farm-plots') {
    ?>
    <div style="display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 1rem; text-align: center; width: 100%;">
        <div style="color: #adb5bd; margin-bottom: 0.1rem; font-size: 24px; display: flex; align-items: center; justify-content: center;">
            <?= $svgLocationOff ?>
        </div>
        <p style="color: #6c757d; font-size: 11px; font-weight: 500; margin: 0; font-family: var(--font-main, 'Montserrat', sans-serif);">
            No other farm plots.
        </p>
    </div>
    <?php
} elseif ($cNoDataType === 'recent-activities') {
    ?>
    <div style="display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 1rem; text-align: center; width: 100%;">
        <div style="color: #adb5bd; margin-bottom: 0.1rem; font-size: 24px; display: flex; align-items: center; justify-content: center;">
            <?= $svgHistory ?>
        </div>
        <p style="color: #6c757d; font-size: 11px; font-weight: 500; margin: 0; font-family: var(--font-main, 'Montserrat', sans-serif);">
            No recent activities found.
        </p>
    </div>
    <?php
} else {
    // Generic NoDataDisplay
    ?>
    <div style="display: flex; flex-direction: column; align-items: center; justify-content: center; height: <?= htmlspecialchars($cHeight) ?>; padding: <?= htmlspecialchars($cPadding) ?>; text-align: center; width: 100%; font-family: var(--font-main, 'Montserrat', sans-serif);">
        <?php if (!empty($cIcon)): ?>
            <div style="color: <?= htmlspecialchars($cIconColor) ?>; margin-bottom: 0.3rem; font-size: <?= htmlspecialchars($cIconSize) ?>px; display: flex; align-items: center; justify-content: center;">
                <?= $cIcon ?> <!-- Expecting valid HTML/SVG snippet -->
            </div>
        <?php endif; ?>
        
        <h3 style="color: var(--text-gray, #6c757d); font-size: 0.75rem; font-weight: 500; margin: 0;">
            <?= htmlspecialchars($cTitle) ?>
        </h3>
        
        <?php if (!empty($cSubtitle)): ?>
            <p style="color: var(--text-gray, #6c757d); font-size: 0.75rem; line-height: 1; margin-top: 0.5rem; margin-bottom: 0;">
                <?= htmlspecialchars($cSubtitle) ?>
            </p>
        <?php endif; ?>
    </div>
    <?php
}

// Clean up variables so they don't bleed into subsequent includes
unset(
    $noDataType, $noDataIcon, $noDataTitle, $noDataSubtitle, 
    $noDataIconSize, $noDataIconColor, $noDataHeight, $noDataPadding
);
?>
