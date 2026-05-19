@extends('admin.layouts.app')

@section('title', 'Berita')
@section('page-title', 'Berita')

@section('content')

    {{-- Flash message --}}
    @if(session('success'))
        <div class="mb-4 px-4 py-3 rounded-lg bg-green-50 border border-green-200 text-green-700 text-sm">
            {{ session('success') }}
        </div>
    @endif

   
    {{-- Section Hero --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden mb-10">
        <div class="px-6 py-4 border-b border-gray-100 flex items-center gap-3 bg-gradient-to-r from-slate-50 to-white">
            <div class="w-9 h-9 rounded-xl flex items-center justify-center shrink-0"
                 style="background: linear-gradient(135deg, rgba(2,166,224,0.12) 0%, rgba(33,63,154,0.08) 100%); border: 1px solid rgba(2,166,224,0.2)">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-[18px] h-[18px]" fill="none" viewBox="0 0 24 24" stroke="#02A6E0" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
            </div>
            <div>
                <h3 class="font-semibold text-gray-800 text-sm">Section Hero</h3>
                <p class="text-xs text-gray-400 mt-0.5">Gambar latar, judul, dan deskripsi di bagian atas halaman Berita</p>
            </div>
        </div>

        <form action="{{ route('admin.markom.news.updateHero') }}" method="POST"
              enctype="multipart/form-data" class="px-6 py-6 space-y-5">
            @csrf
            @method('PUT')

            {{-- Preview --}}
            <div class="relative w-full h-48 rounded-xl overflow-hidden bg-[#0f172a]">
                @if($hero->bg_image)
                    <img src="{{ Storage::url($hero->bg_image) }}"
                         alt="Hero Berita" class="w-full h-full object-cover opacity-60">
                @endif
                <div class="absolute inset-0 flex flex-col items-center justify-center text-center px-4 gap-1">
                    <p class="text-white font-bold text-xl drop-shadow">{{ $hero->heading }}</p>
                    @if($hero->description)
                        <p class="text-gray-300 text-xs max-w-md">{{ $hero->description }}</p>
                    @endif
                </div>
            </div>

            {{-- Gambar --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">
                    Gambar Latar <span class="text-gray-400 font-normal">(landscape, min. 1600×700px)</span>
                </label>
                <input type="file" name="bg_image" accept="image/*"
                       class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-[#02A6E0]/10 file:text-[#02A6E0] hover:file:bg-[#02A6E0]/20 transition">
                @error('bg_image') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Judul --}}
            <div>
                <label class="block text-xs font-medium text-gray-600 mb-1">
                    Judul <span class="text-red-500">*</span>
                </label>
                <input type="text" name="heading" value="{{ old('heading', $hero->heading) }}"
                       class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#02A6E0]/30 focus:border-[#02A6E0]"
                       placeholder="cth: Berita & Kabar Terbaru" required>
                @error('heading') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Deskripsi --}}
            <div>
                <label class="block text-xs font-medium text-gray-600 mb-1">Deskripsi</label>
                <textarea name="description" rows="2"
                          class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#02A6E0]/30 focus:border-[#02A6E0] resize-none"
                          placeholder="Tulis deskripsi singkat...">{{ old('description', $hero->description) }}</textarea>
                @error('description') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="flex justify-end pt-1">
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

    {{-- Section Sticky / Banner Iklan --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden mb-10">
        <div class="px-6 py-4 border-b border-gray-100 flex items-center gap-3 bg-gradient-to-r from-slate-50 to-white">
            <div class="w-9 h-9 rounded-xl flex items-center justify-center shrink-0"
                 style="background: linear-gradient(135deg, rgba(2,166,224,0.12) 0%, rgba(33,63,154,0.08) 100%); border: 1px solid rgba(2,166,224,0.2)">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-[18px] h-[18px]" fill="none" viewBox="0 0 24 24" stroke="#02A6E0" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/>
                </svg>
            </div>
            <div>
                <h3 class="font-semibold text-gray-800 text-sm">Banner Iklan (Sticky)</h3>
                <p class="text-xs text-gray-400 mt-0.5">Gambar iklan yang tampil di bagian atas halaman detail berita</p>
            </div>
        </div>

        <form action="{{ route('admin.markom.news.updateBanner') }}" method="POST"
              enctype="multipart/form-data" class="px-6 py-6 space-y-5">
            @csrf
            @method('PUT')

            {{-- Preview --}}
            <div>
                <p class="text-xs text-gray-400 font-medium uppercase tracking-wider mb-2">Preview Saat Ini</p>
                @if($banner->image)
                    <div class="relative w-full h-36 rounded-xl overflow-hidden bg-gray-100">
                        <img src="{{ Storage::url($banner->image) }}"
                             alt="{{ $banner->alt ?? 'Banner' }}"
                             class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-black/20 flex items-center justify-center">
                            <span class="text-white text-xs font-semibold bg-black/40 px-3 py-1 rounded-full uppercase tracking-widest">
                                Advertisement
                            </span>
                        </div>
                    </div>
                @else
                    <div class="w-full h-36 rounded-xl bg-gray-100 border border-dashed border-gray-300 flex items-center justify-center">
                        <span class="text-gray-400 text-xs font-semibold uppercase tracking-widest">Belum ada gambar</span>
                    </div>
                @endif
            </div>

            {{-- Upload Gambar --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">
                    Gambar Banner <span class="text-gray-400 font-normal">(landscape, rasio 16:9 atau 4:1)</span>
                </label>
                <input type="file" name="image" accept="image/*"
                       class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-[#02A6E0]/10 file:text-[#02A6E0] hover:file:bg-[#02A6E0]/20 transition">
                @error('image') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Link & Alt --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1">
                        Link Tujuan
                        <span class="text-gray-400 font-normal">(opsional, klik banner menuju URL ini)</span>
                    </label>
                    <input type="url" name="link" value="{{ old('link', $banner->link) }}"
                           class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#02A6E0]/30 focus:border-[#02A6E0]"
                           placeholder="https://...">
                    @error('link') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1">
                        Teks Alt
                        <span class="text-gray-400 font-normal">(deskripsi gambar untuk aksesibilitas)</span>
                    </label>
                    <input type="text" name="alt" value="{{ old('alt', $banner->alt) }}"
                           class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#02A6E0]/30 focus:border-[#02A6E0]"
                           placeholder="cth: Banner donasi Ramadan 2026">
                    @error('alt') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="flex justify-end pt-1">
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


    {{-- Section Tabel Berita --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">

        <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between bg-gradient-to-r from-slate-50 to-white">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-xl flex items-center justify-center shrink-0"
                     style="background: linear-gradient(135deg, rgba(2,166,224,0.12) 0%, rgba(33,63,154,0.08) 100%); border: 1px solid rgba(2,166,224,0.2)">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-[18px] h-[18px]" fill="none" viewBox="0 0 24 24" stroke="#02A6E0" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                    </svg>
                </div>
                <div>
                    <h3 class="font-semibold text-gray-800 text-sm">Daftar Berita</h3>
                    <p class="text-xs text-gray-400 mt-0.5">Kelola berita yang tampil di halaman Kabar Baik</p>
                </div>
            </div>
            <div class="flex items-center gap-3">
                <span class="text-xs text-gray-400 bg-gray-100 px-2.5 py-1 rounded-full font-medium">{{ $news->count() }} berita</span>
                <button onclick="openModal()"
                        class="inline-flex items-center gap-1.5 bg-[#02A6E0] hover:bg-[#028AC9] text-white text-xs font-semibold px-3.5 py-2 rounded-lg transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                    </svg>
                    Tambah Berita
                </button>
            </div>
        </div>

        <table class="w-full text-sm text-left">
            <thead class="bg-gray-50 text-gray-500 uppercase text-xs tracking-wider">
                <tr>
                    <th class="px-4 py-3">Cover</th>
                    <th class="px-4 py-3">Judul</th>
                    <th class="px-4 py-3">Kategori</th>
                    <th class="px-4 py-3 text-center">Tier</th>
                    <th class="px-4 py-3 text-center">Status</th>
                    <th class="px-4 py-3">Tanggal</th>
                    <th class="px-4 py-3 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($news as $item)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-4 py-3">
                            @if($item->image)
                                <img src="{{ Storage::url($item->image) }}"
                                     alt="{{ $item->title }}"
                                     class="w-24 h-14 object-cover rounded-lg">
                            @else
                                <div class="w-24 h-14 bg-gray-100 rounded-lg flex items-center justify-center text-gray-300 text-xs">
                                    No image
                                </div>
                            @endif
                        </td>
                        <td class="px-4 py-3 max-w-xs">
                            <p class="font-medium text-gray-800 line-clamp-2 text-xs leading-snug">{{ $item->title }}</p>
                            @if($item->excerpt)
                                <p class="text-gray-400 text-xs mt-0.5 line-clamp-1">{{ $item->excerpt }}</p>
                            @endif
                        </td>
                        <td class="px-4 py-3">
                            <span class="inline-block bg-[#213F9A]/10 text-[#213F9A] text-xs font-semibold px-2 py-0.5 rounded-full">
                                {{ $item->category }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-center">
                            @if($item->tier === 'hero')
                                <span class="inline-block bg-[#02A6E0]/10 text-[#02A6E0] text-xs font-semibold px-2 py-0.5 rounded-full">Hero</span>
                            @elseif($item->tier === 'highlight')
                                <span class="inline-block bg-indigo-100 text-indigo-600 text-xs font-semibold px-2 py-0.5 rounded-full">Highlight</span>
                            @else
                                <span class="inline-block bg-gray-100 text-gray-500 text-xs font-semibold px-2 py-0.5 rounded-full">Regular</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-center">
                            @if($item->is_published)
                                <span class="inline-block bg-green-100 text-green-600 text-xs font-semibold px-2 py-0.5 rounded-full">Tayang</span>
                            @else
                                <span class="inline-block bg-yellow-100 text-yellow-600 text-xs font-semibold px-2 py-0.5 rounded-full">Draft</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-xs text-gray-500">
                            {{ $item->published_at ? $item->published_at->format('d M Y') : '-' }}
                        </td>
                       {{-- section edit & hapus--}}
<td class="px-4 py-3 text-center">
    <div class="flex items-center justify-center gap-3">
        <button
            onclick="openModal(this)"
            data-id="{{ $item->id }}"
            data-title="{{ $item->title }}"
            data-excerpt="{{ $item->excerpt ?? '' }}"
            data-content="{{ $item->content ?? '' }}"
            data-category="{{ $item->category }}"
            data-tier="{{ $item->tier }}"
            data-published-at="{{ $item->published_at ? $item->published_at->format('Y-m-d') : '' }}"
            data-is-published="{{ $item->is_published ? '1' : '0' }}"
            data-image="{{ $item->image ? Storage::url($item->image) : '' }}"
            class="text-xs font-semibold text-[#02A6E0] hover:underline">
            Edit
        </button>

        <form action="{{ route('admin.markom.news.destroy', $item) }}" method="POST"
              onsubmit="return confirm('Hapus berita ini?')" class="flex items-center"> {{-- Ditambahkan flex items-center --}}
            @csrf
            @method('DELETE')
            <button type="submit" class="text-xs font-semibold text-red-500 hover:underline">Hapus</button>
        </form>
    </div>
</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-4 py-16 text-center text-gray-400 text-sm">
                            Belum ada berita. Klik "Tambah Berita" untuk memulai.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Modal Tambah / Edit Berita --}}
    <div id="news-modal-overlay"
         class="fixed inset-0 bg-black/50 z-50 items-center justify-center hidden"
         onclick="if(event.target===this) closeModal()">

        <div class="bg-white rounded-2xl shadow-xl w-full max-w-2xl mx-4 max-h-[92vh] overflow-y-auto">

            <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100 sticky top-0 bg-white rounded-t-2xl z-10">
                <h3 id="modal-title" class="text-base font-semibold text-gray-800">Tambah Berita</h3>
                <button onclick="closeModal()" class="text-gray-400 hover:text-gray-600 text-xl leading-none">&times;</button>
            </div>

            <form id="news-form"
                  action="{{ route('admin.markom.news.store') }}"
                  method="POST"
                  enctype="multipart/form-data"
                  class="px-6 py-5 space-y-4">
                @csrf
                <input type="hidden" name="_method" id="form-method" value="POST">

                {{-- Preview cover saat edit --}}
                <div id="image-preview-wrap" class="hidden">
                    <p class="text-xs text-gray-400 font-medium uppercase tracking-wider mb-2">Cover Saat Ini</p>
                    <img id="image-preview" src="" alt="Cover" class="w-full h-44 object-cover rounded-xl">
                </div>

                {{-- Cover --}}
                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1">Gambar Cover</label>
                    <input type="file" name="image" id="f-image" accept="image/*"
                           class="block w-full text-sm text-gray-500 file:mr-4 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-[#02A6E0]/10 file:text-[#02A6E0] hover:file:bg-[#02A6E0]/20 transition">
                </div>

                {{-- Judul --}}
                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1">
                        Judul <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="title" id="f-title"
                           class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#02A6E0]/30 focus:border-[#02A6E0]"
                           placeholder="Tulis judul berita..." required>
                </div>

                {{-- Kategori & Tier --}}
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">
                            Kategori <span class="text-red-500">*</span>
                        </label>
                        <select name="category" id="f-category"
                                class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#02A6E0]/30 focus:border-[#02A6E0]" required>
                            <option value="Kemanusiaan">Kemanusiaan</option>
                            <option value="Pendidikan">Pendidikan</option>
                            <option value="Kesehatan">Kesehatan</option>
                            <option value="Ekonomi">Ekonomi</option>
                            <option value="Sosial">Sosial</option>
                            <option value="Dakwah">Dakwah</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">
                            Tier <span class="text-red-500">*</span>
                            <span class="text-gray-400 font-normal">(posisi tampil)</span>
                        </label>
                        <select name="tier" id="f-tier"
                                class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#02A6E0]/30 focus:border-[#02A6E0]" required>
                            <option value="hero">Hero — Utama (besar)</option>
                            <option value="highlight">Highlight — Populer (medium)</option>
                            <option value="regular" selected>Regular — Lainnya (kecil)</option>
                        </select>
                    </div>
                </div>

                {{-- Tanggal & Status --}}
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">Tanggal Publikasi</label>
                        <input type="date" name="published_at" id="f-published-at"
                               class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#02A6E0]/30 focus:border-[#02A6E0]">
                    </div>
                    <div class="flex flex-col justify-end pb-1">
                        <label class="flex items-center gap-2.5 cursor-pointer select-none">
                            <div class="relative">
                                <input type="hidden" name="is_published" value="0">
                                <input type="checkbox" name="is_published" id="f-published" value="1"
                                       class="sr-only peer">
                                <div class="w-10 h-5 bg-gray-200 peer-checked:bg-[#02A6E0] rounded-full transition"></div>
                                <div class="absolute top-0.5 left-0.5 w-4 h-4 bg-white rounded-full shadow peer-checked:translate-x-5 transition"></div>
                            </div>
                            <span class="text-xs font-medium text-gray-600">Tayangkan sekarang</span>
                        </label>
                    </div>
                </div>

                {{-- Excerpt --}}
                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1">
                        Ringkasan <span class="text-gray-400 font-normal">(maks. 500 karakter)</span>
                    </label>
                    <textarea name="excerpt" id="f-excerpt" rows="2"
                              class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#02A6E0]/30 focus:border-[#02A6E0] resize-none"
                              placeholder="Tulis ringkasan singkat berita..."></textarea>
                </div>

                {{-- Konten --}}
                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1">Isi Berita</label>
                    <textarea name="content" id="f-content"></textarea>
                </div>

                <div class="flex gap-3 pt-1">
                    <button type="submit"
                            class="flex-1 bg-[#02A6E0] hover:bg-[#028AC9] text-white text-sm font-semibold py-2.5 rounded-lg transition">
                        Simpan
                    </button>
                    <button type="button" onclick="closeModal()"
                            class="flex-1 border border-gray-200 text-gray-600 hover:bg-gray-50 text-sm font-semibold py-2.5 rounded-lg transition">
                        Batal
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/tinymce@7/tinymce.min.js" referrerpolicy="origin"></script>
    <script>
        const storeUrl   = "{{ route('admin.markom.news.store') }}";
        const updateBase = "{{ url('admin/markom/news') }}";

        tinymce.init({
            selector: '#f-content',
            base_url: 'https://cdn.jsdelivr.net/npm/tinymce@7',
            suffix: '.min',
            language: 'id',
            language_url: 'https://cdn.jsdelivr.net/npm/tinymce-i18n@23.10.9/langs7/id.js',
            height: 440,
            menubar: false,
            statusbar: false,
            toolbar_mode: 'wrap',
            plugins: 'lists link image table code',
            toolbar: [
                'undo redo | blocks fontsize | bold italic underline strikethrough | forecolor hilitecolor | removeformat',
                'alignleft aligncenter alignright alignjustify | bullist numlist | link image table | code'
            ],
            font_size_formats: '10pt 11pt 12pt 14pt 16pt 18pt 20pt 24pt 28pt 32pt 36pt',
            content_style: 'body { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif; font-size: 14px; line-height: 1.6; color: #374151; }',
            /* Cegah TinyMCE mengubah URL absolut menjadi relatif */
            convert_urls: false,
            relative_urls: false,
            remove_script_host: false,
            images_upload_handler: (blobInfo) => new Promise((resolve, reject) => {
                const form = new FormData();
                form.append('file', blobInfo.blob(), blobInfo.filename());
                form.append('_token', document.querySelector('meta[name="csrf-token"]').content);
                fetch("{{ route('admin.markom.news.imageUpload') }}", {
                    method: 'POST',
                    body: form,
                })
                .then(r => r.ok ? r.json() : Promise.reject(r))
                .then(data => resolve(data.location))
                .catch(() => reject('Upload gambar gagal.'));
            }),
            setup(editor) {
                editor.on('change', () => editor.save());
            },
        });

        function openModal(btn = null) {
            const overlay = document.getElementById('news-modal-overlay');
            const form    = document.getElementById('news-form');

            let id = null, title = '', excerpt = '', content = '',
                category = '', tier = 'regular', publishedAt = '',
                isPublished = false, imageUrl = '';

            if (btn) {
                const d  = btn.dataset;
                id          = d.id || null;
                title       = d.title || '';
                excerpt     = d.excerpt || '';
                content     = d.content || '';
                category    = d.category || '';
                tier        = d.tier || 'regular';
                publishedAt = d.publishedAt || '';
                isPublished = d.isPublished === '1';
                imageUrl    = d.image || '';
            }

            if (id) {
                document.getElementById('modal-title').textContent = 'Edit Berita';
                form.action = updateBase + '/' + id;
                document.getElementById('form-method').value = 'PUT';
            } else {
                document.getElementById('modal-title').textContent = 'Tambah Berita';
                form.action = storeUrl;
                document.getElementById('form-method').value = 'POST';
            }

            document.getElementById('f-title').value        = title;
            document.getElementById('f-excerpt').value      = excerpt;
            document.getElementById('f-category').value     = category;
            document.getElementById('f-tier').value         = tier;
            document.getElementById('f-published-at').value = publishedAt;
            document.getElementById('f-published').checked  = isPublished;
            document.getElementById('f-image').value        = '';

            const editor = tinymce.get('f-content');
            if (editor) editor.setContent(content);

            const previewWrap = document.getElementById('image-preview-wrap');
            const previewImg  = document.getElementById('image-preview');
            if (imageUrl) {
                previewImg.src = imageUrl;
                previewWrap.classList.remove('hidden');
            } else {
                previewWrap.classList.add('hidden');
            }

            overlay.classList.remove('hidden');
            overlay.classList.add('flex');
        }

        function closeModal() {
            const overlay = document.getElementById('news-modal-overlay');
            overlay.classList.add('hidden');
            overlay.classList.remove('flex');
            const editor = tinymce.get('f-content');
            if (editor) editor.setContent('');
        }

        document.getElementById('news-form').addEventListener('submit', function () {
            tinymce.triggerSave();
        });
    </script>

@endsection
