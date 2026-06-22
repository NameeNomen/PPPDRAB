<?php

namespace App\Livewire\Purchasing;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Material;
use App\Models\MaterialRequest;

class MaterialIndex extends Component
{
    use WithPagination;

    protected $updatesQueryString = ['search'];
    public $search = '';
    public $activeTab = 'material'; // 'material' atau 'request'

    public function switchTab($tab)
    {
        $this->activeTab = $tab;
        $this->search = '';
        $this->resetPage();
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function hapus($id)
    {
        $material = Material::findOrFail($id);

        // Cek apakah material sedang digunakan di RAB
        if ($material->rabItems()->count() > 0) {
            session()->flash('error', 'Gagal! Material ini sedang digunakan dalam dokumen RAB dan tidak dapat dihapus.');
            return;
        }

        $material->delete();
        session()->flash('sukses', 'Material "' . $material->nama_barang . '" berhasil dihapus dari katalog.');
    }

    public function render()
    {
        // Query Material Master
        $materialsQuery = Material::orderBy('updated_at', 'desc');

        if (!empty($this->search) && $this->activeTab === 'material') {
            $materialsQuery->where(function($q) {
                $q->where('nama_barang', 'like', '%' . $this->search . '%')
                  ->orWhere('supplier', 'like', '%' . $this->search . '%')
                  ->orWhere('deskripsi', 'like', '%' . $this->search . '%');
            });
        }

        // Query Material Request
        $requestsQuery = MaterialRequest::with('project', 'requester')
            ->orderBy('created_at', 'desc');

        if (!empty($this->search) && $this->activeTab === 'request') {
            $requestsQuery->where(function($q) {
                $q->where('nama_material', 'like', '%' . $this->search . '%')
                  ->orWhere('deskripsi', 'like', '%' . $this->search . '%');
            });
        }

        return view('livewire.purchasing.material-index', [
            'materials' => $materialsQuery->paginate(10),
            'requests' => $requestsQuery->paginate(10)
        ])->layout('components.layouts.app');
    }
}