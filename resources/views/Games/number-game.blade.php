<!-- resources/views/games/number-game.blade.php -->
@extends('layouts.app')

@section('title', 'Number Recognition - NUMZOO')

@section('content')
    <div class="relative py-4" x-data="numberGame()" x-init="initGame()">
        <!-- Game header -->
        <div class="flex items-center justify-between mb-6">
            <div class="flex items-center">
                <button @click="goToHub()" class="p-2 mr-4 bg-white rounded-full shadow-md hover:bg-gray-100">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-gray-600" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </button>
                <h1 class="text-2xl font-bold text-blue-600">Number Recognition</h1>
            </div>

            <!-- Progress and score -->
            <div class="flex items-center">
                <div class="w-32 h-4 mr-3 overflow-hidden bg-blue-100 rounded-full">
                    <div class="h-full transition-all duration-300 ease-out bg-blue-500"
                        :style="'width: ' + (currentQuestion / totalQuestions * 100) + '%'"></div>
                </div>
                <div class="flex items-center px-3 py-1 bg-yellow-100 rounded-full">
                    <svg class="w-5 h-5 mr-1 text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
                        <path
                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                    </svg>
                    <span class="font-medium text-yellow-800" x-text="score"></span>
                </div>
            </div>
        </div>

        <!-- Main game area -->
        <div class="p-6 mb-6 bg-white shadow-lg rounded-2xl">
            <!-- Game instructions -->
            <template x-if="gameState === 'intro'">
                <div class="py-6 text-center">
                    <h2 class="mb-4 text-2xl font-bold text-gray-800">Welcome to Number Recognition!</h2>
                    <p class="mb-6 text-lg text-gray-600">Help our animal friends learn their numbers!</p>

                    <div class="flex justify-center mb-8">
                        <img src="/images/characters/owl.png" alt="Teacher Owl" class="h-40">
                    </div>

                    <div class="max-w-md p-4 mx-auto mb-6 text-left bg-blue-50 rounded-xl">
                        <p class="mb-2 text-blue-800">In this game, you will:</p>
                        <ul class="space-y-2 text-blue-700 list-disc list-inside">
                            <li>See a number on the screen</li>
                            <li>Choose the animal holding the matching number</li>
                            <li>Earn stars for correct answers</li>
                        </ul>
                    </div>

                    <button @click="startGame()"
                        class="px-8 py-3 text-lg text-white transition transform bg-blue-500 rounded-full shadow-md hover:bg-blue-600 hover:scale-105">
                        Let's Start!
                    </button>
                </div>
            </template>

            <!-- Active gameplay -->
            <template x-if="gameState === 'playing'">
                <div>
                    <!-- Question display -->
                    <div class="mb-8 text-center">
                        <h2 class="mb-2 text-xl text-gray-700">Find the number:</h2>
                        <div class="flex justify-center">
                            <span class="inline-block px-8 py-4 font-bold text-blue-600 bg-blue-100 text-8xl rounded-2xl"
                                x-text="currentQuestion > 0 && questions.length >= currentQuestion ? questions[currentQuestion - 1].target : ''"></span>
                        </div>
                    </div>

                    <!-- Answer options -->
                    <div class="grid max-w-3xl grid-cols-2 gap-4 mx-auto md:grid-cols-3">
                        <template x-for="(option, index) in currentOptions" :key="index">
                            <div class="relative transition transform cursor-pointer hover:scale-105"
                                :class="{
                                    'opacity-50 pointer-events-none': selectedAnswer !== null && selectedAnswer !==
                                        index
                                }"
                                @click="checkAnswer(index)">
                                <div
                                    class="p-3 overflow-hidden shadow-md bg-gradient-to-b from-yellow-100 to-yellow-200 rounded-xl">
                                    <div class="flex flex-col items-center p-2">
                                        <img :src="'/images/characters/' + option.animal + '.png'"
                                            class="object-contain h-24 mb-2" :alt="option.animal">
                                        <div class="flex items-center justify-center w-12 h-12 bg-white rounded-full">
                                            <span class="text-2xl font-bold" x-text="option.number"></span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Feedback indicator (right/wrong) -->
                                <div x-show="selectedAnswer === index"
                                    class="absolute inset-0 flex items-center justify-center rounded-xl"
                                    :class="{
                                        'bg-green-300 bg-opacity-30': isAnswerCorrect,
                                        'bg-red-300 bg-opacity-30': !
                                            isAnswerCorrect
                                    }"
                                    style="display: none;">
                                    <div class="p-2 rounded-full"
                                        :class="{ 'bg-green-100': isAnswerCorrect, 'bg-red-100': !isAnswerCorrect }">
                                        <svg x-show="isAnswerCorrect" class="w-8 h-8 text-green-600" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 13l4 4L19 7" />
                                        </svg>
                                        <svg x-show="!isAnswerCorrect" class="w-8 h-8 text-red-600" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </template>
                    </div>

                    <!-- Feedback and continuation -->
                    <div x-show="selectedAnswer !== null" class="mt-8 text-center" style="display: none;">
                        <p class="mb-4 text-xl"
                            :class="{ 'text-green-600': isAnswerCorrect, 'text-red-600': !isAnswerCorrect }">
                            <span x-show="isAnswerCorrect">Great job! That's correct!</span>
                            <span x-show="!isAnswerCorrect">Oops! The correct answer was <span
                                    x-text="correctAnswer"></span></span>
                        </p>

                        <button @click="nextQuestion()"
                            class="px-6 py-2 text-white bg-blue-500 rounded-full shadow-md hover:bg-blue-600">
                            <span x-text="currentQuestion < totalQuestions ? 'Next Question' : 'See Results'"></span>
                        </button>
                    </div>
                </div>
            </template>

            <!-- Results screen -->
            <template x-if="gameState === 'results'">
                <div class="py-6 text-center">
                    <h2 class="mb-2 text-2xl font-bold text-gray-800">Great Job!</h2>
                    <p class="mb-8 text-lg text-gray-600">You completed the number recognition challenge!</p>

                    <!-- Score display -->
                    <div class="flex justify-center mb-6">
                        <div class="px-8 py-6 text-center bg-yellow-100 rounded-2xl">
                            <p class="mb-2 text-gray-700">Your score:</p>
                            <div class="flex items-center justify-center">
                                <span class="mr-2 text-4xl font-bold text-yellow-600" x-text="score"></span>
                                <svg class="w-8 h-8 text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                            </div>
                            <p class="mt-2 text-gray-600"
                                x-text="correctAnswers + ' out of ' + totalQuestions + ' correct'"></p>
                        </div>
                    </div>

                    <!-- Character reaction -->
                    <div class="flex justify-center mb-8">
                        <template x-if="scorePercentage >= 80">
                            <div class="text-center">
                                <img src="{{ secure_asset('images/characters/panda-happy.png') }}" alt="Happy Panda"
                                    class="h-40 mx-auto">
                                <p class="mt-2 font-medium text-green-600">Fantastic work!</p>
                            </div>
                        </template>

                        <template x-if="scorePercentage >= 50 && scorePercentage < 80">
                            <div class="text-center">
                                <img src="{{ secure_asset('images/characters/fox-smile.png') }}" alt="Smiling Fox"
                                    class="h-40 mx-auto">
                                <p class="mt-2 font-medium text-blue-600">Good job!</p>
                            </div>
                        </template>

                        <template x-if="scorePercentage < 50">
                            <div class="text-center">
                                <img src="{{ secure_asset('images/characters/rabbit-thinking.png') }}"
                                    alt="Thinking Rabbit" class="h-40 mx-auto">
                                <p class="mt-2 font-medium text-purple-600">Let's try again!</p>
                            </div>
                        </template>
                    </div>

                    <!-- Action buttons -->
                    <div class="flex justify-center space-x-4">
                        <button @click="resetGame()"
                            class="px-6 py-3 text-white bg-blue-500 rounded-full shadow-md hover:bg-blue-600">
                            Play Again
                        </button>

                        <button @click="goToHub()"
                            class="px-6 py-3 text-white bg-purple-500 rounded-full shadow-md hover:bg-purple-600">
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

    <!-- Alpine.js component for the number game -->
    <script>
        function numberGame() {
            return {
                // Game state
                gameState: 'intro', // 'intro', 'playing', 'results'
                currentQuestion: 0,
                totalQuestions: 10,
                questions: [],
                currentOptions: [],
                selectedAnswer: null,
                isAnswerCorrect: false,
                correctAnswer: null,

                // Score tracking
                score: 0,
                correctAnswers: 0,
                scorePercentage: 0,

                // Game configuration
                difficultyLevel: 1,

                // Animals for the game
                animals: ['panda', 'fox', 'owl', 'rabbit', 'turtle', 'penguin', 'lion', 'monkey'],

                // Initialize the game
                initGame() {
                    // Load difficulty level from profile if available
                    const storedProfiles = localStorage.getItem('numzoo_profiles');
                    if (storedProfiles) {
                        try {
                            const profileData = JSON.parse(storedProfiles);
                            if (profileData && profileData.currentProfile) {
                                const profile = profileData.list.find(p => p.id === profileData.currentProfile);
                                if (profile && profile.progress && profile.progress.skillLevels && profile.progress
                                    .skillLevels.numbers) {
                                    this.difficultyLevel = profile.progress.skillLevels.numbers;
                                }
                            }
                        } catch (e) {
                            console.error('Failed to parse profiles:', e);
                        }
                    }

                    // Generate questions based on difficulty
                    this.generateQuestions();
                },

                // Generate game questions
                generateQuestions() {
                    this.questions = [];

                    // Define number range based on difficulty
                    let minNumber = 1;
                    let maxNumber = 5;

                    switch (this.difficultyLevel) {
                        case 1:
                            maxNumber = 5;
                            break;
                        case 2:
                            maxNumber = 10;
                            break;
                        case 3:
                            minNumber = 5;
                            maxNumber = 15;
                            break;
                        case 4:
                            minNumber = 10;
                            maxNumber = 20;
                            break;
                        default:
                            maxNumber = 5;
                    }

                    // Generate unique target numbers
                    const numbers = [];
                    for (let i = minNumber; i <= maxNumber; i++) {
                        numbers.push(i);
                    }

                    // Shuffle the numbers
                    this.shuffle(numbers);

                    // Take first totalQuestions numbers or as many as available
                    const numQuestions = Math.min(this.totalQuestions, numbers.length);
                    const targetNumbers = numbers.slice(0, numQuestions);

                    // Create questions with target numbers
                    for (let target of targetNumbers) {
                        this.questions.push({
                            target: target
                        });
                    }

                    // If we don't have enough numbers, generate some duplicates with different presentations
                    while (this.questions.length < this.totalQuestions) {
                        // Get a random target from what we already have
                        const randomIndex = Math.floor(Math.random() * targetNumbers.length);
                        const target = targetNumbers[randomIndex];

                        this.questions.push({
                            target: target
                        });
                    }

                    console.log(
                    `Generated ${this.questions.length} questions for difficulty level ${this.difficultyLevel}`);
                },

                // Start the game
                startGame() {
                    this.gameState = 'playing';
                    this.currentQuestion = 1;
                    this.score = 0;
                    this.correctAnswers = 0;
                    this.selectedAnswer = null;
                    this.generateOptions();
                },

                // Generate options for the current question
                generateOptions() {
                    // Check if we have a valid current question
                    if (!this.questions || this.questions.length === 0 || this.currentQuestion <= 0 || this
                        .currentQuestion > this.questions.length) {
                        console.error('No valid question available at index:', this.currentQuestion - 1);
                        return;
                    }

                    const currentTarget = this.questions[this.currentQuestion - 1].target;
                    const options = [];

                    // Add the correct answer
                    options.push({
                        number: currentTarget,
                        animal: this.getRandomAnimal()
                    });

                    // Add distractors based on difficulty
                    const numberOfOptions = this.difficultyLevel <= 2 ? 3 : 4;

                    // Define range for distractors
                    let minDistractor = Math.max(1, currentTarget - 5);
                    let maxDistractor = currentTarget + 5;

                    // Generate unique distractors
                    while (options.length < numberOfOptions) {
                        let distractor;

                        // For level 1, make distractors visually distinct
                        if (this.difficultyLevel === 1) {
                            const possibleDistractors = [1, 2, 3, 4, 5].filter(n => n !== currentTarget);
                            distractor = possibleDistractors[Math.floor(Math.random() * possibleDistractors.length)];
                        } else {
                            distractor = Math.floor(Math.random() * (maxDistractor - minDistractor + 1)) + minDistractor;
                        }

                        // Ensure distractor is unique and not the target
                        if (distractor !== currentTarget && !options.some(option => option.number === distractor)) {
                            options.push({
                                number: distractor,
                                animal: this.getRandomAnimal(options.map(o => o.animal))
                            });
                        }
                    }

                    // Shuffle options
                    this.shuffle(options);
                    this.currentOptions = options;
                },

                // Check if the selected answer is correct
                checkAnswer(index) {
                    if (this.selectedAnswer !== null) return; // Already answered

                    // Safety check for current question and options
                    if (!this.questions ||
                        this.currentQuestion <= 0 ||
                        this.currentQuestion > this.questions.length ||
                        !this.currentOptions ||
                        index >= this.currentOptions.length) {
                        console.error('Invalid state in checkAnswer: ', {
                            hasQuestions: !!this.questions,
                            currentQuestion: this.currentQuestion,
                            questionsLength: this.questions ? this.questions.length : 0,
                            hasOptions: !!this.currentOptions,
                            optionsLength: this.currentOptions ? this.currentOptions.length : 0,
                            index: index
                        });
                        return;
                    }

                    this.selectedAnswer = index;
                    const selectedNumber = this.currentOptions[index].number;
                    const targetNumber = this.questions[this.currentQuestion - 1].target;

                    this.isAnswerCorrect = selectedNumber === targetNumber;

                    if (this.isAnswerCorrect) {
                        this.correctAnswers++;
                        this.score += 1;
                        try {
                            document.getElementById('correct-sound').play();
                        } catch (e) {
                            console.error('Error playing sound:', e);
                        }
                    } else {
                        try {
                            document.getElementById('incorrect-sound').play();
                        } catch (e) {
                            console.error('Error playing sound:', e);
                        }
                        // Find the correct answer
                        for (let i = 0; i < this.currentOptions.length; i++) {
                            if (this.currentOptions[i].number === targetNumber) {
                                this.correctAnswer = this.currentOptions[i].number;
                                break;
                            }
                        }
                    }
                },

                // Move to the next question
                nextQuestion() {
                    // Increment the question counter
                    this.currentQuestion++;

                    // Reset selection state
                    this.selectedAnswer = null;
                    this.isAnswerCorrect = false;
                    this.correctAnswer = null;

                    // Check if we're at the end of the game
                    if (this.currentQuestion > this.totalQuestions) {
                        this.gameState = 'results';
                        this.scorePercentage = (this.correctAnswers / this.totalQuestions) * 100;
                        try {
                            document.getElementById('complete-sound').play();
                        } catch (e) {
                            console.error('Error playing sound:', e);
                        }
                        this.saveProgress();
                        return;
                    }

                    // Make sure we have enough questions
                    if (this.questions.length < this.currentQuestion) {
                        console.error(
                            `Not enough questions generated. Have ${this.questions.length}, need at least ${this.currentQuestion}`
                            );
                        // Generate more questions if needed
                        while (this.questions.length < this.totalQuestions) {
                            this.generateAdditionalQuestion();
                        }
                    }

                    // Generate options for this question
                    this.generateOptions();
                },

                // Generate an additional question if we run out
                generateAdditionalQuestion() {
                    // Define number range based on difficulty
                    let minNumber = 1;
                    let maxNumber = 5;

                    switch (this.difficultyLevel) {
                        case 1:
                            maxNumber = 5;
                            break;
                        case 2:
                            maxNumber = 10;
                            break;
                        case 3:
                            minNumber = 5;
                            maxNumber = 15;
                            break;
                        case 4:
                            minNumber = 10;
                            maxNumber = 20;
                            break;
                        default:
                            maxNumber = 5;
                    }

                    // Generate a new target number different from existing ones
                    let targetNumber;
                    const existingTargets = this.questions.map(q => q.target);

                    do {
                        targetNumber = Math.floor(Math.random() * (maxNumber - minNumber + 1)) + minNumber;
                    } while (existingTargets.includes(targetNumber));

                    // Add the new question
                    this.questions.push({
                        target: targetNumber
                    });
                },

                // Reset the game to play again
                resetGame() {
                    this.generateQuestions();
                    this.startGame();
                },

                // Go back to the game hub
                goToHub() {
                    window.location.href = '/game-hub';
                },

                // Save progress to local storage
                saveProgress() {
                    const gameId = 'number-recognition';
                    const starsEarned = Math.ceil(this.scorePercentage / 20); // 0-5 stars based on percentage

                    // Get storage data
                    const activityData = localStorage.getItem('numzoo_activity');
                    if (activityData) {
                        try {
                            const activity = JSON.parse(activityData);
                            activity.lastPlayedGame = gameId;
                            activity.lastPlayTime = new Date().toISOString();
                            localStorage.setItem('numzoo_activity', JSON.stringify(activity));
                        } catch (e) {
                            console.error('Failed to update activity:', e);
                        }
                    } else {
                        // Create new activity data if it doesn't exist
                        const newActivity = {
                            lastPlayedGame: gameId,
                            lastPlayTime: new Date().toISOString(),
                            dailyStreak: 1
                        };
                        localStorage.setItem('numzoo_activity', JSON.stringify(newActivity));
                    }

                    // Update profile progress
                    const storedProfiles = localStorage.getItem('numzoo_profiles');
                    if (storedProfiles) {
                        try {
                            const profileData = JSON.parse(storedProfiles);
                            if (profileData && profileData.currentProfile) {
                                const profileIndex = profileData.list.findIndex(p => p.id === profileData.currentProfile);
                                if (profileIndex >= 0) {
                                    const profile = profileData.list[profileIndex];

                                    // Initialize completedGames array if it doesn't exist
                                    if (!profile.progress.completedGames) {
                                        profile.progress.completedGames = [];
                                    }

                                    // Add game completion record
                                    const gameCompletion = {
                                        gameId: gameId,
                                        completedAt: new Date().toISOString(),
                                        score: this.score,
                                        maxScore: this.totalQuestions,
                                        starsEarned: starsEarned
                                    };

                                    profile.progress.completedGames.push(gameCompletion);

                                    // Update total stars
                                    profile.progress.totalStars += starsEarned;

                                    // Update skill level if score is high enough
                                    if (this.scorePercentage >= 70 && this.difficultyLevel === profile.progress.skillLevels
                                        .numbers) {
                                        profile.progress.skillLevels.numbers += 1;
                                    }

                                    // Calculate new overall level
                                    const skillValues = Object.values(profile.progress.skillLevels);
                                    const averageSkillLevel = skillValues.reduce((sum, val) => sum + val, 0) / skillValues
                                        .length;
                                    profile.progress.currentLevel = Math.floor(averageSkillLevel);

                                    // Save updated profile
                                    profileData.list[profileIndex] = profile;
                                    localStorage.setItem('numzoo_profiles', JSON.stringify(profileData));
                                }
                            }
                        } catch (e) {
                            console.error('Failed to update profile:', e);
                        }
                    }
                },

                // Helper: Get a random animal
                getRandomAnimal(exclude = []) {
                    const availableAnimals = this.animals.filter(animal => !exclude.includes(animal));
                    return availableAnimals[Math.floor(Math.random() * availableAnimals.length)];
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
