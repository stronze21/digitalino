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
