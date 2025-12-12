/**
 * ✅ TOAST NOTIFICATION HELPER FUNCTION
 * Location: resources/js/toast.js
 * Usage: Call showToast(message, type, duration)
 */

class ToastManager {
    constructor() {
        this.container = null;
        this.toastCount = 0;
        this.init();
    }

    init() {
        // Create container if not exists
        if (!document.querySelector('.toast-container')) {
            this.container = document.createElement('div');
            this.container.className = 'toast-container';
            document.body.appendChild(this.container);
        } else {
            this.container = document.querySelector('.toast-container');
        }
    }

    /**
     * ✅ Show toast notification
     * @param {string} message - Toast message
     * @param {string} type - 'success', 'error', 'warning', 'info'
     * @param {number} duration - Duration in milliseconds (default 3000)
     */
    show(message, type = 'info', duration = 3000) {
        // Ensure container exists
        if (!this.container) {
            this.init();
        }

        // Create toast element
        const toastId = `toast-${this.toastCount++}`;
        const toast = document.createElement('div');
        toast.id = toastId;
        toast.className = `toast ${type}`;

        // Icon map
        const iconMap = {
            success: '<svg fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>',
            error: '<svg fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path></svg>',
            warning: '<svg fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>',
            info: '<svg fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>'
        };

        // HTML content
        toast.innerHTML = `
            <div class="toast-icon">${iconMap[type] || iconMap.info}</div>
            <div class="toast-message">${message}</div>
            <button class="toast-close" onclick="toastManager.remove('${toastId}')">×</button>
            <div class="toast-progress"></div>
        `;

        // Add to container
        this.container.appendChild(toast);

        // Auto remove
        setTimeout(() => {
            this.remove(toastId);
        }, duration);
    }

    /**
     * ✅ Remove toast notification
     */
    remove(toastId) {
        const toast = document.getElementById(toastId);
        if (toast) {
            // Add fade-out animation
            toast.classList.add('fade-out');

            // Remove after animation
            setTimeout(() => {
                toast.remove();
            }, 300);
        }
    }
}

// ✅ Global toast manager instance
const toastManager = new ToastManager();

/**
 * ✅ Global showToast function for easy access
 * Usage: showToast('Success message', 'success')
 */
function showToast(message, type = 'info', duration = 3000) {
    toastManager.show(message, type, duration);
}

// ✅ Alias functions for convenience
function showSuccess(message, duration = 3000) {
    showToast(message, 'success', duration);
}

function showError(message, duration = 4000) {
    showToast(message, 'error', duration);
}

function showWarning(message, duration = 3500) {
    showToast(message, 'warning', duration);
}

function showInfo(message, duration = 3000) {
    showToast(message, 'info', duration);
}
