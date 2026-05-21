<?php
/**
 * AlertModal Component
 * 
 * Provides a global alert modal for success, error, warning, info, and confirmations.
 * 
 * Usage via JavaScript:
 * AlertModal.show({ 
 *   type: 'success', // 'success', 'error', 'warning', 'info', 'logout', 'delete'
 *   title: 'Action Successful', 
 *   message: 'Your changes have been saved.',
 *   showCancel: false
 * });
 * 
 * // Confirmation example
 * AlertModal.show({
 *   type: 'warning',
 *   title: 'Are you sure?',
 *   message: 'This action cannot be undone.',
 *   showCancel: true,
 *   confirmText: 'Yes, Delete',
 *   cancelText: 'Cancel',
 *   onConfirm: () => { console.log('Confirmed'); AlertModal.hide(); },
 *   onCancel: () => { AlertModal.hide(); }
 * });
 * 
 * Convenience Wrappers:
 * AlertModalTypes.showDeleteSuccess();
 */
?>

<style>
  @keyframes alertModalSlideIn {
    from {
      opacity: 0;
      transform: translateY(-20px) scale(0.95);
    }
    to {
      opacity: 1;
      transform: translateY(0) scale(1);
    }
  }

  #alert-modal-backdrop {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: rgba(0, 0, 0, 0.7);
    display: none;
    justify-content: center;
    align-items: center;
    z-index: 31000; /* Higher than loading modal and side drawer */
    padding: 5px;
    opacity: 0;
    transition: opacity 0.2s ease;
  }

  #alert-modal-backdrop.show {
    display: flex;
    opacity: 1;
  }

  .alert-modal-container {
    background-color: white;
    border-radius: var(--am-border-radius, 6px);
    max-width: var(--am-max-width, 300px);
    width: 100%;
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
    overflow: hidden;
    position: relative;
  }

  #alert-modal-backdrop.show .alert-modal-container {
    animation: alertModalSlideIn 0.2s ease-out forwards;
  }

  .alert-modal-header {
    height: 60px;
    position: relative;
    background-image: radial-gradient(circle at 20% 50%, rgba(255,255,255,0.1) 1px, transparent 1px), 
                      radial-gradient(circle at 80% 20%, rgba(255,255,255,0.1) 1px, transparent 1px), 
                      radial-gradient(circle at 40% 80%, rgba(255,255,255,0.1) 1px, transparent 1px);
    background-size: 20px 20px, 15px 15px, 25px 25px;
  }

  .alert-modal-icon-wrapper {
    position: absolute;
    top: 30px;
    left: 50%;
    transform: translateX(-50%);
    width: 60px;
    height: 60px;
    border-radius: 50%;
    background-color: white;
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 2;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
  }

  .alert-modal-icon-inner {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    justify-content: center;
    align-items: center;
    color: white;
    font-size: 18px;
    font-weight: bold;
  }

  .alert-modal-body {
    padding: 50px 30px 30px 30px;
    text-align: center;
  }

  .alert-modal-title {
    margin: 0 0 15px 0;
    font-size: 18px;
    font-weight: bold;
    font-family: var(--font-main, Arial, sans-serif);
  }

  .alert-modal-message {
    font-size: 12px;
    line-height: 1.5;
    text-align: center;
    font-family: var(--font-main, Arial, sans-serif);
  }

  .alert-modal-actions {
    display: flex;
    justify-content: space-between;
    gap: 15px;
  }

  .alert-modal-btn {
    flex: 1;
    padding: 12px 20px;
    background-color: white;
    border-radius: var(--am-button-radius, 200px);
    cursor: pointer;
    font-size: 12px;
    font-weight: 600;
    transition: all 0.2s;
    font-family: var(--font-main, Arial, sans-serif);
    text-align: center;
  }
  
  .alert-modal-btn-single {
    width: 100%;
  }

</style>

<div id="alert-modal-backdrop">
  <div class="alert-modal-container" id="alert-modal-container">
    <div class="alert-modal-header" id="alert-modal-header"></div>
    <div class="alert-modal-icon-wrapper" id="alert-modal-icon-wrapper">
      <div class="alert-modal-icon-inner" id="alert-modal-icon-inner"></div>
    </div>
    <div class="alert-modal-body">
      <h3 class="alert-modal-title" id="alert-modal-title"></h3>
      <div class="alert-modal-message" id="alert-modal-message"></div>
      
      <div id="alert-modal-actions-container" style="margin-top: 30px;">
        <div class="alert-modal-actions" id="alert-modal-actions-dual" style="display: none;">
          <button class="alert-modal-btn" id="alert-modal-cancel-btn"></button>
          <button class="alert-modal-btn" id="alert-modal-confirm-btn-dual"></button>
        </div>
        <button class="alert-modal-btn alert-modal-btn-single" id="alert-modal-confirm-btn-single" style="display: none;"></button>
      </div>
    </div>
  </div>
</div>

<script>
  const AlertModal = {
    timer: null,
    hideTimeout: null,
    onCloseCallback: null,
    onConfirmCallback: null,
    onCancelCallback: null,

    getAlertConfig: function(type) {
      const configs = {
        success: {
          icon: '✓',
          headerColor: 'var(--dark-green, #055035)',
          iconColor: 'var(--dark-green, #055035)',
          textColor: 'var(--black, #000)',
          buttonColor: 'var(--dark-green, #055035)',
          buttonTextColor: 'var(--dark-green, #055035)'
        },
        error: {
          icon: '✕',
          headerColor: 'var(--red, #dc3545)',
          iconColor: 'var(--red, #dc3545)',
          textColor: 'var(--black, #000)',
          buttonColor: 'var(--red, #dc3545)',
          buttonTextColor: 'var(--red, #dc3545)'
        },
        warning: {
          icon: '!',
          headerColor: 'var(--olive-green, #808000)',
          iconColor: 'var(--olive-green, #808000)',
          textColor: 'var(--black, #000)',
          buttonColor: 'var(--olive-green, #808000)',
          buttonTextColor: 'var(--olive-green, #808000)'
        },
        info: {
          icon: '?',
          headerColor: 'rgba(5, 80, 53, 1)',
          iconColor: 'rgba(5, 80, 53, 0.80)',
          textColor: 'var(--black, #000)',
          buttonColor: 'rgba(5, 80, 53, 0.85)',
          buttonTextColor: 'rgba(5, 80, 53, 1)'
        },
        logout: {
          icon: '✓',
          headerColor: 'var(--dark-green, #055035)',
          iconColor: 'var(--dark-green, #055035)',
          textColor: 'var(--black, #000)',
          buttonColor: 'var(--dark-green, #055035)',
          buttonTextColor: 'var(--dark-green, #055035)'
        },
        delete: {
          icon: '✕',
          headerColor: 'var(--red, #dc3545)',
          iconColor: 'var(--red, #dc3545)',
          textColor: 'var(--black, #000)',
          buttonColor: 'var(--red, #dc3545)',
          buttonTextColor: 'var(--red, #dc3545)'
        }
      };
      return configs[type] || configs.success;
    },

    show: function(options = {}) {
      if (this.timer) {
        clearTimeout(this.timer);
        this.timer = null;
      }
      if (this.hideTimeout) {
        clearTimeout(this.hideTimeout);
        this.hideTimeout = null;
      }

      const backdrop = document.getElementById('alert-modal-backdrop');
      const container = document.getElementById('alert-modal-container');
      const header = document.getElementById('alert-modal-header');
      const iconWrapper = document.getElementById('alert-modal-icon-wrapper');
      const iconInner = document.getElementById('alert-modal-icon-inner');
      const titleEl = document.getElementById('alert-modal-title');
      const messageEl = document.getElementById('alert-modal-message');
      const actionsContainer = document.getElementById('alert-modal-actions-container');
      const actionsDual = document.getElementById('alert-modal-actions-dual');
      const cancelBtn = document.getElementById('alert-modal-cancel-btn');
      const confirmBtnDual = document.getElementById('alert-modal-confirm-btn-dual');
      const confirmBtnSingle = document.getElementById('alert-modal-confirm-btn-single');

      const config = this.getAlertConfig(options.type || 'success');
      
      // Callbacks
      this.onCloseCallback = options.onClose || null;
      this.onConfirmCallback = options.onConfirm || null;
      this.onCancelCallback = options.onCancel || null;

      // Styling from config
      header.style.backgroundColor = config.headerColor;
      iconWrapper.style.border = `3px solid ${config.iconColor}`;
      iconInner.style.backgroundColor = config.iconColor;
      iconInner.innerText = config.icon;
      titleEl.style.color = config.textColor;
      titleEl.innerText = options.title || '';
      
      if (options.message) {
        messageEl.style.color = config.textColor;
        messageEl.innerHTML = options.message;
        messageEl.style.display = 'block';
      } else {
        messageEl.style.display = 'none';
      }

      // Container vars
      container.style.setProperty('--am-max-width', (options.maxWidth || 300) + 'px');
      container.style.setProperty('--am-border-radius', (options.borderRadius || 6) + 'px');
      
      const buttonRadius = options.buttonBorderRadius !== undefined ? options.buttonBorderRadius : 200;
      
      const setupButton = (btn, text) => {
        btn.innerText = text;
        btn.style.border = `2px solid ${config.buttonColor}`;
        btn.style.color = config.buttonTextColor;
        btn.style.borderRadius = `${buttonRadius}px`;
        
        btn.onmouseover = () => {
          btn.style.backgroundColor = config.buttonColor;
          btn.style.color = 'white';
        };
        btn.onmouseout = () => {
          btn.style.backgroundColor = 'white';
          btn.style.color = config.buttonTextColor;
        };
        
        // Reset to default out state initially
        btn.style.backgroundColor = 'white';
      };

      if (options.hideButton) {
        actionsContainer.style.display = 'none';
        messageEl.style.marginBottom = '0';
      } else {
        actionsContainer.style.display = 'block';
        messageEl.style.marginBottom = '30px';
        
        if (options.showCancel) {
          actionsDual.style.display = 'flex';
          confirmBtnSingle.style.display = 'none';
          
          setupButton(cancelBtn, options.cancelText || 'Cancel');
          setupButton(confirmBtnDual, options.confirmText || 'OK');
        } else {
          actionsDual.style.display = 'none';
          confirmBtnSingle.style.display = 'block';
          
          setupButton(confirmBtnSingle, options.confirmText || 'OK');
        }
      }

      // Setup event listeners for this instance
      const handleConfirm = () => {
        if (this.onConfirmCallback) this.onConfirmCallback();
        else this.hide();
      };
      
      const handleCancel = () => {
        if (this.onCancelCallback) this.onCancelCallback();
        else this.hide();
      };

      confirmBtnDual.onclick = handleConfirm;
      confirmBtnSingle.onclick = handleConfirm;
      cancelBtn.onclick = handleCancel;

      // Auto close
      if (options.autoClose && !options.showCancel) {
        this.timer = setTimeout(() => {
          this.hide();
        }, options.autoCloseDelay || 3000);
      }

      backdrop.style.display = 'flex';
      // Force reflow
      void backdrop.offsetWidth;
      backdrop.classList.add('show');

      document.addEventListener('keydown', this.handleKeydown);
    },

    hide: function() {
      const backdrop = document.getElementById('alert-modal-backdrop');
      backdrop.classList.remove('show');
      
      if (this.timer) {
        clearTimeout(this.timer);
        this.timer = null;
      }
      if (this.hideTimeout) {
        clearTimeout(this.hideTimeout);
      }
      
      this.hideTimeout = setTimeout(() => {
        backdrop.style.display = 'none';
        this.hideTimeout = null;
      }, 200);

      document.removeEventListener('keydown', this.handleKeydown);
      
      if (this.onCloseCallback) {
        this.onCloseCallback();
      }
    },

    handleKeydown: function(e) {
      if (e.key === 'Escape') {
        AlertModal.hide();
      }
    }
  };

  document.getElementById('alert-modal-backdrop').addEventListener('click', function(e) {
    if (e.target === this) {
      AlertModal.hide();
    }
  });

  const AlertModalTypes = {
    showDeleteSuccess: function(options = {}) {
      AlertModal.show(Object.assign({
        type: 'success',
        title: 'Delete Successful',
        message: 'Item has been successfully deleted.',
        autoClose: true,
        autoCloseDelay: 1500,
        hideButton: true
      }, options));
    }
  };
</script>
