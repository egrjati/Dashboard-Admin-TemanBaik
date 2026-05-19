<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
                @php $markomActive = request()->routeIs('admin.markom.*') @endphp
                <div class="pt-2">
                    <button onclick="toggleSection('markom')"
                            class="w-full flex items-center justify-between px-3 py-1.5 rounded-lg transition hover:bg-[#1a3280] group">
                        <span class="text-xs text-[#02A6E0] uppercase tracking-widest font-semibold">Markom</span>
                        <svg id="arrow-markom"
                             class="w-3.5 h-3.5 text-[#02A6E0] transition-transform duration-300 {{ $markomActive ? 'rotate-180' : '' }}"
                             fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>

                    <div id="section-markom"
                         class="overflow-hidden transition-all duration-300 {{ $markomActive ? '' : 'hidden' }}">
                        <div class="mt-1 space-y-0.5">
                            {{-- Home --}}
                            <a href="{{ route('admin.markom.home.index') }}"
                               class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition
                                      {{ request()->routeIs('admin.markom.home.*') ? 'bg-[#02A6E0] font-semibold' : 'hover:bg-[#028AC9]' }}">
                                Beranda
                            </a>
                            {{-- About us --}}
                            <a href="{{ route('admin.markom.about.index') }}"
                               class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition
                                      {{ request()->routeIs('admin.markom.about.*') ? 'bg-[#02A6E0] font-semibold' : 'hover:bg-[#028AC9]' }}">
                                Tentang Kami
                            </a>
                            {{-- Program --}}
                             <a href="{{ route('admin.markom.program.index') }}"
                               class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition
                                      {{ request()->routeIs('admin.markom.program.*') ? 'bg-[#02A6E0] font-semibold' : 'hover:bg-[#028AC9]' }}">
                                Program
                            </a>
                            {{-- Artikel --}}
                            <a href="{{ route('admin.markom.article.index') }}"
                               class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition
                                      {{ request()->routeIs('admin.markom.article.*') ? 'bg-[#02A6E0] font-semibold' : 'hover:bg-[#028AC9]' }}">
                                Artikel
                            </a>
                            {{-- News --}}
                            <a href="{{ route('admin.markom.news.index') }}"
                               class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition
                                      {{ request()->routeIs('admin.markom.news.*') ? 'bg-[#02A6E0] font-semibold' : 'hover:bg-[#028AC9]' }}">
                                Berita
                            </a>
                            {{-- Volunteer --}}
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
                    </div>
                </div>

                {{-- Operasional --}}
                @php $opsActive = request()->routeIs('admin.operasional.*') @endphp
                <div class="pt-2">
                    <button onclick="toggleSection('operasional')"
                            class="w-full flex items-center justify-between px-3 py-1.5 rounded-lg transition hover:bg-[#1a3280] group">
                        <span class="text-xs text-[#02A6E0] uppercase tracking-widest font-semibold">Operasional</span>
                        <svg id="arrow-operasional"
                             class="w-3.5 h-3.5 text-[#02A6E0] transition-transform duration-300 {{ $opsActive ? 'rotate-180' : '' }}"
                             fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>

                    <div id="section-operasional"
                         class="overflow-hidden transition-all duration-300 {{ $opsActive ? '' : 'hidden' }}">
                        <div class="mt-1 space-y-0.5">
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
                    </div>
                </div>

                {{-- Super Admin --}}
                @if(Auth::check() && Auth::user()->role === 'superadmin')
                @php $saActive = request()->routeIs('admin.superadmin.*') @endphp
                <div class="pt-2">
                    <button onclick="toggleSection('superadmin')"
                            class="w-full flex items-center justify-between px-3 py-1.5 rounded-lg transition hover:bg-[#1a3280] group">
                        <span class="text-xs text-[#02A6E0] uppercase tracking-widest font-semibold">Super Admin</span>
                        <svg id="arrow-superadmin"
                             class="w-3.5 h-3.5 text-[#02A6E0] transition-transform duration-300 {{ $saActive ? 'rotate-180' : '' }}"
                             fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>

                    <div id="section-superadmin"
                         class="overflow-hidden transition-all duration-300 {{ $saActive ? '' : 'hidden' }}">
                        <div class="mt-1 space-y-0.5">
                            <a href="{{ route('admin.superadmin.user.index') }}"
                               class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition
                                      {{ request()->routeIs('admin.superadmin.user.*') ? 'bg-[#02A6E0] font-semibold' : 'hover:bg-[#028AC9]' }}">
                                Manajemen User
                            </a>
                        </div>
                    </div>
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

    <script>
        function toggleSection(name) {
            const section = document.getElementById('section-' + name);
            const arrow   = document.getElementById('arrow-' + name);

            if (section.classList.contains('hidden')) {
                section.classList.remove('hidden');
                arrow.classList.add('rotate-180');
            } else {
                section.classList.add('hidden');
                arrow.classList.remove('rotate-180');
            }
        }
    </script>

</body>
</html>
