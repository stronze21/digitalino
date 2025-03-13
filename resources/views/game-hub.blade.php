<!-- resources/views/game-hub.blade.php -->
@extends('layouts.app')

@section('title', 'Game Hub - DIGITALINO')

@section('content')
    <div class="py-6" x-data="gameHub()">
        <!-- Profile summary bar -->
        <div class="bg-white rounded-xl shadow-md p-4 mb-6 flex items-center justify-between">
            <div class="flex items-center">
                <template x-if="currentProfile">
                    <div class="flex items-center">
                        <img :src="'/images/avatars/' + currentProfile.avatar + '.png'"
                            class="w-12 h-12 rounded-full border-2 border-purple-400" :alt="currentProfile.name">
                        <div class="ml-3">
                            <h2 class="font-bold text-gray-800" x-text="currentProfile.name"></h2>
                            <div class="flex items-center">
                                <span class="text-sm text-gray-600 mr-2"
                                    x-text="'Level ' + currentProfile.progress.currentLevel"></span>
                                <div class="flex">
                                    <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                    <span class="text-sm text-gray-600 ml-1"
                                        x-text="currentProfile.progress.totalStars"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </template>

                <template x-if="!currentProfile">
                    <div class="text-gray-600">
                        No profile selected.
                        <a href="/" class="text-blue-500 hover:underline">Go back to select a profile</a>
                    </div>
                </template>
            </div>

            <div class="flex items-center space-x-3">
                <!-- Streak counter -->
                <div class="flex items-center bg-orange-100 px-3 py-1 rounded-full">
                    <svg class="w-5 h-5 text-orange-500 mr-1" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M12.395 2.553a1 1 0 00-1.45-.385c-.345.23-.614.558-.822.88-.214.33-.403.713-.57 1.116-.334.804-.614 1.768-.84 2.734a31.365 31.365 0 00-.613 3.58 2.64 2.64 0 01-.945-1.067c-.328-.68-.398-1.534-.398-2.654A1 1 0 005.05 6.05 6.981 6.981 0 003 11a7 7 0 1011.95-4.95c-.592-.591-.98-.985-1.348-1.467-.363-.476-.724-1.063-1.207-2.03zM12.12 15.12A3 3 0 017 13s.879.5 2.5.5c0-1 .5-4 1.25-4.5.5 1 .786 1.293 1.371 1.879A2.99 2.99 0 0113 13a2.99 2.99 0 01-.879 2.121z"
                            clip-rule="evenodd" />
                    </svg>
                    <span class="font-medium text-orange-800"
                        x-text="dailyStreak + ' day' + (dailyStreak !== 1 ? 's' : '')"></span>
                </div>

                <!-- Change profile button -->
                <a href="/" class="bg-purple-100 text-purple-700 p-2 rounded-full hover:bg-purple-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path
                            d="M8 9a3 3 0 100-6 3 3 0 000 6zM8 11a6 6 0 016 6H2a6 6 0 016-6zM16 7a1 1 0 10-2 0v1h-1a1 1 0 100 2h1v1a1 1 0 102 0v-1h1a1 1 0 100-2h-1V7z" />
                    </svg>
                </a>
            </div>
        </div>

        <!-- Game categories -->
        <h2 class="text-2xl font-bold text-gray-800 mb-4">Choose a fun math activity!</h2>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Number Recognition -->
            <div
                class="game-card bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl shadow-lg overflow-hidden transition-transform hover:scale-105">
                <div class="p-5">
                    <h3 class="text-xl font-bold text-white mb-2">Number Recognition</h3>
                    <p class="text-blue-100 mb-4">Learn to identify numbers with animal friends!</p>

                    <div class="flex justify-between items-end">
                        <div>
                            <div class="flex mb-1">
                                <template x-for="i in getSkillLevel('numbers')">
                                    <svg class="w-5 h-5 text-yellow-300 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                </template>
                            </div>
                            <span class="text-xs text-blue-100">Level <span x-text="getSkillLevel('numbers')"></span></span>
                        </div>
                        <button @click="startGame('number-recognition')"
                            class="px-4 py-2 bg-white text-blue-600 rounded-lg font-semibold shadow-md hover:bg-blue-50">
                            Play
                        </button>
                    </div>
                </div>
                <img src="/images/games/number-recognition.png" alt="Number Recognition" class="w-full h-32 object-cover">
            </div>

            <!-- Counting Game -->
            <div
                class="game-card bg-gradient-to-br from-green-500 to-green-600 rounded-2xl shadow-lg overflow-hidden transition-transform hover:scale-105">
                <div class="p-5">
                    <h3 class="text-xl font-bold text-white mb-2">Counting Adventure</h3>
                    <p class="text-green-100 mb-4">Count objects and help animals collect treats!</p>

                    <div class="flex justify-between items-end">
                        <div>
                            <div class="flex mb-1">
                                <template x-for="i in getSkillLevel('counting')">
                                    <svg class="w-5 h-5 text-yellow-300 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                </template>
                            </div>
                            <span class="text-xs text-green-100">Level <span
                                    x-text="getSkillLevel('counting')"></span></span>
                        </div>
                        <button @click="startGame('counting-game')"
                            class="px-4 py-2 bg-white text-green-600 rounded-lg font-semibold shadow-md hover:bg-green-50">
                            Play
                        </button>
                    </div>
                </div>
                <img src="/images/games/counting-game.png" alt="Counting Game" class="w-full h-32 object-cover">
            </div>

            <!-- Addition Game -->
            <div
                class="game-card bg-gradient-to-br from-purple-500 to-purple-600 rounded-2xl shadow-lg overflow-hidden transition-transform hover:scale-105">
                <div class="p-5">
                    <h3 class="text-xl font-bold text-white mb-2">Addition Fun</h3>
                    <p class="text-purple-100 mb-4">Learn to add numbers with fun puzzles!</p>

                    <div class="flex justify-between items-end">
                        <div>
                            <div class="flex mb-1">
                                <template x-for="i in getSkillLevel('addition')">
                                    <svg class="w-5 h-5 text-yellow-300 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                </template>
                            </div>
                            <span class="text-xs text-purple-100">Level <span
                                    x-text="getSkillLevel('addition')"></span></span>
                        </div>
                        <button @click="startGame('addition-game')"
                            class="px-4 py-2 bg-white text-purple-600 rounded-lg font-semibold shadow-md hover:bg-purple-50">
                            Play
                        </button>
                    </div>
                </div>
                <img src="/images/games/addition-game.png" alt="Addition Game" class="w-full h-32 object-cover">
            </div>

            <!-- Shapes Recognition -->
            <div
                class="game-card bg-gradient-to-br from-orange-500 to-orange-600 rounded-2xl shadow-lg overflow-hidden transition-transform hover:scale-105">
                <div class="p-5">
                    <h3 class="text-xl font-bold text-white mb-2">Shape Explorer</h3>
                    <p class="text-orange-100 mb-4">Discover and learn different shapes!</p>

                    <div class="flex justify-between items-end">
                        <div>
                            <div class="flex mb-1">
                                <template x-for="i in getSkillLevel('shapes')">
                                    <svg class="w-5 h-5 text-yellow-300 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                </template>
                            </div>
                            <span class="text-xs text-orange-100">Level <span
                                    x-text="getSkillLevel('shapes')"></span></span>
                        </div>
                        <button @click="startGame('shapes-game')"
                            class="px-4 py-2 bg-white text-orange-600 rounded-lg font-semibold shadow-md hover:bg-orange-50">
                            Play
                        </button>
                    </div>
                </div>
                <img src="/images/games/shapes-game.png" alt="Shapes Game" class="w-full h-32 object-cover">
            </div>

            <!-- Subtraction Game -->
            <div
                class="game-card bg-gradient-to-br from-pink-500 to-pink-600 rounded-2xl shadow-lg overflow-hidden transition-transform hover:scale-105">
                <div class="p-5">
                    <h3 class="text-xl font-bold text-white mb-2">Subtraction Safari</h3>
                    <p class="text-pink-100 mb-4">Learn subtraction with jungle animals!</p>

                    <div class="flex justify-between items-end">
                        <div>
                            <div class="flex mb-1">
                                <template x-for="i in getSkillLevel('subtraction')">
                                    <svg class="w-5 h-5 text-yellow-300 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                </template>
                            </div>
                            <span class="text-xs text-pink-100">Level <span
                                    x-text="getSkillLevel('subtraction')"></span></span>
                        </div>
                        <button @click="startGame('subtraction-game')"
                            class="px-4 py-2 bg-white text-pink-600 rounded-lg font-semibold shadow-md hover:bg-pink-50">
                            Play
                        </button>
                    </div>
                </div>
                <img src="/images/games/subtraction-game.png" alt="Subtraction Game" class="w-full h-32 object-cover">
            </div>

            <!-- Measurement Game -->
            {{-- <div
                class="game-card bg-gradient-to-br from-teal-500 to-teal-600 rounded-2xl shadow-lg overflow-hidden transition-transform hover:scale-105">
                <div class="p-5">
                    <h3 class="text-xl font-bold text-white mb-2">Size & Measurement</h3>
                    <p class="text-teal-100 mb-4">Compare sizes and learn about measurement!</p>

                    <div class="flex justify-between items-end">
                        <div>
                            <div class="flex mb-1">
                                <template
                                    x-for="i in Math.min(3, currentProfile ? currentProfile.progress.currentLevel : 1)">
                                    <svg class="w-5 h-5 text-yellow-300 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                </template>
                            </div>
                            <span class="text-xs text-teal-100">Coming Soon!</span>
                        </div>
                        <button
                            class="px-4 py-2 bg-white text-teal-600 rounded-lg font-semibold shadow-md opacity-50 cursor-not-allowed"
                            disabled>
                            Soon
                        </button>
                    </div>
                </div>
                <img src="/images/games/measurement-game.png" alt="Measurement Game"
                    class="w-full h-32 object-cover opacity-75">
            </div> --}}
        </div>
    </div>

    <!-- Alpine.js component for game hub -->
    <script>
        function gameHub() {
            return {
                currentProfile: null,
                dailyStreak: 0,

                init() {
                    // Load profile data
                    const storedProfiles = localStorage.getItem('digitalino_profiles');
                    if (storedProfiles) {
                        try {
                            const profileData = JSON.parse(storedProfiles);
                            if (profileData && profileData.currentProfile) {
                                const profile = profileData.list.find(p => p.id === profileData.currentProfile);
                                if (profile) {
                                    this.currentProfile = profile;
                                }
                            }
                        } catch (e) {
                            console.error('Failed to parse profiles:', e);
                        }
                    }

                    // Load streak data
                    const activityData = localStorage.getItem('digitalino_activity');
                    if (activityData) {
                        try {
                            const activity = JSON.parse(activityData);
                            if (activity && activity.dailyStreak) {
                                this.dailyStreak = activity.dailyStreak;
                            }
                        } catch (e) {
                            console.error('Failed to parse activity data:', e);
                        }
                    }

                    // Redirect if no profile selected
                    if (!this.currentProfile) {
                        // Give a slight delay to show the message
                        setTimeout(() => {
                            //window.location.href = '/';
                        }, 3000);
                    }
                },

                // Get skill level for a particular skill
                getSkillLevel(skill) {
                    if (!this.currentProfile || !this.currentProfile.progress.skillLevels[skill]) {
                        return 1;
                    }
                    return this.currentProfile.progress.skillLevels[skill];
                },

                // Start a specific game
                startGame(gameId) {
                    // Redirect to the game page
                    window.location.href = '/games/' + gameId;
                }
            };
        }
    </script>
@endsection
