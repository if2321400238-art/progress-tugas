<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Services\FirebaseService;

class ProfileController extends Controller
{
    protected $firebase;

    public function __construct(FirebaseService $firebase)
    {
        $this->firebase = $firebase;
    }

    public function edit(Request $request)
    {
        $user = $request->user();
        return view('profile.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
        ]);

        // Update session dengan data terbaru
        session([
            'name' => $validated['name'],
            'email' => $validated['email'],
        ]);

        // Update ke Firebase Realtime Database (user profile)
        try {
            $userId = session('user_id');
            $this->firebase->updateUserProfile($userId, [
                'name' => $validated['name'],
                'email' => $validated['email'],
                'updated_at' => now()->toDateTimeString(),
            ]);
        } catch (\Exception $e) {
            \Log::error('Firebase update error: ' . $e->getMessage());
        }

        return Redirect::route('profile.edit')->with('status', 'Profil berhasil diperbarui');
    }
}

