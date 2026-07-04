@if ($paginator->hasPages())
    <div class="flex flex-col sm:flex-row items-center justify-between gap-4 px-2 py-1">
        {{-- Info Jumlah Data --}}
        <div class="text-xs text-slate-400 font-medium">
            Menampilkan <span class="font-bold text-slate-700">{{ $paginator->firstItem() ?? 0 }}</span>
            ke <span class="font-bold text-slate-700">{{ $paginator->lastItem() ?? 0 }}</span>
            dari <span class="font-bold text-slate-700">{{ $paginator->total() }}</span> data
        </div>

        {{-- Navigation Bar Container --}}
        <div class="inline-flex items-center bg-white border border-slate-200/90 rounded-2xl shadow-sm overflow-hidden text-sm divide-x divide-slate-100">
            {{-- Tombol Previous (<) --}}
            @if ($paginator->onFirstPage())
                <span class="px-3 py-2 text-slate-300 cursor-not-allowed flex items-center justify-center">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                </span>
            @else
                <button type="button" wire:click="previousPage" 
                        class="px-3 py-2 text-slate-400 hover:text-slate-600 hover:bg-slate-50 transition-colors flex items-center justify-center">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                </button>
            @endif

            {{-- Angka Halaman --}}
            @foreach ($elements as $element)
                {{-- String "Three Dots" Separator --}}
                @if (is_string($element))
                    <span class="px-3 py-2 text-xs text-slate-400 font-medium flex items-center justify-center">{{ $element }}</span>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <span class="px-4 py-2 font-bold text-blue-600 bg-blue-50/80 flex items-center justify-center">
                                {{ $page }}
                            </span>
                        @else
                            <button type="button" wire:click="gotoPage({{ $page }})" 
                                    class="px-4 py-2 font-medium text-slate-600 hover:text-slate-900 hover:bg-slate-50 transition-colors flex items-center justify-center">
                                {{ $page }}
                            </button>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Tombol Next (>) --}}
            @if ($paginator->hasMorePages())
                <button type="button" wire:click="nextPage" 
                        class="px-3 py-2 text-slate-400 hover:text-slate-600 hover:bg-slate-50 transition-colors flex items-center justify-center">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </button>
            @else
                <span class="px-3 py-2 text-slate-300 cursor-not-allowed flex items-center justify-center">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </span>
            @endif
        </div>
    </div>
@endif
