<?php
namespace App\Livewire\Purchasing;

use Livewire\Component;
use App\Models\Material;
use App\Models\MaterialRequest;
use App\Models\Supplier;
use Illuminate\Support\Facades\Auth;

class MaterialForm extends Component
{
    // 1. Properti Material
    public $material_id, $nama_barang, $satuan, $jumlah, $deskripsi;
    
    // 2. Properti Pivot
    public $harga, $lead_time_hari = 0;
    
    // 3. Properti Supplier
    public $searchSupplier = '';
    public $supplier_id = null;
    public $supplierResults = [];
    public $telepon, $pic, $alamat; // Tambahan buat form supplier baru yang disembunyikan

    public function mount($id = null)
    {
        if ($id) {
            $material = Material::findOrFail($id);
            $this->material_id = $id;
            $this->nama_barang = $material->nama_barang;
            $this->satuan      = $material->satuan;
            $this->jumlah      = $material->jumlah;
            $this->deskripsi   = $material->deskripsi;
            $this->harga       = $material->harga; 
        } else {
            $this->jumlah = 0; 
            
            $requestId = request()->query('request_id');
            if ($requestId) {
                $req = MaterialRequest::find($requestId);
                if ($req) {
                    $this->nama_barang = $req->nama_material;
                    $this->satuan      = $req->satuan;
                    $this->jumlah      = (int) $req->estimasi_kebutuhan;
                    $this->deskripsi   = $req->deskripsi;
                }
            }
        }
    }

    public function updatedSearchSupplier()
    {
        $this->supplier_id = null; // Reset ID, berarti user mau masukin data baru
        
        if (strlen($this->searchSupplier) >= 2) {
            $this->supplierResults = Supplier::where('nama_supplier', 'like', '%' . $this->searchSupplier . '%')
                                           ->take(5)->get()->toArray();
        } else {
            $this->supplierResults = [];
        }
    }

    public function pilihSupplier($id, $nama)
    {
        $this->supplier_id = $id;
        $this->searchSupplier = $nama;
        $this->supplierResults = []; 
        
        // Kosongkan form tambahan karena supplier udah ada di database
        $this->telepon = '';
        $this->pic = '';
        $this->alamat = '';
    }

    public function simpan()
    {
        $this->validate([
            'nama_barang'    => 'required|string|max:255',
            'satuan'         => 'required|string|max:50',
            'jumlah'         => 'required|integer|min:1',
            'harga'          => 'required|numeric|min:1',
            'searchSupplier' => 'required|string|max:255',
            'lead_time_hari' => 'required|integer|min:0',
            'telepon'        => 'nullable|string',
            'pic'            => 'nullable|string',
            'alamat'         => 'nullable|string',
            'deskripsi'      => 'nullable|string',
        ]);

        $material = Material::updateOrCreate(['id' => $this->material_id], [
            'nama_barang' => $this->nama_barang,
            'satuan'      => $this->satuan,
            'jumlah'      => $this->jumlah,
            'harga'       => $this->harga,
            'deskripsi'   => $this->deskripsi,
            'id_user'     => Auth::id()
        ]);

        $idSupplierFix = $this->supplier_id;
        
        if (!$idSupplierFix) {
            // Ciptakan supplier baru lengkap dengan data kontaknya
            $supplierBaru = Supplier::create([
                'nama_supplier' => $this->searchSupplier,
                'telepon'       => $this->telepon,
                'pic'           => $this->pic,
                'alamat'        => $this->alamat,
                'is_active'     => true
            ]);
            $idSupplierFix = $supplierBaru->id;
        }

        $material->suppliers()->syncWithoutDetaching([
            $idSupplierFix => [
                'harga'          => $this->harga,
                'lead_time_hari' => $this->lead_time_hari,
            ]
        ]);

        session()->flash('sukses', 'Sistem berhasil menyimpan Material dan memetakan relasi Supplier.');
        return redirect()->route('purchasing.material-index');
    }

    public function render()
    {
        return view('livewire.purchasing.material-form')->layout('components.layouts.app');
    }
}