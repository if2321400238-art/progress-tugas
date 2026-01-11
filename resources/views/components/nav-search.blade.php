<!-- Inline Navbar Search -->
<div id="nav-search-container" class="flex-1 max-w-xl">
    <div class="relative">
        <div class="flex items-center gap-2 bg-white rounded-2xl shadow-soft-md border border-gray-200 overflow-hidden hover:border-emerald-300 transition-colors focus-within:border-emerald-600">
            <svg class="w-5 h-5 text-gray-400 ml-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
            </svg>
            <input type="text"
                   id="nav-search-input"
                   placeholder="Cari tugas..."
                   class="flex-1 px-3 py-2 bg-transparent text-gray-700 placeholder-gray-400 outline-none"
                   oninput="filterTasksNav(this.value)"
                   onkeydown="handleNavSearchKeydown(event)">
            <button onclick="clearNavSearch()"
                    id="nav-clear-btn"
                    class="mr-2 p-2 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-lg transition-colors hidden"
                    title="Hapus pencarian">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        <!-- Results Dropdown -->
        <div id="nav-search-dropdown"
             class="hidden absolute top-12 left-0 right-0 bg-white rounded-2xl shadow-soft-lg border border-gray-200 z-50 max-h-80 overflow-y-auto animate-fade-in">
            <div id="nav-search-results" class="p-3"></div>
        </div>
    </div>
</div>

<script>
function handleNavSearchKeydown(e) {
    if (e.key === 'Enter') {
        e.preventDefault();
    }
}

function filterTasksNav(query) {
    const clearBtn = document.getElementById('nav-clear-btn');
    const dropdown = document.getElementById('nav-search-dropdown');
    const resultsEl = document.getElementById('nav-search-results');
    const cards = document.querySelectorAll('[data-task-name]');

    clearBtn.classList.toggle('hidden', !query);

    if (!query.trim()) {
        dropdown.classList.add('hidden');
        cards.forEach(card => card.style.display = '');
        return;
    }

    const q = query.toLowerCase();
    const results = [];

    cards.forEach((card, idx) => {
        const name = (card.dataset.taskName || '').toLowerCase();
        const subject = (card.dataset.taskSubject || '').toLowerCase();
        if (name.includes(q) || subject.includes(q)) {
            card.style.display = '';
            results.push({ i: idx, name: card.dataset.taskName, subject: card.dataset.taskSubject });
        } else {
            card.style.display = 'none';
        }
    });

    if (results.length) {
        resultsEl.innerHTML = results.map(r => `
            <div class="p-3 border-b border-gray-100 hover:bg-emerald-50 cursor-pointer transition-colors"
                 onclick="scrollToNavResult(${r.i})">
                <p class="font-semibold text-gray-800 text-sm">${r.name}</p>
                <p class="text-xs text-gray-600">${r.subject}</p>
            </div>
        `).join('');
        dropdown.classList.remove('hidden');
    } else {
        resultsEl.innerHTML = '<div class="p-4 text-center text-gray-500 text-sm">Tidak ada tugas ditemukan</div>';
        dropdown.classList.remove('hidden');
    }
}

function clearNavSearch() {
    document.getElementById('nav-search-input').value = '';
    document.getElementById('nav-clear-btn').classList.add('hidden');
    document.getElementById('nav-search-dropdown').classList.add('hidden');
    document.querySelectorAll('[data-task-name]').forEach(card => card.style.display = '');
}

function scrollToNavResult(index) {
    const cards = document.querySelectorAll('[data-task-name]');
    if (cards[index]) {
        cards[index].scrollIntoView({ behavior: 'smooth', block: 'center' });
        cards[index].classList.add('ring-2', 'ring-emerald-400');
        setTimeout(() => cards[index].classList.remove('ring-2', 'ring-emerald-400'), 2000);
    }
}

// Close dropdown when clicking outside
window.addEventListener('click', (e) => {
    if (!e.target.closest('#nav-search-container')) {
        document.getElementById('nav-search-dropdown').classList.add('hidden');
    }
});
</script>
