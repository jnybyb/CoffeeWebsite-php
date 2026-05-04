<?php
$currentButtonText = $buttonText ?? 'Add Record';
$currentButtonAction = $buttonAction ?? 'handleAddRecord()';
?>
<style>
  .reusable-add-btn {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.48rem 1.5rem;
    border: none;
    border-radius: 4px;
    font-size: 0.65rem;
    font-weight: 400;
    font-family: var(--font-main, 'Montserrat', sans-serif);
    cursor: pointer;
    transition: all 0.2s ease;
    outline: none;
    background-color: var(--dark-green, #055035);
    color: var(--white, #ffffff);
  }

  .reusable-add-btn:hover {
    background-color: #044029;
    transform: translateY(-2px);
    box-shadow: 0 4px 8px var(--shadow-color, rgba(0, 0, 0, 0.15));
  }

  .reusable-add-btn-icon {
    width: 12px;
    height: 12px;
    object-fit: contain;
  }
</style>

<button class="reusable-add-btn" onclick="<?php echo htmlspecialchars($currentButtonAction); ?>">
  <img class="reusable-add-btn-icon" src="../../assets/icons/add.png" alt="Add" />
  <?php echo htmlspecialchars($currentButtonText); ?>
</button>

<?php
unset($buttonText);
unset($buttonAction);
?>
