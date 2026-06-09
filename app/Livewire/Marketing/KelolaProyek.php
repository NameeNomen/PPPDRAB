<?php

namespace App\Livewire\Marketing;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\RProject;
use App\Models\RProjectItem;
use App\Models\RProjectItemMaterial;
use App\Models\ProjectAttachment;
use App\Models\ProjectCategory;
use App\Models\Material;
use App\Models\MaterialRequest;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class KelolaProyek extends Component
{
    use WithFileUploads;

    public $daftarProyek;
    public $isModalOpen = false;
    public $isDetailModalOpen = false;
    public $isRequestMaterialModalOpen = false;
   
    // Variabel Deteksi Mode Edit
    public $isEdit = false;
    public $proyek_id;

    // Data Master untuk Dropdown & Pilihan[cite: 1]
    public $listKategori = [], $listPT = [], $listPIC = [], $listLokasi = [], $listMasterMaterial = [];

    // Form Input Proyek Utama[cite: 1, 2]
    public $category_id;
    public $nama_pelanggan, $pic_pelanggan, $no_hp, $target_waktu, $estimasi_budget, $alamat, $deskripsi_proyek;
    public $priority = 'medium';
    public $latitude = -6.200000; // Default Koordinat Indonesia
    public $longitude = 106.816666;
    public $lampiran = [];

    // Form Rincian Kebutuhan Klien (Array Dinamis Item)
    public $items = [];

    // Form Input Pengajuan Material Baru (Jika tidak ada di master)[cite: 2]
    public $req_nama_material, $req_deskripsi, $req_satuan;

    // Penampung Data Detail[cite: 1]
    public $detail_id, $detail_request_no, $detail_kategori, $detail_nama_pelanggan, $detail_pic_pelanggan, $detail_no_hp;
    public $detail_target_waktu, $detail_estimasi_budget, $detail_alamat, $detail_deskripsi_proyek, $detail_priority, $detail_status;
    public $detail_latitude, $detail_longitude;
    public $detail_lampiran = [];
    public $detail_items = [];

    protected $listeners = ['setKoordinat' => 'handleKoordinatUpdate'];

    public function mount()
    {
        $this->loadData();
        if (request()->has('create_from_proyek')) {
            $proyekId = request()->query('create_from_proyek');
            $this->editProyek($proyekId);
        }
    }

    public function loadData()
    {
        $this->daftarProyek = RProject::with(['attachments', 'category', 'items'])
                                ->where('status_proyek', '!=', 'lost')
                                ->orderBy('created_at', 'desc')
                                ->get();
       
        // Ambil Data Master Real (Bukan Dummy)[cite: 1]
        $this->listKategori = ProjectCategory::orderBy('nama_kategori', 'asc')->get();
        $this->listMasterMaterial = Material::orderBy('nama_barang', 'asc')->get();

        $this->listPT = RProject::select('nama_pelanggan')->distinct()->pluck('nama_pelanggan')->toArray();
        $this->listPIC = RProject::select('pic_pelanggan')->distinct()->pluck('pic_pelanggan')->toArray();
        $this->listLokasi = RProject::select('alamat')->distinct()->pluck('alamat')->toArray();
    }

    public function handleKoordinatUpdate($lat, $lng)
    {
        $this->latitude = $lat;
        $this->longitude = $lng;
    }

    public function bukaModal()
    {
        $this->resetInput();
        $this->isEdit = false;
        $this->isModalOpen = true;
        
        // Pemicu peta agar merender ulang koordinat default
        $this->dispatch('initMap', lat: $this->latitude, lng: $this->longitude);
    }

    public function tutupModal()
    {
        $this->isModalOpen = false;
        $this->resetInput();
    }

    public function resetInput()
    {
        $this->reset([
            'proyek_id', 'isEdit', 'category_id', 'nama_pelanggan', 'pic_pelanggan', 'no_hp', 
            'target_waktu', 'estimasi_budget', 'alamat', 'deskripsi_proyek', 'lampiran', 'items'
        ]);
        $this->priority = 'medium';
        $this->latitude = -6.200000;
        $this->longitude = 106.816666;
        
        // Siapkan satu baris kosong pertama untuk form item[cite: 1]
        $this->items = [
            [
                'nama_item' => '',
                'spesifikasi_klien' => '',
                'qty' => 1,
                'satuan' => 'Unit',
                'material_id' => ''
            ]
        ];
    }

    // Fungsi Array Dinamis untuk Baris Kebutuhan Klien[cite: 1]
    public function addItemRow()
    {
        $this->items[] = [
            'nama_item' => '',
            'spesifikasi_klien' => '',
            'qty' => 1,
            'satuan' => 'Unit',
            'material_id' => ''
        ];
    }

    public function removeItemRow($index)
    {
        unset($this->items[$index]);
        $this->items = array_values($this->items);
    }

    // Buka Modal Pengajuan Material Baru
    public function bukaRequestMaterialModal()
    {
        $this->reset(['req_nama_material', 'req_deskripsi', 'req_satuan']);
        $this->isRequestMaterialModalOpen = true;
    }

    public function simpanRequestMaterial()
    {
        $this->validate([
            'req_nama_material' => 'required|string|max:255',
            'req_deskripsi' => 'required|string',
            'req_satuan' => 'required|string|max:50',
        ]);

        // Simpan ke antrean material request (Menunggu verifikasi purchasing)[cite: 2]
        MaterialRequest::create([
            'nama_material' => $this->req_nama_material,
            'deskripsi' => $this->req_deskripsi,
            'satuan' => $this->req_satuan,
            'status' => 'pending',
            'catatan_purchasing' => null,
            'requested_by' => Auth::id()
        ]);

        $this->isRequestMaterialModalOpen = false;
        $this->loadData(); // Muat ulang data master komponen
        session()->flash('sukses_material', 'Permintaan material baru berhasil dikirim ke Purchasing!');
    }

    public function simpanProyek()
    {
        $this->validate([
            'category_id' => 'required',
            'nama_pelanggan' => 'required',
            'pic_pelanggan' => 'required',
            'no_hp' => 'required',
            'target_waktu' => 'required|date',
            'estimasi_budget' => 'required|numeric|min:1000',
            'alamat' => 'required',
            'deskripsi_proyek' => 'required',
            'priority' => 'required|in:low,medium,high',
            'latitude' => 'required',
            'longitude' => 'required',
            'lampiran.*' => 'nullable|file|max:5120',
            'items.*.nama_item' => 'required|string|max:255',
            'items.*.qty' => 'required|numeric|min:1',
            'items.*.satuan' => 'required|string',
        ]);

        $tahunBulan = date('Y/m');
        $hitungProyekBulanIni = RProject::whereYear('created_at', date('Y'))->whereMonth('created_at', date('m'))->count();
        $nomorUrut = str_pad($hitungProyekBulanIni + 1, 4, '0', STR_PAD_LEFT);
        $requestNo = 'REQ/TJT/' . $tahunBulan . '/' . $nomorUrut;

        // 1. Simpan Header Orderan Besar[cite: 1]
        $proyek = RProject::create([
            'request_no' => $requestNo,
            'id_user' => Auth::id(),
            'category_id' => $this->category_id,
            'nama_pelanggan' => $this->nama_pelanggan,
            'pic_pelanggan' => $this->pic_pelanggan,
            'no_hp' => $this->no_hp,
            'deskripsi_proyek' => $this->deskripsi_proyek,
            'target_waktu' => $this->target_waktu,
            'estimasi_budget' => $this->estimasi_budget,
            'alamat' => $this->alamat,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'priority' => $this->priority,
            'status_proyek' => 'waiting_rab'
        ]);

        // 2. Simpan Rincian Item (Penerjemahan Bahasa Klien)[cite: 2]
        foreach ($this->items as $itemData) {
            $item = RProjectItem::create([
                'r_project_id' => $proyek->id,
                'nama_item' => $itemData['nama_item'],
                'qty' => $itemData['qty'],
                'satuan' => $itemData['satuan'],
                'spesifikasi_klien' => $itemData['spesifikasi_klien'],
                'is_calculated' => !empty($itemData['material_id']) ? true : false,
            ]);

            // Jika dipasangkan langsung dengan Master Material, catat hubungan awalnya[cite: 2]
            if (!empty($itemData['material_id'])) {
                RProjectItemMaterial::create([
                    'project_item_id' => $item->id,
                    'material_id' => $itemData['material_id'],
                    'qty' => $itemData['qty'],
                    'satuan' => $itemData['satuan'],
                    'status_kesesuaian' => 'sesuai',
                    'catatan_engineering' => 'Ditempelkan langsung dari modul pencatatan Marketing'
                ]);
            }
        }

        // 3. Simpan Lampiran Dokumen Lapangan
        if (!empty($this->lampiran)) {
            foreach ($this->lampiran as $file) {
                ProjectAttachment::create([
                    'r_project_id' => $proyek->id,
                    'file_name' => $file->getClientOriginalName(),
                    'file_path' => $file->store('dokumen_proyek', 'public'),
                    'file_type' => $file->extension()
                ]);
            }
        }

        session()->flash('sukses', 'Proyek berhasil diinisiasi dengan No: ' . $requestNo);
        $this->tutupModal();
        $this->loadData();
    }

    public function editProyek($id)
    {
        $proyek = RProject::with(['category', 'items'])->findOrFail($id);
       
        $this->proyek_id = $proyek->id;
        $this->category_id = $proyek->category_id;
        $this->priority = $proyek->priority;
        $this->nama_pelanggan = $proyek->nama_pelanggan;
        $this->pic_pelanggan = $proyek->pic_pelanggan;
        $this->no_hp = $proyek->no_hp;
        $this->target_waktu = $proyek->target_waktu;
        $this->estimasi_budget = $proyek->estimasi_budget;
        $this->alamat = $proyek->alamat;
        $this->latitude = $proyek->latitude ?? -6.200000;
        $this->longitude = $proyek->longitude ?? 106.816666;
        $this->deskripsi_proyek = $proyek->deskripsi_proyek;

        // Muat item relasi ke dalam form state array[cite: 1]
        $this->items = [];
        foreach ($proyek->items as $dbItem) {
            // Ambil relasi material jika sudah dipasangkan sebelumnya[cite: 2]
            $pivot = RProjectItemMaterial::where('project_item_id', $dbItem->id)->first();
            
            $this->items[] = [
                'nama_item' => $dbItem->nama_item,
                'spesifikasi_klien' => $dbItem->spesifikasi_klien,
                'qty' => $dbItem->qty,
                'satuan' => $dbItem->satuan,
                'material_id' => $pivot ? $pivot->material_id : ''
            ];
        }

        if (empty($this->items)) {
            $this->items[] = ['nama_item' => '', 'spesifikasi_klien' => '', 'qty' => 1, 'satuan' => 'Unit', 'material_id' => ''];
        }

        $this->isEdit = true;
        $this->isModalOpen = true;
        $this->isDetailModalOpen = false;

        $this->dispatch('initMap', lat: $this->latitude, lng: $this->longitude);
    }

    public function updateProyek()
    {
        $this->validate([
            'category_id' => 'required',
            'nama_pelanggan' => 'required',
            'pic_pelanggan' => 'required',
            'no_hp' => 'required',
            'target_waktu' => 'required|date',
            'estimasi_budget' => 'required|numeric|min:1000',
            'alamat' => 'required',
            'deskripsi_proyek' => 'required',
            'priority' => 'required|in:low,medium,high',
            'latitude' => 'required',
            'longitude' => 'required',
        ]);

        $proyek = RProject::findOrFail($this->proyek_id);
        $proyek->update([
            'category_id' => $this->category_id,
            'nama_pelanggan' => $this->nama_pelanggan,
            'pic_pelanggan' => $this->pic_pelanggan,
            'no_hp' => $this->no_hp,
            'deskripsi_proyek' => $this->deskripsi_proyek,
            'target_waktu' => $this->target_waktu,
            'estimasi_budget' => $this->estimasi_budget,
            'alamat' => $this->alamat,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'priority' => $this->priority,
        ]);

        // Sinkronisasi ulang data item lama
        foreach ($proyek->items as $oldItem) {
            RProjectItemMaterial::where('project_item_id', $oldItem->id)->delete();
            $oldItem->delete();
        }

        foreach ($this->items as $itemData) {
            $item = RProjectItem::create([
                'r_project_id' => $proyek->id,
                'nama_item' => $itemData['nama_item'],
                'qty' => $itemData['qty'],
                'satuan' => $itemData['satuan'],
                'spesifikasi_klien' => $itemData['spesifikasi_klien'],
                'is_calculated' => !empty($itemData['material_id']) ? true : false,
            ]);

            if (!empty($itemData['material_id'])) {
                RProjectItemMaterial::create([
                    'project_item_id' => $item->id,
                    'material_id' => $itemData['material_id'],
                    'qty' => $itemData['qty'],
                    'satuan' => $itemData['satuan'],
                    'status_kesesuaian' => 'sesuai',
                    'catatan_engineering' => 'Diperbarui melalui panel edit data Marketing'
                ]);
            }
        }

        if (!empty($this->lampiran)) {
            foreach ($this->lampiran as $file) {
                ProjectAttachment::create([
                    'r_project_id' => $proyek->id,
                    'file_name' => $file->getClientOriginalName(),
                    'file_path' => $file->store('dokumen_proyek', 'public'),
                    'file_type' => $file->extension()
                ]);
            }
        }

        session()->flash('sukses', 'Data proyek ' . $proyek->request_no . ' berhasil diperbarui!');
        $this->tutupModal();
        $this->loadData();
    }

    public function lihatDetail($id)
    {
        $proyek = RProject::with(['attachments', 'category', 'items'])->findOrFail($id);
       
        $this->detail_id = $proyek->id;
        $this->detail_request_no = $proyek->request_no;
        $this->detail_kategori = $proyek->category ? $proyek->category->nama_kategori : '-';
        $this->detail_nama_pelanggan = $proyek->nama_pelanggan;
        $this->detail_pic_pelanggan = $proyek->pic_pelanggan;
        $this->detail_no_hp = $proyek->no_hp;
        $this->detail_target_waktu = $proyek->target_waktu;
        $this->detail_estimasi_budget = $proyek->estimasi_budget;
        $this->detail_alamat = $proyek->alamat;
        $this->detail_latitude = $proyek->latitude;
        $this->detail_longitude = $proyek->longitude;
        $this->detail_deskripsi_proyek = $proyek->deskripsi_proyek;
        $this->detail_priority = $proyek->priority;
        $this->detail_status = $proyek->status_proyek;
        $this->detail_lampiran = $proyek->attachments;
        
        // Ambil data item beserta informasi material hasil pencarian/pencocokan[cite: 2]
        $this->detail_items = [];
        foreach ($proyek->items as $itm) {
            $pivot = RProjectItemMaterial::with('material')->where('project_item_id', $itm->id)->first();
            $this->detail_items[] = [
                'nama_item' => $itm->nama_item,
                'spesifikasi_klien' => $itm->spesifikasi_klien,
                'qty' => $itm->qty,
                'satuan' => $itm->satuan,
                'material_terpilih' => $pivot && $pivot->material ? $pivot->material->nama_barang . ' (' . $pivot->material->satuan . ')' : 'Belum Dijodohkan / Pakai Request Khusus'
            ];
        }

        $this->isDetailModalOpen = true;
        $this->dispatch('initDetailMap', lat: $this->detail_latitude, lng: $this->detail_longitude);
    }

    public function tutupDetailModal()
    {
        $this->isDetailModalOpen = false;
    }

    public function hapusProyek($id)
    {
        $items = RProjectItem::where('r_project_id', $id)->get();
        foreach ($items as $itm) {
            RProjectItemMaterial::where('project_item_id', $itm->id)->delete();
            $itm->delete();
        }
        RProject::find($id)->delete();
        session()->flash('sukses', 'Data proyek berhasil dihapus dari sistem!');
        $this->loadData();
        $this->isDetailModalOpen = false;
    }
   
    public function render()
    {
        return view('livewire.marketing.kelola-proyek')
            ->layout('components.layouts.app');
    }
}