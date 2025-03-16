<!-- resources/views/welcome.blade.php -->
@extends('layouts.app')

@section('title', 'Welcome to NUMZOO')

@section('content')
    <div class="flex flex-col items-center justify-center min-h-[70vh] py-10" x-data="{ showProfileSelector: false }">

        <!-- Welcome animation -->
        <div class="mb-8 text-center">
            <h1 class="mb-4 text-4xl font-bold text-center text-purple-600 md:text-5xl animate-bounce">
                Welcome to NUMZOO!
            </h1>
            <p class="max-w-lg mx-auto text-lg text-gray-700">
                A fun math adventure for kindergarten learners!
            </p>
        </div>

        <!-- Main mascot/logo -->
        <div class="relative mb-8">
            <img src="/images/mascot.png" alt="NUMZOO Mascot" class="object-contain w-64 h-64">

            <!-- Floating animated stars -->
            <div class="absolute -top-4 -right-4 animate-pulse">
                <svg class="w-8 h-8 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                    <path
                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                </svg>
            </div>
            <div class="absolute delay-300 -bottom-2 -left-4 animate-pulse">
                <svg class="w-6 h-6 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                    <path
                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                </svg>
            </div>
        </div>

        <!-- Call to action buttons -->
        <div class="space-y-4">

            <!-- Auto-creation component that works with the main profile selector -->
            <div x-data="{
                autoCreate() {
                    // We'll use a custom event to communicate with the main component
                    const event = new CustomEvent('auto-create-profile');
                    document.dispatchEvent(event);
                }
            }">
                <button @click="autoCreate()"
                    class="px-8 py-4 text-xl text-white transition transform rounded-full shadow-lg bg-gradient-to-r from-green-500 to-green-600 hover:scale-105 focus:outline-none focus:ring-4 focus:ring-green-300">
                    Let's Play!
                </button>

                <button onclick="location.href='{{ route('about') }}'"
                    class="px-6 py-3 text-blue-700 transition transform bg-blue-100 rounded-full shadow-md hover:scale-105 focus:outline-none focus:ring-4 focus:ring-blue-200">
                    About NUMZOO
                </button>
            </div>
            <!-- Add this button with its own Alpine.js component -->
            <div class="text-center my-6" x-data="{
                clearAllCaches() {
                    // Clear localStorage
                    localStorage.clear();

                    // Call Android method if in WebView
                    if (typeof AndroidApp !== 'undefined') {
                        // Use the AndroidApp interface we defined in Kotlin
                        AndroidApp.clearCache();
                        // No need to reload - our Kotlin code will handle that
                    } else {
                        // Fallback for regular browser
                        alert('All caches cleared! The page will now reload.');
                        window.location.reload();
                    }
                }
            }">
                <button @click="clearAllCaches()"
                    class="px-6 py-3 bg-red-500 text-white rounded-lg hover:bg-red-600 font-semibold shadow-md">
                    Clear All Caches
                </button>
            </div>
        </div>

        <!-- Profile selector modal -->
        <div x-show="showProfileSelector" x-transition
            class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black bg-opacity-50" style="display: none;">
            <div class="w-full max-w-md p-6 bg-white shadow-2xl rounded-2xl" x-data="profileSelector()"
                @click.away="showProfileSelector = false">
                <h2 class="mb-6 text-2xl font-bold text-center text-purple-600">Who's Playing Today?</h2>

                <!-- Profile list -->
                <div class="mb-6">
                    <template x-if="profiles.length === 0">
                        <div class="py-4 text-center text-gray-500">
                            No profiles yet. Create one below!
                        </div>
                    </template>

                    <template x-if="profiles.length > 0">
                        <div class="grid grid-cols-2 gap-4">
                            <template x-for="profile in profiles" :key="profile.id">
                                <button
                                    class="flex flex-col items-center p-3 transition border-2 rounded-xl hover:bg-blue-50"
                                    :class="{
                                        'border-blue-500 bg-blue-50': selectedProfile === profile
                                            .id,
                                        'border-gray-200': selectedProfile !== profile.id
                                    }"
                                    @click="selectProfile(profile.id)">
                                    <img :src="'/images/avatars/' + profile.avatar + '.png'"
                                        class="w-16 h-16 mb-2 rounded-full" :alt="profile.name">
                                    <span class="font-medium" x-text="profile.name"></span>
                                    <span class="text-xs text-gray-500"
                                        x-text="'Level ' + profile.progress.currentLevel"></span>
                                </button>
                            </template>
                        </div>
                    </template>
                </div>

                <!-- Create new profile button -->
                <template x-if="!showNewProfileForm">
                    <button @click="showNewProfileForm = true"
                        class="w-full py-3 text-yellow-900 transition transform bg-yellow-400 shadow-md rounded-xl hover:bg-yellow-300 focus:outline-none focus:ring-4 focus:ring-yellow-200">
                        Create New Player
                    </button>
                </template>

                <!-- New profile form -->
                <template x-if="showNewProfileForm">
                    <div class="space-y-4">
                        <div>
                            <label for="profileName" class="block mb-1 text-sm font-medium text-gray-700">Name</label>
                            <input type="text" id="profileName" x-model="newProfileName"
                                class="w-full p-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"
                                placeholder="Enter your name">
                        </div>

                        <div>
                            <label class="block mb-1 text-sm font-medium text-gray-700">Choose an Avatar</label>
                            <div class="grid grid-cols-4 gap-2">
                                <template x-for="avatar in avatars" :key="avatar">
                                    <button class="p-1 transition border-2 rounded-lg"
                                        :class="{
                                            'border-blue-500 bg-blue-50': newProfileAvatar ===
                                                avatar,
                                            'border-gray-200': newProfileAvatar !== avatar
                                        }"
                                        @click="newProfileAvatar = avatar">
                                        <img :src="'images/avatars/' + avatar + '.png'" class="w-12 h-12 rounded-full"
                                            :alt="'Avatar ' + avatar">
                                    </button>
                                </template>
                            </div>
                        </div>

                        <div class="flex space-x-2">
                            <button @click="showNewProfileForm = false"
                                class="flex-1 py-2 text-gray-800 bg-gray-200 rounded-md hover:bg-gray-300">
                                Cancel
                            </button>
                            <button @click="createProfile()"
                                class="flex-1 py-2 text-white bg-green-500 rounded-md hover:bg-green-600"
                                :disabled="!isValidProfile" :class="{ 'opacity-50 cursor-not-allowed': !isValidProfile }">
                                Create
                            </button>
                        </div>
                    </div>
                </template>

                <!-- Action buttons -->
                <template x-if="selectedProfile && !showNewProfileForm">
                    <div class="flex mt-6 space-x-3">
                        <button @click="showProfileSelector = false; startGame()"
                            class="flex-1 py-3 text-white bg-green-500 shadow-md rounded-xl hover:bg-green-600">
                            Start Playing!
                        </button>
                        <button @click="deleteProfile(selectedProfile)"
                            class="px-4 py-3 text-red-700 bg-red-100 rounded-xl hover:bg-red-200" title="Delete Profile">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                    clip-rule="evenodd" />
                            </svg>
                        </button>
                    </div>
                </template>
            </div>
        </div>
    </div>

    <!-- Alpine.js component for profile selection with auto-creation -->
    <script>
        function clearAllCaches() {
            if (confirm('Are you sure you want to clear all caches? This will reset all game data and profiles.')) {
                // Clear localStorage
                localStorage.clear();

                // Call Android method if in WebView
                if (typeof AndroidApp !== 'undefined') {
                    // Use the AndroidApp interface we defined in Kotlin
                    AndroidApp.clearCache();
                    // No need to reload - our Kotlin code will handle that
                } else {
                    // Fallback for regular browser
                    alert('All caches cleared! The page will now reload.');
                    window.location.reload();
                }
            }
        }

        function profileSelector() {
            return {
                // Profile data
                profiles: [],
                selectedProfile: null,
                showNewProfileForm: false,

                // New profile form
                newProfileName: 'Numzoologist',
                newProfileAvatar: 'fox',
                avatars: ['fox', 'panda', 'owl', 'rabbit', 'turtle', 'penguin', 'lion', 'monkey'],
                // Clear all caches function
                clearAllCaches() {
                    if (confirm('Are you sure you want to clear all caches? This will reset all game data and profiles.')) {
                        // Clear all localStorage items
                        localStorage.clear();

                        // Show confirmation
                        alert('All caches cleared successfully! The page will now reload.');

                        // Reload the page to reset the UI
                        window.location.reload();
                    }
                },
                // Computed property for form validation
                get isValidProfile() {
                    return this.newProfileName.trim().length > 0 && this.newProfileAvatar;
                },

                // Initialize component
                init() {
                    // Load profiles from local storage
                    const storedProfiles = localStorage.getItem('numzoo_profiles');
                    if (storedProfiles) {
                        try {
                            const profileData = JSON.parse(storedProfiles);
                            if (profileData && profileData.list) {
                                this.profiles = profileData.list;
                                this.selectedProfile = profileData.currentProfile;
                            }
                        } catch (e) {
                            console.error('Failed to parse profiles:', e);
                        }
                    }

                    // Listen for auto-create event
                    document.addEventListener('auto-create-profile', () => {
                        if (this.profiles.length === 0) {
                            this.autoCreateProfileAndRedirect();
                        } else {
                            window.location.href = '/game-hub';
                        }
                    });
                },

                // Automatically create a profile and redirect to game hub
                autoCreateProfileAndRedirect() {
                    const newProfile = {
                        id: Date.now().toString(),
                        name: this.newProfileName.trim(),
                        avatar: this.newProfileAvatar,
                        createdAt: new Date().toISOString(),
                        progress: {
                            currentLevel: 1,
                            totalStars: 0,
                            completedGames: [],
                            skillLevels: {
                                counting: 1,
                                numbers: 1,
                                addition: 1,
                                subtraction: 1,
                                shapes: 1
                            }
                        }
                    };

                    this.profiles.push(newProfile);
                    this.selectProfile(newProfile.id);

                    // Redirect to game hub
                    setTimeout(() => {
                        window.location.href = '/game-hub';
                    }, 500); // Small delay to ensure data is saved
                },

                // Select an existing profile
                selectProfile(profileId) {
                    this.selectedProfile = profileId;

                    // Update local storage
                    const profileData = {
                        currentProfile: profileId,
                        list: this.profiles
                    };

                    localStorage.setItem('numzoo_profiles', JSON.stringify(profileData));
                },

                // Create a new profile
                createProfile() {
                    if (!this.isValidProfile) return;

                    const newProfile = {
                        id: Date.now().toString(),
                        name: this.newProfileName.trim(),
                        avatar: this.newProfileAvatar,
                        createdAt: new Date().toISOString(),
                        progress: {
                            currentLevel: 1,
                            totalStars: 0,
                            completedGames: [],
                            skillLevels: {
                                counting: 1,
                                numbers: 1,
                                addition: 1,
                                subtraction: 1,
                                shapes: 1
                            }
                        }
                    };

                    this.profiles.push(newProfile);
                    this.selectProfile(newProfile.id);

                    // Reset form
                    this.showNewProfileForm = false;
                    this.newProfileName = '';
                    this.newProfileAvatar = 'fox';
                },

                // Delete a profile
                deleteProfile(profileId) {
                    if (confirm('Are you sure you want to delete this profile? All progress will be lost!')) {
                        this.profiles = this.profiles.filter(p => p.id !== profileId);

                        if (this.selectedProfile === profileId) {
                            this.selectedProfile = this.profiles.length > 0 ? this.profiles[0].id : null;
                        }

                        // Update local storage
                        const profileData = {
                            currentProfile: this.selectedProfile,
                            list: this.profiles
                        };

                        localStorage.setItem('numzoo_profiles', JSON.stringify(profileData));
                    }
                },

                // Start the game with selected profile
                startGame() {
                    window.location.href = '/game-hub';
                }
            };
        }
    </script>
@endsection
