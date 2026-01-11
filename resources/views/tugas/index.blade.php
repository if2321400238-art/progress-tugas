@extends('layouts.app')

@section('title', 'Dashboard - Progress Tugas')

@section('content')
<!-- Welcome Section -->
<div class="mb-8">
    <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-4 mb-6">
        <div>
            <h2 class="text-3xl font-bold text-gray-900">Selamat Datang, {{ session('name', 'User') }}! 👋</h2>
            <p class="text-gray-600 mt-1">{{ count($tugasArray) }} tugas menanti Anda hari ini</p>
        </div>
        <a href="{{ route('tugas.create') }}"
           class="inline-flex items-center gap-2 bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 text-white px-6 py-3 rounded-xl font-semibold transform hover:scale-105 transition-all duration-200">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Tambah Tugas
        </a>
    </div>

    <!-- Quote Banner Component -->
    <x-quote-banner />

    <!-- Search Bar Component -->
</div>

<!-- Tugas Cards Grid -->
@if(count($tugasArray) > 0)
    <div class="mb-6">
        <h3 class="text-2xl font-bold text-gray-800">Daftar Tugas Berlangsung</h3>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6 auto-rows-max">
        @foreach($tugasArray as $index => $tugas)
            <x-task-card :tugas="$tugas" :index="$index" />
        @endforeach
    </div>
@else
    <!-- Empty State -->
    <x-empty-state
        title="Belum Ada Tugas"
        message="Mulai tambahkan tugas Anda untuk melacak progress dengan lebih baik"
        actionText="Buat Tugas Pertama"
        actionUrl="{{ route('tugas.create') }}"
        icon="document" />
@endif
@endsection
