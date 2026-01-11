@props(['tugas', 'index' => 0])

<div class="bg-white rounded-2xl shadow-soft-lg hover:shadow-soft-xl transition-all duration-300"
     data-task-name="{{ $tugas['nama_tugas'] }}"
     data-task-subject="{{ $tugas['matkul'] }}">

    <!-- Card Header Gradient -->
    <div class="h-2 bg-gradient-to-r
        @if($tugas['kesulitan'] == 'Mudah') from-green-400 to-green-600
        @elseif($tugas['kesulitan'] == 'Sedang') from-yellow-400 to-yellow-600
        @else from-red-400 to-red-600 @endif">
    </div>

    <div class="p-6">
        <!-- Header Section -->
        <div class="flex items-start justify-between mb-4">
            <div class="flex-1">
                <h4 class="text-lg font-bold text-gray-800 mb-1 line-clamp-2">{{ $tugas['nama_tugas'] }}</h4>
                <p class="text-sm text-gray-600">{{ $tugas['matkul'] }}</p>
            </div>
            <span class="px-3 py-1 rounded-full text-xs font-bold whitespace-nowrap ml-2
                @if($tugas['kesulitan'] == 'Mudah') bg-green-100 text-green-700
                @elseif($tugas['kesulitan'] == 'Sedang') bg-yellow-100 text-yellow-700
                @else bg-red-100 text-red-700 @endif">
                {{ $tugas['kesulitan'] }}
            </span>
        </div>

        <!-- Deadline -->
        <div class="flex items-center gap-2 mb-4 text-sm text-gray-600">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
            </svg>
            <span class="font-medium">{{ \Carbon\Carbon::parse($tugas['deadline'])->format('d M Y') }}</span>
        </div>

        <!-- Link (if exists) -->
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
        <div class="flex gap-3 items-center">
            <!-- Complete Button -->
            <form action="{{ route('tugas.update', $tugas['id']) }}" method="POST" class="flex-1">
                @csrf
                @method('PUT')
                <input type="hidden" name="persentase" value="100">
                <button type="submit"
                        class="w-full flex items-center justify-center gap-2 bg-gradient-to-r from-emerald-500 to-teal-600 hover:from-emerald-600 hover:to-teal-700 text-white px-3 py-2 rounded-lg font-semibold transition-all duration-200 shadow-sm hover:shadow-md text-xs">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Selesai
                </button>
            </form>

            <!-- Menu Button -->
            <div class="relative z-40 flex-shrink-0">
                <button class="menu-btn p-2 text-gray-400 hover:text-emerald-600 hover:bg-emerald-50 rounded-lg transition-all"
                        onclick="toggleMenu(event)">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 8c1.1 0 2-0.9 2-2s-0.9-2-2-2-2 0.9-2 2 0.9 2 2 2zm0 2c-1.1 0-2 0.9-2 2s0.9 2 2 2 2-0.9 2-2-0.9-2-2-2zm0 6c-1.1 0-2 0.9-2 2s0.9 2 2 2 2-0.9 2-2-0.9-2-2-2z"></path>
                    </svg>
                </button>

                <!-- Dropdown Menu - positioned above button -->
                <div class="menu-dropdown hidden absolute right-0 -top-10 w-48 bg-white rounded-lg shadow-lg border border-gray-200 z-50">
                    <a href="{{ route('tugas.edit', $tugas['id']) }}"
                       class="flex items-center gap-3 w-full px-4 py-2.5 text-sm font-medium text-gray-700 hover:bg-emerald-50 hover:text-emerald-600 transition-all border-b border-gray-100">
                        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        <span>Edit</span>
                    </a>
                    <form action="{{ route('tugas.destroy', $tugas['id']) }}" method="POST"
                          onsubmit="return confirm('Yakin ingin menghapus tugas ini?')" class="w-full">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="flex items-center gap-3 w-full px-4 py-2.5 text-sm font-medium text-red-600 hover:bg-red-50 transition-all">
                            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                            <span>Hapus</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
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
