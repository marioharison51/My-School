@props(['title' => null])

@php
    $navItems = match (auth()->user()->role) {
        'administrateur' => [
            ['label' => 'Tableau de bord', 'route' => 'admin.dashboard', 'active' => 'admin.dashboard', 'icon' => 'grid'],
            ['label' => 'Élèves', 'route' => 'students.index', 'active' => 'students.*', 'icon' => 'users'],
            ['label' => 'Cours', 'route' => 'courses.index', 'active' => 'courses.*', 'icon' => 'book'],
            ['label' => 'Examens', 'route' => 'exams.index', 'active' => 'exams.*|grades.*', 'icon' => 'clipboard'],
            ['label' => 'Bulletins', 'route' => 'bulletins.select', 'active' => 'bulletins.*', 'icon' => 'document'],
            ['label' => 'Factures', 'route' => 'invoices.index', 'active' => 'invoices.*', 'icon' => 'receipt'],
            ['label' => 'Annonces', 'route' => 'announcements.index', 'active' => 'announcements.*', 'icon' => 'megaphone'],
            ['label' => 'Messages', 'route' => 'messages.index', 'active' => 'messages.*', 'icon' => 'mail'],
            ['label' => 'Utilisateurs', 'route' => 'admin.users.index', 'active' => 'admin.users.*', 'icon' => 'user-cog'],
        ],
        default => [
            ['label' => 'Tableau de bord', 'route' => 'dashboard', 'active' => 'dashboard', 'icon' => 'grid'],
            ['label' => 'Messages', 'route' => 'messages.index', 'active' => 'messages.*', 'icon' => 'mail'],
        ],
    };

    $icons = [
        'grid' => 'M4 4h6v6H4V4zm10 0h6v6h-6V4zM4 14h6v6H4v-6zm10 0h6v6h-6v-6z',
        'users' => 'M9 11a3 3 0 100-6 3 3 0 000 6zM3 20c0-3.3 2.7-6 6-6s6 2.7 6 6M17 11a2.5 2.5 0 100-5M15 20c0-2-1-3.7-2.5-4.7',
        'book' => 'M4 5.5C4 4.7 4.7 4 5.5 4H12v16H5.5c-.8 0-1.5-.7-1.5-1.5v-13zM20 4h-6.5v16H20V4z',
        'clipboard' => 'M8 3h8v3H8V3zM6 6h12v15H6V6zm3 5h6M9 14h6',
        'document' => 'M6 3h9l3 3v15H6V3zM9 11h6M9 15h6',
        'receipt' => 'M6 3h12v18l-2-1.5L14 21l-2-1.5L10 21l-2-1.5L6 21V3zM9 8h6M9 12h6',
        'megaphone' => 'M3 10v4h3l6 4V6L6 10H3zM16 8c1 1 1 7 0 8',
        'mail' => 'M4 6h16v12H4V6zm0 0l8 6 8-6',
        'user-cog' => 'M9 11a3 3 0 100-6 3 3 0 000 6zM4 20c0-3 2.5-5.5 5.5-5.5S15 17 15 20M18 13v1.5M18 18.5V20M15.3 14.3l1 1M20.7 17.7l1 1M15.3 19.7l1-1M20.7 15.3l1-1',
    ];
@endphp

<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ $title ? $title . ' — ' : '' }}{{ config('app.name', 'Mety School') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-gray-50 text-gray-800">
        <div x-data="{ sidebarOpen: false }" class="flex min-h-screen">

            <div x-show="sidebarOpen" x-cloak @click="sidebarOpen = false"
                 class="fixed inset-0 bg-black/40 z-30 lg:hidden"></div>

            <aside
                :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'"
                class="fixed inset-y-0 left-0 z-40 w-64 bg-slate-900 text-slate-300 flex flex-col transition-transform duration-200 lg:static lg:translate-x-0">

                <div class="flex items-center gap-2 px-5 h-16 border-b border-slate-800">
                    <x-application-logo class="h-7 w-7 text-primary-500" />
                    <span class="font-bold text-white">{{ config('app.name', 'Mety School') }}</span>
                </div>

                <nav class="flex-1 overflow-y-auto py-4 px-3 space-y-1">
                    @foreach ($navItems as $item)
                        <a href="{{ route($item['route']) }}"
                           class="flex items-center gap-3 px-3 py-2 rounded-md text-sm font-medium transition
                                  {{ request()->routeIs(...explode('|', $item['active']))
                                        ? 'bg-primary-600 text-white'
                                        : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                            <svg class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
                                <path stroke-linecap="round" stroke-linejoin="round" d="{{ $icons[$item['icon']] }}" />
                            </svg>
                            {{ $item['label'] }}
                        </a>
                    @endforeach
                </nav>

                <div class="border-t border-slate-800 p-3">
                    <a href="{{ route('profile.edit') }}"
                       class="flex items-center gap-3 px-3 py-2 rounded-md text-sm text-slate-300 hover:bg-slate-800 hover:text-white">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 12a4 4 0 100-8 4 4 0 000 8zM4 20c0-3.3 2.7-6 6-6h4c3.3 0 6 2.7 6 6" />
                        </svg>
                        Mon profil
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full flex items-center gap-3 px-3 py-2 rounded-md text-sm text-slate-300 hover:bg-slate-800 hover:text-white">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m4 6H5a2 2 0 01-2-2V6a2 2 0 012-2h6" />
                            </svg>
                            Déconnexion
                        </button>
                    </form>
                </div>
            </aside>

            <div class="flex-1 flex flex-col min-w-0">

                <header class="h-16 bg-white border-b border-gray-200 flex items-center justify-between px-4 lg:px-8">
                    <div class="flex items-center gap-3">
                        <button @click="sidebarOpen = true" class="lg:hidden text-gray-500">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                        </button>
                        <h1 class="font-semibold text-gray-900">{{ $title }}</h1>
                    </div>

                    <div class="flex items-center gap-3">
                        <div class="text-right hidden sm:block">
                            <div class="text-sm font-medium text-gray-900">{{ auth()->user()->name }}</div>
                            <div class="text-xs text-gray-400">{{ ucfirst(auth()->user()->role) }}</div>
                        </div>
                        <div class="w-9 h-9 rounded-full bg-primary-100 text-primary-700 flex items-center justify-center font-semibold">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </div>
                    </div>
                </header>

                <main class="flex-1 p-4 lg:p-8">
                    {{ $slot }}
                </main>

            </div>
        </div>
    </body>
</html>
