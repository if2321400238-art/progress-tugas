@extends('layouts.app')

@section('title', 'Tambah Tugas - Progress Tugas')
@section('page-title', 'Tambah Tugas Baru')
@section('page-subtitle', 'Isi form di bawah untuk membuat tugas baru')

@section('content')
<div class="max-w-3xl mx-auto">
    <!-- Back Button -->
    <div class="mb-6">
        <a href="{{ route('tugas.index') }}"
           class="inline-flex items-center gap-2 text-emerald-600 hover:text-emerald-800 font-semibold group">
            <svg class="w-5 h-5 transform group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
            Kembali ke Dashboard
        </a>
    </div>

    <!-- Form Card -->
    <div class="bg-white rounded-2xl shadow-soft-xl p-6 md:p-8 animate-fade-in">
        <div class="mb-8">
            <div class="w-14 h-14 bg-gradient-to-br from-emerald-500 to-teal-600 rounded-2xl flex items-center justify-center mb-4">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
            </div>
            <h2 class="text-3xl font-bold text-gray-800">Buat Tugas Baru</h2>
            <p class="text-gray-600 mt-2">Lengkapi detail tugas Anda di bawah ini</p>
        </div>

        <form action="{{ route('tugas.store') }}" method="POST" class="space-y-6">
            @csrf

            <!-- Mata Kuliah -->
            <div class="group">
                <label for="matkul" class="block text-sm font-semibold text-gray-700 mb-2">Mata Kuliah <span class="text-red-500">*</span></label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400 group-focus-within:text-emerald-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                    </div>
                    <input type="text"
                           id="matkul"
                           name="matkul"
                           value="{{ old('matkul') }}"
                           class="w-full pl-12 pr-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:border-emerald-500 focus:ring-emerald-500/20 transition-all"
                           placeholder="Contoh: Pemrograman Web"
                           required>
                </div>
                @error('matkul')
                    <p class="text-red-500 text-sm mt-1 flex items-center gap-1 animate-shake">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <!-- Nama Tugas -->
            <div class="group">
                <label for="nama_tugas" class="block text-sm font-semibold text-gray-700 mb-2">Nama Tugas <span class="text-red-500">*</span></label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400 group-focus-within:text-emerald-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <input type="text"
                           id="nama_tugas"
                           name="nama_tugas"
                           value="{{ old('nama_tugas') }}"
                           class="w-full pl-12 pr-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:border-emerald-500 focus:ring-emerald-500/20 transition-all"
                           placeholder="Contoh: Membuat Aplikasi CRUD"
                           required>
                </div>
                @error('nama_tugas')
                    <p class="text-red-500 text-sm mt-1 flex items-center gap-1 animate-shake">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <!-- Deadline & Kesulitan Row -->
            <div class="grid md:grid-cols-2 gap-6">
                <!-- Deadline Date & Time -->
                <div class="group">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Deadline <span class="text-red-500">*</span></label>
                    <div class="grid grid-cols-2 gap-3">
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400 group-focus-within:text-emerald-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <input type="date"
                                   id="deadline"
                                   name="deadline"
                                   value="{{ old('deadline') }}"
                                   class="w-full pl-12 pr-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:border-emerald-500 focus:ring-emerald-500/20 transition-all"
                                   required>
                        </div>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400 group-focus-within:text-emerald-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <input type="time"
                                   id="deadline_time"
                                   name="deadline_time"
                                   value="{{ old('deadline_time', '23:59') }}"
                                   class="w-full pl-12 pr-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:border-emerald-500 focus:ring-emerald-500/20 transition-all">
                        </div>
                    </div>
                    @error('deadline')
                        <p class="text-red-500 text-sm mt-1 flex items-center gap-1 animate-shake">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            {{ $message }}
                        </p>
                    @enderror
                    @error('deadline_time')
                        <p class="text-red-500 text-sm mt-1 flex items-center gap-1 animate-shake">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Kesulitan -->
                <div class="group">
                    <label for="kesulitan" class="block text-sm font-semibold text-gray-700 mb-2">Tingkat Kesulitan <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400 group-focus-within:text-emerald-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                        </div>
                        <select id="kesulitan"
                                name="kesulitan"
                                class="w-full pl-12 pr-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:border-emerald-500 focus:ring-emerald-500/20 transition-all appearance-none"
                                required>
                            <option value="">Pilih Kesulitan</option>
                            <option value="Mudah" {{ old('kesulitan') == 'Mudah' ? 'selected' : '' }}>🟢 Mudah</option>
                            <option value="Sedang" {{ old('kesulitan') == 'Sedang' ? 'selected' : '' }}>🟡 Sedang</option>
                            <option value="Sulit" {{ old('kesulitan') == 'Sulit' ? 'selected' : '' }}>🔴 Sulit</option>
                        </select>
                    </div>
                    @error('kesulitan')
                        <p class="text-red-500 text-sm mt-1 flex items-center gap-1 animate-shake">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>
            </div>

            <!-- Link Tugas -->
            <div class="group">
                <label for="link" class="block text-sm font-semibold text-gray-700 mb-2">Link Tugas <span class="text-gray-400 text-xs">(Opsional)</span></label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400 group-focus-within:text-emerald-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path>
                        </svg>
                    </div>
                    <input type="url"
                           id="link"
                           name="link"
                           value="{{ old('link') }}"
                           class="w-full pl-12 pr-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:border-emerald-500 focus:ring-emerald-500/20 transition-all"
                           placeholder="https://classroom.google.com/...">
                </div>
                @error('link')
                    <p class="text-red-500 text-sm mt-1 flex items-center gap-1 animate-shake">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <!-- Persentase Progress -->
            <div class="group">
                <label for="persentase" class="block text-sm font-semibold text-gray-700 mb-2">
                    Progress Awal
                    <span class="text-emerald-600 font-bold" id="persentaseValue">0</span>%
                </label>
                <input type="range"
                       id="persentase"
                       name="persentase"
                       min="0"
                       max="100"
                       value="{{ old('persentase', 0) }}"
                       class="w-full h-3 bg-gray-200 rounded-full appearance-none cursor-pointer slider"
                       oninput="document.getElementById('persentaseValue').textContent = this.value">
                <div class="flex justify-between text-xs text-gray-500 mt-1">
                    <span>0%</span>
                    <span>25%</span>
                    <span>50%</span>
                    <span>75%</span>
                    <span>100%</span>
                </div>
                @error('persentase')
                    <p class="text-red-500 text-sm mt-1 flex items-center gap-1 animate-shake">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <!-- Action Buttons -->
            <div class="flex gap-4 pt-6 border-t border-gray-200 flex-col sm:flex-row">
                <button type="submit"
                        class="flex-1 flex items-center justify-center gap-2 bg-gradient-to-r from-emerald-500 to-teal-500 hover:from-emerald-600 hover:to-teal-600 text-white px-6 py-4 rounded-xl font-semibold transform hover:scale-105 transition-all duration-200 shadow-soft-lg hover:shadow-soft-xl">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Simpan Tugas
                </button>
                <a href="{{ route('tugas.index') }}"
                   class="px-6 py-4 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-xl font-semibold transition-all duration-200 text-center">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
