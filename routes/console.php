<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Carbon\Carbon;
use App\Services\FirebaseService;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('reminders:send', function () {
    /** @var FirebaseService $firebase */
    $firebase = app(FirebaseService::class);

    $tasks = $firebase->getTugas();
    if (!$tasks) {
        $this->info('Tidak ada tugas.');
        return 0;
    }

    $now = Carbon::now(config('app.timezone'));
    $sentCount = 0;

    foreach ($tasks as $id => $tugas) {
        try {
            // Abaikan jika sudah selesai atau reminder sudah dikirim
            if ((int)($tugas['persentase'] ?? 0) >= 100) {
                continue;
            }
            if (!empty($tugas['reminder_h1_sent'])) {
                continue;
            }

            $date = $tugas['deadline'] ?? null;
            $time = $tugas['deadline_time'] ?? '00:00';
            $userId = $tugas['user_id'] ?? null;

            if (!$date || !$userId) {
                continue;
            }

            // Gabungkan tanggal & waktu; default time jika kosong
            $deadlineAt = Carbon::createFromFormat('Y-m-d H:i', $date.' '.$time, config('app.timezone'));
            $reminderAt = (clone $deadlineAt)->subHour();

            // Kirim tepat pada menit reminder (toleransi 1 menit)
            if ($now->greaterThanOrEqualTo($reminderAt) && $now->lessThan($reminderAt->copy()->addMinute())) {
                // Ambil token dari profile
                $profile = $firebase->getUserProfile($userId);
                $token = $profile['fcm_token'] ?? null;

                if ($token) {
                    $title = 'Pengingat H-1 Jam';
                    $body = 'Tugas "'.($tugas['nama_tugas'] ?? 'Tanpa Nama').'" untuk matkul '.($tugas['matkul'] ?? '-').' akan jatuh tempo dalam 1 jam.';

                    $result = $firebase->sendNotification($token, $title, $body, [
                        'tugas_id' => $id,
                    ]);

                    if ($result !== false) {
                        $firebase->updateTugas($id, [
                            'reminder_h1_sent' => true,
                            'updated_at' => Carbon::now(config('app.timezone'))->toDateTimeString(),
                        ]);
                        $sentCount++;
                        $this->info("Reminder dikirim untuk tugas: {$id}");
                    }
                }
            }
        } catch (\Throwable $e) {
            // Lanjut ke tugas berikutnya
        }
    }

    $this->info("Total reminder terkirim: {$sentCount}");
    return 0;
})->purpose('Kirim notifikasi H-1 jam sebelum deadline tugas');

Artisan::command('reminders:seed-test {userId} {token}', function (string $userId, string $token) {
    /** @var FirebaseService $firebase */
    $firebase = app(FirebaseService::class);

    // Simpan token ke profil user
    try {
        $firebase->updateUserProfile($userId, [
            'fcm_token' => $token,
            'updated_at' => Carbon::now(config('app.timezone'))->toDateTimeString(),
        ]);
        $this->info('FCM token disimpan untuk user: '.$userId);
    } catch (\Throwable $e) {
        $this->error('Gagal simpan token: '.$e->getMessage());
        return 1;
    }

    // Buat tugas dengan deadline tepat +1 jam dari sekarang
    $now = Carbon::now(config('app.timezone'))->second(0);
    $deadlineAt = (clone $now)->addHour();
    $data = [
        'matkul' => 'Tes Matkul',
        'nama_tugas' => 'Tes Reminder H-1 Jam',
        'deadline' => $deadlineAt->format('Y-m-d'),
        'deadline_time' => $deadlineAt->format('H:i'),
        'kesulitan' => 'Mudah',
        'link' => '',
        'persentase' => 0,
        'user_id' => $userId,
        'reminder_h1_sent' => false,
        'created_at' => $now->toDateTimeString(),
        'updated_at' => $now->toDateTimeString(),
    ];

    try {
        $id = $firebase->saveTugas($data);
        $this->info('Tugas test dibuat: '.$id.' (deadline: '.$deadlineAt->toDateTimeString().')');
        $this->info('Jalankan: php artisan reminders:send untuk memicu pengingat sekarang.');
        return 0;
    } catch (\Throwable $e) {
        $this->error('Gagal buat tugas test: '.$e->getMessage());
        return 1;
    }
})->purpose('Seed tugas uji yang akan memicu pengingat H-1 jam');
