<?php

namespace App\Livewire\Marketing;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\RProject;
use App\Models\ProjectAttachment;
use App\Models\ProjectCategory;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class KelolaProyek extends Component
{
    use WithFileUploads;

    public $daftarProyek;
    public $isModalOpen = false;
    public $isDetailModalOpen = false;
    
    // Variabel Deteksi Mode Edit
    public $isEdit = false;
    public $proyek_id;

    // Data Master untuk Datalist Search
    public $listKategori = [], $listPT = [], $listPIC = [], $listLokasi = [];

    // Form Input
    public $nama_pelanggan, $pic_pelanggan, $no_hp, $target_waktu, $estimasi_budget, $alamat, $deskripsi_proyek;
    public $priority = 'medium';
    public $nama_kategori; // Penampung nama kategori (bukan ID, biar bisa diketik bebas)
    public $lampiran = []; 

    // Penampung Data Detail
    public $detail_id, $detail_request_no, $detail_kategori, $detail_nama_pelanggan, $detail_pic_pelanggan, $detail_no_hp;
    public $detail_target_waktu, $detail_estimasi_budget, $detail_alamat, $detail_deskripsi_proyek, $detail_priority, $detail_status;
    public $detail_lampiran = [];

     public function mount()
        {
            $this->daftarProyek = RProject::where('status_proyek', '!=', 'lost')->get();

            // TANGKAP LEMPARAN URL DARI HALAMAN PROYEK
            if (request()->has('create_from_proyek')) {
                $proyekId = request()->query('create_from_proyek');
                
                // Set input dropdown, tarik preview otomatis, dan buka modal form
                $this->id_r_project = $proyekId;
                $this->updatedIdRProject($proyekId); 
                $this->isModalOpen = true;
            }
        }

    public function loadData()
    {
        $this->daftarProyek = RProject::with(['attachments', 'category'])
                                ->orderBy('created_at', 'desc')
                                ->get();
        
        // Tarik data unik buat Datalist Autocomplete
        $this->listKategori = ProjectCategory::pluck('nama_kategori')->toArray();
        $this->listPT = RProject::select('nama_pelanggan')->distinct()->pluck('nama_pelanggan')->toArray();
        $this->listPIC = RProject::select('pic_pelanggan')->distinct()->pluck('pic_pelanggan')->toArray();
        $this->listLokasi = RProject::select('alamat')->distinct()->pluck('alamat')->toArray();
    }

    public function bukaModal()
    {
        $this->resetInput();
        $this->isEdit = false; // Pastiin balik ke mode Create
        $this->isModalOpen = true;
    }

    public function tutupModal()
    {
        $this->isModalOpen = false;
        $this->resetInput();
    }

    public function resetInput()
    {
        $this->reset(['proyek_id', 'isEdit', 'nama_pelanggan', 'pic_pelanggan', 'no_hp', 'target_waktu', 'estimasi_budget', 'alamat', 'deskripsi_proyek', 'nama_kategori', 'lampiran']);
        $this->priority = 'medium';
    }

    public function simpanProyek()
    {
        $this->validate([
            'nama_kategori' => 'required',
            'nama_pelanggan' => 'required',
            'pic_pelanggan' => 'required',
            'no_hp' => 'required',
            'target_waktu' => 'required|date',
            'estimasi_budget' => 'required|numeric|min:1000',
            'alamat' => 'required',
            'deskripsi_proyek' => 'required',
            'priority' => 'required|in:low,medium,high',
            'lampiran.*' => 'nullable|file|max:5120',
        ]);

        // LOGIKA AUTO-CREATE KATEGORI
        $kategori = ProjectCategory::firstOrCreate([
            'nama_kategori' => trim($this->nama_kategori)
        ]);
        

        $tahunBulan = date('Y/m');
        $hitungProyekBulanIni = RProject::whereYear('created_at', date('Y'))->whereMonth('created_at', date('m'))->count();
        $nomorUrut = str_pad($hitungProyekBulanIni + 1, 4, '0', STR_PAD_LEFT);
        $requestNo = 'REQ/TJT/' . $tahunBulan . '/' . $nomorUrut;

        $proyek = RProject::create([
            'request_no' => $requestNo,
            'id_user' => Auth::id(),
            'category_id' => $kategori->id,
            'nama_pelanggan' => $this->nama_pelanggan,
            'pic_pelanggan' => $this->pic_pelanggan,
            'no_hp' => $this->no_hp,
            'deskripsi_proyek' => $this->deskripsi_proyek,
            'target_waktu' => $this->target_waktu,
            'estimasi_budget' => $this->estimasi_budget,
            'alamat' => $this->alamat,
            'priority' => $this->priority,
            'status_proyek' => 'waiting_rab'
        ]);

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
        // Tarik data dari database
        $proyek = RProject::with('category')->findOrFail($id);
        
        // Isi variabel form dengan data lama
        $this->proyek_id = $proyek->id;
        $this->nama_kategori = $proyek->category ? $proyek->category->nama_kategori : '';
        $this->priority = $proyek->priority;
        $this->nama_pelanggan = $proyek->nama_pelanggan;
        $this->pic_pelanggan = $proyek->pic_pelanggan;
        $this->no_hp = $proyek->no_hp;
        $this->target_waktu = $proyek->target_waktu;
        $this->estimasi_budget = $proyek->estimasi_budget;
        $this->alamat = $proyek->alamat;
        $this->deskripsi_proyek = $proyek->deskripsi_proyek;

        // Buka modal dengan status Edit
        $this->isEdit = true;
        $this->isModalOpen = true;
        $this->isDetailModalOpen = false; // Pastiin modal detail ketutup misal ngeditnya dari pop-up detail
    }

    public function updateProyek()
    {
        $this->validate([
            'nama_kategori' => 'required',
            'nama_pelanggan' => 'required',
            'pic_pelanggan' => 'required',
            'no_hp' => 'required',
            'target_waktu' => 'required|date',
            'estimasi_budget' => 'required|numeric|min:1000',
            'alamat' => 'required',
            'deskripsi_proyek' => 'required',
            'priority' => 'required|in:low,medium,high',
            'lampiran.*' => 'nullable|file|max:5120',
        ]);

        // Cek atau bikin kategori baru
        $kategori = ProjectCategory::firstOrCreate([
            'nama_kategori' => trim($this->nama_kategori)
        ]);

        // Cari proyek & update data
        $proyek = RProject::findOrFail($this->proyek_id);
        $proyek->update([
            'category_id' => $kategori->id,
            'nama_pelanggan' => $this->nama_pelanggan,
            'pic_pelanggan' => $this->pic_pelanggan,
            'no_hp' => $this->no_hp,
            'deskripsi_proyek' => $this->deskripsi_proyek,
            'target_waktu' => $this->target_waktu,
            'estimasi_budget' => $this->estimasi_budget,
            'alamat' => $this->alamat,
            'priority' => $this->priority,
        ]);

        // Proses lampiran baru kalau ada yang di-upload
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
        $proyek = RProject::with(['attachments', 'category'])->findOrFail($id);
        
        $this->detail_id = $proyek->id;
        $this->detail_request_no = $proyek->request_no;
        $this->detail_kategori = $proyek->category ? $proyek->category->nama_kategori : '-';
        $this->detail_nama_pelanggan = $proyek->nama_pelanggan;
        $this->detail_pic_pelanggan = $proyek->pic_pelanggan;
        $this->detail_no_hp = $proyek->no_hp;
        $this->detail_target_waktu = $proyek->target_waktu;
        $this->detail_estimasi_budget = $proyek->estimasi_budget;
        $this->detail_alamat = $proyek->alamat;
        $this->detail_deskripsi_proyek = $proyek->deskripsi_proyek;
        $this->detail_priority = $proyek->priority;
        $this->detail_status = $proyek->status_proyek;
        $this->detail_lampiran = $proyek->attachments;

        $this->isDetailModalOpen = true;
    }

    public function tutupDetailModal()
    {
        $this->isDetailModalOpen = false;
    }

    public function hapusProyek($id)
    {
        RProject::find($id)->delete();
        session()->flash('sukses', 'Data proyek berhasil dihapus!');
        $this->loadData();
        $this->isDetailModalOpen = false;
    }
   
    public function render()
    {
        return view('livewire.marketing.kelola-proyek')
        ->layout('components.layouts.app');
    }
}