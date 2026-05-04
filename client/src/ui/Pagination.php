<!-- Pagination Component -->
<?php
/**
 * Pagination Component
 * 
 * Displays pagination controls with intelligent page number display
 * 
 * @param array $config Configuration array containing:
 *   - currentPage (int): Current active page
 *   - totalRecords (int): Total number of records
 *   - pageSize (int): Records per page
 *   - pageSizeOptions (array): Available page size options
 */

$currentPage = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$totalRecords = isset($totalRecords) ? $totalRecords : 0;
$pageSize = isset($pageSize) ? $pageSize : 10;
$pageSizeOptions = isset($pageSizeOptions) ? $pageSizeOptions : [5, 10, 25, 50];

$totalPages = max(1, ceil($totalRecords / $pageSize));
$currentPage = min($currentPage, $totalPages);

$start = $totalRecords === 0 ? 0 : ($currentPage - 1) * $pageSize + 1;
$end = min($totalRecords, $currentPage * $pageSize);

/**
 * PAGINATION LAYOUT ALGORITHM
 * 
 * Computes which page numbers and ellipsis to display based on current page and total pages.
 * 
 * RULES:
 * 1. Always show: First 2 pages (1, 2) and Last 2 pages (n-1, n)
 * 2. Show context: Page before and after the active page
 * 3. Use ellipsis (...): When pages are skipped between sections
 * 
 * DECISION LOGIC:
 * 
 * Case 1: Total Pages ≤ 7
 *   - Display all pages without ellipsis
 *   - Example (5 pages): < 1 2 3 4 5 >
 *   - Example (7 pages): < 1 2 3 4 5 6 7 >
 * 
 * Case 2: Active Page ≤ 3 (Near Start)
 *   - Display: 1 2 3 [4 if page=3] ... n-1 n
 *   - Page 1: < 1 2 3 ... 9 10 >
 *   - Page 2: < 1 2 3 ... 9 10 >
 *   - Page 3: < 1 2 3 4 ... 9 10 > (shows next page 4)
 * 
 * Case 3: Active Page ≥ n-2 (Near End)
 *   - Display: 1 2 ... [n-3 if page=n-2] n-2 n-1 n
 *   - Page 10 of 10: < 1 2 ... 8 9 10 >
 *   - Page 9 of 10: < 1 2 ... 8 9 10 >
 *   - Page 8 of 10: < 1 2 ... 7 8 9 10 > (shows prev page 7)
 * 
 * Case 4: Active Page in Middle (4 to n-3)
 *   - Display: 1 2 ... (x-1) x (x+1) ... n-1 n
 *   - Page 7 of 10: < 1 2 ... 6 7 8 ... 9 10 >
 *   - Page 5 of 10: < 1 2 ... 4 5 6 ... 9 10 >
 * 
 * WHEN TO SHOW ELLIPSIS:
 *   - Left ellipsis: When gap exists between page 2 and the middle section
 *   - Right ellipsis: When gap exists between the middle section and page (n-1)
 * 
 * This ensures users always see:
 *   - Where they are (current page + neighbors)
 *   - Where they can jump to (first 2 and last 2 pages)
 *   - That there are more pages in between (ellipsis)
 */
function getPageNumbers($currentPage, $totalPages) {
  $pages = [];
  
  // Case 1: If total pages <= 7, show all pages without ellipsis
  if ($totalPages <= 7) {
    for ($i = 1; $i <= $totalPages; $i++) {
      $pages[] = $i;
    }
    return $pages;
  }
  
  // Always show first 2 pages
  $pages[] = 1;
  $pages[] = 2;
  
  // Case 2: Current page is 1, 2, or 3 (Near Start)
  if ($currentPage <= 3) {
    $pages[] = 3; // Always show page 3
    if ($currentPage === 3) {
      $pages[] = 4; // Show page 4 only when active page is 3
    }
    $pages[] = 'dots-right';
    $pages[] = $totalPages - 1;
    $pages[] = $totalPages;
  }
  // Case 3: Current page is in last 3 pages (Near End)
  else if ($currentPage >= $totalPages - 2) {
    $pages[] = 'dots-left';
    if ($currentPage === $totalPages - 2) {
      $pages[] = $totalPages - 3;
      $pages[] = $totalPages - 2;
    } else {
      $pages[] = $totalPages - 2;
    }
    $pages[] = $totalPages - 1;
    $pages[] = $totalPages;
  }
  // Case 4: Current page is in the middle
  else {
    $pages[] = 'dots-left';
    $pages[] = $currentPage - 1;
    $pages[] = $currentPage;
    $pages[] = $currentPage + 1;
    $pages[] = 'dots-right';
    $pages[] = $totalPages - 1;
    $pages[] = $totalPages;
  }
  
  return $pages;
}

$pageNumbers = getPageNumbers($currentPage, $totalPages);
?>

<div class="pagination-container">
  <div class="pagination-left">
    Items <?php echo $start; ?>-<?php echo $end; ?> of <?php echo $totalRecords; ?> entries
  </div>
  
  <div class="pagination-right">
    <div class="pagination-pager">
      <!-- Previous Button -->
      <button 
        class="pagination-btn pagination-btn-nav <?php echo $currentPage === 1 ? 'pagination-btn-disabled' : ''; ?>"
        onclick="goToPage(<?php echo max(1, $currentPage - 1); ?>)"
        <?php echo $currentPage === 1 ? 'disabled' : ''; ?>
        aria-label="Previous page"
      >
        ‹
      </button>

      <!-- Page Numbers -->
      <?php foreach ($pageNumbers as $item): ?>
        <?php if (is_string($item) && strpos($item, 'dots') === 0): ?>
          <span class="pagination-ellipsis">…</span>
        <?php else: ?>
          <button 
            class="pagination-btn <?php echo $item === $currentPage ? 'pagination-btn-active' : ''; ?>"
            onclick="goToPage(<?php echo $item; ?>)"
            <?php echo $item === $currentPage ? 'aria-current="page"' : ''; ?>
          >
            <?php echo $item; ?>
          </button>
        <?php endif; ?>
      <?php endforeach; ?>

      <!-- Next Button -->
      <button 
        class="pagination-btn pagination-btn-nav <?php echo $currentPage === $totalPages ? 'pagination-btn-disabled' : ''; ?>"
        onclick="goToPage(<?php echo min($totalPages, $currentPage + 1); ?>)"
        <?php echo $currentPage === $totalPages ? 'disabled' : ''; ?>
        aria-label="Next page"
      >
        ›
      </button>
    </div>


  </div>
</div>

<style>
  /* ===============================
     PAGINATION STYLES
     =============================== */
  .pagination-container {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 10px 12px;
    background-color: white;
    border: none;
    border-top: 0.5px solid rgba(36, 99, 59, 0.3);
    border-radius: 0;
    box-shadow: 0 -2px 8px rgba(0, 0, 0, 0.06);
    position: sticky;
    bottom: 0;
    width: auto;
    z-index: 5;
    font-family: var(--font-main, 'Montserrat', sans-serif);
  }

  .pagination-left {
    color: #6c757d;
    font-size: 10px;
    font-weight: 500;
  }

  .pagination-right {
    display: flex;
    align-items: center;
    gap: 16px;
  }

  /* ===============================
     PAGE NUMBER CONTROLS
     =============================== */
  .pagination-pager {
    display: flex;
    align-items: center;
    gap: 4px;
  }

  .pagination-btn {
    min-width: 22px;
    height: 22px;
    padding: 0 5px;
    border-radius: 5px;
    border: 1px solid #bfc7c2;
    background-color: white;
    cursor: pointer;
    font-size: 9px;
    color: #2b2f33;
    font-weight: 500;
    font-family: var(--font-main, 'Montserrat', sans-serif);
    transition: all 0.2s ease;
    outline: none;
  }

  .pagination-btn:hover:not(:disabled) {
    background-color: #f5f5f5;
    border-color: #a0a0a0;
  }

  .pagination-btn:active:not(:disabled) {
    transform: scale(0.95);
  }

  /* Navigation Buttons (Previous/Next) */
  .pagination-btn-nav {
    background-color: #f0f7f3;
    border: 1px solid rgba(45, 124, 74, 0.4);
    color: #2d7c4a;
    font-size: 12px;
    font-weight: 600;
    min-width: 28px;
  }

  .pagination-btn-nav:hover:not(:disabled) {
    background-color: #e0f0e8;
    border-color: #2d7c4a;
  }

  /* Active Page Button */
  .pagination-btn-active {
    background-color: var(--dark-green, #055035);
    border-color: var(--dark-green, #055035);
    color: white;
  }

  .pagination-btn-active:hover {
    background-color: #044029;
    border-color: #044029;
  }

  /* Disabled Button */
  .pagination-btn:disabled,
  .pagination-btn-disabled {
    opacity: 0.3;
    cursor: not-allowed;
  }

  .pagination-btn:disabled:hover,
  .pagination-btn-disabled:hover {
    background-color: white;
    border-color: #bfc7c2;
  }

  /* Ellipsis */
  .pagination-ellipsis {
    padding: 0 3px;
    color: #868e96;
    font-size: 9px;
    line-height: 22px;
  }



  /* ===============================
     RESPONSIVE DESIGN
     =============================== */
  @media (max-width: 768px) {
    .pagination-container {
      flex-direction: column;
      gap: 10px;
      padding: 8px 10px;
    }

    .pagination-left {
      width: 100%;
      text-align: center;
      font-size: 9px;
    }

    .pagination-right {
      width: 100%;
      justify-content: center;
      gap: 12px;
      flex-wrap: wrap;
    }

    .pagination-pager {
      gap: 3px;
    }

    .pagination-btn {
      min-width: 20px;
      height: 20px;
      padding: 0 4px;
      font-size: 8px;
    }


  }

  @media (max-width: 480px) {
    .pagination-container {
      flex-direction: column;
      gap: 8px;
      padding: 6px 8px;
    }

    .pagination-pager {
      gap: 2px;
      flex-wrap: wrap;
      justify-content: center;
    }

    .pagination-btn {
      min-width: 18px;
      height: 18px;
      padding: 0 3px;
      font-size: 7px;
    }

    .pagination-right {
      flex-direction: column;
      gap: 8px;
      width: 100%;
    }


  }
</style>

<script>
  /**
   * Navigate to a specific page
   * @param {number} pageNum - The page number to navigate to
   */
  function goToPage(pageNum) {
    if (pageNum >= 1) {
      // Update URL with page parameter
      const url = new URL(window.location);
      url.searchParams.set('page', pageNum);
      window.location.href = url.toString();
    }
  }



  /**
   * Optional: Keyboard navigation support
   * Arrow keys to navigate between pages
   */
  document.addEventListener('DOMContentLoaded', function() {
    document.addEventListener('keydown', function(event) {
      if (event.key === 'ArrowLeft') {
        const prevBtn = document.querySelector('.pagination-btn-nav:first-of-type');
        if (prevBtn && !prevBtn.disabled) {
          prevBtn.click();
        }
      } else if (event.key === 'ArrowRight') {
        const nextBtn = document.querySelector('.pagination-btn-nav:last-of-type');
        if (nextBtn && !nextBtn.disabled) {
          nextBtn.click();
        }
      }
    });
  });
</script>
