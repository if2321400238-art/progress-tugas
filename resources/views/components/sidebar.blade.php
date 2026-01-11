<!-- Sidebar Component -->
<aside class="hidden lg:flex flex-col w-72 bg-white min-h-screen shadow-soft-lg rounded-r-3xl overflow-hidden lg:sticky lg:top-0 lg:h-screen lg:overflow-y-auto">
    <!-- Brand -->
    <div class="p-6 border-b border-gray-100 flex items-center gap-3">
        <div class="w-12 h-12 bg-gradient-to-br from-emerald-500 to-teal-600 rounded-2xl flex items-center justify-center shadow-soft-md">
            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                <path d="M9 11l3 3L20 4m-9 14a9 9 0 110-18 9 9 0 010 18z"></path>
            </svg>
        </div>
        <div>
            <h2 class="text-lg font-bold text-gray-900">Tugasku</h2>
            <p class="text-xs text-emerald-600 font-semibold">Jadi mudah, jadi teratur.</p>
        </div>
    </div>

    <!-- Navigation -->
    <nav class="flex-1 p-4 space-y-2 overflow-y-auto">
        <a href="{{ route('tugas.index') }}"
           class="flex items-center gap-3 px-4 py-3 rounded-2xl transition-all duration-200 shadow-sm {{ request()->routeIs('tugas.index') ? 'bg-emerald-50 text-emerald-700 shadow-soft-sm' : 'text-gray-700 hover:bg-gray-50' }}">
            <div class="w-10 h-10 rounded-xl flex items-center justify-center {{ request()->routeIs('tugas.index') ? 'bg-emerald-100 text-emerald-700' : 'bg-gray-100 text-gray-600' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                </svg>
            </div>
            <div>
                <p class="text-sm font-semibold">Dashboard</p>
                <p class="text-xs text-gray-500">Ringkasan tugas</p>
            </div>
        </a>

        <a href="{{ route('tugas.selesai') }}"
           class="flex items-center gap-3 px-4 py-3 rounded-2xl transition-all duration-200 shadow-sm {{ request()->routeIs('tugas.selesai') ? 'bg-emerald-50 text-emerald-700 shadow-soft-sm' : 'text-gray-700 hover:bg-gray-50' }}">
            <div class="w-10 h-10 rounded-xl flex items-center justify-center {{ request()->routeIs('tugas.selesai') ? 'bg-emerald-100 text-emerald-700' : 'bg-gray-100 text-gray-600' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <div>
                <p class="text-sm font-semibold">Tugas Selesai</p>
                <p class="text-xs text-gray-500">Lihat progres akhir</p>
            </div>
        </a>

        <a href="{{ route('tugas.create') }}"
           class="flex items-center gap-3 px-4 py-3 rounded-2xl transition-all duration-200 text-gray-700 hover:bg-gray-50">
            <div class="w-10 h-10 rounded-xl flex items-center justify-center bg-gray-100 text-gray-600">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
            </div>
            <div>
                <p class="text-sm font-semibold">Tambah Tugas</p>
                <p class="text-xs text-gray-500">Buat tugas baru</p>
            </div>
        </a>
    </nav>

    <!-- User Box -->
    <div class="p-4 border-t border-gray-100 bg-gray-50">
        <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 p-3 bg-white rounded-2xl shadow-soft-sm hover:shadow-md transition-all">
            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-emerald-500 to-teal-600 text-white flex items-center justify-center font-semibold flex-shrink-0">
                {{ substr(session('name') ?? 'U', 0, 1) }}
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-sm font-semibold text-gray-800 truncate">{{ session('name') ?? 'User' }}</p>
                <p class="text-xs text-gray-500 truncate">{{ session('email') ?? 'email@example.com' }}</p>
            </div>
            <svg class="w-5 h-5 text-red-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
            </svg>
        </a>
    </div>
</aside>

<!-- Mobile/Tablet Bottom Navigation (moved from footer) -->
<div class="fixed bottom-0 left-0 right-0 border-t border-gray-700 lg:hidden z-50 bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 transform hover:scale-105 transition-all duration-200">
    <div class="flex justify-around">
        <a href="{{ route('tugas.index') }}"
           class="flex-1 flex flex-col items-center justify-center py-3 text-white font-semibold transition-colors transition-colors {{ request()->routeIs('tugas.index') ? 'text-emerald-400' : '' }}">
            <svg class="w-6 h-6 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
            </svg>
            <span class="text-xs">Tugas</span>
        </a>
        <a href="{{ route('tugas.selesai') }}"
           class="flex-1 flex flex-col items-center justify-center py-3 text-white font-semibold transition-colors transition-colors {{ request()->routeIs('tugas.selesai') ? 'text-emerald-400' : '' }}">
            <svg class="w-6 h-6 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <span class="text-xs">Selesai</span>
        </a>
        <a href="{{ route('profile.edit') }}"
           class="flex-1 flex flex-col items-center justify-center py-3 text-white font-semibold transition-colors transition-colors {{ request()->routeIs('profile.edit') ? 'text-emerald-400' : '' }}">
            <svg class="w-6 h-6 mb-1" fill="currentColor" viewBox="0 0 24 24">
                <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"></path>
            </svg>
            <span class="text-xs">Profil</span>
        </a>
    </div>
</div>

<style>
/* Add padding to body to account for fixed mobile bottom nav */
@media (max-width: 1024px) {
    body {
        padding-bottom: 64px;
    }
}
</style>
