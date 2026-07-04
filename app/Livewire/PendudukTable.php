<?php

namespace App\Livewire;

use App\Models\Penduduk;
use Livewire\Component;
use Livewire\WithPagination;

class PendudukTable extends Component
{
    use WithPagination;

    public string $search = '';

    protected $paginationTheme = 'tailwind';

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function clearSearch(): void
    {
        $this->search = '';
        $this->resetPage();
    }

    public function deletePenduduk(int $id): void
    {
        $penduduk = Penduduk::find($id);
        if ($penduduk) {
            $penduduk->delete();
            session()->flash('success', 'Data penduduk berhasil dihapus.');
        }
    }

    public function render()
    {
        $penduduk = Penduduk::when($this->search, function ($q) {
                $search = trim($this->search);
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('nik', 'like', "%{$search}%")
                  ->orWhere('desa', 'like', "%{$search}%")
                  ->orWhere('kecamatan', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(10);

        return view('livewire.penduduk-table', [
            'penduduk' => $penduduk,
        ]);
    }
}
