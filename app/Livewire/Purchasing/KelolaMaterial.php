<?php

namespace App\Livewire\Purchasing;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Material;
use Illuminate\Support\Facades\Auth;

class KelolaMaterial extends Component
{
    use WithPagination;

    // Reset pagination ketika melakukan pencarian
    protected $updatesQueryString = ['search'];
    
    public $search = '';
    public $isFormOpen = false; // Toggle buat buka/tutup form
    
    // State Model
    public $material_id, $nama_barang, $satuan, $harga, $supplier, $deskripsi;

    public function updatingSearch()
    {
        $this->resetPage();
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

        $materials = $query->paginate(10);

        return view('livewire.purchasing.kelola-material', compact('materials'))
            ->layout('components.layouts.app');
    }

    public function buatBaru()
    {
        $this->resetInputFields();
        $this->isFormOpen = true;
    }

    public function resetInputFields()
    {
        $this->material_id = null;
        $this->nama_barang = '';
        $this->satuan = '';
        $this->harga = '';
        $this->supplier = '';
        $this->deskripsi = '';
    }

    public function tutupForm()
    {
        $this->isFormOpen = false;
        $this->resetInputFields();
    }

    public function simpan()
{
    $this->validate([
        'nama_barang' => 'required|string|max:255',
        'satuan' => 'required|string|max:50',
        'harga' => 'required|numeric|min:0',
    ]);

    Material::updateOrCreate(['id' => $this->material_id], [
        'nama_barang' => $this->nama_barang,
        'satuan' => $this->satuan,
        'harga' => $this->harga,
        'supplier' => $this->supplier,
        'deskripsi' => $this->deskripsi,
        'id_user' => Auth::id()
    ]);

    // Notifikasi ke Engineering
    $engineers = \App\Models\User::where('role', 'engineering')->get();
    foreach ($engineers as $eng) {
        \App\Models\Notification::create([
            'id_user' => $eng->id,
            'judul' => 'Material Baru Tersedia',
            'pesan' => "Purchasing menambahkan material: {$this->nama_barang}. Cek katalog untuk RAB.",
            'url_tujuan' => '/engineering/rab',
            'is_read' => false
        ]);
    }

    session()->flash('sukses', 'Material berhasil disimpan & notifikasi terkirim.');
    $this->tutupForm();
}
    public function edit($id)
    {
        $material = Material::findOrFail($id);
        $this->material_id = $id;
        $this->nama_barang = $material->nama_barang;
        $this->satuan = $material->satuan;
        $this->harga = $material->harga;
        $this->supplier = $material->supplier;
        $this->deskripsi = $material->deskripsi;
        
        $this->isFormOpen = true;
    }

    public function hapus($id)
    {
        $material = Material::findOrFail($id);
        
        // Cek dulu apakah material ini udah dipakai di RABItem
        // Kalau udah dipakai, lu nggak boleh asal hapus! Ntar relasinya error.
        if ($material->rabItems()->count() > 0) {
            session()->flash('error', 'Gagal! Material ini sedang digunakan dalam dokumen RAB.');
            return;
        }

        $material->delete();
        session()->flash('sukses', 'Material berhasil dimusnahkan dari katalog.');
    }
}
