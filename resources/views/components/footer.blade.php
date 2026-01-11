<!-- Footer -->
<footer class="bg-gradient-to-r from-gray-900 to-gray-800 text-white mt-12 border-t border-gray-700">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-8">
            <!-- Brand -->
            <div>
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-10 h-10 bg-gradient-to-br from-emerald-600 to-teal-600 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M9 11l3 3L20 4m-9 14a9 9 0 110-18 9 9 0 010 18z"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-bold text-lg">Progress Tugas</h3>
                        <p class="text-gray-400 text-xs">Kelola tugas akademik</p>
                    </div>
                </div>
                <p class="text-gray-400 text-sm">Aplikasi manajemen tugas untuk membantu Anda mencapai kesuksesan akademik.</p>
            </div>

            <!-- Quick Links -->
            <div>
                <h4 class="font-semibold text-white mb-4">Menu Cepat</h4>
                <ul class="space-y-2">
                    <li>
                        <a href="{{ route('tugas.index') }}" class="text-gray-400 hover:text-emerald-400 transition-colors text-sm">
                            Tugas Berlangsung
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('tugas.selesai') }}" class="text-gray-400 hover:text-emerald-400 transition-colors text-sm">
                            Tugas Selesai
                        </a>
                    </li>
                    <li>
                        <a href="#" class="text-gray-400 hover:text-emerald-400 transition-colors text-sm">
                            Profil
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Information -->
            <div>
                <h4 class="font-semibold text-white mb-4">Informasi</h4>
                <ul class="space-y-2">
                    <li>
                        <a href="#" class="text-gray-400 hover:text-emerald-400 transition-colors text-sm">
                            Tentang
                        </a>
                    </li>
                    <li>
                        <a href="#" class="text-gray-400 hover:text-emerald-400 transition-colors text-sm">
                            Bantuan
                        </a>
                    </li>
                    <li>
                        <a href="#" class="text-gray-400 hover:text-emerald-400 transition-colors text-sm">
                            Kebijakan Privasi
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Contact -->
            <div>
                <h4 class="font-semibold text-white mb-4">Hubungi Kami</h4>
                <ul class="space-y-2 text-sm text-gray-400">
                    <li class="flex items-center gap-2">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                        info@progresstugas.com
                    </li>
                    <li class="flex items-center gap-2">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                        </svg>
                        +62 123 456 7890
                    </li>
                </ul>
            </div>
        </div>

        <!-- Divider -->
        <div class="border-t border-gray-700 pt-8">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <p class="text-gray-400 text-sm">© 2026 Progress Tugas. Semua hak dilindungi.</p>
                <div class="flex gap-4 mt-4 md:mt-0">
                    <a href="#" class="text-gray-400 hover:text-emerald-400 transition-colors">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M8.29 20v-7.21h-2.3V9.25h2.3V7.31c0-2.31 1.4-3.56 3.45-3.56 .98 0 1.82 .07 2.06 .1v2.39h-1.41c-1.11 0-1.32 .53-1.32 1.3v1.7h2.62l-3.4 3.54V20h-2.7z"></path>
                        </svg>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-emerald-400 transition-colors">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M23 3a10.9 10.9 0 01-3.14 1.53 4.48 4.48 0 00-7.86 3v1A10.66 10.66 0 013 4s-4 9 5 13a11.64 11.64 0 01-7 2s9 5 20 5a9.5 9.5 0 00-9-5.5c4.75 2.25 7-7 7-7"></path>
                        </svg>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-emerald-400 transition-colors">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M16 8a6 6 0 016 6v7h-4v-7a2 2 0 00-2-2 2 2 0 00-2 2v7h-4v-7a6 6 0 016-6zM2 9h4v12H2z"></path>
                            <circle cx="4" cy="4" r="2"></circle>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </div>

</footer>

<style>
@keyframes fade-in {
    from {
        opacity: 0;
        transform: translateY(10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.animate-fade-in {
    animation: fade-in 0.3s ease-in-out;
}

/* (moved) body padding for mobile nav now handled in sidebar component */
</style>
