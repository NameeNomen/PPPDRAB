<?php
namespace App\Livewire\Purchasing;

use Livewire\Component;
use App\Models\Material;
use Illuminate\Support\Facades\Auth;

class MaterialForm extends Component
{
    public $material_id, $nama_barang, $satuan, $harga, $supplier, $deskripsi;

    public function mount($id = null)
    {
        if ($id) {
            $material = Material::findOrFail($id);
            $this->material_id = $id;
            $this->nama_barang = $material->nama_barang;
            $this->satuan = $material->satuan;
            $this->harga = $material->harga;
            $this->supplier = $material->supplier;
            $this->deskripsi = $material->deskripsi;
        }
    }

    public function simpan()
    {
        $this->validate([
            'nama_barang' => 'required|string|max:255',
            'satuan'      => 'required|string|max:50',
            'harga'       => 'required|numeric|min:0',
        ]);

        Material::updateOrCreate(['id' => $this->material_id], [
            'nama_barang' => $this->nama_barang,
            'satuan'      => $this->satuan,
            'harga'       => $this->harga,
            'supplier'    => $this->supplier,
            'deskripsi'   => $this->deskripsi,
            'id_user'     => Auth::id()
        ]);

        session()->flash('sukses', 'Material berhasil disimpan!');
        return redirect()->route('material.index'); // Kembali ke index setelah simpan
    }

    public function render()
    {
        return view('livewire.purchasing.material-form')->layout('components.layouts.app');
    }
}