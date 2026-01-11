<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\FirebaseService;
use App\Services\QuoteService;

class TugasController extends Controller
{
    protected $firebase;
    protected $quoteService;

    public function __construct(FirebaseService $firebase, QuoteService $quoteService)
    {
        $this->firebase = $firebase;
        $this->quoteService = $quoteService;
    }

    public function index(Request $request)
    {
        $quote = $this->quoteService->getRandomQuote();
        $userId = session('user_id');

        $tugasList = $this->firebase->getTugas($userId);

        // Convert ke array dengan key sebagai id
        $tugasArray = [];
        if ($tugasList) {
            foreach ($tugasList as $key => $tugas) {
                $tugas['id'] = $key;
                $tugasArray[] = $tugas;
            }
        }

        // Filter hanya tugas yang belum selesai (persentase < 100)
        $tugasArray = array_filter($tugasArray, function($tugas) {
            return $tugas['persentase'] < 100;
        });

        // Sorting berdasarkan deadline
        usort($tugasArray, function($a, $b) {
            return strtotime($a['deadline']) - strtotime($b['deadline']);
        });

        return view('tugas.index', compact('tugasArray', 'quote'));
    }

    public function selesai()
    {
        $userId = session('user_id');

        $tugasList = $this->firebase->getTugas($userId);

        // Convert ke array dengan key sebagai id
        $tugasSelesai = [];
        if ($tugasList) {
            foreach ($tugasList as $key => $tugas) {
                $tugas['id'] = $key;
                $tugasSelesai[] = $tugas;
            }
        }

        // Filter hanya tugas yang selesai (persentase = 100)
        $tugasSelesai = array_filter($tugasSelesai, function($tugas) {
            return $tugas['persentase'] == 100;
        });

        // Sorting berdasarkan deadline (terbaru dulu)
        usort($tugasSelesai, function($a, $b) {
            return strtotime($b['deadline']) - strtotime($a['deadline']);
        });

        return view('tugas.selesai', compact('tugasSelesai'));
    }

    public function create()
    {
        return view('tugas.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'matkul' => 'required|string|max:255',
            'nama_tugas' => 'required|string|max:255',
            'deadline' => 'required|date',
            'kesulitan' => 'required|in:Mudah,Sedang,Sulit',
            'link' => 'nullable|url',
            'persentase' => 'required|integer|min:0|max:100',
        ]);

        $data = [
            'matkul' => $validated['matkul'],
            'nama_tugas' => $validated['nama_tugas'],
            'deadline' => $validated['deadline'],
            'kesulitan' => $validated['kesulitan'],
            'link' => $validated['link'] ?? '',
            'persentase' => $validated['persentase'],
            'user_id' => session('user_id'),
            'created_at' => now()->toDateTimeString(),
            'updated_at' => now()->toDateTimeString(),
        ];

        try {
            $key = $this->firebase->saveTugas($data);

            // Kirim notifikasi FCM
            $fcmToken = session('fcm_token');
            if ($fcmToken) {
                $this->firebase->sendNotification(
                    $fcmToken,
                    'Tugas Berhasil Ditambahkan',
                    "Tugas {$data['nama_tugas']} untuk matkul {$data['matkul']} berhasil disimpan!",
                    ['tugas_id' => $key]
                );
            }

            return redirect()->route('tugas.index')->with('success', 'Tugas berhasil ditambahkan!');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menambahkan tugas: ' . $e->getMessage())->withInput();
        }
    }

    public function edit($id)
    {
        try {
            $tugas = $this->firebase->getTugasById($id);

            if (!$tugas) {
                return redirect()->route('tugas.index')->with('error', 'Tugas tidak ditemukan');
            }

            $tugas['id'] = $id;
            return view('tugas.edit', compact('tugas'));
        } catch (\Exception $e) {
            return redirect()->route('tugas.index')->with('error', 'Gagal mengambil data tugas');
        }
    }

    public function update(Request $request, $id)
    {
        // Handle quick complete (only persentase field sent)
        if ($request->has('persentase') && !$request->has('matkul')) {
            $validated = $request->validate([
                'persentase' => 'required|integer|min:0|max:100',
            ]);

            $data = [
                'persentase' => $validated['persentase'],
                'updated_at' => now()->toDateTimeString(),
            ];
        } else {
            // Full update (edit form)
            $validated = $request->validate([
                'matkul' => 'required|string|max:255',
                'nama_tugas' => 'required|string|max:255',
                'deadline' => 'required|date',
                'kesulitan' => 'required|in:Mudah,Sedang,Sulit',
                'link' => 'nullable|url',
                'persentase' => 'required|integer|min:0|max:100',
            ]);

            $data = [
                'matkul' => $validated['matkul'],
                'nama_tugas' => $validated['nama_tugas'],
                'deadline' => $validated['deadline'],
                'kesulitan' => $validated['kesulitan'],
                'link' => $validated['link'] ?? '',
                'persentase' => $validated['persentase'],
                'updated_at' => now()->toDateTimeString(),
            ];
        }

        try {
            $this->firebase->updateTugas($id, $data);

            // Kirim notifikasi
            $fcmToken = session('fcm_token');
            if ($fcmToken) {
                $this->firebase->sendNotification(
                    $fcmToken,
                    'Tugas Berhasil Diperbarui',
                    "Tugas {$data['nama_tugas']} berhasil diperbarui!",
                    ['tugas_id' => $id]
                );
            }

            return redirect()->route('tugas.index')->with('success', 'Tugas berhasil diperbarui!');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal memperbarui tugas: ' . $e->getMessage())->withInput();
        }
    }

    public function destroy($id)
    {
        try {
            $this->firebase->deleteTugas($id);
            return redirect()->route('tugas.index')->with('success', 'Tugas berhasil dihapus!');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menghapus tugas: ' . $e->getMessage());
        }
    }

    public function refreshQuote()
    {
        $this->quoteService->clearCache();
        $quote = $this->quoteService->getRandomQuote();
        return response()->json([
            'success' => true,
            'quote' => $quote
        ]);
    }
}
