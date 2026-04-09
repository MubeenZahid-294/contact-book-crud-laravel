<!DOCTYPE html>
<html lang="en" id="htmlRoot">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ContactBook</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Inter', 'sans-serif'] },
                    colors: {
                        brand: {
                            50:  '#eef2ff',
                            100: '#e0e7ff',
                            500: '#6366f1',
                            600: '#4f46e5',
                            700: '#4338ca',
                        }
                    }
                }
            }
        }
    </script>
    <style>
    body { font-family: 'Inter', sans-serif; }
    .sidebar-link {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 10px 16px;
    border-radius: 8px;
    font-size: 14px;
    font-weight: 500;
    color: #94a3b8;
    transition: all 0.2s;
    text-decoration: none;
}
.sidebar-link:hover {
    background-color: rgba(255,255,255,0.1);
    color: #ffffff;
}
.sidebar-link.active {
    background-color: rgba(255,255,255,0.1);
    color: #ffffff;
}

    /* Dark Mode Overrides */
    .dark body { background-color: #0f172a; }
    .dark header { background-color: #1e293b !important; border-color: #334155 !important; }
    .dark main { background-color: #0f172a; }
    .dark .bg-white { background-color: #1e293b !important; }
    .dark .bg-slate-100 { background-color: #0f172a !important; }
    .dark .border-slate-200 { border-color: #334155 !important; }
    .dark .text-slate-800 { color: #f1f5f9 !important; }
    .dark .text-slate-700 { color: #cbd5e1 !important; }
    .dark .text-slate-600 { color: #94a3b8 !important; }
    .dark .text-slate-500 { color: #64748b !important; }
    .dark .text-slate-400 { color: #475569 !important; }
    .dark .bg-slate-50  { background-color: #1e293b !important; }
    .dark .bg-gray-100  { background-color: #0f172a !important; }
    .dark .bg-green-50  { background-color: #052e16 !important; }
    .dark .text-green-700 { color: #4ade80 !important; }
    .dark .border-green-200 { border-color: #166534 !important; }
    .dark input, .dark textarea, .dark select {
        background-color: #1e293b !important;
        border-color: #334155 !important;
        color: #f1f5f9 !important;
    }
    .dark input::placeholder, .dark textarea::placeholder {
        color: #475569 !important;
    }
    .dark .divide-y > * { border-color: #334155 !important; }
    .dark .border-t { border-color: #334155 !important; }
    .dark .hover\:bg-slate-50:hover { background-color: #1e293b !important; }
    .dark .hover\:bg-gray-50:hover  { background-color: #1e293b !important; }
    .dark .bg-brand-50  { background-color: #1e1b4b !important; }
    .dark .text-brand-600 { color: #818cf8 !important; }
    .dark .bg-red-50 { background-color: #2d0a0a !important; }
    .dark .text-red-500 { color: #f87171 !important; }
    .dark .bg-yellow-50 { background-color: #2d1f00 !important; }
    .dark .text-yellow-500 { color: #fbbf24 !important; }
</style>
</head>
<body class="bg-slate-100 flex h-screen overflow-hidden">

    <!-- Sidebar -->
    <aside class="w-64 bg-slate-900 flex flex-col flex-shrink-0">
        <!-- Logo -->
        <div class="px-6 py-5 border-b border-white/10">
            <span class="text-white font-bold text-lg tracking-tight">📒 ContactBook</span>
        </div>

        <!-- Nav -->
        <nav class="flex-1 px-3 py-4 space-y-1">

            {{-- All Contacts --}}
            <a href="{{ route('contacts.index') }}"
               class="sidebar-link {{ request()->routeIs('contacts.index') && !request('filter') ? 'active' : '' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M17 20h5v-2a4 4 0 00-4-4H6a4 4 0 00-4 4v2h5M12 12a4 4 0 100-8 4 4 0 000 8z"/>
                </svg>
                All Contacts
            </a>

            {{-- Dashboard --}}
            <a href="{{ route('contacts.stats') }}"
               class="sidebar-link {{ request()->routeIs('contacts.stats') ? 'active' : '' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                </svg>
                Dashboard
            </a>

            {{-- Favorites --}}
            <a href="{{ route('contacts.index', ['filter' => 'favorites']) }}"
               class="sidebar-link {{ request('filter') === 'favorites' ? 'active' : '' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                </svg>
                Favorites
            </a>

            {{-- Tags --}}
            <a href="{{ route('tags.index') }}"
               class="sidebar-link {{ request()->routeIs('tags.*') ? 'active' : '' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-5 5a2 2 0 01-2.828 0l-7-7A2 2 0 013 8V5a2 2 0 012-2z"/>
                </svg>
                Tags
            </a>

            {{-- Dark Mode --}}
            <button onclick="toggleDark()"
                    class="sidebar-link w-full text-left" id="darkBtn">
                <svg id="darkIcon" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
                </svg>
                <span id="darkLabel">Dark Mode</span>
            </button>

            {{-- Add Contact --}}
            <a href="{{ route('contacts.create') }}"
               class="sidebar-link {{ request()->routeIs('contacts.create') ? 'active' : '' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M12 4v16m8-8H4"/>
                </svg>
                Add Contact
            </a>

        </nav>

        <!-- User -->
        <div class="px-3 py-4 border-t border-white/10">
            <a href="{{ route('profile.edit') }}"
   class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-white/10 transition">
    <div class="w-8 h-8 rounded-full bg-brand-600 flex items-center justify-center text-white text-xs font-bold">
        {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
    </div>
    <div class="flex-1 min-w-0">
        <p class="text-white text-sm font-medium truncate">{{ auth()->user()->name }}</p>
        <p class="text-slate-400 text-xs truncate">{{ auth()->user()->email }}</p>
    </div>
</a>
            <form method="POST" action="{{ route('logout') }}" class="mt-2">
                @csrf
                <button type="submit"
                        class="w-full text-left sidebar-link text-red-400 hover:text-red-300">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h6a2 2 0 012 2v1"/>
                    </svg>
                    Logout
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content -->
    <div class="flex-1 flex flex-col overflow-hidden">

        <!-- Top Bar -->
        <header class="bg-white border-b border-slate-200 px-8 py-4 flex items-center justify-between flex-shrink-0">
            <div>
                <h1 class="text-lg font-semibold text-slate-800">@yield('page-title', 'Contacts')</h1>
                <p class="text-xs text-slate-400 mt-0.5">@yield('page-subtitle', 'Manage your contacts')</p>
            </div>
           {{-- Notification Bell --}}
<div class="relative" id="notifWrapper">
    <button onclick="toggleNotifications()"
            class="relative p-2 rounded-lg hover:bg-slate-100 transition" id="bellBtn">
        <svg class="w-5 h-5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
        </svg>
        {{-- Badge --}}
        <span id="notifBadge"
              class="absolute -top-1 -right-1 w-5 h-5 bg-red-500 text-white text-xs rounded-full hidden items-center justify-center font-bold">
            0
        </span>
    </button>

    {{-- Dropdown --}}
    <div id="notifDropdown"
         class="hidden absolute right-0 top-12 w-80 bg-white rounded-xl shadow-lg border border-slate-200 z-50 overflow-hidden">

        {{-- Header --}}
        <div class="flex items-center justify-between px-4 py-3 border-b border-slate-100">
            <span class="text-sm font-semibold text-slate-700">Notifications</span>
            <button onclick="markAllRead()"
                    class="text-xs text-brand-600 hover:underline">
                Mark all read
            </button>
        </div>

        {{-- List --}}
        <div id="notifList" class="max-h-80 overflow-y-auto divide-y divide-slate-50">
            <div class="px-4 py-6 text-center text-slate-400 text-sm" id="notifEmpty">
                No notifications yet
            </div>
        </div>
    </div>
</div>
            <a href="{{ route('contacts.create') }}"
               class="bg-brand-600 hover:bg-brand-700 text-white text-sm font-medium px-4 py-2 rounded-lg transition flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                New Contact
            </a>
        </header>

        <!-- Page Body -->
        <main class="flex-1 overflow-y-auto px-8 py-6">
            @if(session('success'))
                <div class="mb-5 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg text-sm flex items-center gap-2">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"/>
                    </svg>
                    {{ session('success') }}
                </div>
            @endif

            @yield('content')
        </main>
    </div>
<script>
    // Apply saved preference on page load
    const saved = localStorage.getItem('darkMode');
    if (saved === 'true') {
        document.getElementById('htmlRoot').classList.add('dark');
        updateBtn(true);
    }

    function toggleDark() {
        const html = document.getElementById('htmlRoot');
        const isDark = html.classList.toggle('dark');
        localStorage.setItem('darkMode', isDark);
        updateBtn(isDark);
    }

    function updateBtn(isDark) {
        const label = document.getElementById('darkLabel');
        const icon  = document.getElementById('darkIcon');
        if (!label || !icon) return;

        if (isDark) {
            label.textContent = 'Light Mode';
            icon.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/>`;
        } else {
            label.textContent = 'Dark Mode';
            icon.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>`;
        }
    }
    // Notifications
let notifOpen = false;

async function loadNotifCount() {
    try {
        const res  = await fetch('{{ route("notifications.count") }}');
        const data = await res.json();
        const badge = document.getElementById('notifBadge');
        if (data.count > 0) {
            badge.textContent = data.count > 9 ? '9+' : data.count;
            badge.classList.remove('hidden');
            badge.classList.add('flex');
        } else {
            badge.classList.add('hidden');
            badge.classList.remove('flex');
        }
    } catch(e) {}
}

async function toggleNotifications() {
    const dropdown = document.getElementById('notifDropdown');
    notifOpen = !notifOpen;

    if (notifOpen) {
        dropdown.classList.remove('hidden');
        await loadNotifications();
    } else {
        dropdown.classList.add('hidden');
    }
}

async function loadNotifications() {
    try {
        const res   = await fetch('{{ route("notifications.index") }}');
        const items = await res.json();
        const list  = document.getElementById('notifList');
        const empty = document.getElementById('notifEmpty');

        // Reset badge after reading
        const badge = document.getElementById('notifBadge');
        badge.classList.add('hidden');
        badge.classList.remove('flex');

        if (items.length === 0) {
            list.innerHTML = `<div class="px-4 py-6 text-center text-slate-400 text-sm">No notifications yet</div>`;
            return;
        }

        list.innerHTML = items.map(n => `
            <div class="flex items-start gap-3 px-4 py-3 hover:bg-slate-50 transition ${n.is_read ? 'opacity-60' : ''}" id="notif-${n.id}">
                <div class="w-8 h-8 rounded-full flex items-center justify-center flex-shrink-0 ${
                    n.type === 'success' ? 'bg-green-100 text-green-600' :
                    n.type === 'info'    ? 'bg-blue-100 text-blue-600' :
                    'bg-red-100 text-red-600'
                }">
                    ${n.type === 'success' ? '✓' : n.type === 'info' ? '✎' : '✕'}
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-xs text-slate-700 font-medium">${n.message}</p>
                    <p class="text-xs text-slate-400 mt-0.5">${timeAgo(n.created_at)}</p>
                </div>
                <button onclick="deleteNotif(${n.id})"
                        class="text-slate-300 hover:text-red-400 transition text-xs flex-shrink-0">✕</button>
            </div>
        `).join('');
    } catch(e) {}
}

async function markAllRead() {
    await fetch('{{ route("notifications.markAll") }}', {
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
    });
    loadNotifications();
}

async function deleteNotif(id) {
    await fetch(`/notifications/${id}`, {
        method: 'DELETE',
        headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
    });
    document.getElementById(`notif-${id}`)?.remove();
}

function timeAgo(dateStr) {
    const diff = Math.floor((new Date() - new Date(dateStr)) / 1000);
    if (diff < 60)   return 'just now';
    if (diff < 3600) return Math.floor(diff / 60) + 'm ago';
    if (diff < 86400) return Math.floor(diff / 3600) + 'h ago';
    return Math.floor(diff / 86400) + 'd ago';
}

// Close dropdown when clicking outside
document.addEventListener('click', function(e) {
    const wrapper = document.getElementById('notifWrapper');
    if (wrapper && !wrapper.contains(e.target)) {
        document.getElementById('notifDropdown').classList.add('hidden');
        notifOpen = false;
    }
});

// Load count on page load
loadNotifCount();

// Refresh count every 30 seconds
setInterval(loadNotifCount, 30000);
</script>
</body>
</html>