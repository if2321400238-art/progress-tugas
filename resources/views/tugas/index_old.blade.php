@extends('layouts.app')

@section('title', 'Dashboard - Progress Tugas')
@section('page-title', 'Dashboard')
@section('page-subtitle', 'Selamat datang kembali! Mari kelola tugas Anda')

@section('content')
<!-- Welcome Banner with Quote -->
<div class="relative bg-gradient-to-r from-emerald-500 via-teal-500 to-cyan-500 rounded-3xl shadow-soft-lg overflow-hidden mb-8 animate-slide-down">
    <div class="absolute inset-0 bg-black opacity-10"></div>
    <div class="relative z-10 p-6 md:p-8 flex flex-col gap-6">
        <!-- Welcome Section -->
        <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-6">
            <div class="flex-1 space-y-2">
                <h2 class="text-3xl font-bold text-white leading-tight">Selamat Datang, {{ session('name', 'User') }}! 👋</h2>
                <p class="text-white/90 text-base md:text-lg">{{ count($tugasArray) }} tugas menanti Anda hari ini</p>
                <div class="pt-2">
                    <a href="{{ route('tugas.create') }}"
                       class="inline-flex items-center gap-2 bg-white text-emerald-600 px-6 py-3 rounded-xl font-semibold hover:shadow-soft-lg transform hover:-translate-y-0.5 transition-all duration-200">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Tambah Tugas Baru
                    </a>
                </div>
            </div>
            <div class="hidden lg:block">
                <div class="w-48 h-48 opacity-20">
                    <svg viewBox="0 0 200 200" fill="white">
                        <path d="M45,-60 L55,-60 L55,-10 L105,-10 L105,0 L55,0 L55,50 L45,50 L45,0 L-5,0 L-5,-10 L45,-10 Z" transform="translate(100 100)" />
                    </svg>
                </div>
            </div>
        </div>

        <!-- Quote Section -->
        <div class="border-t border-white/30 pt-6">
            <div class="flex items-start gap-4">
                <div class="w-12 h-12 bg-white/20 rounded-2xl flex items-center justify-center flex-shrink-0">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 17h3l2-4V7H6v6h3zm7 0h3l2-4V7h-6v6h3z" />
                    </svg>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-lg md:text-xl font-semibold leading-relaxed italic text-white mb-2" id="quoteText" data-quote-text style="transition: opacity 0.3s ease;">"{{ $quote['quote'] }}"</p>
                    <p class="text-sm font-semibold text-white/80 mb-3" id="quoteAuthor" data-quote-author style="transition: opacity 0.3s ease;">— {{ $quote['author'] ?? 'Unknown' }}</p>
                    <div class="flex flex-wrap items-center gap-3">
                        @php $category = $quote['category'] ?? null; @endphp
                        @if($category)
                            <span class="px-3 py-1 rounded-full text-xs font-semibold bg-white/20 border border-white/30" id="quoteCategory" data-quote-category>{{ ucfirst($category) }}</span>
                        @endif
                        <span class="text-xs text-white/70 flex items-center gap-1">
                            <span class="w-2 h-2 bg-emerald-200 rounded-full animate-pulse"></span>
                            Berganti otomatis setiap 8 detik
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Quote of the Day -->
<div class="relative overflow-hidden rounded-2xl shadow-soft-lg mb-8 animate-fade-in" style="animation-delay: 0.3s;">
    <div class="absolute inset-0 bg-gradient-to-r from-emerald-500 via-teal-500 to-cyan-500 opacity-90"></div>
    <div class="absolute inset-0" style="background: radial-gradient(circle at 20% 20%, rgba(255,255,255,0.15), transparent 35%), radial-gradient(circle at 80% 0%, rgba(255,255,255,0.08), transparent 30%);"></div>
    <div class="relative z-10 p-6 md:p-7 flex flex-col gap-4 text-white">
        <div class="flex items-center justify-between gap-3">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 17h3l2-4V7H6v6h3zm7 0h3l2-4V7h-6v6h3z" />
                    </svg>
                </div>
                <div>
                    <p class="text-xs uppercase tracking-[0.2em] text-white/80">Quote of the day</p>
                    <p class="text-sm font-semibold text-white/90">Powered by quotes.liupurnomo.com</p>
                </div>
            </div>
            @php $category = $quote['category'] ?? null; @endphp
            @if($category)
                <span class="px-3 py-1 rounded-full text-xs font-semibold bg-white/15 border border-white/20">{{ ucfirst($category) }}</span>
            @endif
        </div>

        <div class="space-y-3">
            <p class="text-lg md:text-xl font-semibold leading-relaxed italic">“{{ $quote['quote'] }}”</p>
            <p class="text-sm font-semibold text-white/80">— {{ $quote['author'] ?? 'Unknown' }}</p>
        </div>

        <div class="flex items-center justify-between gap-3 pt-1">
            <div class="flex items-center gap-2 text-xs text-white/80">
                <span class="w-2 h-2 bg-emerald-300 rounded-full animate-pulse"></span>
                <span>Random inspirational quote</span>
            </div>
            <form action="{{ route('refresh.quote') }}" method="POST" class="shrink-0">
                @csrf
                <button type="submit" class="inline-flex items-center gap-2 px-3 py-2 bg-white/10 hover:bg-white/20 border border-white/20 rounded-lg text-sm font-semibold transition-all duration-200">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                    </svg>
                    Refresh
                </button>
            </form>
        </div>
    </div>
</div>

<!-- Section Header -->
<div class="flex items-center justify-between mb-6">
    <h3 class="text-2xl font-bold text-gray-800">Daftar Tugas</h3>
    <div class="flex items-center gap-2">
        <span class="text-sm text-gray-600">{{ count($tugasArray) }} tugas ditemukan</span>
    </div>
</div>

<!-- Tugas Cards Grid -->
@if(count($tugasArray) > 0)
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
        @foreach($tugasArray as $index => $tugas)
        <div class="bg-white rounded-2xl shadow-soft-lg hover:shadow-soft-xl transition-all duration-300 transform hover:-translate-y-1 overflow-hidden animate-fade-in"
             style="animation-delay: {{ $index * 0.1 }}s;">
            <!-- Card Header dengan Gradient -->
            <div class="h-2 bg-gradient-to-r
                @if($tugas['kesulitan'] == 'Mudah') from-green-400 to-green-600
                @elseif($tugas['kesulitan'] == 'Sedang') from-yellow-400 to-yellow-600
                @else from-red-400 to-red-600 @endif">
            </div>

            <div class="p-6">
                <!-- Header -->
                <div class="flex items-start justify-between mb-4">
                    <div class="flex-1">
                        <h4 class="text-lg font-bold text-gray-800 mb-1">{{ $tugas['nama_tugas'] }}</h4>
                        <p class="text-sm text-gray-600">{{ $tugas['matkul'] }}</p>
                    </div>
                    <span class="px-3 py-1 rounded-full text-xs font-bold
                        @if($tugas['kesulitan'] == 'Mudah') bg-green-100 text-green-700
                        @elseif($tugas['kesulitan'] == 'Sedang') bg-yellow-100 text-yellow-700
                        @else bg-red-100 text-red-700 @endif">
                        {{ $tugas['kesulitan'] }}
                    </span>
                </div>

                <!-- Deadline Badge -->
                <div class="flex items-center gap-2 mb-4 text-sm">
                    <div class="flex items-center gap-1 text-gray-600">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        <span class="font-medium">{{ \Carbon\Carbon::parse($tugas['deadline'])->format('d M Y') }}</span>
                    </div>
                </div>

                @if($tugas['link'])
                <a href="{{ $tugas['link'] }}" target="_blank"
                   class="inline-flex items-center gap-1 text-sm text-emerald-600 hover:text-emerald-800 font-medium mb-4">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                    </svg>
                    Link Tugas
                </a>
                @endif

                <!-- Progress Bar -->
                <div class="mb-6">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-xs font-semibold text-gray-600">Progress</span>
                        <span class="text-xs font-bold text-emerald-600">{{ $tugas['persentase'] }}%</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2 overflow-hidden">
                        <div class="bg-gradient-to-r from-emerald-500 to-teal-600 h-2 rounded-full transition-all duration-500"
                             style="width: {{ $tugas['persentase'] }}%"></div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="flex gap-2 flex-col sm:flex-row">
                    <a href="{{ route('tugas.edit', $tugas['id']) }}"
                       class="flex-1 flex items-center justify-center gap-2 bg-emerald-50 hover:bg-emerald-100 text-emerald-600 px-4 py-2.5 rounded-xl font-semibold transition-all duration-200">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        Edit
                    </a>
                    <form action="{{ route('tugas.destroy', $tugas['id']) }}" method="POST"
                          onsubmit="return confirm('Yakin ingin menghapus tugas ini?')" class="flex-1">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="w-full flex items-center justify-center gap-2 bg-red-50 hover:bg-red-100 text-red-600 px-4 py-2.5 rounded-xl font-semibold transition-all duration-200">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                            Hapus
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
    </div>
@else
    <!-- Empty State -->
    <div class="bg-white rounded-2xl shadow-soft-lg p-12 text-center animate-fade-in">
        <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
            <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
        </div>
        <h3 class="text-2xl font-bold text-gray-800 mb-2">Belum Ada Tugas</h3>
        <p class="text-gray-600 mb-6">Mulai tambahkan tugas Anda untuk melacak progress dengan lebih baik</p>
        <a href="{{ route('tugas.create') }}"
           class="inline-flex items-center gap-2 bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 text-white px-8 py-3 rounded-xl font-semibold transform hover:scale-105 transition-all duration-200">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Buat Tugas Pertama
        </a>
    </div>
@endif
@endsection
