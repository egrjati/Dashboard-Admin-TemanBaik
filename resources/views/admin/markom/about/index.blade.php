@extends('admin.layouts.app')

@section('title', 'Tentang Kami')
@section('page-title', 'Tentang Kami')

@section('content')

    {{-- Flash message --}}
    @if(session('success'))
        <div class="mb-4 px-4 py-3 rounded-lg bg-green-50 border border-green-200 text-green-700 text-sm">
            {{ session('success') }}
        </div>
    @endif

    {{-- Section Hero --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">

        {{-- Header card --}}
        <div class="px-6 py-4 border-b border-gray-100 flex items-center gap-3 bg-gradient-to-r from-slate-50 to-white">
            <div class="w-9 h-9 rounded-xl flex items-center justify-center shrink-0"
                 style="background: linear-gradient(135deg, rgba(2,166,224,0.12) 0%, rgba(33,63,154,0.08) 100%); border: 1px solid rgba(2,166,224,0.2)">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-[18px] h-[18px]" fill="none" viewBox="0 0 24 24" stroke="#02A6E0" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
            </div>
            <div>
                <h3 class="font-semibold text-gray-800 text-sm">Section Hero</h3>
                <p class="text-xs text-gray-400 mt-0.5">Gambar latar, judul, dan deskripsi di bagian atas halaman Tentang Kami</p>
            </div>
        </div>

        {{-- Preview gambar saat ini --}}
        @if($hero->image)
            <div class="px-6 pt-5">
                <p class="text-xs text-gray-400 font-medium uppercase tracking-wider mb-2">Preview Saat Ini</p>
                <div class="relative w-full h-48 rounded-xl overflow-hidden bg-gray-100">
                    <img src="{{ Storage::url($hero->image) }}"
                         alt="Hero About"
                         class="w-full h-full object-cover">
                    <div class="absolute inset-0 bg-[#0f172a]/60 flex flex-col items-center justify-center text-center px-4">
                        <p class="text-white font-bold text-xl">{{ $hero->title }}</p>
                        <p class="text-gray-300 text-sm mt-1 max-w-md">{{ $hero->description }}</p>
                    </div>
                </div>
            </div>
        @endif

        {{-- Form edit hero --}}
        <form action="{{ route('admin.markom.about.update', $hero) }}" method="POST" enctype="multipart/form-data"
              class="px-6 py-6 space-y-5">
            @csrf
            @method('PUT')

            {{-- Gambar --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">
                    Gambar Hero <span class="text-gray-400 font-normal">(landscape, min. 1600×700px)</span>
                </label>
                <input type="file" name="image" accept="image/*"
                       class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-[#02A6E0]/10 file:text-[#02A6E0] hover:file:bg-[#02A6E0]/20 transition">
                @error('image')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Judul --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Judul</label>
                <input type="text" name="title" value="{{ old('title', $hero->title) }}"
                       placeholder="cth: Tentang Teman Baik"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#02A6E0]/40 focus:border-[#02A6E0]"
                       required>
                @error('title')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Deskripsi --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Deskripsi</label>
                <textarea name="description" rows="3"
                          placeholder="cth: Kami hadir untuk menjadi jembatan kebaikan..."
                          class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#02A6E0]/40 focus:border-[#02A6E0] resize-none">{{ old('description', $hero->description) }}</textarea>
                @error('description')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Tombol simpan --}}
            <div class="flex justify-end pt-2">
                <button type="submit"
                        class="inline-flex items-center gap-2 bg-[#02A6E0] hover:bg-[#028AC9] text-white text-sm font-semibold px-5 py-2.5 rounded-lg transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                    </svg>
                    Simpan Perubahan
                </button>
            </div>

        </form>
    </div>

    {{-- Section Kisah kami --}}

@endsection
