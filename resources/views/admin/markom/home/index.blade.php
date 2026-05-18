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

    {{-- Section Hero Slider --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between bg-gradient-to-r from-slate-50 to-white">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-xl flex items-center justify-center shrink-0"
                     style="background: linear-gradient(135deg, rgba(2,166,224,0.12) 0%, rgba(33,63,154,0.08) 100%); border: 1px solid rgba(2,166,224,0.2)">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-[18px] h-[18px]" fill="none" viewBox="0 0 24 24" stroke="#02A6E0" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div>
                <div>
                    <h3 class="font-semibold text-gray-800 text-sm">Hero Slider</h3>
                    <p class="text-xs text-gray-400 mt-0.5">Kelola gambar slide utama di beranda</p>
                </div>
            </div>
            <div class="flex items-center gap-3">
                <span class="text-xs text-gray-400 bg-gray-100 px-2.5 py-1 rounded-full font-medium">{{ $sliders->count() }} slide</span>
                <button onclick="openModal()"
                        class="inline-flex items-center gap-1.5 bg-[#02A6E0] hover:bg-[#028AC9] text-white text-xs font-semibold px-3.5 py-2 rounded-lg transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                    Tambah Slide
                </button>
            </div>
        </div>
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
    <div class="mt-8 bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between bg-gradient-to-r from-slate-50 to-white">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-xl flex items-center justify-center shrink-0"
                     style="background: linear-gradient(135deg, rgba(2,166,224,0.12) 0%, rgba(33,63,154,0.08) 100%); border: 1px solid rgba(2,166,224,0.2)">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-[18px] h-[18px]" fill="none" viewBox="0 0 24 24" stroke="#02A6E0" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                </div>
                <div>
                    <h3 class="font-semibold text-gray-800 text-sm">Section Penyebaran</h3>
                    <p class="text-xs text-gray-400 mt-0.5">Statistik dampak program yang tampil di beranda</p>
                </div>
            </div>
        </div>

        <form action="{{ route('admin.markom.home.updateStats') }}" method="POST">
            @csrf
            @method('PUT')

            <table class="w-full text-sm text-left">
                    <thead class="bg-gray-50 text-gray-500 uppercase text-xs tracking-wider">
                        <tr class="text-center">
                            <th class="px-4 py-3">Total</th>
                            <th class="px-4 py-3">Label</th>
                            <th class="px-4 py-3">Icon</th>
                            <th class="px-4 py-3">Deskripsi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($stats as $i => $stat)
                            <tr class="hover:bg-gray-50 transition">
                                <input type="hidden" name="stats[{{ $i }}][key]" value="{{ $stat->key }}">
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
                                <td colspan="4" class="px-4 py-12 text-center text-gray-400 text-sm">
                                    Data penyebaran belum tersedia. Jalankan seeder terlebih dahulu.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

            @if($stats->isNotEmpty())
                <div class="px-6 py-4 border-t border-gray-100 flex justify-end bg-gray-50/50">
                    <button type="submit"
                            class="inline-flex items-center gap-2 bg-[#02A6E0] hover:bg-[#028AC9] text-white text-sm font-semibold px-5 py-2 rounded-lg transition">
                        Simpan Perubahan
                    </button>
                </div>
            @endif
        </form>
    </div>

    {{-- Section Testimoni --}}
    <div class="mt-8 bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between bg-gradient-to-r from-slate-50 to-white">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-xl flex items-center justify-center shrink-0"
                     style="background: linear-gradient(135deg, rgba(2,166,224,0.12) 0%, rgba(33,63,154,0.08) 100%); border: 1px solid rgba(2,166,224,0.2)">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4.5 h-4.5" fill="none" viewBox="0 0 24 24" stroke="#02A6E0" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                    </svg>
                </div>
                <div>
                    <h3 class="font-semibold text-gray-800 text-sm">Section Testimoni</h3>
                    <p class="text-xs text-gray-400 mt-0.5">Ulasan dari donatur, penerima manfaat & mitra</p>
                </div>
            </div>
            <div class="flex items-center gap-3">
                <span class="text-xs text-gray-400 bg-gray-100 px-2.5 py-1 rounded-full font-medium">{{ $testimonials->count() }} testimoni</span>
                <button onclick="openTestimonialModal()"
                        class="inline-flex items-center gap-1.5 bg-[#02A6E0] hover:bg-[#028AC9] text-white text-xs font-semibold px-3.5 py-2 rounded-lg transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                    Tambah Testimoni
                </button>
            </div>
        </div>

        <div class="p-6">
        @if($testimonials->isEmpty())
            <div class="py-10 text-center text-gray-400 text-sm">
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
        </div>{{-- /p-6 --}}
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
                closeProgramModal();
                closeMitraModal();
                closeCtaModal();
            }
        });
    </script>

    {{-- Modal CTA --}}
    <div id="cta-modal-overlay"
         class="fixed inset-0 bg-black/50 z-50 items-center justify-center hidden"
         onclick="if(event.target===this) closeCtaModal()">

        <div class="bg-white rounded-2xl shadow-xl w-full max-w-lg mx-4 max-h-[90vh] overflow-y-auto">

            <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100 sticky top-0 bg-white rounded-t-2xl">
                <h3 class="text-base font-semibold text-gray-800">Edit CTA Relawan</h3>
                <button onclick="closeCtaModal()" class="text-gray-400 hover:text-gray-600 text-xl leading-none">&times;</button>
            </div>

            <form id="cta-form"
                  action="{{ route('admin.markom.home.updateCta') }}"
                  method="POST"
                  enctype="multipart/form-data"
                  class="px-6 py-5 space-y-4">
                @csrf
                @method('PUT')

                {{-- Background Image --}}
                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1">
                        Background Image
                        <span class="text-gray-400 font-normal">(opsional — kosongkan jika tidak ingin mengganti)</span>
                    </label>
                    @if($cta && $cta->bg_image)
                        <div id="cta-bg-current" class="mb-2">
                            <img src="{{ asset('storage/' . $cta->bg_image) }}" alt="BG saat ini"
                                 class="w-full h-20 object-cover rounded-lg">
                            <p class="text-[10px] text-gray-400 mt-1">Gambar saat ini</p>
                        </div>
                    @endif
                    <div id="cta-bg-preview-wrap" class="hidden mb-2">
                        <img id="cta-bg-preview-img" src="#" alt="preview" class="w-full h-20 object-cover rounded-lg">
                        <p class="text-[10px] text-gray-400 mt-1">Preview baru</p>
                    </div>
                    <input type="file" name="bg_image" id="cta-bg-image" accept="image/jpeg,image/png,image/webp"
                           class="block w-full text-xs text-gray-500 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-[#213F9A]/10 file:text-[#213F9A] hover:file:bg-[#213F9A]/20">
                    <p class="text-xs text-gray-400 mt-1">JPG, PNG, WEBP. Maks 5MB. Rekomendasi: 1600×600px landscape.</p>
                </div>

                {{-- Cartoon Image --}}
                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1">
                        Gambar Kartun / Maskot
                        <span class="text-gray-400 font-normal">(opsional)</span>
                    </label>
                    @if($cta && $cta->cartoon_image)
                        <div class="mb-2">
                            <img src="{{ asset('storage/' . $cta->cartoon_image) }}" alt="Kartun saat ini"
                                 class="h-20 w-auto object-contain rounded-lg bg-gray-50 border border-gray-100 p-1">
                            <p class="text-[10px] text-gray-400 mt-1">Gambar saat ini</p>
                        </div>
                    @endif
                    <div id="cta-cartoon-preview-wrap" class="hidden mb-2">
                        <img id="cta-cartoon-preview-img" src="#" alt="preview"
                             class="h-20 w-auto object-contain rounded-lg bg-gray-50 border border-gray-100 p-1">
                        <p class="text-[10px] text-gray-400 mt-1">Preview baru</p>
                    </div>
                    <input type="file" name="cartoon_image" id="cta-cartoon-image" accept="image/jpeg,image/png,image/webp"
                           class="block w-full text-xs text-gray-500 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-[#02A6E0]/10 file:text-[#02A6E0] hover:file:bg-[#02A6E0]/20">
                    <p class="text-xs text-gray-400 mt-1">JPG, PNG, WEBP. Maks 3MB. Gunakan PNG transparan untuk hasil terbaik.</p>
                </div>

                <div class="border-t border-gray-100 pt-4 space-y-4">
                    {{-- Heading Before --}}
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">Judul — Bagian Normal <span class="text-red-500">*</span></label>
                        <input type="text" name="heading_before" id="cta-heading-before"
                               value="{{ $cta->heading_before ?? '' }}"
                               class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#213F9A]/30 focus:border-[#213F9A]"
                               placeholder="cth: Jadi Bagian dari" required>
                    </div>

                    {{-- Heading Highlight --}}
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">
                            Judul — Bagian Berwarna Biru <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="heading_highlight" id="cta-heading-highlight"
                               value="{{ $cta->heading_highlight ?? '' }}"
                               class="w-full border border-[#02A6E0]/40 rounded-lg px-3 py-2 text-sm text-[#02A6E0] font-semibold focus:outline-none focus:ring-2 focus:ring-[#02A6E0]/30 focus:border-[#02A6E0]"
                               placeholder="cth: Kehebatan Mereka Berkontribusi" required>
                    </div>

                    {{-- Heading After --}}
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">Judul — Bagian Akhir <span class="text-red-500">*</span></label>
                        <input type="text" name="heading_after" id="cta-heading-after"
                               value="{{ $cta->heading_after ?? '' }}"
                               class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#213F9A]/30 focus:border-[#213F9A]"
                               placeholder="cth: untuk Masyarakat" required>
                    </div>

                    {{-- Body --}}
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">Deskripsi <span class="text-red-500">*</span></label>
                        <textarea name="body" id="cta-body" rows="3"
                                  class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#213F9A]/30 focus:border-[#213F9A] resize-none"
                                  placeholder="Tulis deskripsi CTA..." required>{{ $cta->body ?? '' }}</textarea>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        {{-- Button Label --}}
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1">Teks Tombol <span class="text-red-500">*</span></label>
                            <input type="text" name="button_label" id="cta-button-label"
                                   value="{{ $cta->button_label ?? '' }}"
                                   class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#213F9A]/30 focus:border-[#213F9A]"
                                   placeholder="cth: Gabung Sekarang" required>
                        </div>
                        {{-- Button Href --}}
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1">Link Tombol <span class="text-red-500">*</span></label>
                            <input type="text" name="button_href" id="cta-button-href"
                                   value="{{ $cta->button_href ?? '' }}"
                                   class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#213F9A]/30 focus:border-[#213F9A]"
                                   placeholder="cth: /kemitraan/volunteer" required>
                        </div>
                    </div>
                </div>

                <div class="flex gap-3 pt-1">
                    <button type="submit"
                            class="flex-1 bg-[#213F9A] hover:bg-[#1a3480] text-white text-sm font-semibold py-2.5 rounded-lg transition">
                        Simpan Perubahan
                    </button>
                    <button type="button" onclick="closeCtaModal()"
                            class="flex-1 border border-gray-200 text-gray-600 hover:bg-gray-50 text-sm font-semibold py-2.5 rounded-lg transition">
                        Batal
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openCtaModal() {
            document.getElementById('cta-modal-overlay').classList.remove('hidden');
            document.getElementById('cta-modal-overlay').classList.add('flex');
        }

        function closeCtaModal() {
            document.getElementById('cta-modal-overlay').classList.add('hidden');
            document.getElementById('cta-modal-overlay').classList.remove('flex');
        }

        document.getElementById('cta-bg-image').addEventListener('change', function (e) {
            const file = e.target.files[0];
            if (!file) return;
            const reader = new FileReader();
            reader.onload = (ev) => {
                document.getElementById('cta-bg-preview-img').src = ev.target.result;
                document.getElementById('cta-bg-preview-wrap').classList.remove('hidden');
            };
            reader.readAsDataURL(file);
        });

        document.getElementById('cta-cartoon-image').addEventListener('change', function (e) {
            const file = e.target.files[0];
            if (!file) return;
            const reader = new FileReader();
            reader.onload = (ev) => {
                document.getElementById('cta-cartoon-preview-img').src = ev.target.result;
                document.getElementById('cta-cartoon-preview-wrap').classList.remove('hidden');
            };
            reader.readAsDataURL(file);
        });
    </script>

    {{-- Section Highlight Program --}}
    <div class="mt-8 bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between bg-gradient-to-r from-slate-50 to-white">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-xl flex items-center justify-center shrink-0"
                     style="background: linear-gradient(135deg, rgba(2,166,224,0.12) 0%, rgba(33,63,154,0.08) 100%); border: 1px solid rgba(2,166,224,0.2)">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4.5 h-4.5" fill="none" viewBox="0 0 24 24" stroke="#02A6E0" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                    </svg>
                </div>
                <div>
                    <h3 class="font-semibold text-gray-800 text-sm">Program Unggulan</h3>
                    <p class="text-xs text-gray-400 mt-0.5">Program pilihan yang ditampilkan di beranda</p>
                </div>
            </div>
            <div class="flex items-center gap-3">
                <span class="text-xs text-gray-400 bg-gray-100 px-2.5 py-1 rounded-full font-medium">{{ $highlightPrograms->count() }} program</span>
                <button onclick="openProgramModal()"
                        class="inline-flex items-center gap-1.5 bg-[#02A6E0] hover:bg-[#028AC9] text-white text-xs font-semibold px-3.5 py-2 rounded-lg transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                    Tambah Program
                </button>
            </div>
        </div>

        <div class="p-6">
        @if($highlightPrograms->isEmpty())
            <div class="py-10 text-center text-gray-400 text-sm">
                Belum ada program. Klik "+ Tambah Program" untuk memulai.
            </div>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($highlightPrograms as $prog)
                    <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden flex flex-col {{ $prog->is_active ? '' : 'opacity-50' }}">

                        {{-- Thumbnail --}}
                        <div class="relative h-36 bg-gray-100 overflow-hidden">
                            @if($prog->image)
                                <img src="{{ Storage::url($prog->image) }}"
                                     alt="{{ $prog->label }}"
                                     class="w-full h-full object-cover">
                            @else
                                <img src="https://picsum.photos/seed/{{ Str::slug($prog->label) }}/600/400"
                                     alt="{{ $prog->label }}"
                                     class="w-full h-full object-cover">
                            @endif
                            {{-- Label overlay --}}
                            <div class="absolute bottom-0 left-0 right-0 bg-[#02A6E0] py-1.5 px-3 text-center">
                                <span class="text-white font-bold text-xs uppercase tracking-widest">{{ $prog->label }}</span>
                            </div>
                            @if(!$prog->is_active)
                                <div class="absolute top-2 right-2 bg-gray-700/70 text-white text-[10px] font-medium px-2 py-0.5 rounded-full">
                                    Nonaktif
                                </div>
                            @endif
                        </div>

                        {{-- Body --}}
                        <div class="p-4 flex flex-col gap-2 flex-1">
                            <p class="text-gray-500 text-xs leading-relaxed line-clamp-2">{{ $prog->desc }}</p>
                            <p class="text-[#02A6E0] text-xs font-mono truncate">{{ $prog->href }}</p>
                        </div>

                        {{-- Actions --}}
                        <div class="px-4 pb-4 flex items-center gap-3">
                            <button onclick="openProgramModal(
                                        {{ $prog->id }},
                                        '{{ addslashes($prog->label) }}',
                                        '{{ addslashes($prog->desc) }}',
                                        '{{ addslashes($prog->href) }}',
                                        {{ $prog->order }},
                                        {{ $prog->is_active ? 'true' : 'false' }},
                                        '{{ $prog->image ? Storage::url($prog->image) : '' }}'
                                    )"
                                    class="text-xs font-semibold text-[#02A6E0] hover:underline">
                                Edit
                            </button>
                            <form action="{{ route('admin.markom.highlight-program.destroy', $prog) }}" method="POST"
                                  onsubmit="return confirm('Hapus program ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-xs font-semibold text-red-400 hover:underline">Hapus</button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
        </div>{{-- /p-6 --}}
    </div>

    {{-- Section Mitra --}}
    <div class="mt-8 bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between bg-gradient-to-r from-slate-50 to-white">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-xl flex items-center justify-center shrink-0"
                     style="background: linear-gradient(135deg, rgba(2,166,224,0.12) 0%, rgba(33,63,154,0.08) 100%); border: 1px solid rgba(2,166,224,0.2)">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4.5 h-4.5" fill="none" viewBox="0 0 24 24" stroke="#02A6E0" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </div>
                <div>
                    <h3 class="font-semibold text-gray-800 text-sm">Mitra Kami</h3>
                    <p class="text-xs text-gray-400 mt-0.5">Logo mitra yang tampil di marquee beranda</p>
                </div>
            </div>
            <div class="flex items-center gap-3">
                <span class="text-xs text-gray-400 bg-gray-100 px-2.5 py-1 rounded-full font-medium">{{ $partners->count() }} mitra</span>
                <button onclick="openMitraModal()"
                        class="inline-flex items-center gap-1.5 bg-[#02A6E0] hover:bg-[#028AC9] text-white text-xs font-semibold px-3.5 py-2 rounded-lg transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                    Tambah Mitra
                </button>
            </div>
        </div>

        <div class="p-6">
        @if($partners->isEmpty())
            <div class="py-10 text-center text-gray-400 text-sm">
                Belum ada logo mitra. Klik "+ Tambah Mitra" untuk memulai.
            </div>
        @else
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-4">
                @foreach($partners as $partner)
                    <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden flex flex-col {{ $partner->is_active ? '' : 'opacity-50' }}">

                        {{-- Logo Thumbnail --}}
                        <div class="relative h-24 bg-gray-50 flex items-center justify-center p-3 overflow-hidden">
                            <img src="{{ Storage::url($partner->image) }}"
                                 alt="Mitra #{{ $partner->id }}"
                                 class="max-h-full max-w-full object-contain">
                            @if(!$partner->is_active)
                                <div class="absolute top-1.5 right-1.5 bg-gray-700/70 text-white text-[9px] font-medium px-1.5 py-0.5 rounded-full">
                                    Nonaktif
                                </div>
                            @endif
                        </div>

                        {{-- Actions --}}
                        <div class="px-3 py-2.5 flex items-center justify-between border-t border-gray-50">
                            <span class="text-gray-400 text-[10px]">#{{ $partner->order }}</span>
                            <div class="flex items-center gap-3">
                                <button onclick="openMitraModal(
                                            {{ $partner->id }},
                                            {{ $partner->order }},
                                            {{ $partner->is_active ? 'true' : 'false' }},
                                            '{{ Storage::url($partner->image) }}'
                                        )"
                                        class="text-xs font-semibold text-[#02A6E0] hover:underline">
                                    Edit
                                </button>
                                <form action="{{ route('admin.markom.home-partner.destroy', $partner) }}" method="POST"
                                      onsubmit="return confirm('Hapus logo mitra ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-xs font-semibold text-red-400 hover:underline">Hapus</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
        </div>{{-- /p-6 --}}
    </div>

    {{-- Section CTA Relawan --}}
    <div class="mt-8 bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between bg-gradient-to-r from-slate-50 to-white">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-xl flex items-center justify-center shrink-0"
                     style="background: linear-gradient(135deg, rgba(33,63,154,0.12) 0%, rgba(2,166,224,0.08) 100%); border: 1px solid rgba(33,63,154,0.2)">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4.5 h-4.5" fill="none" viewBox="0 0 24 24" stroke="#213F9A" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z" />
                    </svg>
                </div>
                <div>
                    <h3 class="font-semibold text-gray-800 text-sm">CTA Relawan</h3>
                    <p class="text-xs text-gray-400 mt-0.5">Banner ajakan bergabung sebagai relawan</p>
                </div>
            </div>
            <button onclick="openCtaModal()"
                    class="inline-flex items-center gap-1.5 bg-[#213F9A] hover:bg-[#1a3480] text-white text-xs font-semibold px-3.5 py-2 rounded-lg transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                Edit CTA
            </button>
        </div>

        @if($cta)
        {{-- Preview strip --}}
        <div class="relative h-28 overflow-hidden">
                @if($cta->bg_image)
                    <img src="{{ asset('storage/' . $cta->bg_image) }}" alt="BG"
                         class="absolute inset-0 w-full h-full object-cover blur-sm scale-105">
                @else
                    <div class="absolute inset-0 bg-gradient-to-r from-[#EEF4FF] to-[#E6F7FE]"></div>
                @endif
                <div class="absolute inset-0 bg-white/50"></div>

                <div class="relative h-full flex items-center gap-6 px-6">
                    {{-- Cartoon thumb --}}
                    <div class="shrink-0 w-16 h-16 rounded-xl overflow-hidden bg-[#02A6E0]/10 flex items-center justify-center border border-[#02A6E0]/20">
                        @if($cta->cartoon_image)
                            <img src="{{ asset('storage/' . $cta->cartoon_image) }}" alt="Kartun"
                                 class="w-full h-full object-contain p-1">
                        @else
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-[#02A6E0]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                            </svg>
                        @endif
                    </div>
                    {{-- Text preview --}}
                    <div class="min-w-0">
                        <p class="font-bold text-[#213F9A] text-sm leading-snug truncate">
                            {{ $cta->heading_before }}
                            <span class="text-[#02A6E0]">{{ $cta->heading_highlight }}</span>
                            {{ $cta->heading_after }}
                        </p>
                        <p class="text-gray-500 text-xs mt-1 line-clamp-2 leading-relaxed">{{ $cta->body }}</p>
                    </div>
                    {{-- Button preview --}}
                    <div class="ml-auto shrink-0">
                        <span class="inline-flex items-center gap-1.5 text-white text-xs font-semibold px-4 py-2 rounded-lg"
                              style="background: linear-gradient(135deg, #02A6E0 0%, #213F9A 100%)">
                            {{ $cta->button_label }}
                        </span>
                    </div>
                </div>
            </div>
        @else
        <div class="px-6 py-10 text-center text-gray-400 text-sm">
            Belum ada data CTA. Klik "Edit CTA" untuk mengisi.
        </div>
        @endif
    </div>

    {{-- Modal Mitra --}}
    <div id="mitra-modal-overlay"
         class="fixed inset-0 bg-black/50 z-50 items-center justify-center hidden"
         onclick="if(event.target===this) closeMitraModal()">

        <div class="bg-white rounded-2xl shadow-xl w-full max-w-sm mx-4">

            <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
                <h3 id="mitra-modal-title" class="text-base font-semibold text-gray-800">Tambah Mitra</h3>
                <button onclick="closeMitraModal()" class="text-gray-400 hover:text-gray-600 text-xl leading-none">&times;</button>
            </div>

            <form id="mitra-form"
                  action="{{ route('admin.markom.home-partner.store') }}"
                  method="POST"
                  enctype="multipart/form-data"
                  class="px-6 py-5 space-y-4">
                @csrf
                <input type="hidden" name="_method" id="mitra-method" value="POST">

                {{-- Preview --}}
                <div id="mitra-preview-wrap" class="hidden">
                    <p class="text-xs text-gray-500 mb-1">Preview Logo</p>
                    <div class="w-full h-28 bg-gray-50 rounded-lg border border-gray-100 flex items-center justify-center p-3">
                        <img id="mitra-preview-img" src="#" alt="preview" class="max-h-full max-w-full object-contain">
                    </div>
                </div>

                {{-- Upload --}}
                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1">
                        Logo
                        <span id="mitra-img-required" class="text-red-500">*</span>
                        <span id="mitra-img-optional" class="hidden text-gray-400 font-normal">(opsional, kosongkan jika tidak ingin mengganti)</span>
                    </label>
                    <input type="file" name="image" id="mitra-image" accept="image/jpeg,image/png,image/webp"
                           class="block w-full text-xs text-gray-500 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-[#02A6E0]/10 file:text-[#02A6E0] hover:file:bg-[#02A6E0]/20">
                    <p class="text-xs text-gray-400 mt-1">JPG, PNG, WEBP. Maks 3MB. Rekomendasi: logo transparan (PNG).</p>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    {{-- Urutan --}}
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">Urutan</label>
                        <input type="number" name="order" id="mitra-order" min="0" value="0"
                               class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#02A6E0]/30 focus:border-[#02A6E0]">
                    </div>
                    {{-- Status --}}
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">Status</label>
                        <select name="is_active" id="mitra-status"
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
                    <button type="button" onclick="closeMitraModal()"
                            class="flex-1 border border-gray-200 text-gray-600 hover:bg-gray-50 text-sm font-semibold py-2.5 rounded-lg transition">
                        Batal
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        const mitraStoreUrl   = "{{ route('admin.markom.home-partner.store') }}";
        const mitraUpdateBase = "{{ url('admin/markom/home-partner') }}";

        function openMitraModal(id = null, order = 0, isActive = true, imageUrl = '') {
            const overlay  = document.getElementById('mitra-modal-overlay');
            const form     = document.getElementById('mitra-form');
            const imgReq   = document.getElementById('mitra-img-required');
            const imgOpt   = document.getElementById('mitra-img-optional');
            const prevWrap = document.getElementById('mitra-preview-wrap');
            const prevImg  = document.getElementById('mitra-preview-img');

            document.getElementById('mitra-image').value = '';

            if (id) {
                document.getElementById('mitra-modal-title').textContent = 'Edit Logo Mitra';
                form.action = mitraUpdateBase + '/' + id;
                document.getElementById('mitra-method').value = 'PUT';
                imgReq.classList.add('hidden');
                imgOpt.classList.remove('hidden');
                if (imageUrl) {
                    prevImg.src = imageUrl;
                    prevWrap.classList.remove('hidden');
                } else {
                    prevWrap.classList.add('hidden');
                }
            } else {
                document.getElementById('mitra-modal-title').textContent = 'Tambah Mitra';
                form.action = mitraStoreUrl;
                document.getElementById('mitra-method').value = 'POST';
                imgReq.classList.remove('hidden');
                imgOpt.classList.add('hidden');
                prevWrap.classList.add('hidden');
                prevImg.src = '#';
            }

            document.getElementById('mitra-order').value  = order;
            document.getElementById('mitra-status').value = isActive ? '1' : '0';

            overlay.classList.remove('hidden');
            overlay.classList.add('flex');
        }

        function closeMitraModal() {
            document.getElementById('mitra-modal-overlay').classList.add('hidden');
            document.getElementById('mitra-modal-overlay').classList.remove('flex');
        }

        document.getElementById('mitra-image').addEventListener('change', function (e) {
            const file = e.target.files[0];
            if (!file) return;
            const reader = new FileReader();
            reader.onload = (ev) => {
                document.getElementById('mitra-preview-img').src = ev.target.result;
                document.getElementById('mitra-preview-wrap').classList.remove('hidden');
            };
            reader.readAsDataURL(file);
        });
    </script>

    {{-- Modal Highlight Program --}}
    <div id="program-modal-overlay"
         class="fixed inset-0 bg-black/50 z-50 items-center justify-center hidden"
         onclick="if(event.target===this) closeProgramModal()">

        <div class="bg-white rounded-2xl shadow-xl w-full max-w-md mx-4 max-h-[90vh] overflow-y-auto">

            <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100 sticky top-0 bg-white rounded-t-2xl">
                <h3 id="program-modal-title" class="text-base font-semibold text-gray-800">Tambah Program</h3>
                <button onclick="closeProgramModal()" class="text-gray-400 hover:text-gray-600 text-xl leading-none">&times;</button>
            </div>

            <form id="program-form"
                  action="{{ route('admin.markom.highlight-program.store') }}"
                  method="POST"
                  enctype="multipart/form-data"
                  class="px-6 py-5 space-y-4">
                @csrf
                <input type="hidden" name="_method" id="program-method" value="POST">

                {{-- Preview gambar --}}
                <div id="program-preview-wrap" class="hidden">
                    <p class="text-xs text-gray-500 mb-1">Preview Foto</p>
                    <img id="program-preview-img" src="#" alt="preview"
                         class="w-full h-32 object-cover rounded-lg">
                </div>

                {{-- Upload foto --}}
                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1">
                        Foto
                        <span id="prog-img-required" class="text-red-500">*</span>
                        <span id="prog-img-optional" class="hidden text-gray-400 font-normal">(opsional)</span>
                    </label>
                    <input type="file" name="image" id="prog-image" accept="image/jpeg,image/png,image/webp"
                           class="block w-full text-xs text-gray-500 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-[#02A6E0]/10 file:text-[#02A6E0] hover:file:bg-[#02A6E0]/20">
                    <p class="text-xs text-gray-400 mt-1">JPG, PNG, WEBP. Maks 3MB. Jika kosong saat edit, foto tidak berubah.</p>
                </div>

                {{-- Label --}}
                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1">Nama Program <span class="text-red-500">*</span></label>
                    <input type="text" name="label" id="prog-label"
                           class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#02A6E0]/30 focus:border-[#02A6E0]"
                           placeholder="cth: Bidang Pendidikan" required>
                </div>

                {{-- Deskripsi --}}
                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1">Deskripsi <span class="text-red-500">*</span></label>
                    <textarea name="desc" id="prog-desc" rows="3"
                              class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#02A6E0]/30 focus:border-[#02A6E0] resize-none"
                              placeholder="Deskripsi singkat program..." required></textarea>
                </div>

                {{-- Href --}}
                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1">Link Program <span class="text-red-500">*</span></label>
                    <input type="text" name="href" id="prog-href"
                           class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#02A6E0]/30 focus:border-[#02A6E0]"
                           placeholder="cth: /program/pendidikan" required>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    {{-- Urutan --}}
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">Urutan</label>
                        <input type="number" name="order" id="prog-order" min="0" value="0"
                               class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#02A6E0]/30 focus:border-[#02A6E0]">
                    </div>
                    {{-- Status --}}
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">Status</label>
                        <select name="is_active" id="prog-status"
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
                    <button type="button" onclick="closeProgramModal()"
                            class="flex-1 border border-gray-200 text-gray-600 hover:bg-gray-50 text-sm font-semibold py-2.5 rounded-lg transition">
                        Batal
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        const programStoreUrl   = "{{ route('admin.markom.highlight-program.store') }}";
        const programUpdateBase = "{{ url('admin/markom/highlight-program') }}";

        function openProgramModal(id = null, label = '', desc = '', href = '', order = 0, isActive = true, imageUrl = '') {
            const overlay = document.getElementById('program-modal-overlay');
            const form    = document.getElementById('program-form');
            const imgReq  = document.getElementById('prog-img-required');
            const imgOpt  = document.getElementById('prog-img-optional');
            const prevWrap = document.getElementById('program-preview-wrap');
            const prevImg  = document.getElementById('program-preview-img');

            document.getElementById('prog-image').value = '';

            if (id) {
                document.getElementById('program-modal-title').textContent = 'Edit Program';
                form.action = programUpdateBase + '/' + id;
                document.getElementById('program-method').value = 'PUT';
                imgReq.classList.add('hidden');
                imgOpt.classList.remove('hidden');
                if (imageUrl) {
                    prevImg.src = imageUrl;
                    prevWrap.classList.remove('hidden');
                } else {
                    prevWrap.classList.add('hidden');
                }
            } else {
                document.getElementById('program-modal-title').textContent = 'Tambah Program';
                form.action = programStoreUrl;
                document.getElementById('program-method').value = 'POST';
                imgReq.classList.remove('hidden');
                imgOpt.classList.add('hidden');
                prevWrap.classList.add('hidden');
                prevImg.src = '#';
            }

            document.getElementById('prog-label').value  = label;
            document.getElementById('prog-desc').value   = desc;
            document.getElementById('prog-href').value   = href;
            document.getElementById('prog-order').value  = order;
            document.getElementById('prog-status').value = isActive ? '1' : '0';

            overlay.classList.remove('hidden');
            overlay.classList.add('flex');
        }

        function closeProgramModal() {
            document.getElementById('program-modal-overlay').classList.add('hidden');
            document.getElementById('program-modal-overlay').classList.remove('flex');
        }

        document.getElementById('prog-image').addEventListener('change', function (e) {
            const file = e.target.files[0];
            if (!file) return;
            const reader = new FileReader();
            reader.onload = (ev) => {
                document.getElementById('program-preview-img').src = ev.target.result;
                document.getElementById('program-preview-wrap').classList.remove('hidden');
            };
            reader.readAsDataURL(file);
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
