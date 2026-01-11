@extends('layouts.app')

@section('title', 'Edit Profil - Progress Tugas')
@section('page-title', 'Edit Profil')
@section('page-subtitle', 'Perbarui informasi akun Anda')

@section('content')
<div class="max-w-2xl mx-auto">
    @if(session('status'))
        <div class="mb-6 bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-xl">
            {{ session('status') }}
        </div>
    @endif

    <div class="bg-white rounded-2xl shadow-soft-lg p-6">
        <form method="POST" action="{{ route('profile.update') }}" class="space-y-6">
            @csrf
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Nama</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}"
                       class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:border-emerald-500 focus:ring-0 outline-none"
                       required>
                @error('name')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Email</label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}"
                       class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:border-emerald-500 focus:ring-0 outline-none"
                       required>
                @error('email')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center justify-end gap-3 pt-6 border-t border-gray-100">
                <a href="{{ route('tugas.index') }}" class="px-5 py-3 rounded-xl border border-gray-200 text-gray-700 hover:bg-gray-50">Batal</a>
                <button type="submit"
                        class="px-6 py-3 rounded-xl bg-gradient-to-r from-emerald-600 to-teal-600 text-white font-semibold hover:from-emerald-700 hover:to-teal-700">
                    Simpan Perubahan
                </button>
            </div>
        </form>

        <!-- Logout Section -->
        <div class="mt-8 pt-8 border-t border-gray-200">
            <p class="text-sm text-gray-600 mb-4">Keluar dari akun Anda</p>
            <form method="POST" action="{{ route('logout') }}" class="m-0">
                @csrf
                <button type="submit" class="px-6 py-3 rounded-xl border border-red-200 text-red-600 hover:bg-red-50 font-semibold transition-colors">
                    Logout
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
