<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'Dashboard') - TemanBaik Admin</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 font-sans">

    <div class="flex min-h-screen">

        {{-- Sidebar --}}
        <aside class="w-64 bg-[#213F9A] text-white flex flex-col fixed inset-y-0 left-0 z-50">

            {{-- Logo --}}
            <div class="px-6 py-5 border-b border-[#02A6E0]">
                <h1 class="text-xl font-bold tracking-wide">TemanBaik</h1>
                <p class="text-xs text-[#02A6E0] mt-0.5">Admin Panel</p>
            </div>

            {{-- Navigasi --}}
            <nav class="flex-1 overflow-y-auto px-4 py-4 space-y-1">

                {{-- Dashboard --}}
                <a href="{{ route('admin.dashboard') }}"
                   class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition
                          {{ request()->routeIs('admin.dashboard') ? 'bg-[#02A6E0] font-semibold' : 'hover:bg-[#028AC9]' }}">
                    Dashboard
                </a>

                {{-- Markom --}}
                <div class="pt-3">
                    <p class="text-xs text-[#02A6E0] uppercase tracking-widest px-3 mb-1">Markom</p>

                    <a href="{{ route('admin.markom.home.index') }}"
                       class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition
                              {{ request()->routeIs('admin.markom.home.*') ? 'bg-[#02A6E0] font-semibold' : 'hover:bg-[#028AC9]' }}">
                        Beranda
                    </a>
                    <a href="{{ route('admin.markom.article.index') }}"
                       class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition
                              {{ request()->routeIs('admin.markom.article.*') ? 'bg-[#02A6E0] font-semibold' : 'hover:bg-[#028AC9]' }}">
                        Artikel
                    </a>
                    <a href="{{ route('admin.markom.news.index') }}"
                       class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition
                              {{ request()->routeIs('admin.markom.news.*') ? 'bg-[#02A6E0] font-semibold' : 'hover:bg-[#028AC9]' }}">
                        Berita
                    </a>
                    <a href="{{ route('admin.markom.program.index') }}"
                       class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition
                              {{ request()->routeIs('admin.markom.program.*') ? 'bg-[#02A6E0] font-semibold' : 'hover:bg-[#028AC9]' }}">
                        Program
                    </a>
                    <a href="{{ route('admin.markom.volunteer.index') }}"
                       class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition
                              {{ request()->routeIs('admin.markom.volunteer.*') ? 'bg-[#02A6E0] font-semibold' : 'hover:bg-[#028AC9]' }}">
                        Volunteer
                    </a>
                    <a href="{{ route('admin.markom.faq.index') }}"
                       class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition
                              {{ request()->routeIs('admin.markom.faq.*') ? 'bg-[#02A6E0] font-semibold' : 'hover:bg-[#028AC9]' }}">
                        FAQ
                    </a>
                    <a href="{{ route('admin.markom.mitra.index') }}"
                       class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition
                              {{ request()->routeIs('admin.markom.mitra.*') ? 'bg-[#02A6E0] font-semibold' : 'hover:bg-[#028AC9]' }}">
                        Mitra
                    </a>
                </div>

                {{-- Operasional --}}
                <div class="pt-3">
                    <p class="text-xs text-[#02A6E0] uppercase tracking-widest px-3 mb-1">Operasional</p>

                    <a href="{{ route('admin.operasional.donatur.index') }}"
                       class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition
                              {{ request()->routeIs('admin.operasional.donatur.*') ? 'bg-[#02A6E0] font-semibold' : 'hover:bg-[#028AC9]' }}">
                        Donatur
                    </a>
                    <a href="{{ route('admin.operasional.konfirmasi-donasi.index') }}"
                       class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition
                              {{ request()->routeIs('admin.operasional.konfirmasi-donasi.*') ? 'bg-[#02A6E0] font-semibold' : 'hover:bg-[#028AC9]' }}">
                        Konfirmasi Donasi
                    </a>
                    <a href="{{ route('admin.operasional.bantuan.index') }}"
                       class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition
                              {{ request()->routeIs('admin.operasional.bantuan.*') ? 'bg-[#02A6E0] font-semibold' : 'hover:bg-[#028AC9]' }}">
                        Bantuan
                    </a>
                    <a href="{{ route('admin.operasional.kemitraan.index') }}"
                       class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition
                              {{ request()->routeIs('admin.operasional.kemitraan.*') ? 'bg-[#02A6E0] font-semibold' : 'hover:bg-[#028AC9]' }}">
                        Kemitraan
                    </a>
                </div>

                {{-- Super Admin --}}
                @if(Auth::check() && Auth::user()->role === 'superadmin')
                <div class="pt-3">
                    <p class="text-xs text-[#02A6E0] uppercase tracking-widest px-3 mb-1">Super Admin</p>

                    <a href="{{ route('admin.superadmin.user.index') }}"
                       class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition
                              {{ request()->routeIs('admin.superadmin.user.*') ? 'bg-[#02A6E0] font-semibold' : 'hover:bg-[#028AC9]' }}">
                        Manajemen User
                    </a>
                </div>
                @endif

            </nav>

        </aside>

        {{-- Main Area --}}
        <div class="flex-1 flex flex-col ml-64">

            {{-- Top Navbar --}}
            <header class="bg-white shadow-sm px-6 py-4 flex items-center justify-between sticky top-0 z-40">
                <h2 class="text-lg font-semibold text-gray-700">
                    @yield('page-title', 'Dashboard')
                </h2>

                <div class="flex items-center gap-4">
                    <span class="text-sm text-gray-600">{{ Auth::user()->name }}</span>
                    <form action="{{ route('admin.logout') }}" method="POST">
                        @csrf
                        <button type="submit"
                                class="text-sm text-red-500 hover:text-red-700 transition">
                            Logout
                        </button>
                    </form>
                </div>
            </header>

            {{-- Content --}}
            <main class="flex-1 p-6">
                @yield('content')
            </main>

        </div>

    </div>

</body>
</html>
