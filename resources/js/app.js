// resources/js/app.js

/**
 * File system access for the app
 * This would normally use real file system API but for our stateless app
 * we'll just use a simple wrapper around localStorage
 */
window.fs = {
    // Read a file (simulated with localStorage)
    readFile: async function(path, options = {}) {
        const key = 'numzoo_file_' + path;
        const data = localStorage.getItem(key);

        if (data === null) {
            throw new Error(`File not found: ${path}`);
        }

        if (options.encoding === 'utf8') {
            return data;
        }

        // Otherwise return as Uint8Array (for binary files)
        const encoder = new TextEncoder();
        return encoder.encode(data);
    },

    // Write a file (simulated with localStorage)
    writeFile: async function(path, data, options = {}) {
        const key = 'numzoo_file_' + path;

        if (data instanceof Uint8Array) {
            const decoder = new TextDecoder();
            data = decoder.decode(data);
        }

        localStorage.setItem(key, data);
        return true;
    },

    // Check if a file exists
    exists: function(path) {
        const key = 'numzoo_file_' + path;
        return localStorage.getItem(key) !== null;
    },

    // Remove a file
    unlink: async function(path) {
        const key = 'numzoo_file_' + path;
        localStorage.removeItem(key);
        return true;
    }
};

import Alpine from 'alpinejs';
import { persist } from '@alpinejs/persist';
import initStorageManager from './storage-manager.js';

// resources/js/settings-handler.js

/**
 * Settings panel handler
 * This file contains functions to open the settings panel
 */

// Register settings handler
window.openSettings = function() {
    // Dispatch event to open settings modal
    const event = new CustomEvent('open-settings');
    window.dispatchEvent(event);
};

// Update the app.js to include this file
// In resources/js/app.js, add:
// import './settings-handler';

// Add event listener to settings button in the layout
document.addEventListener('DOMContentLoaded', function() {
    const settingsButton = document.querySelector('[data-settings-button]');
    if (settingsButton) {
        settingsButton.addEventListener('click', function(e) {
            e.preventDefault();
            window.openSettings();
        });
    }
});

// resources/js/settings-api.js

// resources/js/settings-api.js

/**
 * Settings API handler
 * Functions to interact with the settings API endpoints
 */

// Safe CSRF token getter
const getCsrfToken = () => {
    const tokenElement = document.querySelector('meta[name="csrf-token"]');
    return tokenElement ? tokenElement.getAttribute('content') : '';
};

/**
 * Save settings to the server
 * @param {object} settings - Settings object to save
 * @returns {Promise} Promise resolving to the API response
 */
export async function saveSettings(settings) {
    try {
        const response = await fetch('/settings/save', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': getCsrfToken(),
                'Accept': 'application/json'
            },
            body: JSON.stringify({ settings })
        });

        return await response.json();
    } catch (error) {
        console.error('Failed to save settings:', error);
        return { success: false, error: 'Network error' };
    }
}

/**
 * Verify PIN
 * @param {string} pin - PIN to verify
 * @param {string} storedPin - PIN stored locally for comparison
 * @returns {Promise} Promise resolving to the API response
 */
export async function verifyPin(pin, storedPin) {
    try {
        const response = await fetch('/settings/verify-pin', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': getCsrfToken(),
                'Accept': 'application/json'
            },
            body: JSON.stringify({ pin, storedPin })
        });

        return await response.json();
    } catch (error) {
        console.error('Failed to verify PIN:', error);
        return { success: false, error: 'Network error' };
    }
}

/**
 * Export data
 * @returns {Promise} Promise resolving to the API response
 */
export async function exportData() {
    try {
        const response = await fetch('/settings/export-data', {
            method: 'GET',
            headers: {
                'Accept': 'application/json'
            }
        });

        return await response.json();
    } catch (error) {
        console.error('Failed to export data:', error);
        return { success: false, error: 'Network error' };
    }
}

/**
 * Import data from file
 * @param {File} file - JSON file to import
 * @returns {Promise} Promise resolving to the API response
 */
export async function importData(file) {
    try {
        const formData = new FormData();
        formData.append('dataFile', file);
        formData.append('_token', getCsrfToken());

        const response = await fetch('/settings/import-data', {
            method: 'POST',
            headers: {
                'Accept': 'application/json'
            },
            body: formData
        });

        return await response.json();
    } catch (error) {
        console.error('Failed to import data:', error);
        return { success: false, error: 'Network error' };
    }
}

/**
 * Reset data
 * @returns {Promise} Promise resolving to the API response
 */
export async function resetData() {
    try {
        const response = await fetch('/settings/reset-data', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': getCsrfToken(),
                'Accept': 'application/json'
            }
        });

        return await response.json();
    } catch (error) {
        console.error('Failed to reset data:', error);
        return { success: false, error: 'Network error' };
    }
}

// Export all functions as an object
export default {
    saveSettings,
    verifyPin,
    exportData,
    importData,
    resetData
};


// Register Alpine plugins
Alpine.plugin(persist);

// Register global Alpine components
Alpine.data('storageManager', initStorageManager);

// Initialize Alpine
window.Alpine = Alpine;
Alpine.start();

// Register service worker for PWA
if ('serviceWorker' in navigator) {
    window.addEventListener('load', () => {
        navigator.serviceWorker.register('/service-worker.js')
            .then(registration => {
                console.log('Service worker registered: ', registration);
            })
            .catch(error => {
                console.log('Service worker registration failed: ', error);
            });
    });
}

// Global audio controller
window.playSound = function(sound) {
    // Check if sounds are enabled in settings
    const settingsStr = localStorage.getItem('numzoo_settings');
    let soundEnabled = true;

    if (settingsStr) {
        try {
            const settings = JSON.parse(settingsStr);
            soundEnabled = settings.soundEnabled !== false;
        } catch (e) {
            console.error('Failed to parse settings:', e);
        }
    }

    if (!soundEnabled) return;

    // Play the requested sound
    const audio = document.getElementById(sound + '-sound');
    if (audio) {
        audio.currentTime = 0;
        audio.play().catch(e => console.error('Error playing sound:', e));
    }
};

// Register event handlers for break reminders
document.addEventListener('DOMContentLoaded', () => {
    // Initialize session timer for breaks
    let sessionTime = 0;
    const breakInterval = 20 * 60; // 20 minutes in seconds

    const incrementSession = () => {
        // Only count time if user is active (not idle)
        sessionTime++;

        // Store last activity time
        localStorage.setItem('numzoo_last_active', Date.now().toString());

        // Check if it's time for a break
        if (sessionTime >= breakInterval) {
            // Trigger break reminder
            const breakReminderEvent = new CustomEvent('showBreakReminder');
            document.dispatchEvent(breakReminderEvent);

            // Reset timer
            sessionTime = 0;
        }
    };

    // Set up timer
    setInterval(incrementSession, 1000);

    // Reset timer on page load
    const lastActive = localStorage.getItem('numzoo_last_active');
    if (lastActive) {
        const elapsed = (Date.now() - parseInt(lastActive)) / 1000;
        if (elapsed > 5 * 60) { // 5 minutes of inactivity
            sessionTime = 0;
        }
    }
});
