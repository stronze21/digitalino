<!-- resources/views/components/welcome-tour.blade.php -->
<div x-data="welcomeTour()" x-show="isVisible"
    class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50"
    x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" style="display: none;">
    <div class="bg-white rounded-2xl shadow-xl p-6 max-w-md w-full" @click.away="step === 0 ? skipTour() : null">
        <!-- Welcome screen -->
        <template x-if="step === 0">
            <div class="text-center">
                <img src="/images/logo.png" alt="NUMZOO Logo" class="h-24 mx-auto mb-4">
                <h2 class="text-2xl font-bold text-gray-800 mb-2">Welcome to NUMZOO!</h2>
                <p class="text-gray-600 mb-6">
                    A fun learning adventure for kindergarten mathematics
                </p>

                <div class="flex flex-col items-center mb-6">
                    <img src="/images/mascot.png" alt="NUMZOO Mascot" class="h-32 mb-3">
                    <p class="text-sm text-gray-500 italic">
                        "Hi there! I'm Digi, your learning buddy!"
                    </p>
                </div>

                <div class="space-y-3">
                    <button @click="startTour()"
                        class="w-full py-3 bg-blue-500 text-white rounded-xl hover:bg-blue-600 transition">
                        Take a Quick Tour
                    </button>
                    <button @click="skipTour()"
                        class="w-full py-3 bg-gray-200 text-gray-700 rounded-xl hover:bg-gray-300 transition">
                        Skip Tour
                    </button>
                </div>
            </div>
        </template>

        <!-- Tour steps -->
        <template x-if="step === 1">
            <div>
                <div class="text-center mb-4">
                    <h2 class="text-xl font-bold text-gray-800">Create a Profile</h2>
                </div>
                <div class="mb-6">
                    <img src="/images/tour/profiles.png" alt="Profile Creation"
                        class="w-full h-40 object-cover rounded-lg mb-3">
                    <p class="text-gray-600">
                        First, create a profile for your child. This allows us to track their progress and personalize
                        the learning experience.
                    </p>
                </div>
                <div class="flex justify-between">
                    <button @click="step = 0" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300">
                        Back
                    </button>
                    <button @click="step = 2" class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600">
                        Next
                    </button>
                </div>
            </div>
        </template>

        <template x-if="step === 2">
            <div>
                <div class="text-center mb-4">
                    <h2 class="text-xl font-bold text-gray-800">Explore Math Games</h2>
                </div>
                <div class="mb-6">
                    <img src="/images/tour/games.png" alt="Game Hub" class="w-full h-40 object-cover rounded-lg mb-3">
                    <p class="text-gray-600">
                        Choose from different math games designed to build essential numeracy skills. Each game focuses
                        on specific concepts like counting, number recognition, and basic operations.
                    </p>
                </div>
                <div class="flex justify-between">
                    <button @click="step = 1" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300">
                        Back
                    </button>
                    <button @click="step = 3" class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600">
                        Next
                    </button>
                </div>
            </div>
        </template>

        <template x-if="step === 3">
            <div>
                <div class="text-center mb-4">
                    <h2 class="text-xl font-bold text-gray-800">Track Progress</h2>
                </div>
                <div class="mb-6">
                    <img src="/images/tour/progress.png" alt="Progress Tracking"
                        class="w-full h-40 object-cover rounded-lg mb-3">
                    <p class="text-gray-600">
                        Watch your child's progress as they complete games and earn stars. The difficulty adjusts
                        automatically based on their performance.
                    </p>
                </div>
                <div class="flex justify-between">
                    <button @click="step = 2" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300">
                        Back
                    </button>
                    <button @click="step = 4" class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600">
                        Next
                    </button>
                </div>
            </div>
        </template>

        <template x-if="step === 4">
            <div>
                <div class="text-center mb-4">
                    <h2 class="text-xl font-bold text-gray-800">Parent/Teacher Settings</h2>
                </div>
                <div class="mb-6">
                    <img src="/images/tour/settings.png" alt="Settings"
                        class="w-full h-40 object-cover rounded-lg mb-3">
                    <p class="text-gray-600">
                        Access the settings menu (default PIN: 0000) to customize the experience, adjust difficulty,
                        export progress data, and more.
                    </p>
                </div>
                <div class="flex justify-between">
                    <button @click="step = 3" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300">
                        Back
                    </button>
                    <button @click="step = 5" class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600">
                        Next
                    </button>
                </div>
            </div>
        </template>

        <template x-if="step === 5">
            <div>
                <div class="text-center mb-4">
                    <h2 class="text-xl font-bold text-gray-800">You're All Set!</h2>
                </div>
                <div class="flex flex-col items-center mb-6">
                    <img src="/images/characters/panda-happy.png" alt="Happy Panda" class="h-32 mb-3">
                    <p class="text-gray-600 text-center mb-4">
                        You're ready to start the NUMZOO math adventure! Let's create a profile and begin exploring
                        numbers together.
                    </p>
                </div>
                <button @click="finishTour()"
                    class="w-full py-3 bg-green-500 text-white rounded-xl hover:bg-green-600 transition">
                    Let's Start!
                </button>
            </div>
        </template>
    </div>
</div>

<script>
    function welcomeTour() {
        return {
            isVisible: false,
            step: 0,

            // Initialize component
            init() {
                // Check if it's the first time
                const isFirstVisit = !localStorage.getItem('numzoo_initialized');

                if (isFirstVisit) {
                    this.isVisible = true;
                }
            },

            // Start the tour
            startTour() {
                this.step = 1;
            },

            // Skip the tour
            skipTour() {
                this.isVisible = false;
                localStorage.setItem('numzoo_initialized', 'true');
            },

            // Finish the tour
            finishTour() {
                this.isVisible = false;
                localStorage.setItem('numzoo_initialized', 'true');
            }
        };
    }
</script>
