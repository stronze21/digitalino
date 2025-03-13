<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SettingsController extends Controller
{
    /**
     * Show the settings view.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('settings');
    }

    /**
     * Save settings via API.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function save(Request $request)
    {
        // Validate the request
        $validated = $request->validate([
            'settings' => 'required|array',
            'settings.soundEnabled' => 'boolean',
            'settings.musicEnabled' => 'boolean',
            'settings.animationsEnabled' => 'boolean',
            'settings.colorScheme' => 'string|in:default,pastel,high-contrast',
            'settings.breakRemindersEnabled' => 'boolean',
            'settings.fontSize' => 'string|in:small,medium,large',
            'settings.difficultyAdjustment' => 'string|in:auto,manual',
        ]);

        // We're just returning the settings to be saved in localStorage
        // In a traditional app, you'd save these to a database
        return response()->json([
            'success' => true,
            'settings' => $validated['settings']
        ]);
    }

    /**
     * Verify PIN.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function verifyPin(Request $request)
    {
        // Validate the request
        $validated = $request->validate([
            'pin' => 'required|string|size:4',
            'storedPin' => 'required|string|size:4',
        ]);

        // In a real app, you might verify against a database
        // Here we're just checking against what's stored in localStorage
        $verified = $validated['pin'] === $validated['storedPin'];

        return response()->json([
            'success' => $verified
        ]);
    }

    /**
     * Export user data.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function exportData(Request $request)
    {
        // The actual data export is handled client-side through localStorage
        // This endpoint just serves to validate and format the data if needed

        return response()->json([
            'success' => true,
            'message' => 'Data ready for export'
        ]);
    }

    /**
     * Import user data.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function importData(Request $request)
    {
        // Validate the uploaded file
        $request->validate([
            'dataFile' => 'required|file|mimes:json|max:1024', // 1MB max
        ]);

        if ($request->hasFile('dataFile')) {
            $file = $request->file('dataFile');

            // Read the file content
            $content = file_get_contents($file->path());

            // Validate the JSON structure
            try {
                $data = json_decode($content, true, 512, JSON_THROW_ON_ERROR);

                // Basic validation that this is DIGITALINO data
                if (!isset($data['profiles']) || !isset($data['settings'])) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Invalid data structure'
                    ], 400);
                }

                return response()->json([
                    'success' => true,
                    'data' => $data
                ]);
            } catch (\Exception $e) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid JSON format'
                ], 400);
            }
        }

        return response()->json([
            'success' => false,
            'message' => 'No file uploaded'
        ], 400);
    }

    /**
     * Reset user data.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function resetData(Request $request)
    {
        // This is handled client-side with localStorage
        // This endpoint could serve as additional security verification

        return response()->json([
            'success' => true,
            'message' => 'Data reset successful'
        ]);
    }
}
