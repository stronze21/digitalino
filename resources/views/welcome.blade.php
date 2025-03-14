<!-- resources/views/welcome.blade.php -->
@extends('layouts.app')

@section('title', 'Welcome to DIGITALINO')

@section('content')
    <div class="flex flex-col items-center justify-center min-h-[70vh] py-10" x-data="{ showProfileSelector: false }">

        <!-- Welcome animation -->
        <div class="mb-8 text-center">
            <h1 class="text-4xl md:text-5xl font-bold text-center mb-4 text-purple-600 animate-bounce">
                Welcome to DIGITALINO!
            </h1>
            <p class="text-lg text-gray-700 max-w-lg mx-auto">
                A fun math adventure for kindergarten learners!
            </p>
        </div>

        <!-- Main mascot/logo -->
        <div class="mb-8 relative">
            <img src="/images/mascot.png" alt="DIGITALINO Mascot" class="w-64 h-64 object-contain">

            <!-- Floating animated stars -->
            <div class="absolute -top-4 -right-4 animate-pulse">
                <svg class="w-8 h-8 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                    <path
                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                </svg>
            </div>
            <div class="absolute -bottom-2 -left-4 animate-pulse delay-300">
                <svg class="w-6 h-6 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                    <path
                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                </svg>
            </div>
        </div>

        <!-- Call to action buttons -->
        <div class="space-y-4">
            <button @click="showProfileSelector = true"
                class="px-8 py-4 bg-gradient-to-r from-green-500 to-green-600 text-white text-xl rounded-full shadow-lg transform transition hover:scale-105 focus:outline-none focus:ring-4 focus:ring-green-300">
                Let's Play!
            </button>

            <button onclick="location.href='{{ route('about') }}'"
                class="px-6 py-3 bg-blue-100 text-blue-700 rounded-full shadow-md transform transition hover:scale-105 focus:outline-none focus:ring-4 focus:ring-blue-200">
                About DIGITALINO
            </button>
        </div>

        <!-- Profile selector modal -->
        <div x-show="showProfileSelector" x-transition
            class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50" style="display: none;">
            <div class="bg-white rounded-2xl p-6 max-w-md w-full shadow-2xl" x-data="profileSelector()"
                @click.away="showProfileSelector = false">
                <h2 class="text-2xl font-bold text-center mb-6 text-purple-600">Who's Playing Today?</h2>

                <!-- Profile list -->
                <div class="mb-6">
                    <template x-if="profiles.length === 0">
                        <div class="text-center py-4 text-gray-500">
                            No profiles yet. Create one below!
                        </div>
                    </template>

                    <template x-if="profiles.length > 0">
                        <div class="grid grid-cols-2 gap-4">
                            <template x-for="profile in profiles" :key="profile.id">
                                <button
                                    class="flex flex-col items-center p-3 border-2 rounded-xl transition hover:bg-blue-50"
                                    :class="{
                                        'border-blue-500 bg-blue-50': selectedProfile === profile
                                            .id,
                                        'border-gray-200': selectedProfile !== profile.id
                                    }"
                                    @click="selectProfile(profile.id)">
                                    <img :src="'/images/avatars/' + profile.avatar + '.png'"
                                        class="w-16 h-16 rounded-full mb-2" :alt="profile.name">
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
                        class="w-full py-3 bg-yellow-400 text-yellow-900 rounded-xl shadow-md transform transition hover:bg-yellow-300 focus:outline-none focus:ring-4 focus:ring-yellow-200">
                        Create New Player
                    </button>
                </template>

                <!-- New profile form -->
                <template x-if="showNewProfileForm">
                    <div class="space-y-4">
                        <div>
                            <label for="profileName" class="block text-sm font-medium text-gray-700 mb-1">Name</label>
                            <input type="text" id="profileName" x-model="newProfileName"
                                class="w-full p-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"
                                placeholder="Enter your name">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Choose an Avatar</label>
                            <div class="grid grid-cols-4 gap-2">
                                <template x-for="avatar in avatars" :key="avatar">
                                    <button class="p-1 border-2 rounded-lg transition"
                                        :class="{
                                            'border-blue-500 bg-blue-50': newProfileAvatar ===
                                                avatar,
                                            'border-gray-200': newProfileAvatar !== avatar
                                        }"
                                        @click="newProfileAvatar = avatar">
                                        <img :src="'{{ asset('images/avatars/' + avatar + '.png'') }}" class="w-12 h-12 rounded-full"
                                            :alt="'Avatar ' + avatar">
                                    </button>
                                </template>
                            </div>
                        </div>

                        <div class="flex space-x-2">
                            <button @click="showNewProfileForm = false"
                                class="flex-1 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300">
                                Cancel
                            </button>
                            <button @click="createProfile()"
                                class="flex-1 py-2 bg-green-500 text-white rounded-md hover:bg-green-600"
                                :disabled="!isValidProfile" :class="{ 'opacity-50 cursor-not-allowed': !isValidProfile }">
                                Create
                            </button>
                        </div>
                    </div>
                </template>

                <!-- Action buttons -->
                <template x-if="selectedProfile && !showNewProfileForm">
                    <div class="mt-6 flex space-x-3">
                        <button @click="showProfileSelector = false; startGame()"
                            class="flex-1 py-3 bg-green-500 text-white rounded-xl shadow-md hover:bg-green-600">
                            Start Playing!
                        </button>
                        <button @click="deleteProfile(selectedProfile)"
                            class="py-3 px-4 bg-red-100 text-red-700 rounded-xl hover:bg-red-200" title="Delete Profile">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
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

    <!-- Alpine.js component for profile selection -->
    <script>
        function profileSelector() {
            return {
                // Profile data
                profiles: [],
                selectedProfile: null,
                showNewProfileForm: false,

                // New profile form
                newProfileName: '',
                newProfileAvatar: 'fox',
                avatars: ['fox', 'panda', 'owl', 'rabbit', 'turtle', 'penguin', 'lion', 'monkey'],

                // Computed property for form validation
                get isValidProfile() {
                    return this.newProfileName.trim().length > 0 && this.newProfileAvatar;
                },

                // Initialize component
                init() {
                    // Load profiles from local storage
                    const storedProfiles = localStorage.getItem('digitalino_profiles');
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
                },

                // Select an existing profile
                selectProfile(profileId) {
                    this.selectedProfile = profileId;

                    // Update local storage
                    const profileData = {
                        currentProfile: profileId,
                        list: this.profiles
                    };

                    localStorage.setItem('digitalino_profiles', JSON.stringify(profileData));
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

                        localStorage.setItem('digitalino_profiles', JSON.stringify(profileData));
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
