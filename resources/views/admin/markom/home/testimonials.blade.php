@extends('admin.layouts.app')

@section('title', 'Testimoni')
@section('page-title', 'Testimoni')

@section('content')

    {{-- Flash message --}}
    @if(session('success'))
        <div class="mb-4 px-4 py-3 rounded-lg bg-green-50 border border-green-200 text-green-700 text-sm">
            {{ session('success') }}
        </div>
    @endif

    {{-- Header --}}
    <div class="flex items-center justify-between mb-6">
        <p class="text-sm text-gray-500">Daftar Testimoni</p>
        <button onclick="openModal()"
                class="inline-flex items-center gap-2 bg-[#02A6E0] hover:bg-[#028AC9] text-white text-sm font-semibold px-4 py-2 rounded-lg transition">
            + Tambah Testimoni
        </button>
    </div>

    {{-- Table --}}
    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <table class="w-full text-sm text-left">
            <thead class="bg-gray-50 text-gray-500 uppercase text-xs tracking-wider">
                <tr>
                    <th class="px-4 py-3">Nama</th>
                    <th class="px-4 py-3">Role</th>
                    <th class="px-4 py-3">Lokasi</th>
                    <th class="px-4 py-3">Kutipan</th>
                    <th class="px-4 py-3 text-center">Urutan</th>
                    <th class="px-4 py-3 text-center">Status</th>
                    <th class="px-4 py-3 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($testimonials as $t)
                    <tr class="hover:bg-gray-50 transition">
                        {{-- Avatar + Nama --}}
                        <td class="px-4 py-3">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-full flex items-center justify-center text-white font-bold text-xs shrink-0"
                                     style="background: linear-gradient(135deg, #02A6E0 0%, #213F9A 100%)">
                                    {{ strtoupper(collect(explode(' ', $t->name))->map(fn($w) => $w[0])->take(2)->join('')) }}
                                </div>
                                <span class="font-medium text-gray-800">{{ $t->name }}</span>
                            </div>
                        </td>
                        {{-- Role badge --}}
                        <td class="px-4 py-3">
                            @php
                                $roleClass = match($t->role) {
                                    'Donatur'          => 'bg-[#02A6E0]/10 text-[#02A6E0]',
                                    'Penerima Manfaat' => 'bg-[#213F9A]/10 text-[#213F9A]',
                                    'Mitra'            => 'text-white',
                                    default            => 'bg-gray-100 text-gray-500',
                                };
                                $roleStyle = $t->role === 'Mitra'
                                    ? 'background: linear-gradient(135deg, #02A6E0 0%, #213F9A 100%);'
                                    : '';
                            @endphp
                            <span class="inline-flex items-center text-[10px] font-bold uppercase tracking-wider px-2.5 py-1 rounded-full {{ $roleClass }}"
                                  style="{{ $roleStyle }}">
                                {{ $t->role }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-gray-500">{{ $t->location }}</td>
                        <td class="px-4 py-3 text-gray-600 max-w-xs truncate">{{ $t->quote }}</td>
                        <td class="px-4 py-3 text-center text-gray-700">{{ $t->order }}</td>
                        <td class="px-4 py-3 text-center">
                            @if($t->is_active)
                                <span class="inline-block px-2.5 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-700">Aktif</span>
                            @else
                                <span class="inline-block px-2.5 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-500">Nonaktif</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-center">
                            <div class="flex items-center justify-center gap-3">
                                <button onclick="openModal({{ $t->id }}, '{{ addslashes($t->name) }}', '{{ addslashes($t->role) }}', '{{ addslashes($t->location) }}', {{ $t->order }}, {{ $t->is_active ? 'true' : 'false' }}, '{{ addslashes($t->quote) }}')"
                                        class="text-xs font-semibold text-[#02A6E0] hover:underline">
                                    Edit
                                </button>
                                <form action="{{ route('admin.markom.testimonial.destroy', $t) }}" method="POST"
                                      onsubmit="return confirm('Hapus testimoni ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-xs font-semibold text-red-500 hover:underline">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-4 py-12 text-center text-gray-400 text-sm">
                            Belum ada testimoni. Klik "+ Tambah Testimoni" untuk memulai.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Modal --}}
    <div id="modal-overlay"
         class="fixed inset-0 bg-black/50 z-50 items-center justify-center hidden"
         onclick="if(event.target===this) closeModal()">

        <div class="bg-white rounded-2xl shadow-xl w-full max-w-lg mx-4 max-h-[90vh] overflow-y-auto">

            {{-- Modal Header --}}
            <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100 sticky top-0 bg-white rounded-t-2xl">
                <h3 id="modal-title" class="text-base font-semibold text-gray-800">Tambah Testimoni</h3>
                <button onclick="closeModal()" class="text-gray-400 hover:text-gray-600 text-xl leading-none">&times;</button>
            </div>

            {{-- Form --}}
            <form id="testimonial-form"
                  action="{{ route('admin.markom.testimonial.store') }}"
                  method="POST"
                  class="px-6 py-5 space-y-4">
                @csrf
                <input type="hidden" name="_method" id="form-method" value="POST">

                {{-- Nama --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama <span class="text-red-500">*</span></label>
                    <input type="text" name="name" id="input-name"
                           placeholder="cth: Andini Pratama"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#02A6E0]/40 focus:border-[#02A6E0]"
                           required>
                </div>

                {{-- Role --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Role <span class="text-red-500">*</span></label>
                    <select name="role" id="input-role"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#02A6E0]/40 focus:border-[#02A6E0]"
                            required>
                        <option value="Donatur">Donatur</option>
                        <option value="Penerima Manfaat">Penerima Manfaat</option>
                        <option value="Mitra">Mitra</option>
                    </select>
                </div>

                {{-- Lokasi --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Lokasi <span class="text-red-500">*</span></label>
                    <input type="text" name="location" id="input-location"
                           placeholder="cth: Jakarta"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#02A6E0]/40 focus:border-[#02A6E0]"
                           required>
                </div>

                {{-- Kutipan --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Kutipan <span class="text-red-500">*</span></label>
                    <textarea name="quote" id="input-quote" rows="4"
                              placeholder="cth: Laporannya jelas dan saya bisa memilih program..."
                              class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#02A6E0]/40 focus:border-[#02A6E0] resize-none"
                              required></textarea>
                    <p class="text-xs text-gray-400 mt-1">Maksimal 500 karakter.</p>
                </div>

                {{-- Urutan --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Urutan</label>
                    <input type="number" name="order" id="input-order" min="0"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#02A6E0]/40 focus:border-[#02A6E0]"
                           value="0">
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
        const storeUrl   = "{{ route('admin.markom.testimonial.store') }}";
        const updateBase = "{{ url('admin/markom/testimonial') }}";

        function openModal(id = null, name = '', role = 'Donatur', location = '', order = 0, isActive = true, quote = '') {
            const modal = document.getElementById('modal-overlay');
            const form  = document.getElementById('testimonial-form');

            if (id) {
                document.getElementById('modal-title').textContent = 'Edit Testimoni';
                form.action = updateBase + '/' + id;
                document.getElementById('form-method').value = 'PUT';
            } else {
                document.getElementById('modal-title').textContent = 'Tambah Testimoni';
                form.action = storeUrl;
                document.getElementById('form-method').value = 'POST';
            }

            document.getElementById('input-name').value     = name;
            document.getElementById('input-role').value     = role;
            document.getElementById('input-location').value = location;
            document.getElementById('input-order').value    = order;
            document.getElementById('input-status').value   = isActive ? '1' : '0';
            document.getElementById('input-quote').value    = quote;

            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closeModal() {
            const modal = document.getElementById('modal-overlay');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }

        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') closeModal();
        });
    </script>

@endsection
