<!-- resources/views/layouts/app.blade.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="DIGITALINO: A math learning game for kindergarten students">
    <title>DIGITALINO - @yield('title', 'Math Adventure')</title>

    <!-- Prevent caching for development -->
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">

    <!-- PWA Meta Tags -->
    <meta name="theme-color" content="#4CAF50">
    <link rel="manifest" href="/manifest.json">
    <link rel="apple-touch-icon" href="/images/icons/icon-192x192.png">



    <!-- Custom fonts for child-friendly UI -->
    <link href="https://fonts.googleapis.com/css2?family=Comic+Neue:wght@400;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Comic Neue', cursive;
            background-color: #F0FFF0;
        }
    </style>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script>
        window.assetUrl = "{{ asset('') }}";
    </script>
</head>

<body class="antialiased">
    <div id="app" class="min-h-screen">
        <!-- Header with logo -->
        <header class="bg-gradient-to-r from-green-400 to-blue-500 p-4 shadow-md">
            <div class="container mx-auto flex justify-between items-center">
                <div class="flex items-center">
                    <img src="{{ secure_asset('images/logo.png') }}" alt="DIGITALINO Logo" class="h-12 w-auto mr-2">
                    <h1 class="text-2xl font-bold text-white">DIGITALINO</h1>
                </div>


                <!-- Settings button (with PIN protection) -->
                {{-- <button class="p-2 bg-yellow-400 rounded-full shadow-md hover:bg-yellow-300 transition"
                    data-settings-button>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </button> --}}
            </div>
        </header>

        <!-- Main content -->
        <main class="container mx-auto p-4">
            @yield('content')
        </main>

        <!-- Character that follows along all screens -->
        <div class="fixed bottom-4 left-4" x-data="characterHelper()">
            <img :src="{{ asset('images/characters/' + currentCharacter + '.png') }}"
                class="h-24 w-auto cursor-pointer animate-bounce" @click="giveHint()" alt="Helper Character">
        </div>

        <!-- Break reminder notification -->
        <div x-data="breakReminder()" x-show="showReminder" x-transition
            class="fixed top-4 right-4 bg-white p-4 rounded-lg shadow-lg border-2 border-blue-400 max-w-xs"
            style="display: none;">
            <div class="flex items-start">
                <div class="flex-shrink-0 text-blue-500">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-gray-900">Time for a break!</h3>
                    <div class="mt-1 text-sm text-gray-600">
                        <p>Let's rest our eyes for a moment.</p>
                    </div>
                    <div class="mt-2 flex">
                        <button type="button"
                            class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-md text-white bg-blue-600 hover:bg-blue-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                            @click="dismissReminder()">
                            Okay, got it!
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Include settings modal component -->
        @include('components.settings-modal')

        <!-- Include welcome tour component -->
        @include('components.welcome-tour')
    </div>


    <!-- Alpine JS character helper -->
    <script>
        function characterHelper() {
            return {
                characters: ['panda', 'fox', 'owl', 'rabbit', 'turtle'],
                currentCharacter: 'panda',

                init() {
                    // Load preferred character from localStorage if available
                    const savedCharacter = localStorage.getItem('preferredCharacter');
                    if (savedCharacter) {
                        this.currentCharacter = savedCharacter;
                    }

                    // Randomly change character occasionally
                    setInterval(() => {
                        if (Math.random() > 0.9) {
                            this.currentCharacter = this.characters[Math.floor(Math.random() * this.characters
                                .length)];
                        }
                    }, 60000);
                },

                giveHint() {
                    // This would be replaced with context-specific hints
                    alert("I'm here to help! Try your best!");
                }
            }
        }

        function breakReminder() {
            return {
                showReminder: false,

                init() {
                    // Check every 20 minutes if the app is being used
                    setInterval(() => {
                        this.showReminder = true;
                    }, 20 * 60 * 1000);
                },

                dismissReminder() {
                    this.showReminder = false;
                }
            }
        }
    </script>
</body>

</html>
