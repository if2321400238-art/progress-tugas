<!-- Search Bar Component -->
<div class="relative mb-8" id="search-container">
    <div class="flex items-center gap-2 bg-white rounded-2xl shadow-soft-md border border-gray-200 overflow-hidden hover:border-emerald-300 transition-colors focus-within:border-emerald-600 focus-within:shadow-soft-lg">
        <svg class="w-6 h-6 text-gray-400 ml-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
        </svg>

        <input type="text"
               id="search-input"
               placeholder="Cari tugas berdasarkan nama atau matkul..."
               class="flex-1 px-4 py-3 bg-transparent text-gray-700 placeholder-gray-400 outline-none"
               onkeydown="handleSearchKeydown(event)"
               oninput="filterTasks(this.value)">

        <button onclick="clearSearch()"
                class="mr-2 p-2 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-lg transition-colors hidden"
                id="clear-btn"
                title="Hapus pencarian">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
    </div>

    <!-- Search Results Dropdown -->
    <div id="search-dropdown"
         class="hidden absolute top-16 left-0 right-0 bg-white rounded-2xl shadow-soft-lg border border-gray-200 z-50 max-h-96 overflow-y-auto animate-fade-in">
        <div id="search-results" class="p-4">
            <!-- Results akan muncul di sini -->
        </div>
    </div>
</div>

<script>
function handleSearchKeydown(e) {
    if (e.key === 'Enter') {
        e.preventDefault();
        // Search is already being filtered on input
    }
}

function filterTasks(query) {
    const clearBtn = document.getElementById('clear-btn');
    const searchDropdown = document.getElementById('search-dropdown');
    const cards = document.querySelectorAll('[data-task-name]');

    // Show/hide clear button
    clearBtn.classList.toggle('hidden', !query);

    if (!query.trim()) {
        searchDropdown.classList.add('hidden');
        // Show all cards
        cards.forEach(card => {
            card.style.display = '';
        });
        return;
    }

    const results = [];
    const queryLower = query.toLowerCase();

    cards.forEach(card => {
        const name = (card.dataset.taskName || '').toLowerCase();
        const subject = (card.dataset.taskSubject || '').toLowerCase();

        if (name.includes(queryLower) || subject.includes(queryLower)) {
            card.style.display = '';
            results.push({
                name: card.dataset.taskName,
                subject: card.dataset.taskSubject,
                element: card
            });
        } else {
            card.style.display = 'none';
        }
    });

    // Update dropdown
    if (results.length > 0) {
        const resultsList = results.map((r, i) => `
            <div class="p-3 border-b border-gray-100 hover:bg-emerald-50 cursor-pointer transition-colors"
                 onclick="scrollToCard(${i})">
                <p class="font-semibold text-gray-800 text-sm">${r.name}</p>
                <p class="text-xs text-gray-600">${r.subject}</p>
            </div>
        `).join('');
        document.getElementById('search-results').innerHTML = resultsList;
        searchDropdown.classList.remove('hidden');
    } else {
        document.getElementById('search-results').innerHTML = '<div class="p-6 text-center text-gray-500"><p class="text-sm">Tidak ada tugas ditemukan</p></div>';
        searchDropdown.classList.remove('hidden');
    }
}

function clearSearch() {
    document.getElementById('search-input').value = '';
    document.getElementById('clear-btn').classList.add('hidden');
    document.getElementById('search-dropdown').classList.add('hidden');

    // Show all cards
    document.querySelectorAll('[data-task-name]').forEach(card => {
        card.style.display = '';
    });
}

function scrollToCard(index) {
    const cards = document.querySelectorAll('[data-task-name]');
    if (cards[index]) {
        cards[index].scrollIntoView({ behavior: 'smooth', block: 'center' });
        // Highlight the card
        cards[index].classList.add('ring-2', 'ring-emerald-400');
        setTimeout(() => {
            cards[index].classList.remove('ring-2', 'ring-emerald-400');
        }, 2000);
    }
}

// Close dropdown when clicking outside
document.addEventListener('click', (e) => {
    if (!e.target.closest('#search-container')) {
        document.getElementById('search-dropdown').classList.add('hidden');
    }
});
</script>
