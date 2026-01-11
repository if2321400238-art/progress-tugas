@extends('layouts.app')

@section('title', 'Tugas Selesai - Progress Tugas')

@section('content')
<!-- Section Header -->
<div class="flex items-center justify-between mb-6">
    <div>
        @section('page-title', 'Tugas Selesai')
        <p class="text-sm text-gray-600 mt-1">{{ count($tugasSelesai) }} tugas telah diselesaikan</p>
    </div>
    <a href="{{ route('tugas.index') }}"
       class="inline-flex items-center gap-2 text-emerald-600 hover:text-emerald-700 font-semibold transition-colors">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
        </svg>
        Kembali
    </a>
</div>

<!-- Completed Tasks Grid -->
@if(count($tugasSelesai) > 0)
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6 auto-rows-max">
        @foreach($tugasSelesai as $index => $tugas)
            <x-task-card-completed :tugas="$tugas" :index="$index" />
        @endforeach
    </div>
@else
    <!-- Empty State -->
    <div class="bg-white rounded-2xl shadow-soft-lg p-12 text-center animate-fade-in" data-empty-state>
        <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
            <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
        </div>
        <h3 class="text-2xl font-bold text-gray-800 mb-2">Belum Ada Tugas Selesai</h3>
        <p class="text-gray-600 mb-6">Lengkapi tugas Anda untuk memunculkannya di sini</p>
        <a href="{{ route('tugas.index') }}"
           class="inline-flex items-center gap-2 bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 text-white px-8 py-3 rounded-xl font-semibold transform hover:scale-105 transition-all duration-200">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Ke Tugas Berlangsung
        </a>
    </div>
@endif

<script>
// Dropdown menu functionality
function toggleMenu(event) {
    event.preventDefault();
    event.stopPropagation();

    const button = event.currentTarget;
    const dropdown = button.closest('.relative').querySelector('.menu-dropdown');

    // Close all other dropdowns
    document.querySelectorAll('.menu-dropdown').forEach(menu => {
        if (menu !== dropdown) {
            menu.classList.add('hidden');
        }
    });

    dropdown.classList.toggle('hidden');
}

// Close dropdown when clicking outside
document.addEventListener('click', (e) => {
    if (!e.target.closest('.relative')) {
        document.querySelectorAll('.menu-dropdown').forEach(menu => {
            menu.classList.add('hidden');
        });
    }
});
</script>
@endsection
