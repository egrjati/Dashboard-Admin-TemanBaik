@extends('admin.layouts.app')

@section('title', 'Konten Program — ' . $program->name)
@section('page-title', 'Konten Program')

@section('content')

    {{-- Flash message --}}
    @if(session('success'))
        <div class="mb-4 px-4 py-3 rounded-lg bg-green-50 border border-green-200 text-green-700 text-sm">
            {{ session('success') }}
        </div>
    @endif

    {{-- Breadcrumb / Back --}}
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('admin.markom.program.index') }}"
           class="inline-flex items-center gap-1.5 text-sm text-gray-500 hover:text-gray-800 transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
            </svg>
            Kembali ke Daftar Program
        </a>
        <span class="text-gray-300">/</span>
        <span class="text-sm font-semibold text-gray-800">{{ $program->name }}</span>
    </div>

    {{-- ── Section Hero ──────────────────────────────────────────────────── --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">

        <div class="px-6 py-4 border-b border-gray-100 flex items-center gap-3 bg-gradient-to-r from-slate-50 to-white">
            <div class="w-9 h-9 rounded-xl flex items-center justify-center shrink-0"
                 style="background: linear-gradient(135deg, rgba(2,166,224,0.12) 0%, rgba(33,63,154,0.08) 100%); border: 1px solid rgba(2,166,224,0.2)">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-[18px] h-[18px]" fill="none" viewBox="0 0 24 24" stroke="#02A6E0" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
            </div>
            <div>
                <h3 class="font-semibold text-gray-800 text-sm">Section Hero</h3>
                <p class="text-xs text-gray-400 mt-0.5">Gambar latar dan teks utama di bagian atas halaman {{ $program->name }}</p>
            </div>
        </div>

        {{-- Preview bg image saat ini --}}
        @if($pageHero->bg_image)
            <div class="px-6 pt-5">
                <p class="text-xs text-gray-400 font-medium uppercase tracking-wider mb-2">Preview Saat Ini</p>
                <div class="relative w-full h-44 rounded-xl overflow-hidden bg-gray-100">
                    <img src="{{ Storage::url($pageHero->bg_image) }}" alt="Hero BG" class="w-full h-full object-cover">
                    <div class="absolute inset-0 bg-[#213F9A]/75 flex flex-col items-center justify-center text-center px-4">
                        <p class="text-white font-bold text-lg drop-shadow">
                            {{ $pageHero->heading }}
                            <span class="text-[#02A6E0]">{{ $pageHero->heading_highlight }}</span>
                        </p>
                        @if($pageHero->description)
                            <p class="text-gray-200 text-xs mt-1 max-w-md">{{ $pageHero->description }}</p>
                        @endif
                    </div>
                </div>
            </div>
        @endif

        <form action="{{ route('admin.markom.program.updateHeroContent', $program) }}" method="POST"
              enctype="multipart/form-data" class="px-6 py-6 space-y-5">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">
                    Gambar Latar <span class="text-gray-400 font-normal">(landscape, min. 1600×700px)</span>
                </label>
                <input type="file" name="bg_image" accept="image/*"
                       class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-[#02A6E0]/10 file:text-[#02A6E0] hover:file:bg-[#02A6E0]/20 transition">
                @error('bg_image') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Judul Heading</label>
                    <input type="text" name="heading" value="{{ old('heading', $pageHero->heading) }}"
                           placeholder="cth: Kemanusiaan Hadir,"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#02A6E0]/40 focus:border-[#02A6E0]"
                           required>
                    @error('heading') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">
                        Heading Highlight <span class="text-gray-400 font-normal">(teks berwarna biru)</span>
                    </label>
                    <input type="text" name="heading_highlight" value="{{ old('heading_highlight', $pageHero->heading_highlight) }}"
                           placeholder="cth: Harapan Kembali Tumbuh"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#02A6E0]/40 focus:border-[#02A6E0]"
                           required>
                    @error('heading_highlight') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Deskripsi</label>
                <textarea name="description" rows="3"
                          placeholder="cth: Bersama kami, setiap donasi membawa dampak nyata bagi sesama..."
                          class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#02A6E0]/40 focus:border-[#02A6E0] resize-none">{{ old('description', $pageHero->description) }}</textarea>
                @error('description') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="flex justify-end">
                <button type="submit"
                        class="inline-flex items-center gap-2 bg-[#02A6E0] hover:bg-[#028AC9] text-white text-sm font-semibold px-5 py-2.5 rounded-lg transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                    </svg>
                    Simpan Hero
                </button>
            </div>
        </form>
    </div>

    {{-- ── Sub-program Items ─────────────────────────────────────────────── --}}
    <div class="mt-8 bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">

        <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between bg-gradient-to-r from-slate-50 to-white">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-xl flex items-center justify-center shrink-0"
                     style="background: linear-gradient(135deg, rgba(2,166,224,0.12) 0%, rgba(33,63,154,0.08) 100%); border: 1px solid rgba(2,166,224,0.2)">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-[18px] h-[18px]" fill="none" viewBox="0 0 24 24" stroke="#02A6E0" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 10h16M4 14h16M4 18h16"/>
                    </svg>
                </div>
                <div>
                    <h3 class="font-semibold text-gray-800 text-sm">Sub-program (Item)</h3>
                    <p class="text-xs text-gray-400 mt-0.5">Daftar kegiatan / layanan dalam program {{ $program->name }}</p>
                </div>
            </div>
            <div class="flex items-center gap-3">
                <span class="text-xs text-gray-400 bg-gray-100 px-2.5 py-1 rounded-full font-medium">{{ $items->count() }} item</span>
                <button onclick="openItemModal()"
                        class="inline-flex items-center gap-1.5 bg-[#02A6E0] hover:bg-[#028AC9] text-white text-xs font-semibold px-3.5 py-2 rounded-lg transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                    </svg>
                    Tambah Item
                </button>
            </div>
        </div>

        <table class="w-full text-sm text-left">
            <thead class="bg-gray-50 text-gray-500 uppercase text-xs tracking-wider">
                <tr>
                    <th class="px-4 py-3">Gambar</th>
                    <th class="px-4 py-3">Judul</th>
                    <th class="px-4 py-3">Deskripsi</th>
                    <th class="px-4 py-3 text-center">Urutan</th>
                    <th class="px-4 py-3 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($items as $item)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-4 py-3">
                            @if($item->image)
                                <img src="{{ Storage::url($item->image) }}" alt="{{ $item->title }}"
                                     class="w-28 h-16 object-cover rounded-lg">
                            @else
                                <div class="w-28 h-16 bg-gray-100 rounded-lg flex items-center justify-center text-gray-300 text-xs">
                                    No image
                                </div>
                            @endif
                        </td>
                        <td class="px-4 py-3 font-medium text-gray-800">{{ $item->title }}</td>
                        <td class="px-4 py-3 text-gray-500 max-w-xs">
                            <span class="line-clamp-2 text-xs">{{ $item->description ?? '-' }}</span>
                        </td>
                        <td class="px-4 py-3 text-center text-gray-700">{{ $item->order }}</td>
                        <td class="px-4 py-3 text-center">
                            <div class="flex items-center justify-center gap-3">
                                <button onclick="openItemModal(
                                    {{ $item->id }},
                                    '{{ addslashes($item->title) }}',
                                    '{{ addslashes($item->description ?? '') }}',
                                    {{ $item->order }},
                                    '{{ $item->image ? Storage::url($item->image) : '' }}'
                                )" class="text-xs font-semibold text-[#02A6E0] hover:underline">
                                    Edit
                                </button>
                                <form action="{{ route('admin.markom.program.destroyItem', [$program, $item]) }}" method="POST"
                                      onsubmit="return confirm('Hapus item ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-xs font-semibold text-red-500 hover:underline">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-4 py-12 text-center text-gray-400 text-sm">
                            Belum ada item. Klik "+ Tambah Item" untuk memulai.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- ── Footer CTA ────────────────────────────────────────────────────── --}}
    <div class="mt-8 bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">

        <div class="px-6 py-4 border-b border-gray-100 flex items-center gap-3 bg-gradient-to-r from-slate-50 to-white">
            <div class="w-9 h-9 rounded-xl flex items-center justify-center shrink-0"
                 style="background: linear-gradient(135deg, rgba(2,166,224,0.12) 0%, rgba(33,63,154,0.08) 100%); border: 1px solid rgba(2,166,224,0.2)">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-[18px] h-[18px]" fill="none" viewBox="0 0 24 24" stroke="#02A6E0" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z" />
                </svg>
            </div>
            <div>
                <h3 class="font-semibold text-gray-800 text-sm">Footer CTA</h3>
                <p class="text-xs text-gray-400 mt-0.5">Bagian ajakan donasi di bagian bawah halaman {{ $program->name }}</p>
            </div>
        </div>

        {{-- Preview bg image CTA --}}
        @if($pageCta->bg_image)
            <div class="px-6 pt-5">
                <p class="text-xs text-gray-400 font-medium uppercase tracking-wider mb-2">Preview Saat Ini</p>
                <div class="relative w-full h-32 rounded-xl overflow-hidden bg-gray-100">
                    <img src="{{ Storage::url($pageCta->bg_image) }}" alt="CTA BG" class="w-full h-full object-cover">
                    <div class="absolute inset-0 bg-[#213F9A]/75 flex flex-col items-center justify-center text-center px-4">
                        <p class="text-white font-bold drop-shadow">{{ $pageCta->heading }}</p>
                        @if($pageCta->description)
                            <p class="text-gray-200 text-xs mt-1">{{ $pageCta->description }}</p>
                        @endif
                    </div>
                </div>
            </div>
        @endif

        <form action="{{ route('admin.markom.program.updateCtaContent', $program) }}" method="POST"
              enctype="multipart/form-data" class="px-6 py-6 space-y-5">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">
                    Gambar Latar CTA <span class="text-gray-400 font-normal">(landscape, min. 1600×400px)</span>
                </label>
                <input type="file" name="bg_image" accept="image/*"
                       class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-[#02A6E0]/10 file:text-[#02A6E0] hover:file:bg-[#02A6E0]/20 transition">
                @error('bg_image') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Heading CTA</label>
                <input type="text" name="heading" value="{{ old('heading', $pageCta->heading) }}"
                       placeholder="cth: Bersama Hadirkan Harapan bagi Sesama"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#02A6E0]/40 focus:border-[#02A6E0]"
                       required>
                @error('heading') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Deskripsi CTA</label>
                <textarea name="description" rows="2"
                          placeholder="cth: Setiap kepedulian Anda menjadi cahaya baru bagi saudara kita..."
                          class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#02A6E0]/40 focus:border-[#02A6E0] resize-none">{{ old('description', $pageCta->description) }}</textarea>
                @error('description') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="flex justify-end">
                <button type="submit"
                        class="inline-flex items-center gap-2 bg-[#02A6E0] hover:bg-[#028AC9] text-white text-sm font-semibold px-5 py-2.5 rounded-lg transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                    </svg>
                    Simpan Footer CTA
                </button>
            </div>
        </form>
    </div>

    {{-- ── Modal Item ────────────────────────────────────────────────────── --}}
    <div id="item-modal-overlay"
         class="fixed inset-0 bg-black/50 z-50 items-center justify-center hidden"
         onclick="if(event.target===this) closeItemModal()">

        <div class="bg-white rounded-2xl shadow-xl w-full max-w-lg mx-4 max-h-[90vh] overflow-y-auto">

            <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100 sticky top-0 bg-white rounded-t-2xl">
                <h3 id="item-modal-title" class="text-base font-semibold text-gray-800">Tambah Item</h3>
                <button onclick="closeItemModal()" class="text-gray-400 hover:text-gray-600 text-xl leading-none">&times;</button>
            </div>

            <form id="item-form"
                  action="{{ route('admin.markom.program.storeItem', $program) }}"
                  method="POST"
                  enctype="multipart/form-data"
                  class="px-6 py-5 space-y-4">
                @csrf
                <input type="hidden" name="_method" id="item-method" value="POST">

                {{-- Preview gambar saat edit --}}
                <div id="item-image-preview-wrap" class="hidden">
                    <p class="text-xs text-gray-400 font-medium uppercase tracking-wider mb-2">Gambar Saat Ini</p>
                    <img id="item-image-preview" src="" alt="Preview" class="w-full h-40 object-cover rounded-xl">
                </div>

                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1">Judul <span class="text-red-500">*</span></label>
                    <input type="text" name="title" id="i-title"
                           class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#02A6E0]/30 focus:border-[#02A6E0]"
                           placeholder="cth: Safari Dakwah" required>
                </div>

                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1">Gambar</label>
                    <input type="file" name="image" id="i-image" accept="image/*"
                           class="block w-full text-sm text-gray-500 file:mr-4 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-[#02A6E0]/10 file:text-[#02A6E0] hover:file:bg-[#02A6E0]/20 transition">
                </div>

                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1">Deskripsi</label>
                    <textarea name="description" id="i-description" rows="4"
                              class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#02A6E0]/30 focus:border-[#02A6E0] resize-none"
                              placeholder="Tulis deskripsi lengkap program ini..."></textarea>
                </div>

                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1">Urutan</label>
                    <input type="number" name="order" id="i-order" min="0" value="0"
                           class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#02A6E0]/30 focus:border-[#02A6E0]">
                </div>

                <div class="flex gap-3 pt-1">
                    <button type="submit"
                            class="flex-1 bg-[#02A6E0] hover:bg-[#028AC9] text-white text-sm font-semibold py-2.5 rounded-lg transition">
                        Simpan
                    </button>
                    <button type="button" onclick="closeItemModal()"
                            class="flex-1 border border-gray-200 text-gray-600 hover:bg-gray-50 text-sm font-semibold py-2.5 rounded-lg transition">
                        Batal
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        const itemStoreUrl   = "{{ route('admin.markom.program.storeItem', $program) }}";
        const itemUpdateBase = "{{ url('admin/markom/program/' . $program->id . '/items') }}";

        function openItemModal(id = null, title = '', description = '', order = 0, imageUrl = '') {
            const overlay = document.getElementById('item-modal-overlay');
            const form    = document.getElementById('item-form');

            if (id) {
                document.getElementById('item-modal-title').textContent = 'Edit Item';
                form.action = itemUpdateBase + '/' + id;
                document.getElementById('item-method').value = 'PUT';
            } else {
                document.getElementById('item-modal-title').textContent = 'Tambah Item';
                form.action = itemStoreUrl;
                document.getElementById('item-method').value = 'POST';
            }

            document.getElementById('i-title').value       = title;
            document.getElementById('i-description').value = description;
            document.getElementById('i-order').value       = order;
            document.getElementById('i-image').value       = '';

            const previewWrap = document.getElementById('item-image-preview-wrap');
            const previewImg  = document.getElementById('item-image-preview');
            if (imageUrl) {
                previewImg.src = imageUrl;
                previewWrap.classList.remove('hidden');
            } else {
                previewWrap.classList.add('hidden');
            }

            overlay.classList.remove('hidden');
            overlay.classList.add('flex');
        }

        function closeItemModal() {
            const overlay = document.getElementById('item-modal-overlay');
            overlay.classList.add('hidden');
            overlay.classList.remove('flex');
        }
    </script>

@endsection
