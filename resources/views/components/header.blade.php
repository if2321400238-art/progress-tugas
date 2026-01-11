<!-- Top Navigation Bar -->
<nav class="bg-gradient-to-r from-emerald-50 to-teal-50 border-b border-emerald-100 sticky top-0 z-40 shadow-soft-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <!-- Inline Search replaces logo -->
            <x-nav-search />

            <!-- Right Section: Notifications only -->
            <div class="flex items-center gap-4">
                <div class="relative" id="notifications-container">
                    <button onclick="toggleNotifications(event)"
                            class="relative p-2.5 text-gray-600 hover:text-emerald-600 hover:bg-white rounded-xl transition-all"
                            title="Notifikasi">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0018 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                        </svg>
                        <span id="notification-badge" class="absolute top-1 right-1 w-2.5 h-2.5 bg-red-500 rounded-full hidden"></span>
                    </button>

                    <!-- Notification Dropdown -->
                    <div id="notifications-dropdown"
                         class="hidden absolute right-0 mt-2 w-80 bg-white rounded-2xl shadow-soft-lg border border-gray-100 overflow-hidden animate-fade-in">
                        <div class="p-4 bg-gradient-to-r from-emerald-50 to-teal-50 border-b border-emerald-100">
                            <h3 class="font-semibold text-gray-800">Notifikasi</h3>
                        </div>
                        <div id="notifications-list" class="max-h-96 overflow-y-auto">
                            <div class="p-8 text-center text-gray-500">
                                <p class="text-sm">Tidak ada notifikasi baru</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>

<script>
function toggleUserMenu(e) {
    e.stopPropagation();
    document.getElementById('notifications-dropdown').classList.add('hidden');
}

function toggleNotifications(e) {
    e.stopPropagation();
    document.getElementById('notifications-dropdown').classList.toggle('hidden');
}

document.addEventListener('click', () => {
    document.getElementById('notifications-dropdown').classList.add('hidden');
});

// Load notifications
function loadNotifications() {
    const container = document.getElementById('notifications-list');
    const badge = document.getElementById('notification-badge');

    // Get notifications from database
    fetch('/api/notifications')
        .then(r => r.json())
        .then(data => {
            if (data.notifications && data.notifications.length > 0) {
                badge.classList.remove('hidden');
                container.innerHTML = data.notifications.map(n => `
                    <div class="p-4 border-b border-gray-100 hover:bg-gray-50 transition-colors">
                        <p class="text-sm font-semibold text-gray-800">${n.title}</p>
                        <p class="text-xs text-gray-600 mt-1">${n.message}</p>
                        <p class="text-xs text-gray-400 mt-2">${n.time}</p>
                    </div>
                `).join('');
            }
        });
}

loadNotifications();
setInterval(loadNotifications, 30000); // Refresh every 30s
</script>
