<!-- resources/views/games/addition-game.blade.php -->
@extends('layouts.app')

@section('title', 'Addition Fun - DIGITALINO')

@section('content')
    <div class="py-4 relative" x-data="additionGame()" x-init="initGame()">
        <!-- Game header -->
        <div class="mb-6 flex justify-between items-center">
            <div class="flex items-center">
                <button @click="goToHub()" class="mr-4 bg-white p-2 rounded-full shadow-md hover:bg-gray-100">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-600" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </button>
                <h1 class="text-2xl font-bold text-purple-600">Addition Fun</h1>
            </div>

            <!-- Progress and score -->
            <div class="flex items-center">
                <div class="bg-purple-100 rounded-full h-4 w-32 overflow-hidden mr-3">
                    <div class="bg-purple-500 h-full transition-all duration-300 ease-out"
                        :style="'width: ' + (currentQuestion / totalQuestions * 100) + '%'"></div>
                </div>
                <div class="flex items-center bg-yellow-100 px-3 py-1 rounded-full">
                    <svg class="w-5 h-5 text-yellow-500 mr-1" fill="currentColor" viewBox="0 0 20 20">
                        <path
                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                    </svg>
                    <span class="font-medium text-yellow-800" x-text="score"></span>
                </div>
            </div>
        </div>

        <!-- Main game area -->
        <div class="bg-white rounded-2xl shadow-lg p-6 mb-6">
            <!-- Game instructions -->
            <template x-if="gameState === 'intro'">
                <div class="text-center py-6">
                    <h2 class="text-2xl font-bold text-gray-800 mb-4">Welcome to Addition Fun!</h2>
                    <p class="text-lg text-gray-600 mb-6">Help our animal friends solve addition problems!</p>

                    <div class="flex justify-center mb-8">
                        <img src="/images/characters/fox.png" alt="Teacher Fox" class="h-40">
                    </div>

                    <div class="max-w-md mx-auto bg-purple-50 rounded-xl p-4 mb-6 text-left">
                        <p class="text-purple-800 mb-2">In this game, you will:</p>
                        <ul class="text-purple-700 space-y-2 list-disc list-inside">
                            <li>See an addition problem</li>
                            <li>Choose the correct answer</li>
                            <li>Earn stars for correct answers</li>
                        </ul>
                    </div>

                    <button @click="startGame()"
                        class="px-8 py-3 bg-purple-500 text-white text-lg rounded-full shadow-md hover:bg-purple-600 transform transition hover:scale-105">
                        Let's Start!
                    </button>
                </div>
            </template>

            <!-- Active gameplay -->
            <template x-if="gameState === 'playing'">
                <div>
                    <!-- Question display -->
                    <div class="mb-8 text-center">
                        <h2 class="text-xl text-gray-700 mb-4">What is the sum?</h2>

                        <div class="flex justify-center items-center">
                            <div class="bg-purple-100 rounded-2xl p-6 inline-flex items-center text-4xl font-bold">
                                <div class="bg-white rounded-lg p-4 shadow-md mr-4">
                                    <span class="text-purple-600" x-text="currentProblem.num1"></span>
                                </div>
                                <div class="text-purple-600 mr-4">+</div>
                                <div class="bg-white rounded-lg p-4 shadow-md mr-4">
                                    <span class="text-purple-600" x-text="currentProblem.num2"></span>
                                </div>
                                <div class="text-purple-600 mr-4">=</div>
                                <div class="bg-white rounded-lg p-4 shadow-md border-2 border-dashed border-purple-300">
                                    <span class="text-gray-400">?</span>
                                </div>
                            </div>
                        </div>

                        <!-- Visual representation (for level 1) -->
                        <template x-if="difficultyLevel === 1">
                            <div class="mt-6 flex justify-center">
                                <div class="bg-white rounded-xl p-4 shadow-md flex flex-col items-center">
                                    <div class="mb-4 flex justify-center">
                                        <template x-for="i in currentProblem.num1">
                                            <img src="/images/counting/star.png" class="h-8 w-8 mx-1" alt="star">
                                        </template>
                                    </div>
                                    <div class="border-b-2 border-gray-200 w-full mb-4"></div>
                                    <div class="flex justify-center">
                                        <template x-for="i in currentProblem.num2">
                                            <img src="/images/counting/star.png" class="h-8 w-8 mx-1" alt="star">
                                        </template>
                                    </div>
                                </div>
                            </div>
                        </template>
                    </div>

                    <!-- Answer options -->
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 max-w-2xl mx-auto">
                        <template x-for="(option, index) in answerOptions" :key="index">
                            <div class="bg-white border-2 rounded-xl shadow-md p-4 text-center cursor-pointer transition transform hover:scale-105"
                                :class="{
                                    'border-gray-200': selectedAnswer === null,
                                    'border-green-500 bg-green-50': selectedAnswer === index && isAnswerCorrect,
                                    'border-red-500 bg-red-50': selectedAnswer === index && !isAnswerCorrect,
                                    'opacity-60': selectedAnswer !== null && selectedAnswer !== index
                                }"
                                @click="checkAnswer(index)">
                                <span class="text-3xl font-bold"
                                    :class="{
                                        'text-gray-800': selectedAnswer === null || (selectedAnswer !== index),
                                        'text-green-600': selectedAnswer === index && isAnswerCorrect,
                                        'text-red-600': selectedAnswer === index && !isAnswerCorrect
                                    }"
                                    x-text="option"></span>
                            </div>
                        </template>
                    </div>

                    <!-- Feedback and continuation -->
                    <div x-show="selectedAnswer !== null" class="mt-8 text-center" style="display: none;">
                        <p class="text-xl mb-4"
                            :class="{ 'text-green-600': isAnswerCorrect, 'text-red-600': !isAnswerCorrect }">
                            <span x-show="isAnswerCorrect">Great job! That's correct!</span>
                            <span x-show="!isAnswerCorrect">Oops! The correct answer was <span
                                    x-text="currentProblem.num1 + currentProblem.num2"></span></span>
                        </p>

                        <button @click="nextQuestion()"
                            class="px-6 py-2 bg-purple-500 text-white rounded-full shadow-md hover:bg-purple-600">
                            <span x-text="currentQuestion < totalQuestions ? 'Next Question' : 'See Results'"></span>
                        </button>
                    </div>
                </div>
            </template>

            <!-- Results screen -->
            <template x-if="gameState === 'results'">
                <div class="text-center py-6">
                    <h2 class="text-2xl font-bold text-gray-800 mb-2">Great Job!</h2>
                    <p class="text-lg text-gray-600 mb-8">You completed the addition challenge!</p>

                    <!-- Score display -->
                    <div class="flex justify-center mb-6">
                        <div class="bg-yellow-100 rounded-2xl px-8 py-6 text-center">
                            <p class="text-gray-700 mb-2">Your score:</p>
                            <div class="flex items-center justify-center">
                                <span class="text-4xl font-bold text-yellow-600 mr-2" x-text="score"></span>
                                <svg class="w-8 h-8 text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                            </div>
                            <p class="text-gray-600 mt-2"
                                x-text="correctAnswers + ' out of ' + totalQuestions + ' correct'"></p>
                        </div>
                    </div>

                    <!-- Character reaction -->
                    <div class="flex justify-center mb-8">
                        <template x-if="scorePercentage >= 80">
                            <div class="text-center">
                                <img src="/images/characters/fox-happy.png" alt="Happy Fox" class="h-40 mx-auto">
                                <p class="text-green-600 font-medium mt-2">Fantastic adding!</p>
                            </div>
                        </template>

                        <template x-if="scorePercentage >= 50 && scorePercentage < 80">
                            <div class="text-center">
                                <img src="/images/characters/fox.png" alt="Fox" class="h-40 mx-auto">
                                <p class="text-blue-600 font-medium mt-2">Good work!</p>
                            </div>
                        </template>

                        <template x-if="scorePercentage < 50">
                            <div class="text-center">
                                <img src="/images/characters/fox-thinking.png" alt="Thinking Fox" class="h-40 mx-auto">
                                <p class="text-purple-600 font-medium mt-2">Let's practice more!</p>
                            </div>
                        </template>
                    </div>

                    <!-- Action buttons -->
                    <div class="flex justify-center space-x-4">
                        <button @click="resetGame()"
                            class="px-6 py-3 bg-purple-500 text-white rounded-full shadow-md hover:bg-purple-600">
                            Play Again
                        </button>

                        <button @click="goToHub()"
                            class="px-6 py-3 bg-green-500 text-white rounded-full shadow-md hover:bg-green-600">
                            Back to Games
                        </button>
                    </div>
                </div>
            </template>
        </div>

        <!-- Sound effects (hidden) -->
        <audio id="correct-sound" src="/sounds/correct.mp3" preload="auto"></audio>
        <audio id="incorrect-sound" src="/sounds/incorrect.mp3" preload="auto"></audio>
        <audio id="complete-sound" src="/sounds/complete.mp3" preload="auto"></audio>
    </div>

    <!-- Alpine.js component for the addition game -->
    <script>
        function additionGame() {
            return {
                // Game state
                gameState: 'intro', // 'intro', 'playing', 'results'
                currentQuestion: 0,
                totalQuestions: 10,
                currentProblem: {
                    num1: 0,
                    num2: 0
                },
                answerOptions: [],
                selectedAnswer: null,
                isAnswerCorrect: false,

                // Score tracking
                score: 0,
                correctAnswers: 0,
                scorePercentage: 0,

                // Game configuration
                difficultyLevel: 1,

                // Initialize the game
                initGame() {
                    // Load difficulty level from profile if available
                    const storedProfiles = localStorage.getItem('digitalino_profiles');
                    if (storedProfiles) {
                        try {
                            const profileData = JSON.parse(storedProfiles);
                            if (profileData && profileData.currentProfile) {
                                const profile = profileData.list.find(p => p.id === profileData.currentProfile);
                                if (profile && profile.progress && profile.progress.skillLevels && profile.progress
                                    .skillLevels.addition) {
                                    this.difficultyLevel = profile.progress.skillLevels.addition;
                                }
                            }
                        } catch (e) {
                            console.error('Failed to parse profiles:', e);
                        }
                    }
                },

                // Start the game
                startGame() {
                    this.gameState = 'playing';
                    this.currentQuestion = 1;
                    this.score = 0;
                    this.correctAnswers = 0;
                    this.selectedAnswer = null;
                    this.generateQuestion();
                },

                // Generate a new addition problem
                generateQuestion() {
                    // Define number range based on difficulty
                    let max1 = 5;
                    let max2 = 5;

                    switch (this.difficultyLevel) {
                        case 1:
                            max1 = 5;
                            max2 = 5;
                            break;
                        case 2:
                            max1 = 10;
                            max2 = 10;
                            break;
                        case 3:
                            max1 = 20;
                            max2 = 10;
                            break;
                        case 4:
                            max1 = 20;
                            max2 = 20;
                            break;
                        default:
                            max1 = 5;
                            max2 = 5;
                    }

                    // Generate random numbers for the problem
                    const num1 = Math.floor(Math.random() * max1) + 1;
                    const num2 = Math.floor(Math.random() * max2) + 1;

                    this.currentProblem = {
                        num1,
                        num2
                    };

                    // Generate answer options
                    this.generateAnswerOptions(num1 + num2);
                },

                // Generate answer options for the current problem
                generateAnswerOptions(correctSum) {
                    const options = [correctSum];

                    // Add distractors
                    while (options.length < 4) {
                        // Generate a distractor that's close to the correct sum
                        let distractor;

                        // For level 1, make distractors more distinct
                        if (this.difficultyLevel === 1) {
                            distractor = Math.floor(Math.random() * 10) + 1; // 1-10
                        } else {
                            // Generate distractors within ±3 of the correct sum, but ensure they're unique
                            const offset = Math.floor(Math.random() * 7) - 3; // -3 to +3
                            distractor = Math.max(1, correctSum + offset);
                        }

                        // Ensure distractor is unique and not the correct sum
                        if (distractor !== correctSum && !options.includes(distractor)) {
                            options.push(distractor);
                        }
                    }

                    // Shuffle options
                    this.shuffle(options);
                    this.answerOptions = options;
                },

                // Check if the selected answer is correct
                checkAnswer(index) {
                    if (this.selectedAnswer !== null) return; // Already answered

                    this.selectedAnswer = index;
                    const selectedSum = this.answerOptions[index];
                    const correctSum = this.currentProblem.num1 + this.currentProblem.num2;

                    this.isAnswerCorrect = selectedSum === correctSum;

                    if (this.isAnswerCorrect) {
                        this.correctAnswers++;
                        this.score += 10;
                        document.getElementById('correct-sound').play();
                    } else {
                        document.getElementById('incorrect-sound').play();
                    }
                },

                // Move to the next question
                nextQuestion() {
                    if (this.currentQuestion < this.totalQuestions) {
                        this.currentQuestion++;
                        this.selectedAnswer = null;
                        this.generateQuestion();
                    } else {
                        this.gameState = 'results';
                        this.scorePercentage = (this.correctAnswers / this.totalQuestions) * 100;
                        document.getElementById('complete-sound').play();
                        this.saveProgress();
                    }
                },

                // Reset the game to play again
                resetGame() {
                    this.startGame();
                },

                // Go back to the game hub
                goToHub() {
                    window.location.href = '/game-hub';
                },

                // Save progress to local storage
                saveProgress() {
                    const gameId = 'addition-game';
                    const starsEarned = Math.ceil(this.scorePercentage / 20); // 0-5 stars based on percentage

                    // Get storage data
                    const activityData = localStorage.getItem('digitalino_activity');
                    if (activityData) {
                        try {
                            const activity = JSON.parse(activityData);
                            activity.lastPlayedGame = gameId;
                            activity.lastPlayTime = new Date().toISOString();
                            localStorage.setItem('digitalino_activity', JSON.stringify(activity));
                        } catch (e) {
                            console.error('Failed to update activity:', e);
                        }
                    }

                    // Update profile progress
                    const storedProfiles = localStorage.getItem('digitalino_profiles');
                    if (storedProfiles) {
                        try {
                            const profileData = JSON.parse(storedProfiles);
                            if (profileData && profileData.currentProfile) {
                                const profileIndex = profileData.list.findIndex(p => p.id === profileData.currentProfile);
                                if (profileIndex >= 0) {
                                    const profile = profileData.list[profileIndex];

                                    // Add game to completed games if not already present
                                    if (!profile.progress.completedGames.includes(gameId)) {
                                        profile.progress.completedGames.push(gameId);
                                    }

                                    // Update total stars
                                    profile.progress.totalStars += starsEarned;

                                    // Update skill level if score is high enough
                                    if (this.scorePercentage >= 70 && this.difficultyLevel === profile.progress.skillLevels
                                        .addition) {
                                        profile.progress.skillLevels.addition += 1;
                                    }

                                    // Calculate new overall level
                                    const skillValues = Object.values(profile.progress.skillLevels);
                                    const averageSkillLevel = skillValues.reduce((sum, val) => sum + val, 0) / skillValues
                                        .length;
                                    profile.progress.currentLevel = Math.floor(averageSkillLevel);

                                    // Save updated profile
                                    profileData.list[profileIndex] = profile;
                                    localStorage.setItem('digitalino_profiles', JSON.stringify(profileData));
                                }
                            }
                        } catch (e) {
                            console.error('Failed to update profile:', e);
                        }
                    }
                },

                // Helper: Shuffle an array
                shuffle(array) {
                    for (let i = array.length - 1; i > 0; i--) {
                        const j = Math.floor(Math.random() * (i + 1));
                        [array[i], array[j]] = [array[j], array[i]];
                    }
                    return array;
                }
            };
        }
    </script>
@endsection
