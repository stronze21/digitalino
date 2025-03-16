<!-- resources/views/about.blade.php -->
@extends('layouts.app')

@section('title', 'About NUMZOO')

@section('content')
    <div class="py-8">
        <div class="max-w-4xl mx-auto">
            <!-- Header section -->
            <div class="text-center mb-10">
                <h1 class="text-3xl md:text-4xl font-bold text-green-600 mb-4">About NUMZOO</h1>
                <p class="text-lg text-gray-600">A fun math learning adventure for kindergarten students</p>
            </div>

            <!-- Main content -->
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden mb-8">
                <div class="md:flex">
                    <div class="md:w-1/3 bg-gradient-to-br from-green-400 to-blue-500 p-6 flex items-center justify-center">
                        <img src="{{ url('') }}/images/mascot.png" alt="NUMZOO Mascot" class="w-48 h-48 object-contain">
                    </div>
                    <div class="md:w-2/3 p-6 md:p-8">
                        <h2 class="text-2xl font-bold text-gray-800 mb-4">Our Mission</h2>
                        <p class="text-gray-700 mb-4">
                            NUMZOO is designed to make learning mathematics fun and engaging for kindergarten learners.
                            Through interactive games featuring colorful animal characters, we aim to help young children
                            develop strong foundational math skills in an enjoyable way.
                        </p>
                        <p class="text-gray-700">
                            Our application aligns with the kindergarten curriculum and focuses on key numeracy skills
                            including number recognition, counting, basic operations, and spatial reasoning.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Educational approach -->
            <div class="bg-white rounded-2xl shadow-lg p-6 md:p-8 mb-8">
                <h2 class="text-2xl font-bold text-gray-800 mb-4">Our Educational Approach</h2>

                <div class="grid md:grid-cols-2 gap-6">
                    <div class="bg-blue-50 rounded-xl p-5">
                        <div class="flex items-center mb-3">
                            <div class="bg-blue-100 p-2 rounded-full mr-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-800">Play-Based Learning</h3>
                        </div>
                        <p class="text-gray-700">
                            We believe that children learn best through play. Our games are designed to be fun while
                            incorporating essential math concepts in a natural, engaging way.
                        </p>
                    </div>

                    <div class="bg-green-50 rounded-xl p-5">
                        <div class="flex items-center mb-3">
                            <div class="bg-green-100 p-2 rounded-full mr-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-600" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-800">Curriculum Aligned</h3>
                        </div>
                        <p class="text-gray-700">
                            All our activities are designed to align with the DepEd's MATATAG curriculum, ensuring that
                            children are developing the skills they need for school success.
                        </p>
                    </div>

                    <div class="bg-purple-50 rounded-xl p-5">
                        <div class="flex items-center mb-3">
                            <div class="bg-purple-100 p-2 rounded-full mr-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-purple-600" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-800">Adaptive Difficulty</h3>
                        </div>
                        <p class="text-gray-700">
                            Our games adjust to each child's ability level, providing just the right amount of challenge to
                            keep them engaged and learning.
                        </p>
                    </div>

                    <div class="bg-yellow-50 rounded-xl p-5">
                        <div class="flex items-center mb-3">
                            <div class="bg-yellow-100 p-2 rounded-full mr-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-yellow-600" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-800">Positive Reinforcement</h3>
                        </div>
                        <p class="text-gray-700">
                            We use stars, badges, and encouraging feedback to motivate children and build confidence in
                            their mathematical abilities.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Features -->
            <div class="bg-white rounded-2xl shadow-lg p-6 md:p-8 mb-8">
                <h2 class="text-2xl font-bold text-gray-800 mb-6">Key Features</h2>

                <ul class="space-y-4">
                    <li class="flex">
                        <svg class="flex-shrink-0 h-6 w-6 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                clip-rule="evenodd" />
                        </svg>
                        <span class="text-gray-700"><strong>Multiple Game Types:</strong> Featuring number recognition,
                            counting, addition, subtraction, and shape identification.</span>
                    </li>
                    <li class="flex">
                        <svg class="flex-shrink-0 h-6 w-6 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                clip-rule="evenodd" />
                        </svg>
                        <span class="text-gray-700"><strong>Cute Animal Characters:</strong> Friendly animal guides that
                            make learning more engaging and relatable for young children.</span>
                    </li>
                    <li class="flex">
                        <svg class="flex-shrink-0 h-6 w-6 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                clip-rule="evenodd" />
                        </svg>
                        <span class="text-gray-700"><strong>Progress Tracking:</strong> Local storage of children's progress
                            to help them see their improvement over time.</span>
                    </li>
                    <li class="flex">
                        <svg class="flex-shrink-0 h-6 w-6 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                clip-rule="evenodd" />
                        </svg>
                        <span class="text-gray-700"><strong>Offline Functionality:</strong> Works without an internet
                            connection, making it accessible anywhere.</span>
                    </li>
                    <li class="flex">
                        <svg class="flex-shrink-0 h-6 w-6 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                clip-rule="evenodd" />
                        </svg>
                        <span class="text-gray-700"><strong>Eye-Friendly Design:</strong> Regular break reminders and
                            child-friendly visuals to protect young eyes.</span>
                    </li>
                </ul>
            </div>

            <!-- The team -->
            <div class="bg-white rounded-2xl shadow-lg p-6 md:p-8">
                <h2 class="text-2xl font-bold text-gray-800 mb-6">Our Team</h2>

                <p class="text-gray-700 mb-6">
                    NUMZOO was developed by a team of Computer Science students from Northwestern University in Laoag
                    City, Ilocos Norte:
                </p>

                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <div class="text-center">
                        <div class="bg-blue-100 rounded-full w-20 h-20 flex items-center justify-center mx-auto mb-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-blue-600" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        <h3 class="font-medium text-gray-800">Mark Angelo C. Campos</h3>
                    </div>

                    <div class="text-center">
                        <div class="bg-green-100 rounded-full w-20 h-20 flex items-center justify-center mx-auto mb-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-green-600" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        <h3 class="font-medium text-gray-800">Benedict L. Agarpao</h3>
                    </div>

                    <div class="text-center">
                        <div class="bg-purple-100 rounded-full w-20 h-20 flex items-center justify-center mx-auto mb-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-purple-600" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        <h3 class="font-medium text-gray-800">Neal Andrei A. Sahagun</h3>
                    </div>

                    <div class="text-center">
                        <div class="bg-orange-100 rounded-full w-20 h-20 flex items-center justify-center mx-auto mb-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-orange-600" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        <h3 class="font-medium text-gray-800">Justine Carl C. Villanueva</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
