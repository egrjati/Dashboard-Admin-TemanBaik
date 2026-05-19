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
                        <td class="px-4 py-3 text-center">
                            <div class="flex items-center justify-center gap-3">
                                <button onclick="openModal(
                                    {{ $item->id }},
                                    '{{ addslashes($item->title) }}',
                                    '{{ addslashes($item->excerpt ?? '') }}',
                                    '{{ addslashes($item->content ?? '') }}',
                                    '{{ $item->category }}',
                                    '{{ $item->tier }}',
                                    '{{ $item->published_at ? $item->published_at->format('Y-m-d') : '' }}',
                                    {{ $item->is_published ? 'true' : 'false' }},
                                    '{{ $item->image ? Storage::url($item->image) : '' }}'
                                )" class="text-xs font-semibold text-[#02A6E0] hover:underline">
                                    Edit
                                </button>
                                <form action="{{ route('admin.markom.news.destroy', $item) }}" method="POST"
                                      onsubmit="return confirm('Hapus berita ini?')">
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
                    <label class="block text-xs font-medium text-gray-600 mb-1">
                        Isi Berita <span class="text-gray-400 font-normal">(pisahkan paragraf dengan baris kosong)</span>
                    </label>
                    <textarea name="content" id="f-content" rows="8"
                              class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#02A6E0]/30 focus:border-[#02A6E0] resize-y"
                              placeholder="Tulis isi lengkap berita..."></textarea>
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

    <script>
        const storeUrl   = "{{ route('admin.markom.news.store') }}";
        const updateBase = "{{ url('admin/markom/news') }}";

        function openModal(id = null, title = '', excerpt = '', content = '', category = 'Kemanusiaan', tier = 'regular', publishedAt = '', isPublished = false, imageUrl = '') {
            const overlay = document.getElementById('news-modal-overlay');
            const form    = document.getElementById('news-form');

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
            document.getElementById('f-content').value      = content;
            document.getElementById('f-category').value     = category;
            document.getElementById('f-tier').value         = tier;
            document.getElementById('f-published-at').value = publishedAt;
            document.getElementById('f-published').checked  = isPublished;
            document.getElementById('f-image').value        = '';

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
        }
    </script>

@endsection
