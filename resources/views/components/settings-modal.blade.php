<!-- resources/views/components/settings-modal.blade.php -->
<div x-data="settingsComponent()" x-show="isOpen"
    class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50"
    x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" @click.self="closeSettings()"
    style="display: none;">
    <div class="bg-white rounded-2xl shadow-xl p-6 max-w-md w-full">
        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Settings</h2>
            <button @click="closeSettings()" class="text-gray-500 hover:text-gray-700 focus:outline-none">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <!-- PIN verification -->
        <template x-if="!pinVerified">
            <div>
                <p class="text-gray-600 mb-4">Please enter the parent/teacher PIN to access settings:</p>
                <div class="flex justify-center mb-4">
                    <template x-for="(digit, index) in [0, 1, 2, 3]" :key="index">
                        <input type="password" maxlength="1" x-model="pinInput[index]"
                            @keyup="handlePinDigit($event, index)" @keydown.delete="handlePinDelete($event, index)"
                            class="w-12 h-12 text-center text-xl border-2 rounded-md mx-1 focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                    </template>
                </div>
                <template x-if="pinError">
                    <p class="text-red-500 text-center mb-4" x-text="pinError"></p>
                </template>
                <div class="flex justify-center">
                    <button @click="verifyPin()" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">
                        Verify
                    </button>
                </div>
                <p class="text-sm text-gray-500 mt-4 text-center">Default PIN: 0000</p>
            </div>
        </template>

        <!-- Settings content -->
        <template x-if="pinVerified">
            <div>
                <!-- Sound settings -->
                <div class="mb-6">
                    <h3 class="text-lg font-medium text-gray-800 mb-3">Sound Settings</h3>
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-gray-700">Sound Effects</span>
                        <div>
                            <button @click="settings.soundEnabled = !settings.soundEnabled"
                                class="relative inline-flex items-center h-6 rounded-full w-11"
                                :class="settings.soundEnabled ? 'bg-green-500' : 'bg-gray-300'">
                                <span class="inline-block w-4 h-4 transform bg-white rounded-full transition"
                                    :class="settings.soundEnabled ? 'translate-x-6' : 'translate-x-1'"></span>
                            </button>
                        </div>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-gray-700">Background Music</span>
                        <div>
                            <button @click="settings.musicEnabled = !settings.musicEnabled"
                                class="relative inline-flex items-center h-6 rounded-full w-11"
                                :class="settings.musicEnabled ? 'bg-green-500' : 'bg-gray-300'">
                                <span class="inline-block w-4 h-4 transform bg-white rounded-full transition"
                                    :class="settings.musicEnabled ? 'translate-x-6' : 'translate-x-1'"></span>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Appearance settings -->
                <div class="mb-6">
                    <h3 class="text-lg font-medium text-gray-800 mb-3">Appearance</h3>
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-gray-700">Animations</span>
                        <div>
                            <button @click="settings.animationsEnabled = !settings.animationsEnabled"
                                class="relative inline-flex items-center h-6 rounded-full w-11"
                                :class="settings.animationsEnabled ? 'bg-green-500' : 'bg-gray-300'">
                                <span class="inline-block w-4 h-4 transform bg-white rounded-full transition"
                                    :class="settings.animationsEnabled ? 'translate-x-6' : 'translate-x-1'"></span>
                            </button>
                        </div>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-gray-700">Color Scheme</span>
                        <div class="flex space-x-2">
                            <button @click="settings.colorScheme = 'default'" class="w-6 h-6 rounded-full border-2"
                                :class="settings.colorScheme === 'default' ? 'border-blue-500' : 'border-gray-300'"
                                style="background: linear-gradient(135deg, #4ade80, #3b82f6);"></button>
                            <button @click="settings.colorScheme = 'pastel'" class="w-6 h-6 rounded-full border-2"
                                :class="settings.colorScheme === 'pastel' ? 'border-blue-500' : 'border-gray-300'"
                                style="background: linear-gradient(135deg, #fbcfe8, #93c5fd);"></button>
                            <button @click="settings.colorScheme = 'high-contrast'"
                                class="w-6 h-6 rounded-full border-2"
                                :class="settings.colorScheme === 'high-contrast' ? 'border-blue-500' : 'border-gray-300'"
                                style="background: linear-gradient(135deg, #000000, #ffffff);"></button>
                        </div>
                    </div>
                </div>

                <!-- Accessibility settings -->
                <div class="mb-6">
                    <h3 class="text-lg font-medium text-gray-800 mb-3">Accessibility</h3>
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-gray-700">Break Reminders</span>
                        <div>
                            <button @click="toggleBreakReminders()"
                                class="relative inline-flex items-center h-6 rounded-full w-11"
                                :class="settings.breakRemindersEnabled ? 'bg-green-500' : 'bg-gray-300'">
                                <span class="inline-block w-4 h-4 transform bg-white rounded-full transition"
                                    :class="settings.breakRemindersEnabled ? 'translate-x-6' : 'translate-x-1'"></span>
                            </button>
                        </div>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-gray-700">Font Size</span>
                        <div class="flex items-center">
                            <button @click="decreaseFontSize()"
                                class="text-gray-500 hover:text-gray-700 focus:outline-none"
                                :disabled="settings.fontSize === 'small'"
                                :class="settings.fontSize === 'small' ? 'opacity-50 cursor-not-allowed' : ''">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M20 12H4" />
                                </svg>
                            </button>

                            <span class="mx-2 text-sm">
                                <span x-show="settings.fontSize === 'small'">Small</span>
                                <span x-show="settings.fontSize === 'medium'">Medium</span>
                                <span x-show="settings.fontSize === 'large'">Large</span>
                            </span>

                            <button @click="increaseFontSize()"
                                class="text-gray-500 hover:text-gray-700 focus:outline-none"
                                :disabled="settings.fontSize === 'large'"
                                :class="settings.fontSize === 'large' ? 'opacity-50 cursor-not-allowed' : ''">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Game settings -->
                <div class="mb-6">
                    <h3 class="text-lg font-medium text-gray-800 mb-3">Game Settings</h3>
                    <div class="flex items-center justify-between">
                        <span class="text-gray-700">Difficulty Adjustment</span>
                        <div>
                            <select x-model="settings.difficultyAdjustment"
                                class="rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                <option value="auto">Automatic</option>
                                <option value="manual">Manual</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Export/import data -->
                <div class="mb-6">
                    <h3 class="text-lg font-medium text-gray-800 mb-3">Data Management</h3>
                    <div class="flex space-x-2">
                        <button @click="exportData()"
                            class="px-3 py-2 bg-blue-100 text-blue-700 rounded-md hover:bg-blue-200 flex-1">
                            Export Data
                        </button>
                        <button @click="importData()"
                            class="px-3 py-2 bg-purple-100 text-purple-700 rounded-md hover:bg-purple-200 flex-1">
                            Import Data
                        </button>
                    </div>
                </div>

                <!-- Reset options -->
                <div class="border-t border-gray-200 pt-4">
                    <h3 class="text-lg font-medium text-gray-800 mb-3">Reset Options</h3>
                    <div class="flex space-x-2">
                        <button @click="resetSettings()"
                            class="px-3 py-2 bg-yellow-100 text-yellow-700 rounded-md hover:bg-yellow-200 flex-1">
                            Reset Settings
                        </button>
                        <button @click="confirmResetProgress()"
                            class="px-3 py-2 bg-red-100 text-red-700 rounded-md hover:bg-red-200 flex-1">
                            Reset All Progress
                        </button>
                    </div>
                </div>

                <!-- Change PIN -->
                <div class="mt-6 border-t border-gray-200 pt-4">
                    <h3 class="text-lg font-medium text-gray-800 mb-3">Security</h3>
                    <button @click="showChangePinForm = !showChangePinForm"
                        class="px-4 py-2 bg-gray-100 text-gray-700 rounded-md hover:bg-gray-200 w-full">
                        Change PIN
                    </button>

                    <!-- Change PIN form -->
                    <template x-if="showChangePinForm">
                        <div class="mt-4 p-4 border border-gray-200 rounded-md">
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Current PIN</label>
                                <div class="flex">
                                    <template x-for="(digit, index) in [0, 1, 2, 3]" :key="index">
                                        <input type="password" maxlength="1" x-model="currentPinInput[index]"
                                            class="w-10 h-10 text-center text-lg border-2 rounded-md mx-1 focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                    </template>
                                </div>
                            </div>
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 mb-1">New PIN</label>
                                <div class="flex">
                                    <template x-for="(digit, index) in [0, 1, 2, 3]" :key="index">
                                        <input type="password" maxlength="1" x-model="newPinInput[index]"
                                            class="w-10 h-10 text-center text-lg border-2 rounded-md mx-1 focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                    </template>
                                </div>
                            </div>
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Confirm New PIN</label>
                                <div class="flex">
                                    <template x-for="(digit, index) in [0, 1, 2, 3]" :key="index">
                                        <input type="password" maxlength="1" x-model="confirmPinInput[index]"
                                            class="w-10 h-10 text-center text-lg border-2 rounded-md mx-1 focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                    </template>
                                </div>
                            </div>
                            <template x-if="pinChangeError">
                                <p class="text-red-500 text-sm mb-4" x-text="pinChangeError"></p>
                            </template>
                            <div class="flex space-x-2">
                                <button @click="showChangePinForm = false"
                                    class="px-3 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 flex-1">
                                    Cancel
                                </button>
                                <button @click="changePin()"
                                    class="px-3 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 flex-1">
                                    Save New PIN
                                </button>
                            </div>
                        </div>
                    </template>
                </div>

                <!-- Save button -->
                <div class="mt-6 flex justify-end">
                    <button @click="saveSettings()"
                        class="px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600">
                        Save Settings
                    </button>
                </div>
            </div>
        </template>

        <!-- Reset confirmation dialog -->
        <template x-if="showResetConfirmation">
            <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
                <div class="bg-white rounded-lg p-6 max-w-sm mx-auto">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Reset All Progress?</h3>
                    <p class="text-gray-700 mb-4">
                        This will delete all user profiles, progress, and game data. This action cannot be undone.
                    </p>
                    <div class="flex justify-end space-x-3">
                        <button @click="showResetConfirmation = false"
                            class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300">
                            Cancel
                        </button>
                        <button @click="resetAllProgress()"
                            class="px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-600">
                            Reset
                        </button>
                    </div>
                </div>
            </div>
        </template>

        <!-- File input for import (hidden) -->
        <input type="file" id="import-data-input" accept=".json" class="hidden"
            @change="handleFileImport($event)">
    </div>
</div>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('settingsComponent', () => ({
            isOpen: false,
            pinVerified: false,
            pinInput: ['', '', '', ''],
            currentPinInput: ['', '', '', ''],
            newPinInput: ['', '', '', ''],
            confirmPinInput: ['', '', '', ''],
            pinError: null,
            pinChangeError: null,
            showChangePinForm: false,
            showResetConfirmation: false,
            pin: '0000',

            // Settings object
            settings: {
                soundEnabled: true,
                musicEnabled: true,
                animationsEnabled: true,
                colorScheme: 'default',
                breakRemindersEnabled: true,
                fontSize: 'medium',
                difficultyAdjustment: 'auto'
            },

            // Initialize component
            init() {
                // Load settings from localStorage
                this.loadSettings();

                // Load PIN from localStorage
                const storedPin = localStorage.getItem('digitalino_pin');
                if (storedPin) {
                    this.pin = storedPin;
                }

                // Listen for settings open event
                window.addEventListener('open-settings', () => {
                    this.openSettings();
                });
            },

            // Open settings modal
            openSettings() {
                this.isOpen = true;
                this.pinVerified = false;
                this.pinInput = ['', '', '', ''];
                this.pinError = null;
            },

            // Close settings modal
            closeSettings() {
                this.isOpen = false;
            },

            // Handle PIN input digit
            handlePinDigit(event, index) {
                const digit = event.target.value;

                // Only allow digits
                if (digit && !digit.match(/^\d$/)) {
                    this.pinInput[index] = '';
                    return;
                }

                // Move focus to next input if this one is filled
                if (digit && index < 3) {
                    event.target.nextElementSibling.focus();
                }
            },

            // Handle delete keypress in PIN input
            handlePinDelete(event, index) {
                // If current field is empty and user pressed delete, move to previous field
                if (index > 0 && !this.pinInput[index] && event.key === 'Backspace') {
                    event.preventDefault();
                    const prevInput = event.target.previousElementSibling;
                    prevInput.focus();
                    prevInput.select();
                }
            },

            // Verify PIN
            async verifyPin() {
                const enteredPin = this.pinInput.join('');

                if (enteredPin.length !== 4) {
                    this.pinError = 'Please enter a 4-digit PIN';
                    return;
                }

                try {
                    // Verify through API if available
                    const response = await fetch('/settings/verify-pin', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector(
                                    'meta[name="csrf-token"]')?.getAttribute(
                                'content') || '',
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({
                            pin: enteredPin,
                            storedPin: this.pin
                        })
                    });

                    const result = await response.json();

                    if (result.success) {
                        this.pinVerified = true;
                        this.pinError = null;
                    } else {
                        this.pinError = 'Incorrect PIN';
                        this.pinInput = ['', '', '', ''];
                    }
                } catch (error) {
                    // Fallback to client-side verification
                    if (enteredPin === this.pin) {
                        this.pinVerified = true;
                        this.pinError = null;
                    } else {
                        this.pinError = 'Incorrect PIN';
                        this.pinInput = ['', '', '', ''];
                    }
                }
            },

            // Load settings from localStorage
            loadSettings() {
                const storedSettings = localStorage.getItem('digitalino_settings');
                if (storedSettings) {
                    try {
                        const parsedSettings = JSON.parse(storedSettings);
                        this.settings = {
                            ...this.settings,
                            ...parsedSettings
                        };
                    } catch (e) {
                        console.error('Failed to parse settings:', e);
                    }
                }
            },

            // Save settings to localStorage
            async saveSettings() {
                try {
                    // Send settings to API
                    const response = await fetch('/settings/save', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector(
                                    'meta[name="csrf-token"]')?.getAttribute(
                                'content') || '',
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({
                            settings: this.settings
                        })
                    });

                    const result = await response.json();

                    if (result.success) {
                        // Store in localStorage
                        localStorage.setItem('digitalino_settings', JSON.stringify(this
                            .settings));
                        this.closeSettings();

                        // Apply settings to the app
                        this.applySettings();
                    } else {
                        console.error('Failed to save settings:', result.error);
                    }
                } catch (error) {
                    // Fallback to just local storage
                    localStorage.setItem('digitalino_settings', JSON.stringify(this.settings));
                    this.closeSettings();

                    // Apply settings to the app
                    this.applySettings();
                }
            },

            // Apply settings to the app
            applySettings() {
                // Apply font size
                document.documentElement.style.fontSize = {
                    'small': '16px',
                    'medium': '18px',
                    'large': '20px'
                } [this.settings.fontSize];

                // Apply color scheme
                document.body.dataset.colorScheme = this.settings.colorScheme;

                // Show confirmation message
                const event = new CustomEvent('settings-saved');
                window.dispatchEvent(event);
            },

            // Toggle break reminders
            toggleBreakReminders() {
                this.settings.breakRemindersEnabled = !this.settings.breakRemindersEnabled;
            },

            // Increase font size
            increaseFontSize() {
                const sizes = ['small', 'medium', 'large'];
                const currentIndex = sizes.indexOf(this.settings.fontSize);

                if (currentIndex < sizes.length - 1) {
                    this.settings.fontSize = sizes[currentIndex + 1];
                }
            },

            // Decrease font size
            decreaseFontSize() {
                const sizes = ['small', 'medium', 'large'];
                const currentIndex = sizes.indexOf(this.settings.fontSize);

                if (currentIndex > 0) {
                    this.settings.fontSize = sizes[currentIndex - 1];
                }
            },

            // Reset settings to defaults
            resetSettings() {
                this.settings = {
                    soundEnabled: true,
                    musicEnabled: true,
                    animationsEnabled: true,
                    colorScheme: 'default',
                    breakRemindersEnabled: true,
                    fontSize: 'medium',
                    difficultyAdjustment: 'auto'
                };
            },

            // Show reset progress confirmation
            confirmResetProgress() {
                this.showResetConfirmation = true;
            },

            // Reset all progress
            async resetAllProgress() {
                try {
                    // Send reset request to API
                    const response = await fetch('/settings/reset-data', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector(
                                    'meta[name="csrf-token"]')?.getAttribute(
                                'content') || '',
                            'Accept': 'application/json'
                        }
                    });

                    const result = await response.json();

                    if (result.success) {
                        // Clear all app data from localStorage
                        localStorage.removeItem('digitalino_profiles');
                        localStorage.removeItem('digitalino_activity');

                        // Keep settings and PIN

                        this.showResetConfirmation = false;
                        this.closeSettings();

                        // Reload the page to apply changes
                        window.location.reload();
                    }
                } catch (error) {
                    // Fallback to just clearing localStorage
                    localStorage.removeItem('digitalino_profiles');
                    localStorage.removeItem('digitalino_activity');

                    // Keep settings and PIN

                    this.showResetConfirmation = false;
                    this.closeSettings();

                    // Reload the page to apply changes
                    window.location.reload();
                }
            },

            // Change PIN
            changePin() {
                // Validate current PIN
                const currentPin = this.currentPinInput.join('');
                if (currentPin !== this.pin) {
                    this.pinChangeError = 'Current PIN is incorrect';
                    return;
                }

                // Validate new PIN
                const newPin = this.newPinInput.join('');
                const confirmPin = this.confirmPinInput.join('');

                if (newPin.length !== 4) {
                    this.pinChangeError = 'New PIN must be 4 digits';
                    return;
                }

                if (newPin !== confirmPin) {
                    this.pinChangeError = 'New PINs do not match';
                    return;
                }

                // Save new PIN
                this.pin = newPin;
                localStorage.setItem('digitalino_pin', newPin);

                // Reset form
                this.showChangePinForm = false;
                this.currentPinInput = ['', '', '', ''];
                this.newPinInput = ['', '', '', ''];
                this.confirmPinInput = ['', '', '', ''];
                this.pinChangeError = null;
            },

            // Export data
            async exportData() {
                try {
                    // Call API to prepare data for export
                    const response = await fetch('/settings/export-data', {
                        method: 'GET',
                        headers: {
                            'Accept': 'application/json'
                        }
                    });

                    const result = await response.json();

                    if (result.success) {
                        // Collect all app data
                        const exportData = {
                            profiles: JSON.parse(localStorage.getItem(
                                'digitalino_profiles') ||
                                '{"list":[],"currentProfile":null}'),
                            activity: JSON.parse(localStorage.getItem(
                                'digitalino_activity') || '{}'),
                            settings: this.settings,
                            exportDate: new Date().toISOString()
                        };

                        // Convert to JSON
                        const dataStr = JSON.stringify(exportData, null, 2);

                        // Create download link
                        const dataBlob = new Blob([dataStr], {
                            type: 'application/json'
                        });
                        const url = URL.createObjectURL(dataBlob);

                        const downloadLink = document.createElement('a');
                        downloadLink.href = url;
                        downloadLink.download = 'digitalino_data.json';

                        // Trigger download
                        document.body.appendChild(downloadLink);
                        downloadLink.click();
                        document.body.removeChild(downloadLink);

                        // Clean up
                        URL.revokeObjectURL(url);
                    }
                } catch (error) {
                    // Fallback to client-side export
                    const exportData = {
                        profiles: JSON.parse(localStorage.getItem('digitalino_profiles') ||
                            '{"list":[],"currentProfile":null}'),
                        activity: JSON.parse(localStorage.getItem('digitalino_activity') ||
                            '{}'),
                        settings: this.settings,
                        exportDate: new Date().toISOString()
                    };

                    // Convert to JSON
                    const dataStr = JSON.stringify(exportData, null, 2);

                    // Create download link
                    const dataBlob = new Blob([dataStr], {
                        type: 'application/json'
                    });
                    const url = URL.createObjectURL(dataBlob);

                    const downloadLink = document.createElement('a');
                    downloadLink.href = url;
                    downloadLink.download = 'digitalino_data.json';

                    // Trigger download
                    document.body.appendChild(downloadLink);
                    downloadLink.click();
                    document.body.removeChild(downloadLink);

                    // Clean up
                    URL.revokeObjectURL(url);
                }
            },

            // Import data
            importData() {
                document.getElementById('import-data-input').click();
            },

            // Handle file import
            async handleFileImport(event) {
                const file = event.target.files[0];

                if (!file) return;

                try {
                    // Send file to API for validation
                    const formData = new FormData();
                    formData.append('dataFile', file);
                    formData.append('_token', document.querySelector('meta[name="csrf-token"]')
                        ?.getAttribute('content') || '');

                    const response = await fetch('/settings/import-data', {
                        method: 'POST',
                        headers: {
                            'Accept': 'application/json'
                        },
                        body: formData
                    });

                    const result = await response.json();

                    if (result.success) {
                        // Import the data
                        const importedData = result.data;

                        // Import profiles and activity
                        localStorage.setItem('digitalino_profiles', JSON.stringify(importedData
                            .profiles));

                        if (importedData.activity) {
                            localStorage.setItem('digitalino_activity', JSON.stringify(
                                importedData.activity));
                        }

                        // Import settings
                        this.settings = {
                            ...this.settings,
                            ...importedData.settings
                        };

                        // Save settings
                        localStorage.setItem('digitalino_settings', JSON.stringify(this
                            .settings));

                        // Close settings and reload page
                        this.closeSettings();
                        window.location.reload();
                    } else {
                        alert('Failed to import data: ' + result.message);
                    }
                } catch (error) {
                    // Fallback to client-side import
                    const reader = new FileReader();

                    reader.onload = (e) => {
                        try {
                            const importedData = JSON.parse(e.target.result);

                            // Validate data structure
                            if (!importedData.profiles || !importedData.settings) {
                                alert('Invalid data file format');
                                return;
                            }

                            // Import profiles and activity
                            localStorage.setItem('digitalino_profiles', JSON.stringify(
                                importedData.profiles));

                            if (importedData.activity) {
                                localStorage.setItem('digitalino_activity', JSON.stringify(
                                    importedData.activity));
                            }

                            // Import settings
                            this.settings = {
                                ...this.settings,
                                ...importedData.settings
                            };

                            // Save settings
                            localStorage.setItem('digitalino_settings', JSON.stringify(this
                                .settings));

                            // Close settings and reload page
                            this.closeSettings();
                            window.location.reload();
                        } catch (e) {
                            console.error('Failed to parse import file:', e);
                            alert('Failed to import data: Invalid file format');
                        }
                    };

                    reader.readAsText(file);
                }

                // Reset file input
                event.target.value = '';
            }
        }));
    });
</script>
