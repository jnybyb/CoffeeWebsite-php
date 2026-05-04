<?php
$currentSearchPlaceholder = $searchPlaceholder ?? 'Search...';
$currentSearchInputId = $searchInputId ?? 'searchInput';
$currentSearchOnInput = $searchOnInput ?? '';
?>
<style>
  .reusable-search-wrapper {
    position: relative;
    flex: 0 0 300px;
  }

  .reusable-search-icon {
    position: absolute;
    left: 7px;
    top: 50%;
    transform: translateY(-50%);
    width: 12px;
    height: 12px;
    color: #6c757d;
    pointer-events: none;
  }

  .reusable-search-input {
    width: 100%;
    padding: 0.5rem 1.5rem 0.5rem 1.7rem;
    border: 1px solid var(--dark-green, #055035);
    border-radius: 4px;
    font-size: 0.65rem;
    font-family: var(--font-main, 'Montserrat', sans-serif);
    outline: none;
    transition: all 0.2s ease;
  }

  .reusable-search-input:focus {
    box-shadow: 0 0 0 3px rgba(5, 80, 53, 0.1);
  }

  .reusable-clear-icon {
    position: absolute;
    right: 10px;
    top: 50%;
    transform: translateY(-50%);
    width: 9px;
    height: 9px;
    cursor: pointer;
    opacity: 0.6;
    transition: opacity 0.2s ease;
  }

  .reusable-clear-icon:hover {
    opacity: 1;
  }

  .reusable-clear-icon.hidden {
    display: none;
  }
  
  @media (max-width: 768px) {
    .reusable-search-wrapper {
      flex: 1;
    }
  }
  
  @media (max-width: 480px) {
    .reusable-search-wrapper {
      flex: 1;
    }
  }
</style>

<div class="reusable-search-wrapper">
  <img class="reusable-search-icon" src="../../assets/icons/search.png" alt="Search" />
  <input 
    type="text" 
    class="reusable-search-input" 
    placeholder="<?php echo htmlspecialchars($currentSearchPlaceholder); ?>"
    id="<?php echo htmlspecialchars($currentSearchInputId); ?>"
    oninput="handleReusableSearchInput_<?php echo htmlspecialchars($currentSearchInputId); ?>(this)"
  />
  <img 
    src="../../assets/icons/close.png" 
    class="reusable-clear-icon hidden" 
    id="clearIcon_<?php echo htmlspecialchars($currentSearchInputId); ?>" 
    alt="Clear" 
    onclick="clearReusableSearch_<?php echo htmlspecialchars($currentSearchInputId); ?>()" 
  />
</div>

<script>
  function handleReusableSearchInput_<?php echo htmlspecialchars($currentSearchInputId); ?>(inputElem) {
    const clearIcon = document.getElementById('clearIcon_<?php echo htmlspecialchars($currentSearchInputId); ?>');
    if (inputElem.value.length > 0) {
      clearIcon.classList.remove('hidden');
    } else {
      clearIcon.classList.add('hidden');
    }
    
    <?php if ($currentSearchOnInput): ?>
    <?php echo $currentSearchOnInput; ?>;
    <?php endif; ?>
  }

  function clearReusableSearch_<?php echo htmlspecialchars($currentSearchInputId); ?>() {
    const searchInput = document.getElementById('<?php echo htmlspecialchars($currentSearchInputId); ?>');
    const clearIcon = document.getElementById('clearIcon_<?php echo htmlspecialchars($currentSearchInputId); ?>');
    searchInput.value = '';
    clearIcon.classList.add('hidden');
    searchInput.focus();
    
    <?php if ($currentSearchOnInput): ?>
    <?php echo $currentSearchOnInput; ?>;
    <?php endif; ?>
  }
</script>

<?php
unset($searchPlaceholder);
unset($searchInputId);
unset($searchOnInput);
?>
