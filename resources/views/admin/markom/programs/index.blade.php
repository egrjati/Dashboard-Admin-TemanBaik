@extends('admin.layouts.app')

@section('title', 'Program')
@section('page-title', 'Program')

@section('content')

    {{-- Flash message --}}
    @if(session('success'))
        <div class="mb-4 px-4 py-3 rounded-lg bg-green-50 border border-green-200 text-green-700 text-sm">
            {{ session('success') }}
        </div>
    @endif

    {{-- Section Hero Program --}}
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
                <p class="text-xs text-gray-400 mt-0.5">Gambar latar, judul, dan deskripsi di bagian atas halaman Program</p>
            </div>
        </div>

        {{-- Preview --}}
        @if($hero->image)
            <div class="px-6 pt-5">
                <p class="text-xs text-gray-400 font-medium uppercase tracking-wider mb-2">Preview Saat Ini</p>
                <div class="relative w-full h-48 rounded-xl overflow-hidden bg-gray-100">
                    <img src="{{ Storage::url($hero->image) }}" alt="Hero Program" class="w-full h-full object-cover">
                    <div class="absolute inset-0 bg-[#0f172a]/60 flex flex-col items-center justify-center text-center px-4">
                        <p class="text-white font-bold text-xl">
                            {{ $hero->title }} <span class="text-[#02A6E0]">{{ $hero->title_highlight }}</span>
                        </p>
                        @if($hero->description)
                            <p class="text-gray-300 text-sm mt-1 max-w-md">{{ $hero->description }}</p>
                        @endif
                    </div>
                </div>
            </div>
        @endif

        <form action="{{ route('admin.markom.program.updateHero') }}" method="POST" enctype="multipart/form-data"
              class="px-6 py-6 space-y-5">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">
                    Gambar Hero <span class="text-gray-400 font-normal">(landscape, min. 1600×700px)</span>
                </label>
                <input type="file" name="image" accept="image/*"
                       class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-[#02A6E0]/10 file:text-[#02A6E0] hover:file:bg-[#02A6E0]/20 transition">
                @error('image') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Judul</label>
                    <input type="text" name="title" value="{{ old('title', $hero->title) }}"
                           placeholder="cth: Program"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#02A6E0]/40 focus:border-[#02A6E0]"
                           required>
                    @error('title') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">
                        Judul Highlight
                        <span class="text-gray-400 font-normal">(teks berwarna biru)</span>
                    </label>
                    <input type="text" name="title_highlight" value="{{ old('title_highlight', $hero->title_highlight) }}"
                           placeholder="cth: Teman Baik"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#02A6E0]/40 focus:border-[#02A6E0]"
                           required>
                    @error('title_highlight') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Deskripsi</label>
                <textarea name="description" rows="3"
                          placeholder="cth: Temukan layanan zakat & donasi yang mudah, aman, dan terpercaya untuk Anda."
                          class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#02A6E0]/40 focus:border-[#02A6E0] resize-none">{{ old('description', $hero->description) }}</textarea>
                @error('description') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

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

    {{-- Section Card Program --}}
    <div class="mt-8 bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">

        <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between bg-gradient-to-r from-slate-50 to-white">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-xl flex items-center justify-center shrink-0"
                     style="background: linear-gradient(135deg, rgba(2,166,224,0.12) 0%, rgba(33,63,154,0.08) 100%); border: 1px solid rgba(2,166,224,0.2)">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-[18px] h-[18px]" fill="none" viewBox="0 0 24 24" stroke="#02A6E0" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                    </svg>
                </div>
                <div>
                    <h3 class="font-semibold text-gray-800 text-sm">Card Program</h3>
                    <p class="text-xs text-gray-400 mt-0.5">Kelola kartu program yang tampil di halaman Program</p>
                </div>
            </div>
            <div class="flex items-center gap-3">
                <span class="text-xs text-gray-400 bg-gray-100 px-2.5 py-1 rounded-full font-medium">{{ $cards->count() }} program</span>
                <button onclick="openCardModal()"
                        class="inline-flex items-center gap-1.5 bg-[#02A6E0] hover:bg-[#028AC9] text-white text-xs font-semibold px-3.5 py-2 rounded-lg transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                    </svg>
                    Tambah Program
                </button>
            </div>
        </div>

        <table class="w-full text-sm text-left">
            <thead class="bg-gray-50 text-gray-500 uppercase text-xs tracking-wider">
                <tr>
                    <th class="px-4 py-3">Cover</th>
                    <th class="px-4 py-3">Nama</th>
                    <th class="px-4 py-3">Icon</th>
                    <th class="px-4 py-3">Deskripsi</th>
                    <th class="px-4 py-3 text-center">Urutan</th>
                    <th class="px-4 py-3 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($cards as $card)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-4 py-3">
                            @if($card->image)
                                <img src="{{ Storage::url($card->image) }}"
                                     alt="{{ $card->name }}"
                                     class="w-24 h-14 object-cover rounded-lg">
                            @else
                                <div class="w-24 h-14 bg-gray-100 rounded-lg flex items-center justify-center text-gray-300 text-xs">
                                    No image
                                </div>
                            @endif
                        </td>
                        <td class="px-4 py-3 font-medium text-gray-800">{{ $card->name }}</td>
                        <td class="px-4 py-3 text-gray-500 font-mono text-xs">{{ $card->icon }}</td>
                        <td class="px-4 py-3 text-gray-500 max-w-xs">
                            <span class="line-clamp-2 text-xs">{{ $card->description ?? '-' }}</span>
                        </td>
                        <td class="px-4 py-3 text-center text-gray-700">{{ $card->order }}</td>
                        <td class="px-4 py-3 text-center">
                            <div class="flex items-center justify-center gap-3">
                                <a href="{{ route('admin.markom.program.content', $card) }}"
                                   class="text-xs font-semibold text-[#213F9A] hover:underline">
                                    Konten
                                </a>
                                <button onclick="openCardModal(
                                    {{ $card->id }},
                                    '{{ addslashes($card->name) }}',
                                    '{{ addslashes($card->description ?? '') }}',
                                    '{{ $card->icon }}',
                                    {{ $card->order }},
                                    '{{ $card->image ? Storage::url($card->image) : '' }}'
                                )" class="text-xs font-semibold text-[#02A6E0] hover:underline">
                                    Edit
                                </button>
                                <form action="{{ route('admin.markom.program.destroy', $card) }}" method="POST"
                                      onsubmit="return confirm('Hapus card program {{ addslashes($card->name) }}?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-xs font-semibold text-red-500 hover:underline">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-4 py-12 text-center text-gray-400 text-sm">
                            Belum ada program. Klik "Tambah Program" untuk memulai atau jalankan seeder.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Modal Card Program --}}
    <div id="card-modal-overlay"
         class="fixed inset-0 bg-black/50 z-50 items-center justify-center hidden"
         onclick="if(event.target===this) closeCardModal()">

        <div class="bg-white rounded-2xl shadow-xl w-full max-w-lg mx-4 max-h-[90vh] overflow-y-auto">

            <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100 sticky top-0 bg-white rounded-t-2xl">
                <h3 id="card-modal-title" class="text-base font-semibold text-gray-800">Tambah Program</h3>
                <button onclick="closeCardModal()" class="text-gray-400 hover:text-gray-600 text-xl leading-none">&times;</button>
            </div>

            <form id="card-form"
                  action="{{ route('admin.markom.program.store') }}"
                  method="POST"
                  enctype="multipart/form-data"
                  class="px-6 py-5 space-y-4">
                @csrf
                <input type="hidden" name="_method" id="card-method" value="POST">

                {{-- Preview cover saat edit --}}
                <div id="card-image-preview-wrap" class="hidden">
                    <p class="text-xs text-gray-400 font-medium uppercase tracking-wider mb-2">Cover Saat Ini</p>
                    <img id="card-image-preview" src="" alt="Cover" class="w-full h-40 object-cover rounded-xl">
                </div>

                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1">
                        Nama Program <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="name" id="c-name"
                           class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#02A6E0]/30 focus:border-[#02A6E0]"
                           placeholder="cth: Kemanusiaan" required>
                </div>

                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1">
                        Gambar Cover
                    </label>
                    <input type="file" name="image" id="c-image" accept="image/*"
                           class="block w-full text-sm text-gray-500 file:mr-4 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-[#02A6E0]/10 file:text-[#02A6E0] hover:file:bg-[#02A6E0]/20 transition">
                </div>

                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1">
                        Icon <span class="text-red-500">*</span>
                    </label>
                    <select name="icon" id="c-icon"
                            class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#02A6E0]/30 focus:border-[#02A6E0]" required>
                        <option value="heart-handshake">🤝 Heart Handshake — Kemanusiaan</option>
                        <option value="graduation-cap">🎓 Graduation Cap — Pendidikan</option>
                        <option value="chart-no-axes-combined">📊 Chart — Ekonomi</option>
                        <option value="accessibility">♿ Accessibility — Kesehatan</option>
                        <option value="users-round">👥 Users Round — Sosial</option>
                        <option value="moon-star">🌙 Moon Star — Dakwah</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1">
                        Deskripsi
                        <span class="text-gray-400 font-normal">(maks. 15 kata)</span>
                    </label>
                    <textarea name="description" id="c-description" rows="3"
                              class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#02A6E0]/30 focus:border-[#02A6E0] resize-none"
                              placeholder="Tulis deskripsi singkat program..."></textarea>
                    <p id="c-word-count" class="text-xs text-gray-400 mt-1">0 / 15 kata</p>
                </div>

                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1">Urutan</label>
                    <input type="number" name="order" id="c-order" min="0" value="0"
                           class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#02A6E0]/30 focus:border-[#02A6E0]">
                </div>

                <div class="flex gap-3 pt-1">
                    <button type="submit"
                            class="flex-1 bg-[#02A6E0] hover:bg-[#028AC9] text-white text-sm font-semibold py-2.5 rounded-lg transition">
                        Simpan
                    </button>
                    <button type="button" onclick="closeCardModal()"
                            class="flex-1 border border-gray-200 text-gray-600 hover:bg-gray-50 text-sm font-semibold py-2.5 rounded-lg transition">
                        Batal
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        const cardStoreUrl   = "{{ route('admin.markom.program.store') }}";
        const cardUpdateBase = "{{ url('admin/markom/program') }}";

        function openCardModal(id = null, name = '', description = '', icon = 'heart-handshake', order = 0, imageUrl = '') {
            const overlay = document.getElementById('card-modal-overlay');
            const form    = document.getElementById('card-form');

            if (id) {
                document.getElementById('card-modal-title').textContent = 'Edit Program';
                form.action = cardUpdateBase + '/' + id;
                document.getElementById('card-method').value = 'PUT';
            } else {
                document.getElementById('card-modal-title').textContent = 'Tambah Program';
                form.action = cardStoreUrl;
                document.getElementById('card-method').value = 'POST';
            }

            document.getElementById('c-name').value        = name;
            document.getElementById('c-icon').value        = icon;
            document.getElementById('c-description').value = description;
            document.getElementById('c-order').value       = order;
            document.getElementById('c-image').value       = '';

            const previewWrap = document.getElementById('card-image-preview-wrap');
            const previewImg  = document.getElementById('card-image-preview');
            if (imageUrl) {
                previewImg.src = imageUrl;
                previewWrap.classList.remove('hidden');
            } else {
                previewWrap.classList.add('hidden');
            }

            updateWordCount();

            overlay.classList.remove('hidden');
            overlay.classList.add('flex');
        }

        function closeCardModal() {
            const overlay = document.getElementById('card-modal-overlay');
            overlay.classList.add('hidden');
            overlay.classList.remove('flex');
        }

        function updateWordCount() {
            const desc  = document.getElementById('c-description').value.trim();
            const words = desc ? desc.split(/\s+/).length : 0;
            const el    = document.getElementById('c-word-count');
            el.textContent = words + ' / 15 kata';
            el.className   = 'text-xs mt-1 ' + (words > 15 ? 'text-red-500' : 'text-gray-400');
        }

        document.getElementById('c-description').addEventListener('input', updateWordCount);
    </script>

@endsection
