<?php
namespace App\Livewire\Purchasing;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Material;

class MaterialIndex extends Component
{
    use WithPagination;

    protected $updatesQueryString = ['search'];
    public $search = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function hapus($id)
    {
        $material = Material::findOrFail($id);

        if ($material->rabItems()->count() > 0) {
            session()->flash('error', 'Gagal! Material ini sedang digunakan dalam dokumen RAB.');
            return;
        }

        $material->delete();
        session()->flash('sukses', 'Material berhasil dihapus.');
    }

    public function render()
    {
        $query = Material::orderBy('updated_at', 'desc');

        if (!empty($this->search)) {
            $query->where(function($q) {
                $q->where('nama_barang', 'like', '%' . $this->search . '%')
                  ->orWhere('supplier', 'like', '%' . $this->search . '%');
            });
        }

        return view('livewire.purchasing.material-index', [
            'materials' => $query->paginate(10)
        ])->layout('components.layouts.app');
    }
}