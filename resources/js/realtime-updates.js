/**
 * ✅ REAL-TIME AUTO-REFRESH SYSTEM
 * Implements polling for auto-updating dashboards and statistics
 * 
 * Location: resources/js/realtime-updates.js
 * Usage: Include in layout after jQuery and other dependencies
 */

class RealtimeUpdater {
    constructor(options = {}) {
        this.interval = options.interval || 5000; // 5 seconds default
        this.timers = {};
        this.enabled = true;

        console.log('✅ RealtimeUpdater initialized with interval:', this.interval);
    }

    /**
     * ✅ Start auto-refreshing a specific element
     * @param {string} endpoint - API endpoint to fetch data from
     * @param {string} selector - CSS selector of element to update
     * @param {function} callback - Function to process response and update DOM
     */
    watch(endpoint, selector, callback) {
        if (this.timers[endpoint]) {
            clearInterval(this.timers[endpoint]);
        }

        // Fetch immediately on first load
        this.fetchAndUpdate(endpoint, selector, callback);

        // Then set up interval
        this.timers[endpoint] = setInterval(() => {
            if (this.enabled) {
                this.fetchAndUpdate(endpoint, selector, callback);
            }
        }, this.interval);

        console.log('✅ Watching:', endpoint);
    }

    /**
     * ✅ Fetch data and update DOM
     */
    async fetchAndUpdate(endpoint, selector, callback) {
        try {
            const response = await fetch(endpoint, {
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
                }
            });

            if (!response.ok) {
                console.warn('Fetch failed for:', endpoint, response.status);
                return;
            }

            const data = await response.json();

            // Get the element and apply callback
            const element = document.querySelector(selector);
            if (element && callback) {
                callback(data, element);
            }

            console.log('✅ Updated:', selector);
        } catch (error) {
            console.error('Error fetching from:', endpoint, error);
        }
    }

    /**
     * ✅ Stop all watchers
     */
    stopAll() {
        Object.values(this.timers).forEach(timer => clearInterval(timer));
        this.timers = {};
        console.log('✅ All watchers stopped');
    }

    /**
     * ✅ Pause/resume watchers without clearing them
     */
    pause() {
        this.enabled = false;
        console.log('✅ Watchers paused');
    }

    resume() {
        this.enabled = true;
        console.log('✅ Watchers resumed');
    }
}

// ============================================
// USAGE EXAMPLES FOR EMPLOYER DASHBOARD
// ============================================

// Initialize on page load
const realtimeUpdater = new RealtimeUpdater({ interval: 5000 });

// Example 1: Update pending applications count
realtimeUpdater.watch(
    '/api/applications/count/pending',
    '.pending-count',
    (data, element) => {
        element.textContent = data.count;
        // Add animation if count changed
        if (element.dataset.lastCount != data.count) {
            element.classList.add('pulse');
            setTimeout(() => element.classList.remove('pulse'), 1000);
            element.dataset.lastCount = data.count;
        }
    }
);

// Example 2: Update interview scheduled count
realtimeUpdater.watch(
    '/api/applications/count/interview',
    '.interview-count',
    (data, element) => {
        element.textContent = data.count;
    }
);

// Example 3: Update statistics board
realtimeUpdater.watch(
    '/api/dashboard/stats',
    '#stats-board',
    (data, element) => {
        // Update multiple stat cards
        document.querySelector('[data-stat="total"]').textContent = data.total;
        document.querySelector('[data-stat="pending"]').textContent = data.pending;
        document.querySelector('[data-stat="interviewing"]').textContent = data.interviewing;
        document.querySelector('[data-stat="selected"]').textContent = data.selected;
    }
);

// Example 4: Update notifications badge
realtimeUpdater.watch(
    '/api/notifications/unread-count',
    '.notification-badge',
    (data, element) => {
        if (data.count > 0) {
            element.style.display = 'inline';
            element.textContent = data.count > 99 ? '99+' : data.count;
        } else {
            element.style.display = 'none';
        }
    }
);

// Example 5: Update job applications list for specific job
realtimeUpdater.watch(
    `/api/jobs/${jobId}/applications/live`,
    '#applications-list',
    (data, element) => {
        // Rebuild the list
        if (data.applications && data.applications.length > 0) {
            element.innerHTML = data.applications.map(app => `
                <div class="application-item" data-id="${app.id}">
                    <span class="name">${app.hoten}</span>
                    <span class="status">${app.status}</span>
                </div>
            `).join('');
        }
    }
);

// ============================================
// REQUIRED API ENDPOINTS TO IMPLEMENT
// ============================================

/*
Add these endpoints to your controllers:

1. GET /api/applications/count/pending
   Response: { count: 5 }

2. GET /api/applications/count/interview
   Response: { count: 3 }

3. GET /api/dashboard/stats
   Response: {
       total: 50,
       pending: 10,
       interviewing: 15,
       selected: 25
   }

4. GET /api/notifications/unread-count
   Response: { count: 3 }

5. GET /api/jobs/{jobId}/applications/live
   Response: {
       applications: [
           { id: 1, hoten: 'Nguyễn A', status: 'chờ xử lý' },
           ...
       ]
   }
*/

// ============================================
// CLEANUP ON PAGE UNLOAD
// ============================================

window.addEventListener('beforeunload', () => {
    realtimeUpdater.stopAll();
});

// ============================================
// CSS ANIMATION FOR PULSE EFFECT
// ============================================

/*
Add to your CSS file:

@keyframes pulse {
    0%, 100% {
        opacity: 1;
    }
    50% {
        opacity: 0.7;
    }
}

.pulse {
    animation: pulse 1s ease-in-out;
}
*/

