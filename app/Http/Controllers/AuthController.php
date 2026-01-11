<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\FirebaseService;

class AuthController extends Controller
{
    protected $firebase;

    public function __construct(FirebaseService $firebase)
    {
        $this->firebase = $firebase;
    }

    public function showLogin()
    {
        if (session('user_id')) {
            return redirect()->route('tugas.index');
        }
        return view('auth.login');
    }

    public function showRegister()
    {
        if (session('user_id')) {
            return redirect()->route('tugas.index');
        }
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'password' => 'required|min:6|confirmed',
        ]);

        try {
            // Jika email sudah terdaftar, tampilkan error yang jelas
            if ($this->firebase->userExistsByEmail($validated['email'])) {
                return back()->withErrors(['email' => 'Email ini sudah terdaftar. Silakan login.'])->withInput();
            }

            $user = $this->firebase->createUser($validated['email'], $validated['password']);

            // Simpan user profile ke Firebase database
            $this->firebase->saveUserProfile($user->uid, [
                'name' => $validated['name'],
                'email' => $validated['email'],
                'created_at' => now()->toDateTimeString(),
            ]);

            session([
                'user_id' => $user->uid,
                'email' => $validated['email'],
                'name' => $validated['name'],
            ]);

            return redirect()->route('tugas.index')->with('success', 'Registrasi berhasil!');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage())->withInput();
        }
    }

    public function login(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        try {
            $signInResult = $this->firebase->signIn($validated['email'], $validated['password']);
            $userId = $signInResult->firebaseUserId();

            // Fetch user profile dari Firebase database
            $userProfile = $this->firebase->getUserProfile($userId);

            session([
                'user_id' => $userId,
                'email' => $userProfile['email'] ?? $validated['email'],
                'name' => $userProfile['name'] ?? 'User',
                'id_token' => $signInResult->idToken(),
            ]);

            if ($request->has('fcm_token')) {
                session(['fcm_token' => $request->fcm_token]);
            }

            return redirect()->route('tugas.index')->with('success', 'Login berhasil!');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage())->withInput();
        }
    }

    public function logout()
    {
        session()->flush();
        return redirect()->route('login')->with('success', 'Logout berhasil!');
    }

    public function saveFcmToken(Request $request)
    {
        $request->validate([
            'token' => 'required|string',
        ]);
        session(['fcm_token' => $request->token]);

        // Persist token ke Firebase agar bisa dipakai untuk reminder terjadwal
        try {
            $userId = session('user_id');
            if ($userId) {
                $this->firebase->updateUserProfile($userId, [
                    'fcm_token' => $request->token,
                    'updated_at' => now()->toDateTimeString(),
                ]);
            }
        } catch (\Throwable $e) {
            // Abaikan error, tetap balikan success agar UX lancar
        }

        return response()->json(['success' => true]);
    }

    public function me()
    {
        $userId = session('user_id');
        $profile = [];
        if ($userId) {
            try {
                $profile = $this->firebase->getUserProfile($userId);
            } catch (\Throwable $e) {
                $profile = [];
            }
        }

        return response()->json([
            'user_id' => $userId,
            'email' => session('email'),
            'name' => session('name'),
            'session_fcm_token' => session('fcm_token'),
            'profile_fcm_token' => $profile['fcm_token'] ?? null,
        ]);
    }
}
