<div class="card p-0 overflow-hidden">
    {{-- Search Bar Section --}}
    <div class="p-4 border-b border-slate-100 flex items-center justify-between bg-slate-50">
        <div class="flex items-center gap-2">
            <div class="relative w-72 sm:w-80">
                <input type="text"
                       wire:model.live.debounce.300ms="search"
                       placeholder="Cari NIK, Nama, Dusun..."
                       class="form-input pl-9 pr-8 py-2 text-sm w-full transition-all duration-200 focus:ring-2 focus:ring-blue-500/20">
                
                {{-- Search Icon --}}
                <svg class="w-4 h-4 text-slate-400 absolute left-3 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>

                {{-- Clear Search Button (jika ada teks) --}}
                @if($search)
                    <button wire:click="clearSearch"
                            type="button" 
                            class="absolute right-3 top-2.5 text-slate-400 hover:text-slate-600 focus:outline-none transition-colors"
                            title="Bersihkan pencarian">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                @endif
            </div>

            {{-- Tombol Cari --}}
            <button type="button" 
                    wire:click="$refresh"
                    style="background-color: #2563eb; color: #ffffff; border: none; border-radius: 8px; padding: 8px 16px; font-size: 12px; font-weight: 700; cursor: pointer; display: flex; align-items: center; gap: 6px; box-shadow: 0 1px 2px rgba(0,0,0,0.05); transition: all 0.2s;"
                    onmouseover="this.style.backgroundColor='#1d4ed8'"
                    onmouseout="this.style.backgroundColor='#2563eb'">
                {{-- Spinner jika sedang loading --}}
                <svg wire:loading wire:target="search" class="animate-spin h-3.5 w-3.5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <svg wire:loading.remove wire:target="search" style="width: 14px; height: 14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                <span>Cari</span>
            </button>
        </div>
    </div>

    {{-- Table Section dengan Smooth Transition --}}
    <div class="overflow-x-auto relative transition-all duration-300" wire:loading.class="opacity-60" wire:target="search">
        <table class="data-table">
            <thead>
                <tr>
                    <th>NIK</th>
                    <th>Nama Lengkap</th>
                    <th>L/P</th>
                    <th>Usia</th>
                    <th>Desa / Kecamatan</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($penduduk as $p)
                <tr class="transition-colors duration-150 hover:bg-blue-50/40">
                    <td class="font-medium text-slate-800">{{ $p->nik }}</td>
                    <td class="font-semibold text-slate-800">{{ $p->nama }}</td>
                    <td class="text-slate-600">{{ substr($p->jenis_kelamin, 0, 1) }}</td>
                    <td class="text-slate-600">{{ $p->umur }} thn</td>
                    <td class="text-slate-600">{{ $p->desa }}, Kec. {{ $p->kecamatan }} (RT {{ $p->rt ?? '-' }}/RW {{ $p->rw ?? '-' }})</td>
                    <td>
                        <div class="flex items-center justify-center gap-2">
                            <a href="{{ route('admin.penduduk.edit', $p) }}" class="p-1.5 text-slate-400 hover:text-blue-600 bg-slate-100 hover:bg-blue-50 rounded-lg transition-colors" title="Edit">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                            </a>
                            <button wire:click="deletePenduduk({{ $p->id }})" 
                                    wire:confirm="Yakin ingin menghapus data penduduk {{ $p->nama }}?"
                                    type="button" 
                                    class="p-1.5 text-slate-400 hover:text-red-600 bg-slate-100 hover:bg-red-50 rounded-lg transition-colors" title="Hapus">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-12 text-slate-500">
                        @if($search)
                            Tidak ada data penduduk yang cocok dengan kata kunci "<span class="font-semibold text-slate-700">{{ $search }}</span>".
                        @else
                            Tidak ada data penduduk yang ditemukan.
                        @endif
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination Links Modern --}}
    <div class="p-4 border-t border-slate-100 bg-slate-50/50">
        {{ $penduduk->links('livewire.custom-pagination') }}
    </div>
</div>
