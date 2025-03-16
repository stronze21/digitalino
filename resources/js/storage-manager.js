// resources/js/storage-manager.js

import { persist } from '@alpinejs/persist'

/**
 * Storage Manager for NUMZOO
 * Handles all local storage operations for the stateless application
 */
export default function initStorageManager() {
    return {
        // Use Alpine.js persist for automatic storage sync
        progress: persist({
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
        }).as('numzoo_progress'),

        // Game profiles for multiple users on same device
        profiles: persist({
            currentProfile: null,
            list: []
        }).as('numzoo_profiles'),

        // Game settings
        settings: persist({
            soundEnabled: true,
            musicEnabled: true,
            animationsEnabled: true,
            colorScheme: 'default',
            language: 'en',
            difficultyAdjustment: 'auto',
            characterName: 'Digi'
        }).as('numzoo_settings'),

        // Recent activity tracking
        recentActivity: persist({
            lastPlayedGame: null,
            lastPlayTime: null,
            sessionDuration: 0,
            dailyStreak: 0,
            lastActiveDate: null
        }).as('numzoo_activity'),

        /**
         * Initialize storage
         */
        init() {
            // Check if it's the first time launching the app
            if (!localStorage.getItem('numzoo_initialized')) {
                this.resetToDefaults();
                localStorage.setItem('numzoo_initialized', 'true');
            }

            // Update daily streak
            this.updateDailyStreak();
        },

        /**
         * Reset all data to defaults
         */
        resetToDefaults() {
            this.progress = {
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
            };

            this.profiles = {
                currentProfile: null,
                list: []
            };

            this.settings = {
                soundEnabled: true,
                musicEnabled: true,
                animationsEnabled: true,
                colorScheme: 'default',
                language: 'en',
                difficultyAdjustment: 'auto',
                characterName: 'Digi'
            };

            this.recentActivity = {
                lastPlayedGame: null,
                lastPlayTime: null,
                sessionDuration: 0,
                dailyStreak: 0,
                lastActiveDate: null
            };
        },

        /**
         * Create a new user profile
         * @param {string} name - Name of the profile
         * @param {string} avatar - Selected avatar image
         */
        createProfile(name, avatar) {
            const newProfile = {
                id: Date.now().toString(),
                name,
                avatar,
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

            this.profiles.list.push(newProfile);
            this.selectProfile(newProfile.id);
        },

        /**
         * Select a user profile
         * @param {string} profileId - ID of the profile to select
         */
        selectProfile(profileId) {
            const profile = this.profiles.list.find(p => p.id === profileId);

            if (profile) {
                this.profiles.currentProfile = profileId;
                this.progress = { ...profile.progress };
            }
        },

        /**
         * Update game progress
         * @param {string} gameId - ID of the completed game
         * @param {number} score - Score achieved
         * @param {number} starsEarned - Stars earned in this game
         */
        updateProgress(gameId, score, starsEarned) {
            // Add to completed games if not already present
            if (!this.progress.completedGames.includes(gameId)) {
                this.progress.completedGames.push(gameId);
            }

            // Update total stars
            this.progress.totalStars += starsEarned;

            // Extract skill category from gameId (e.g., "counting-1" -> "counting")
            const skillCategory = gameId.split('-')[0];

            // Update skill level if this category exists
            if (this.progress.skillLevels[skillCategory] !== undefined) {
                // Calculate new level based on score (simplified example)
                const currentLevel = this.progress.skillLevels[skillCategory];
                const scoreThreshold = 0.7; // 70% correct to advance

                if (score >= scoreThreshold && this.isLastGameInLevel(gameId, currentLevel)) {
                    this.progress.skillLevels[skillCategory] += 1;
                }
            }

            // Update overall level based on average of skill levels
            const skillValues = Object.values(this.progress.skillLevels);
            const averageSkillLevel = skillValues.reduce((sum, val) => sum + val, 0) / skillValues.length;
            this.progress.currentLevel = Math.floor(averageSkillLevel);

            // Sync with current profile if one is selected
            this.syncProfileProgress();

            // Update activity tracking
            this.trackActivity(gameId);
        },

        /**
         * Check if this is the last game in the current level
         * @param {string} gameId - ID of the completed game
         * @param {number} currentLevel - Current level in this skill
         * @returns {boolean} - Whether this is the last game
         */
        isLastGameInLevel(gameId, currentLevel) {
            // This is simplified - would need game config data
            // to determine the actual progression structure
            return gameId.endsWith(`-${currentLevel}-3`);
        },

        /**
         * Sync current progress to selected profile
         */
        syncProfileProgress() {
            if (this.profiles.currentProfile) {
                const profileIndex = this.profiles.list.findIndex(
                    p => p.id === this.profiles.currentProfile
                );

                if (profileIndex >= 0) {
                    this.profiles.list[profileIndex].progress = { ...this.progress };
                }
            }
        },

        /**
         * Track user activity
         * @param {string} gameId - ID of the played game
         */
        trackActivity(gameId) {
            const now = new Date();

            this.recentActivity.lastPlayedGame = gameId;
            this.recentActivity.lastPlayTime = now.toISOString();

            // Update daily streak
            this.updateDailyStreak();
        },

        /**
         * Update daily streak counter
         */
        updateDailyStreak() {
            const now = new Date();
            const today = now.toISOString().split('T')[0];

            if (this.recentActivity.lastActiveDate) {
                const lastDate = new Date(this.recentActivity.lastActiveDate);
                const lastDay = lastDate.toISOString().split('T')[0];

                const yesterday = new Date(now);
                yesterday.setDate(now.getDate() - 1);
                const yesterdayStr = yesterday.toISOString().split('T')[0];

                if (lastDay === today) {
                    // Already counted today
                    return;
                } else if (lastDay === yesterdayStr) {
                    // Yesterday - increment streak
                    this.recentActivity.dailyStreak++;
                } else {
                    // Streak broken
                    this.recentActivity.dailyStreak = 1;
                }
            } else {
                // First day
                this.recentActivity.dailyStreak = 1;
            }

            this.recentActivity.lastActiveDate = today;
        },

        /**
         * Export user data as JSON
         * @returns {string} - JSON string of user data
         */
        exportData() {
            const exportData = {
                profiles: this.profiles,
                currentProgress: this.progress,
                settings: this.settings,
                activity: this.recentActivity,
                exportDate: new Date().toISOString()
            };

            return JSON.stringify(exportData);
        },

        /**
         * Import user data from JSON
         * @param {string} jsonData - JSON string to import
         * @returns {boolean} - Success status
         */
        importData(jsonData) {
            try {
                const data = JSON.parse(jsonData);

                // Validate data structure
                if (!data.profiles || !data.currentProgress || !data.settings) {
                    return false;
                }

                // Apply imported data
                this.profiles = data.profiles;
                this.progress = data.currentProgress;
                this.settings = data.settings;

                if (data.activity) {
                    this.recentActivity = data.activity;
                }

                return true;
            } catch (error) {
                console.error('Failed to import data:', error);
                return false;
            }
        }
    };
}
