<?php
/**
 * LoadingModal Component
 * 
 * Provides a global loading modal with customizable title, message, sub-message,
 * and an optional progress bar.
 * 
 * Usage via JavaScript:
 * LoadingModal.show({ title: 'Processing', message: 'Please wait...' });
 * LoadingModal.updateProgress(50);
 * LoadingModal.hide();
 * 
 * Convenience Wrappers:
 * ModalTypes.showSaving();
 * ModalTypes.showDeleting();
 * ModalTypes.showLoggingIn();
 * ModalTypes.showDeleteLoading();
 */
?>

<style>
  @keyframes lm-spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
  }

  .lm-spinner {
    width: 35px;
    height: 35px;
    border: 3px solid #f3f3f3;
    border-top: 3px solid var(--lm-spinner-color, var(--dark-green, #055035));
    border-radius: 50%;
    animation: lm-spin 1s linear infinite;
    margin: 0 auto;
  }

  #loading-modal-backdrop {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: rgba(0, 0, 0, 0.65);
    display: none; /* hidden by default */
    justify-content: center;
    align-items: center;
    z-index: 30000;
    padding: 10px;
    opacity: 0;
    transition: opacity 0.2s ease;
  }

  #loading-modal-backdrop.show {
    display: flex;
    opacity: 1;
  }

  .lm-modal-container {
    background-color: white;
    border-radius: 6px;
    width: 100%;
    max-width: 280px;
    padding: 40px 5px;
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.25);
    text-align: center;
    position: relative;
    font-family: var(--font-main, 'Montserrat', sans-serif);
  }

  .lm-title {
    margin: 0 0 6px 0;
    color: var(--black, #000);
    font-size: 16px;
    font-weight: 700;
  }

  .lm-message {
    color: #495057;
    font-size: 13px;
  }

  .lm-submessage {
    color: #6c757d;
    font-size: 12px;
    margin-top: 6px;
    display: none;
  }

  .lm-progress-container {
    width: 100%;
    margin-top: 14px;
    display: none;
    padding: 0 20px;
    box-sizing: border-box;
  }

  .lm-progress-bar-bg {
    width: 100%;
    height: 8px;
    background-color: #f1f3f5;
    border-radius: 999px;
    overflow: hidden;
  }

  .lm-progress-bar-fill {
    width: 0%;
    height: 100%;
    background-color: var(--lm-spinner-color, var(--dark-green, #055035));
    transition: width 0.3s ease;
  }

  .lm-progress-text {
    margin-top: 6px;
    font-size: 12px;
    color: #6c757d;
  }
</style>

<div id="loading-modal-backdrop">
  <div class="lm-modal-container">
    <div style="margin-bottom: 12px;">
      <div class="lm-spinner" id="lm-spinner"></div>
    </div>
    <h3 class="lm-title" id="lm-title">Processing</h3>
    <div class="lm-message" id="lm-message">Please wait...</div>
    <div class="lm-submessage" id="lm-submessage"></div>
    
    <div class="lm-progress-container" id="lm-progress-container">
      <div class="lm-progress-bar-bg">
        <div class="lm-progress-bar-fill" id="lm-progress-bar-fill"></div>
      </div>
      <div class="lm-progress-text" id="lm-progress-text">0%</div>
    </div>

    <div class="lm-button-container" id="lm-button-container" style="display: none; margin-top: 20px; gap: 10px; justify-content: center;">
      <button id="lm-btn-cancel" style="padding: 8px 16px; border: 1px solid #ccc; background: white; border-radius: 4px; cursor: pointer; font-family: inherit; font-size: 13px;">Cancel</button>
      <button id="lm-btn-confirm" style="padding: 8px 16px; border: none; background: #dc3545; color: white; border-radius: 4px; cursor: pointer; font-family: inherit; font-size: 13px;">Confirm</button>
    </div>
  </div>
</div>

<script>
  const LoadingModal = {
    dismissible: false,
    onCloseCallback: null,
    hideTimeout: null,

    show: function(options = {}) {
      if (this.hideTimeout) {
        clearTimeout(this.hideTimeout);
        this.hideTimeout = null;
      }
      const backdrop = document.getElementById('loading-modal-backdrop');
      const titleEl = document.getElementById('lm-title');
      const messageEl = document.getElementById('lm-message');
      const subMessageEl = document.getElementById('lm-submessage');
      const progressContainer = document.getElementById('lm-progress-container');
      const spinnerContainer = document.getElementById('lm-spinner').parentElement;
      const buttonContainer = document.getElementById('lm-button-container');
      const spinnerEl = document.getElementById('lm-spinner');
      const progressFill = document.getElementById('lm-progress-bar-fill');

      // Reset visibility for regular show mode
      spinnerContainer.style.display = 'block';
      buttonContainer.style.display = 'none';

      // Set options with defaults
      titleEl.innerText = options.title || 'Processing';
      messageEl.innerText = options.message || 'Please wait...';
      
      if (options.subMessage) {
        subMessageEl.innerText = options.subMessage;
        subMessageEl.style.display = 'block';
      } else {
        subMessageEl.style.display = 'none';
      }

      // Configure progress bar
      if (typeof options.progress === 'number' && options.progress >= 0 && options.progress <= 100) {
        progressContainer.style.display = 'block';
        this.updateProgress(options.progress);
        messageEl.style.marginBottom = '14px';
      } else {
        progressContainer.style.display = 'none';
        messageEl.style.marginBottom = options.subMessage ? '6px' : '0';
      }

      // Set spinner and progress color
      const color = options.spinnerColor || 'var(--dark-green, #055035)';
      spinnerEl.style.setProperty('--lm-spinner-color', color);
      progressFill.style.backgroundColor = color;

      this.dismissible = options.dismissible || false;
      this.onCloseCallback = options.onClose || null;

      backdrop.style.display = 'flex';
      // Force reflow for transition
      void backdrop.offsetWidth;
      backdrop.classList.add('show');
      
      // Add keyboard listener for Escape
      document.addEventListener('keydown', this.handleKeydown);
    },

    showConfirm: function(options = {}) {
      if (this.hideTimeout) {
        clearTimeout(this.hideTimeout);
        this.hideTimeout = null;
      }
      const backdrop = document.getElementById('loading-modal-backdrop');
      const titleEl = document.getElementById('lm-title');
      const messageEl = document.getElementById('lm-message');
      const subMessageEl = document.getElementById('lm-submessage');
      const progressContainer = document.getElementById('lm-progress-container');
      const spinnerContainer = document.getElementById('lm-spinner').parentElement;
      const buttonContainer = document.getElementById('lm-button-container');
      const confirmBtn = document.getElementById('lm-btn-confirm');
      const cancelBtn = document.getElementById('lm-btn-cancel');

      titleEl.innerText = options.title || 'Confirm';
      messageEl.innerText = options.message || 'Are you sure?';
      
      if (options.subMessage) {
        subMessageEl.innerText = options.subMessage;
        subMessageEl.style.display = 'block';
      } else {
        subMessageEl.style.display = 'none';
      }

      progressContainer.style.display = 'none';
      spinnerContainer.style.display = 'none'; // hide spinner
      buttonContainer.style.display = 'flex'; // show buttons
      messageEl.style.marginBottom = '0';

      confirmBtn.innerText = options.confirmText || 'Confirm';
      cancelBtn.innerText = options.cancelText || 'Cancel';
      
      confirmBtn.style.backgroundColor = options.confirmColor || '#dc3545';

      // Remove old listeners by cloning
      const newConfirm = confirmBtn.cloneNode(true);
      confirmBtn.parentNode.replaceChild(newConfirm, confirmBtn);
      const newCancel = cancelBtn.cloneNode(true);
      cancelBtn.parentNode.replaceChild(newCancel, cancelBtn);

      newConfirm.addEventListener('click', () => {
        if(options.onConfirm) {
            options.onConfirm();
        } else {
            this.hide();
        }
      });
      
      newCancel.addEventListener('click', () => {
        if(options.onCancel) {
            options.onCancel();
        } else {
            this.hide();
        }
      });

      this.dismissible = options.dismissible !== undefined ? options.dismissible : true;
      this.onCloseCallback = options.onClose || null;

      backdrop.style.display = 'flex';
      void backdrop.offsetWidth;
      backdrop.classList.add('show');
      
      document.addEventListener('keydown', this.handleKeydown);
    },

    updateProgress: function(progress) {
      if (progress >= 0 && progress <= 100) {
        document.getElementById('lm-progress-bar-fill').style.width = progress + '%';
        document.getElementById('lm-progress-text').innerText = Math.round(progress) + '%';
      }
    },

    hide: function() {
      const backdrop = document.getElementById('loading-modal-backdrop');
      backdrop.classList.remove('show');
      
      if (this.hideTimeout) {
        clearTimeout(this.hideTimeout);
      }
      
      this.hideTimeout = setTimeout(() => {
        backdrop.style.display = 'none';
        this.hideTimeout = null;
      }, 200); // match transition duration

      document.removeEventListener('keydown', this.handleKeydown);
      
      if (this.onCloseCallback) {
        this.onCloseCallback();
      }
    },

    handleKeydown: function(e) {
      if (e.key === 'Escape' && LoadingModal.dismissible) {
        LoadingModal.hide();
      }
    }
  };

  // Click outside to dismiss
  document.getElementById('loading-modal-backdrop').addEventListener('click', function(e) {
    if (e.target === this && LoadingModal.dismissible) {
      LoadingModal.hide();
    }
  });

  // Convenience wrappers
  const ModalTypes = {
    showSaving: function(options = {}) {
      LoadingModal.show(Object.assign({
        title: 'Saving...',
        message: 'Saving your changes',
        dismissible: false,
        spinnerColor: 'var(--dark-green, #055035)'
      }, options));
    },
    showDeleting: function(options = {}) {
      LoadingModal.show(Object.assign({
        title: 'Deleting...',
        message: 'Removing item',
        dismissible: false,
        spinnerColor: 'var(--dark-green, #055035)'
      }, options));
    },
    showLoggingIn: function(options = {}) {
      LoadingModal.show(Object.assign({
        title: 'Signing in...',
        message: 'Authenticating your credentials',
        dismissible: false,
        spinnerColor: 'var(--dark-green, #055035)'
      }, options));
    },
    showDeleteLoading: function(options = {}) {
      LoadingModal.show(Object.assign({
        title: 'Deleting...',
        message: 'Removing item',
        dismissible: false,
        spinnerColor: '#dc3545'
      }, options));
    }
  };
</script>
