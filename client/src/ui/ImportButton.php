<?php
$currentImportText = $importText ?? 'Import Record';
$currentImportAction = $importAction ?? 'handleImportClick()';
$currentImportId = $importId ?? 'importBtn';
?>
<style>
  .reusable-import-btn {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.48rem 1.5rem;
    border: 1px solid var(--dark-green, #055035);
    border-radius: 4px;
    font-size: 0.65rem;
    font-weight: 400;
    font-family: var(--font-main, 'Montserrat', sans-serif);
    cursor: pointer;
    transition: all 0.2s ease;
    outline: none;
    background-color: var(--white, #ffffff);
    color: var(--dark-green, #055035);
  }

  .reusable-import-btn:hover {
    background-color: #f5f5f5;
  }

  .reusable-import-btn-icon {
    width: 15px;
    height: 15px;
    object-fit: contain;
  }
</style>

<button class="reusable-import-btn" onclick="<?php echo htmlspecialchars($currentImportAction); ?>" id="<?php echo htmlspecialchars($currentImportId); ?>">
  <img class="reusable-import-btn-icon" src="../../assets/icons/import.png" alt="Import" />
  <?php echo htmlspecialchars($currentImportText); ?>
</button>

<?php
unset($importText);
unset($importAction);
unset($importId);
?>
