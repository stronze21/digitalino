<!-- resources/views/games/shapes-game.blade.php -->
@extends('layouts.app')

@section('title', 'Shape Explorer - DIGITALINO')

@section('content')
    <div class="py-4 relative" x-data="shapesGame()" x-init="initGame()">
        <!-- Game header -->
        <div class="mb-6 flex justify-between items-center">
            <div class="flex items-center">
                <button @click="goToHub()" class="mr-4 bg-white p-2 rounded-full shadow-md hover:bg-gray-100">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-600" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </button>
                <h1 class="text-2xl font-bold text-orange-600">Shape Explorer</h1>
            </div>

            <!-- Progress and score -->
            <div class="flex items-center">
                <div class="bg-orange-100 rounded-full h-4 w-32 overflow-hidden mr-3">
                    <div class="bg-orange-500 h-full transition-all duration-300 ease-out"
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
                    <h2 class="text-2xl font-bold text-gray-800 mb-4">Welcome to Shape Explorer!</h2>
                    <p class="text-lg text-gray-600 mb-6">Discover and learn different shapes!</p>

                    <div class="flex justify-center mb-8">
                        <img src="/images/characters/lion.png" alt="Teacher Lion" class="h-40">
                    </div>

                    <div class="max-w-md mx-auto bg-orange-50 rounded-xl p-4 mb-6 text-left">
                        <p class="text-orange-800 mb-2">In this game, you will:</p>
                        <ul class="text-orange-700 space-y-2 list-disc list-inside">
                            <li>Learn to identify different shapes</li>
                            <li>Match shapes with their names</li>
                            <li>Earn stars for correct answers</li>
                        </ul>
                    </div>

                    <button @click="startGame()"
                        class="px-8 py-3 bg-orange-500 text-white text-lg rounded-full shadow-md hover:bg-orange-600 transform transition hover:scale-105">
                        Let's Start!
                    </button>
                </div>
            </template>

            <!-- Active gameplay -->
            <template x-if="gameState === 'playing'">
                <div>
                    <!-- Question display -->
                    <div class="mb-8 text-center">
                        <h2 class="text-xl text-gray-700 mb-4" x-text="questionPrompt"></h2>

                        <template x-if="questionType === 'nameToShape'">
                            <div class="flex justify-center">
                                <div class="bg-orange-100 rounded-2xl px-8 py-4 inline-flex items-center">
                                    <span class="text-3xl font-bold text-orange-600"
                                        x-text="currentQuestion > 0 && questions.length >= currentQuestion ? questions[currentQuestion - 1].targetName : ''"></span>
                                </div>
                            </div>
                        </template>

                        <template x-if="questionType === 'shapeToName'">
                            <div class="flex justify-center">
                                <div class="bg-orange-100 rounded-2xl p-4 inline-flex items-center">
                                    <img :src="'/images/shapes/' + currentShape.fileName + '.png'"
                                        class="h-28 object-contain" :alt="currentShape.name">
                                </div>
                            </div>
                        </template>
                    </div>

                    <!-- Answer options for name to shape -->
                    <template x-if="questionType === 'nameToShape'">
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-4 max-w-3xl mx-auto">
                            <template x-for="(option, index) in shapeOptions" :key="index">
                                <div class="bg-white border-2 rounded-xl shadow-md p-4 flex justify-center cursor-pointer transition transform hover:scale-105"
                                    :class="{
                                        'border-gray-200': selectedAnswer === null,
                                        'border-green-500 bg-green-50': selectedAnswer === index && isAnswerCorrect,
                                        'border-red-500 bg-red-50': selectedAnswer === index && !isAnswerCorrect,
                                        'opacity-60': selectedAnswer !== null && selectedAnswer !== index
                                    }"
                                    @click="checkAnswer(index)">
                                    <img :src="'/images/shapes/' + option.fileName + '.png'" class="h-20 object-contain"
                                        :alt="option.name">
                                </div>
                            </template>
                        </div>
                    </template>

                    <!-- Answer options for shape to name -->
                    <template x-if="questionType === 'shapeToName'">
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-4 max-w-3xl mx-auto">
                            <template x-for="(option, index) in nameOptions" :key="index">
                                <div class="bg-white border-2 rounded-xl shadow-md p-4 text-center cursor-pointer transition transform hover:scale-105"
                                    :class="{
                                        'border-gray-200': selectedAnswer === null,
                                        'border-green-500 bg-green-50': selectedAnswer === index && isAnswerCorrect,
                                        'border-red-500 bg-red-50': selectedAnswer === index && !isAnswerCorrect,
                                        'opacity-60': selectedAnswer !== null && selectedAnswer !== index
                                    }"
                                    @click="checkAnswer(index)">
                                    <span class="text-xl font-bold"
                                        :class="{
                                            'text-gray-800': selectedAnswer === null || (selectedAnswer !== index),
                                            'text-green-600': selectedAnswer === index && isAnswerCorrect,
                                            'text-red-600': selectedAnswer === index && !isAnswerCorrect
                                        }"
                                        x-text="option"></span>
                                </div>
                            </template>
                        </div>
                    </template>

                    <!-- Feedback and continuation -->
                    <div x-show="selectedAnswer !== null" class="mt-8 text-center" style="display: none;">
                        <p class="text-xl mb-4"
                            :class="{ 'text-green-600': isAnswerCorrect, 'text-red-600': !isAnswerCorrect }">
                            <span x-show="isAnswerCorrect">Great job! That's correct!</span>
                            <span x-show="!isAnswerCorrect">
                                <template x-if="questionType === 'nameToShape'">
                                    Oops! This is a <span x-text="currentShape.name"></span>
                                </template>
                                <template x-if="questionType === 'shapeToName'">
                                    Oops! This shape is called a <span x-text="currentShape.name"></span>
                                </template>
                            </span>
                        </p>

                        <button @click="nextQuestion()"
                            class="px-6 py-2 bg-orange-500 text-white rounded-full shadow-md hover:bg-orange-600">
                            <span x-text="currentQuestion < totalQuestions ? 'Next Question' : 'See Results'"></span>
                        </button>
                    </div>
                </div>
            </template>

            <!-- Results screen -->
            <template x-if="gameState === 'results'">
                <div class="text-center py-6">
                    <h2 class="text-2xl font-bold text-gray-800 mb-2">Great Job!</h2>
                    <p class="text-lg text-gray-600 mb-8">You completed the shape explorer challenge!</p>

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
                                <img src="/images/characters/lion-happy.png" alt="Happy Lion" class="h-40 mx-auto">
                                <p class="text-green-600 font-medium mt-2">You're a shape master!</p>
                            </div>
                        </template>

                        <template x-if="scorePercentage >= 50 && scorePercentage < 80">
                            <div class="text-center">
                                <img src="/images/characters/lion.png" alt="Lion" class="h-40 mx-auto">
                                <p class="text-blue-600 font-medium mt-2">Good shape recognition!</p>
                            </div>
                        </template>

                        <template x-if="scorePercentage < 50">
                            <div class="text-center">
                                <img src="/images/characters/lion-thinking.png" alt="Thinking Lion" class="h-40 mx-auto">
                                <p class="text-purple-600 font-medium mt-2">Let's practice more shapes!</p>
                            </div>
                        </template>
                    </div>

                    <!-- Action buttons -->
                    <div class="flex justify-center space-x-4">
                        <button @click="resetGame()"
                            class="px-6 py-3 bg-orange-500 text-white rounded-full shadow-md hover:bg-orange-600">
                            Play Again
                        </button>

                        <button @click="goToHub()"
                            class="px-6 py-3 bg-purple-500 text-white rounded-full shadow-md hover:bg-purple-600">
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

    <!-- Alpine.js component for the shapes game -->
    <script>
        function shapesGame() {
            return {
                // Game state
                gameState: 'intro', // 'intro', 'playing', 'results'
                currentQuestion: 0,
                totalQuestions: 10,
                questions: [],
                questionType: 'nameToShape', // 'nameToShape' or 'shapeToName'
                questionPrompt: '',
                currentShape: null,
                shapeOptions: [],
                nameOptions: [],
                selectedAnswer: null,
                isAnswerCorrect: false,

                // Score tracking
                score: 0,
                correctAnswers: 0,
                scorePercentage: 0,

                // Game configuration
                difficultyLevel: 1,

                // Shapes database
                shapes: [{
                        name: 'Circle',
                        fileName: 'circle',
                        level: 1
                    },
                    {
                        name: 'Square',
                        fileName: 'square',
                        level: 1
                    },
                    {
                        name: 'Triangle',
                        fileName: 'triangle',
                        level: 1
                    },
                    {
                        name: 'Rectangle',
                        fileName: 'rectangle',
                        level: 1
                    },
                    {
                        name: 'Oval',
                        fileName: 'oval',
                        level: 2
                    },
                    {
                        name: 'Diamond',
                        fileName: 'diamond',
                        level: 2
                    },
                    {
                        name: 'Star',
                        fileName: 'star',
                        level: 2
                    },
                    {
                        name: 'Heart',
                        fileName: 'heart',
                        level: 2
                    },
                    {
                        name: 'Pentagon',
                        fileName: 'pentagon',
                        level: 3
                    },
                    {
                        name: 'Hexagon',
                        fileName: 'hexagon',
                        level: 3
                    },
                    {
                        name: 'Octagon',
                        fileName: 'octagon',
                        level: 3
                    },
                    {
                        name: 'Crescent',
                        fileName: 'crescent',
                        level: 3
                    },
                    {
                        name: 'Trapezoid',
                        fileName: 'trapezoid',
                        level: 4
                    },
                    {
                        name: 'Parallelogram',
                        fileName: 'parallelogram',
                        level: 4
                    },
                    {
                        name: 'Rhombus',
                        fileName: 'rhombus',
                        level: 4
                    },
                    {
                        name: 'Cube',
                        fileName: 'cube',
                        level: 4
                    }
                ],

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
                                    .skillLevels.shapes) {
                                    this.difficultyLevel = profile.progress.skillLevels.shapes;
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
                    this.generateQuestions();
                    this.setupCurrentQuestion();
                },

                // Generate all questions for the game
                generateQuestions() {
                    this.questions = [];

                    // Filter shapes based on difficulty level
                    const availableShapes = this.shapes.filter(shape => shape.level <= this.difficultyLevel);

                    // Shuffle the shapes
                    const shuffledShapes = [...availableShapes];
                    this.shuffle(shuffledShapes);

                    // Generate questions alternating between name->shape and shape->name
                    for (let i = 0; i < this.totalQuestions; i++) {
                        // Ensure we don't run out of shapes
                        const shapeIndex = i % shuffledShapes.length;
                        const questionType = i % 2 === 0 ? 'nameToShape' : 'shapeToName';

                        this.questions.push({
                            shape: shuffledShapes[shapeIndex],
                            type: questionType,
                            targetName: shuffledShapes[shapeIndex].name
                        });
                    }
                },

                // Setup the current question
                setupCurrentQuestion() {
                    if (this.currentQuestion <= 0 || this.currentQuestion > this.questions.length) {
                        return;
                    }

                    const question = this.questions[this.currentQuestion - 1];
                    this.questionType = question.type;
                    this.currentShape = question.shape;

                    if (this.questionType === 'nameToShape') {
                        this.questionPrompt = 'Find the shape:';
                        this.generateShapeOptions();
                    } else { // shapeToName
                        this.questionPrompt = 'What is this shape called?';
                        this.generateNameOptions();
                    }
                },

                // Generate shape options for name->shape questions
                generateShapeOptions() {
                    // Current correct shape
                    const correctShape = this.currentShape;

                    // Add correct shape to options
                    this.shapeOptions = [correctShape];

                    // Add distractors based on difficulty
                    const availableShapes = this.shapes.filter(shape =>
                        shape.level <= this.difficultyLevel &&
                        shape.name !== correctShape.name
                    );

                    this.shuffle(availableShapes);

                    // Number of options based on difficulty
                    const numOptions = this.difficultyLevel <= 2 ? 3 : 6;

                    // Add distractor shapes
                    for (let i = 0; i < numOptions - 1 && i < availableShapes.length; i++) {
                        this.shapeOptions.push(availableShapes[i]);
                    }

                    // Shuffle options
                    this.shuffle(this.shapeOptions);
                },

                // Generate name options for shape->name questions
                generateNameOptions() {
                    // Current correct name
                    const correctName = this.currentShape.name;

                    // Add correct name to options
                    this.nameOptions = [correctName];

                    // Add distractors based on difficulty
                    const availableNames = this.shapes
                        .filter(shape =>
                            shape.level <= this.difficultyLevel &&
                            shape.name !== correctName
                        )
                        .map(shape => shape.name);

                    this.shuffle(availableNames);

                    // Number of options based on difficulty
                    const numOptions = this.difficultyLevel <= 2 ? 3 : 6;

                    // Add distractor names
                    for (let i = 0; i < numOptions - 1 && i < availableNames.length; i++) {
                        this.nameOptions.push(availableNames[i]);
                    }

                    // Shuffle options
                    this.shuffle(this.nameOptions);
                },

                // Check if the selected answer is correct
                checkAnswer(index) {
                    if (this.selectedAnswer !== null) return; // Already answered

                    this.selectedAnswer = index;

                    if (this.questionType === 'nameToShape') {
                        const selectedShape = this.shapeOptions[index];
                        this.isAnswerCorrect = selectedShape.name === this.currentShape.name;
                    } else { // shapeToName
                        const selectedName = this.nameOptions[index];
                        this.isAnswerCorrect = selectedName === this.currentShape.name;
                    }

                    if (this.isAnswerCorrect) {
                        this.correctAnswers++;
                        this.score += 1;
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
                        this.setupCurrentQuestion();
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
                    const gameId = 'shapes-game';
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
                                        .shapes) {
                                        profile.progress.skillLevels.shapes += 1;
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
