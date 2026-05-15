@extends('admin.layouts.app')

@section('title', 'Hero Slider')
@section('page-title', 'Beranda')

@section('content')

    {{-- Flash message --}}
    @if(session('success'))
        <div class="mb-4 px-4 py-3 rounded-lg bg-green-50 border border-green-200 text-green-700 text-sm">
            {{ session('success') }}
        </div>
    @endif

    {{-- Header --}}
    <div class="flex items-center justify-between mb-6">
        <p class="text-sm text-gray-500">Hero Section</p>
        <button onclick="openModal()"
                class="inline-flex items-center gap-2 bg-[#02A6E0] hover:bg-[#028AC9] text-white text-sm font-semibold px-4 py-2 rounded-lg transition">
            + Tambah Slide
        </button>
    </div>

    {{-- Table --}}
    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <table class="w-full text-sm text-left">
            <thead class="bg-gray-50 text-gray-500 uppercase text-xs tracking-wider">
                <tr>
                    <th class="px-4 py-3">Preview</th>
                    <th class="px-4 py-3">Judul</th>
                    <th class="px-4 py-3">Link Redirect</th>
                    <th class="px-4 py-3 text-center">Urutan</th>
                    <th class="px-4 py-3 text-center">Status</th>
                    <th class="px-4 py-3 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($sliders as $slider)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-4 py-3">
                            <img src="{{ Storage::url($slider->image) }}"
                                 alt="{{ $slider->title }}"
                                 class="w-32 h-16 object-cover rounded-lg">
                        </td>
                        <td class="px-4 py-3 font-medium text-gray-800">
                            {{ $slider->title ?? '-' }}
                        </td>
                        <td class="px-4 py-3 text-gray-500 max-w-50 truncate">
                            {{ $slider->link ?? '-' }}
                        </td>
                        <td class="px-4 py-3 text-center text-gray-700">{{ $slider->order }}</td>
                        <td class="px-4 py-3 text-center">
                            @if($slider->is_active)
                                <span class="inline-block px-2.5 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-700">Aktif</span>
                            @else
                                <span class="inline-block px-2.5 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-500">Nonaktif</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-center">
                            <div class="flex items-center justify-center gap-3">
                                <button onclick="openModal({{ $slider->id }}, '{{ addslashes($slider->title) }}', '{{ addslashes($slider->link) }}', {{ $slider->order }}, {{ $slider->is_active ? 'true' : 'false' }}, '{{ Storage::url($slider->image) }}')"
                                        class="text-xs font-semibold text-[#02A6E0] hover:underline">
                                    Edit
                                </button>
                                <form action="{{ route('admin.markom.home.destroy', $slider) }}" method="POST"
                                      onsubmit="return confirm('Hapus slide ini?')">
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
                            Belum ada slide. Klik "Tambah Slide" untuk memulai.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Section Penyebaran --}}
    <div class="mt-10">
        <div class="flex items-center justify-between mb-6">
            <p class="text-sm text-gray-500">Section Penyebaran</p>
        </div>

        <form action="{{ route('admin.markom.home.updateStats') }}" method="POST">
            @csrf
            @method('PUT')

            <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                <table class="w-full text-sm text-left">
                    <thead class="bg-gray-50 text-gray-500 uppercase text-xs tracking-wider">
                        <tr>
                            <th class="px-4 py-3">Key</th>
                            <th class="px-4 py-3">Nilai (Value)</th>
                            <th class="px-4 py-3">Label</th>
                            <th class="px-4 py-3">Icon</th>
                            <th class="px-4 py-3">Deskripsi (Tooltip)</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($stats as $i => $stat)
                            <tr class="hover:bg-gray-50 transition">
                                <input type="hidden" name="stats[{{ $i }}][key]" value="{{ $stat->key }}">
                                <td class="px-4 py-3 text-gray-400 font-mono text-xs">{{ $stat->key }}</td>
                                <td class="px-4 py-3">
                                    <input type="text" name="stats[{{ $i }}][value]"
                                           value="{{ $stat->value }}"
                                           class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#02A6E0]/40 focus:border-[#02A6E0]"
                                           placeholder="cth: 1,2 Jt+" required>
                                </td>
                                <td class="px-4 py-3">
                                    <input type="text" name="stats[{{ $i }}][label]"
                                           value="{{ $stat->label }}"
                                           class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#02A6E0]/40 focus:border-[#02A6E0]"
                                           placeholder="cth: PENERIMA MANFAAT" required>
                                </td>
                                <td class="px-4 py-3">
                                    <select name="stats[{{ $i }}][icon]"
                                            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#02A6E0]/40 focus:border-[#02A6E0]" required>
                                        <option value="users"    {{ $stat->icon === 'users'    ? 'selected' : '' }}>👥 Users</option>
                                        <option value="heart"    {{ $stat->icon === 'heart'    ? 'selected' : '' }}>❤️ Heart</option>
                                        <option value="location" {{ $stat->icon === 'location' ? 'selected' : '' }}>📍 Location</option>
                                    </select>
                                </td>
                                <td class="px-4 py-3">
                                    <input type="text" name="stats[{{ $i }}][description]"
                                           value="{{ $stat->description }}"
                                           class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#02A6E0]/40 focus:border-[#02A6E0]"
                                           placeholder="cth: Total individu yang telah menerima manfaat...">
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-4 py-12 text-center text-gray-400 text-sm">
                                    Data penyebaran belum tersedia. Jalankan seeder terlebih dahulu.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($stats->isNotEmpty())
                <div class="mt-4 flex justify-end">
                    <button type="submit"
                            class="inline-flex items-center gap-2 bg-[#02A6E0] hover:bg-[#028AC9] text-white text-sm font-semibold px-6 py-2.5 rounded-lg transition">
                        Simpan Perubahan
                    </button>
                </div>
            @endif
        </form>
    </div>

    {{-- Section Testimoni --}}
    <div class="mt-10">
        <div class="flex items-center justify-between mb-6">
            <p class="text-sm text-gray-500">Section Testimoni</p>
            <button onclick="openTestimonialModal()"
                    class="inline-flex items-center gap-2 bg-[#02A6E0] hover:bg-[#028AC9] text-white text-sm font-semibold px-4 py-2 rounded-lg transition">
                + Tambah Testimoni
            </button>
        </div>

        @if($testimonials->isEmpty())
            <div class="bg-white rounded-xl shadow-sm px-6 py-12 text-center text-gray-400 text-sm">
                Belum ada testimoni. Klik "+ Tambah Testimoni" untuk memulai.
            </div>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($testimonials as $t)
                    @php
                        $initials = collect(explode(' ', $t->name))->map(fn($w) => strtoupper($w[0]))->take(2)->join('');
                        $roleBadge = match($t->role) {
                            'Donatur'          => 'bg-[#02A6E0]/10 text-[#02A6E0]',
                            'Penerima Manfaat' => 'bg-[#213F9A]/10 text-[#213F9A]',
                            'Mitra'            => 'text-white',
                            default            => 'bg-gray-100 text-gray-500',
                        };
                        $roleStyle = $t->role === 'Mitra'
                            ? 'background: linear-gradient(135deg, #02A6E0 0%, #213F9A 100%);'
                            : '';
                    @endphp
                    <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-5 flex flex-col gap-3 {{ $t->is_active ? '' : 'opacity-50' }}">
                        {{-- Top: role badge + status --}}
                        <div class="flex items-center justify-between">
                            <span class="inline-flex items-center text-[10px] font-bold uppercase tracking-wider px-2.5 py-1 rounded-full {{ $roleBadge }}"
                                  style="{{ $roleStyle }}">
                                {{ $t->role }}
                            </span>
                            @if(!$t->is_active)
                                <span class="text-[10px] text-gray-400 font-medium">Nonaktif</span>
                            @endif
                        </div>

                        {{-- Quote --}}
                        <p class="text-slate-500 text-xs leading-relaxed italic line-clamp-3">
                            &ldquo;{{ $t->quote }}&rdquo;
                        </p>

                        {{-- Divider --}}
                        <div class="h-px bg-gray-100"></div>

                        {{-- Author --}}
                        <div class="flex items-center gap-2.5">
                            <div class="w-8 h-8 rounded-full flex items-center justify-center text-white font-bold text-xs shrink-0"
                                 style="background: linear-gradient(135deg, #02A6E0 0%, #213F9A 100%)">
                                {{ $initials }}
                            </div>
                            <div class="min-w-0">
                                <p class="font-semibold text-gray-800 text-xs truncate">{{ $t->name }}</p>
                                <p class="text-gray-400 text-xs truncate">{{ $t->location }}</p>
                            </div>
                        </div>

                        {{-- Actions --}}
                        <div class="flex items-center gap-3 pt-1">
                            <button onclick="openTestimonialModal({{ $t->id }}, '{{ addslashes($t->name) }}', '{{ addslashes($t->role) }}', '{{ addslashes($t->location) }}', {{ $t->order }}, {{ $t->is_active ? 'true' : 'false' }}, '{{ addslashes($t->quote) }}')"
                                    class="text-xs font-semibold text-[#02A6E0] hover:underline">
                                Edit
                            </button>
                            <form action="{{ route('admin.markom.testimonial.destroy', $t) }}" method="POST"
                                  onsubmit="return confirm('Hapus testimoni ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-xs font-semibold text-red-400 hover:underline">Hapus</button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    {{-- Modal Testimoni --}}
    <div id="testimonial-modal-overlay"
         class="fixed inset-0 bg-black/50 z-50 items-center justify-center hidden"
         onclick="if(event.target===this) closeTestimonialModal()">

        <div class="bg-white rounded-2xl shadow-xl w-full max-w-md mx-4 max-h-[90vh] overflow-y-auto">

            <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100 sticky top-0 bg-white rounded-t-2xl">
                <h3 id="testimonial-modal-title" class="text-base font-semibold text-gray-800">Tambah Testimoni</h3>
                <button onclick="closeTestimonialModal()" class="text-gray-400 hover:text-gray-600 text-xl leading-none">&times;</button>
            </div>

            <form id="testimonial-form"
                  action="{{ route('admin.markom.testimonial.store') }}"
                  method="POST"
                  class="px-6 py-5 space-y-4">
                @csrf
                <input type="hidden" name="_method" id="testimonial-method" value="POST">

                <div class="grid grid-cols-2 gap-4">
                    <div class="col-span-2">
                        <label class="block text-xs font-medium text-gray-600 mb-1">Nama <span class="text-red-500">*</span></label>
                        <input type="text" name="name" id="t-name"
                               class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#02A6E0]/30 focus:border-[#02A6E0]"
                               placeholder="cth: Andini Pratama" required>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">Role <span class="text-red-500">*</span></label>
                        <select name="role" id="t-role"
                                class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#02A6E0]/30 focus:border-[#02A6E0]" required>
                            <option value="Donatur">Donatur</option>
                            <option value="Penerima Manfaat">Penerima Manfaat</option>
                            <option value="Mitra">Mitra</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">Lokasi <span class="text-red-500">*</span></label>
                        <input type="text" name="location" id="t-location"
                               class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#02A6E0]/30 focus:border-[#02A6E0]"
                               placeholder="cth: Jakarta" required>
                    </div>
                    <div class="col-span-2">
                        <label class="block text-xs font-medium text-gray-600 mb-1">Kutipan <span class="text-red-500">*</span></label>
                        <textarea name="quote" id="t-quote" rows="3"
                                  class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#02A6E0]/30 focus:border-[#02A6E0] resize-none"
                                  placeholder="Tulis testimoni di sini..." required></textarea>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">Urutan</label>
                        <input type="number" name="order" id="t-order" min="0" value="0"
                               class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#02A6E0]/30 focus:border-[#02A6E0]">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">Status</label>
                        <select name="is_active" id="t-status"
                                class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#02A6E0]/30 focus:border-[#02A6E0]">
                            <option value="1">Aktif</option>
                            <option value="0">Nonaktif</option>
                        </select>
                    </div>
                </div>

                <div class="flex gap-3 pt-1">
                    <button type="submit"
                            class="flex-1 bg-[#02A6E0] hover:bg-[#028AC9] text-white text-sm font-semibold py-2.5 rounded-lg transition">
                        Simpan
                    </button>
                    <button type="button" onclick="closeTestimonialModal()"
                            class="flex-1 border border-gray-200 text-gray-600 hover:bg-gray-50 text-sm font-semibold py-2.5 rounded-lg transition">
                        Batal
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        const testimonialStoreUrl   = "{{ route('admin.markom.testimonial.store') }}";
        const testimonialUpdateBase = "{{ url('admin/markom/testimonial') }}";

        function openTestimonialModal(id = null, name = '', role = 'Donatur', location = '', order = 0, isActive = true, quote = '') {
            const overlay = document.getElementById('testimonial-modal-overlay');
            const form    = document.getElementById('testimonial-form');

            if (id) {
                document.getElementById('testimonial-modal-title').textContent = 'Edit Testimoni';
                form.action = testimonialUpdateBase + '/' + id;
                document.getElementById('testimonial-method').value = 'PUT';
            } else {
                document.getElementById('testimonial-modal-title').textContent = 'Tambah Testimoni';
                form.action = testimonialStoreUrl;
                document.getElementById('testimonial-method').value = 'POST';
            }

            document.getElementById('t-name').value     = name;
            document.getElementById('t-role').value     = role;
            document.getElementById('t-location').value = location;
            document.getElementById('t-order').value    = order;
            document.getElementById('t-status').value   = isActive ? '1' : '0';
            document.getElementById('t-quote').value    = quote;

            overlay.classList.remove('hidden');
            overlay.classList.add('flex');
        }

        function closeTestimonialModal() {
            const overlay = document.getElementById('testimonial-modal-overlay');
            overlay.classList.add('hidden');
            overlay.classList.remove('flex');
        }

        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                closeModal();
                closeTestimonialModal();
            }
        });
    </script>

    {{-- Modal --}}
    <div id="modal-overlay"
         class="fixed inset-0 bg-black/50 z-50 items-center justify-center hidden"
         onclick="if(event.target===this) closeModal()">

        <div class="bg-white rounded-2xl shadow-xl w-full max-w-lg mx-4">

            {{-- Modal Header --}}
            <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
                <h3 id="modal-title" class="text-base font-semibold text-gray-800">Tambah Slide</h3>
                <button onclick="closeModal()" class="text-gray-400 hover:text-gray-600 text-xl leading-none">&times;</button>
            </div>

            {{-- Form --}}
            <form id="slider-form"
                  action="{{ route('admin.markom.home.store') }}"
                  method="POST"
                  enctype="multipart/form-data"
                  class="px-6 py-5 space-y-4">
                @csrf
                <input type="hidden" name="_method" id="form-method" value="POST">
                <input type="hidden" name="order" id="input-order" value="0">

                {{-- Preview gambar (muncul saat edit atau saat pilih file baru) --}}
                <div id="preview-wrap" class="hidden">
                    <p class="text-xs text-gray-500 mb-1">Preview</p>
                    <img id="preview-img" src="#" alt="preview"
                         class="w-full h-36 object-cover rounded-lg">
                </div>

                {{-- Upload Gambar --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Gambar <span id="image-required" class="text-red-500">*</span>
                        <span id="image-optional" class="hidden text-gray-400 font-normal">(opsional, biarkan kosong jika tidak ingin mengganti)</span>
                    </label>
                    <input type="file" name="image" id="input-image" accept="image/jpeg,image/png,image/webp"
                           class="block w-full text-sm text-gray-600 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-[#02A6E0]/10 file:text-[#02A6E0] hover:file:bg-[#02A6E0]/20">
                    <p class="text-xs text-gray-400 mt-1">Format: JPG, PNG, WEBP. Maks 3MB. Rekomendasi: 1920×600px (landscape).</p>
                </div>

                {{-- Judul --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Judul <span class="text-gray-400 font-normal">(opsional)</span></label>
                    <input type="text" name="title" id="input-title"
                           placeholder="cth: Bersama Memberi, Bersama Berkembang"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#02A6E0]/40 focus:border-[#02A6E0]">
                </div>

                {{-- Link Redirect --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Link Redirect <span class="text-gray-400 font-normal">(opsional)</span></label>
                    <input type="text" name="link" id="input-link"
                           placeholder="cth: /layanan/pendaftaran-donatur"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#02A6E0]/40 focus:border-[#02A6E0]">
                    <p class="text-xs text-gray-400 mt-1">URL tujuan ketika gambar diklik. Kosongkan jika tidak ada.</p>
                </div>

                {{-- Status --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                    <select name="is_active" id="input-status"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#02A6E0]/40 focus:border-[#02A6E0]">
                        <option value="1">Aktif</option>
                        <option value="0">Nonaktif</option>
                    </select>
                </div>

                {{-- Footer --}}
                <div class="flex gap-3 pt-2">
                    <button type="submit"
                            class="flex-1 bg-[#02A6E0] hover:bg-[#028AC9] text-white text-sm font-semibold py-2.5 rounded-lg transition">
                        Simpan
                    </button>
                    <button type="button" onclick="closeModal()"
                            class="flex-1 border border-gray-300 text-gray-600 hover:bg-gray-50 text-sm font-semibold py-2.5 rounded-lg transition">
                        Batal
                    </button>
                </div>

            </form>
        </div>
    </div>

    <script>
        const storeUrl = "{{ route('admin.markom.home.store') }}";
        const updateUrlBase = "{{ url('admin/markom/home') }}";

        function openModal(id = null, title = '', link = '', order = 0, isActive = true, imageUrl = '') {
            const modal = document.getElementById('modal-overlay');
            const form = document.getElementById('slider-form');
            const modalTitle = document.getElementById('modal-title');
            const methodInput = document.getElementById('form-method');
            const imageRequired = document.getElementById('image-required');
            const imageOptional = document.getElementById('image-optional');
            const previewWrap = document.getElementById('preview-wrap');
            const previewImg = document.getElementById('preview-img');

            // Reset file input
            document.getElementById('input-image').value = '';

            if (id) {
                // Mode Edit
                modalTitle.textContent = 'Edit Slide';
                form.action = updateUrlBase + '/' + id;
                methodInput.value = 'PUT';
                imageRequired.classList.add('hidden');
                imageOptional.classList.remove('hidden');
                document.getElementById('input-image').removeAttribute('required');

                // Tampilkan preview gambar saat ini
                previewImg.src = imageUrl;
                previewWrap.classList.remove('hidden');
            } else {
                // Mode Tambah
                modalTitle.textContent = 'Tambah Slide';
                form.action = storeUrl;
                methodInput.value = 'POST';
                imageRequired.classList.remove('hidden');
                imageOptional.classList.add('hidden');
                document.getElementById('input-image').setAttribute('required', 'required');

                previewWrap.classList.add('hidden');
                previewImg.src = '#';
            }

            document.getElementById('input-title').value = title;
            document.getElementById('input-link').value = link;
            document.getElementById('input-order').value = order;
            document.getElementById('input-status').value = isActive ? '1' : '0';

            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closeModal() {
            const modal = document.getElementById('modal-overlay');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }

        // Preview gambar yang baru dipilih
        document.getElementById('input-image').addEventListener('change', function (e) {
            const file = e.target.files[0];
            if (!file) return;
            const reader = new FileReader();
            reader.onload = (ev) => {
                document.getElementById('preview-img').src = ev.target.result;
                document.getElementById('preview-wrap').classList.remove('hidden');
            };
            reader.readAsDataURL(file);
        });

    </script>

@endsection
