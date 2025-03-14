<!-- resources/views/settings.blade.php -->
@extends('layouts.app')

@section('title', 'Settings - DIGITALINO')

@section('content')
    <div class="max-w-4xl mx-auto py-6">
        <div class="mb-6 flex items-center">
            <a href="{{ route('game-hub') }}" class="mr-4 bg-white p-2 rounded-full shadow-md hover:bg-gray-100">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-600" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </a>
            <h1 class="text-2xl font-bold text-gray-800">Settings</h1>
        </div>

        <div class="bg-white rounded-2xl shadow-lg p-6">
            <div class="text-center py-12">
                <img src="{{ secure_asset('images/characters/owl.png') }}" alt="Owl" class="h-32 mx-auto mb-4">
                <h2 class="text-xl font-bold text-gray-800 mb-4">Settings Access</h2>
                <p class="text-gray-600 mb-6">
                    To access the settings, please click the gear icon in the top right corner of any screen.
                    You will need to enter the parent/teacher PIN to access the settings.
                </p>
                <p class="text-gray-500 text-sm mb-6">
                    Default PIN: 0000
                </p>

                <button class="px-6 py-3 bg-blue-500 text-white rounded-xl hover:bg-blue-600 transition"
                    onclick="window.openSettings()">
                    Open Settings
                </button>
            </div>
        </div>

        <div class="mt-8 bg-white rounded-2xl shadow-lg p-6">
            <h2 class="text-xl font-bold text-gray-800 mb-4">Settings Help</h2>

            <div class="space-y-6">
                <div>
                    <h3 class="font-medium text-lg text-gray-800 mb-2">Sound Settings</h3>
                    <p class="text-gray-600">
                        Control sound effects and background music for the application.
                    </p>
                </div>

                <div>
                    <h3 class="font-medium text-lg text-gray-800 mb-2">Appearance</h3>
                    <p class="text-gray-600">
                        Adjust animations and color schemes to customize the visual experience.
                    </p>
                </div>

                <div>
                    <h3 class="font-medium text-lg text-gray-800 mb-2">Accessibility</h3>
                    <p class="text-gray-600">
                        Configure break reminders and font size for better accessibility.
                    </p>
                </div>

                <div>
                    <h3 class="font-medium text-lg text-gray-800 mb-2">Game Settings</h3>
                    <p class="text-gray-600">
                        Adjust difficulty settings and game parameters.
                    </p>
                </div>

                <div>
                    <h3 class="font-medium text-lg text-gray-800 mb-2">Data Management</h3>
                    <p class="text-gray-600">
                        Export and import user data for backup or transferring between devices.
                    </p>
                </div>

                <div>
                    <h3 class="font-medium text-lg text-gray-800 mb-2">Reset Options</h3>
                    <p class="text-gray-600">
                        Reset settings to defaults or clear all progress data.
                    </p>
                </div>

                <div>
                    <h3 class="font-medium text-lg text-gray-800 mb-2">Security</h3>
                    <p class="text-gray-600">
                        Change the PIN required to access settings.
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection
