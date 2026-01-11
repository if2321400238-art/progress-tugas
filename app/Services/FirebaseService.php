<?php

namespace App\Services;

use Kreait\Firebase\Factory;
use Kreait\Firebase\Auth;
use Kreait\Firebase\Database;
use Kreait\Firebase\Messaging;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;
use Illuminate\Support\Facades\Log;

class FirebaseService
{
    protected $auth;
    protected $database;
    protected $messaging;

    public function __construct()
    {
        $factory = (new Factory)
            ->withServiceAccount(storage_path('app/firebase/service-account.json'))
            ->withDatabaseUri('https://tugas-22b74-default-rtdb.asia-southeast1.firebasedatabase.app');

        $this->auth = $factory->createAuth();
        $this->database = $factory->createDatabase();
        $this->messaging = $factory->createMessaging();
    }

    // Authentication Methods
    public function createUser($email, $password)
    {
        try {
            return $this->auth->createUserWithEmailAndPassword($email, $password);
        } catch (\Exception $e) {
            throw new \Exception('Gagal membuat user: ' . $e->getMessage());
        }
    }

    public function signIn($email, $password)
    {
        try {
            return $this->auth->signInWithEmailAndPassword($email, $password);
        } catch (\Exception $e) {
            throw new \Exception('Login gagal: ' . $e->getMessage());
        }
    }

    public function verifyIdToken($idToken)
    {
        try {
            return $this->auth->verifyIdToken($idToken);
        } catch (\Exception $e) {
            throw new \Exception('Token tidak valid');
        }
    }

    // Check if a user exists by email in Firebase Auth
    public function userExistsByEmail(string $email): bool
    {
        try {
            $this->auth->getUserByEmail($email);
            return true; // Found
        } catch (\Throwable $e) {
            return false; // Not found
        }
    }

    // Database Methods
    public function saveTugas($data)
    {
        try {
            $reference = $this->database->getReference('tugas')->push($data);
            return $reference->getKey();
        } catch (\Exception $e) {
            throw new \Exception('Gagal menyimpan data: ' . $e->getMessage());
        }
    }

    public function getTugas($userId = null)
    {
        try {
            $reference = $this->database->getReference('tugas');

            if ($userId) {
                $snapshot = $reference->orderByChild('user_id')->equalTo($userId)->getSnapshot();
            } else {
                $snapshot = $reference->getSnapshot();
            }

            return $snapshot->getValue() ?? [];
        } catch (\Exception $e) {
            throw new \Exception('Gagal mengambil data: ' . $e->getMessage());
        }
    }

    public function getTugasById($id)
    {
        try {
            return $this->database->getReference('tugas/' . $id)->getSnapshot()->getValue();
        } catch (\Exception $e) {
            throw new \Exception('Gagal mengambil data: ' . $e->getMessage());
        }
    }

    public function updateTugas($id, $data)
    {
        try {
            $this->database->getReference('tugas/' . $id)->update($data);
            return true;
        } catch (\Exception $e) {
            throw new \Exception('Gagal update data: ' . $e->getMessage());
        }
    }

    public function deleteTugas($id)
    {
        try {
            $this->database->getReference('tugas/' . $id)->remove();
            return true;
        } catch (\Exception $e) {
            throw new \Exception('Gagal hapus data: ' . $e->getMessage());
        }
    }

    // Cloud Messaging Methods
    public function sendNotification($token, $title, $body, $data = [])
    {
        try {
            $notification = Notification::create($title, $body);

            $message = CloudMessage::new()
                ->withToken($token)
                ->withNotification($notification)
                ->withData($data);

            return $this->messaging->send($message);
        } catch (\Exception $e) {
            // Log error tapi jangan throw exception
            Log::error('FCM Error: ' . $e->getMessage());
            return false;
        }
    }

    public function sendNotificationToTopic($topic, $title, $body, $data = [])
    {
        try {
            $notification = Notification::create($title, $body);

            $message = CloudMessage::new()
                ->withTopic($topic)
                ->withNotification($notification)
                ->withData($data);

            return $this->messaging->send($message);
        } catch (\Exception $e) {
            Log::error('FCM Error: ' . $e->getMessage());
            return false;
        }
    }

    // User Profile Methods
    public function updateUserProfile($userId, $data)
    {
        try {
            $this->database->getReference('users/' . $userId)->update($data);
            return true;
        } catch (\Exception $e) {
            throw new \Exception('Gagal update profil: ' . $e->getMessage());
        }
    }

    public function saveUserProfile($userId, $data)
    {
        try {
            $this->database->getReference('users/' . $userId)->set($data);
            return true;
        } catch (\Exception $e) {
            throw new \Exception('Gagal menyimpan profil: ' . $e->getMessage());
        }
    }

    public function getUserProfile($userId)
    {
        try {
            $snapshot = $this->database->getReference('users/' . $userId)->getSnapshot();
            return $snapshot->getValue() ?? [];
        } catch (\Exception $e) {
            throw new \Exception('Gagal mengambil profil: ' . $e->getMessage());
        }
    }
}
