<?php
namespace App\Livewire\Marketing;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\RProject;
use App\Models\ProjectCategory;
use App\Models\ProjectAttachment;
use App\Models\User;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;

class KelolaProyek extends Component
{
    use WithFileUploads;

    public $daftarProyek = [];
    public $isModalOpen = false;
    public $isEdit = false; // Penanda apakah sedang mode edit atau create
    public $viewMode = 'list'; // Mengatur tampilan: 'list' atau 'detail'
    public $proyekId; // Menyimpan ID proyek yang sedang dipilih (untuk detail/edit/delete)
    public $detailProyek; // Menyimpan data proyek untuk tampilan detail

    // Form inputs sesuai Migration
    public $category_id;
    public $nama_projek;
    public $nama_pelanggan;
    public $pic_pelanggan;
    public $no_hp;
    public $deskripsi_proyek;
    public $target_waktu;
    public $estimasi_budget;
    public $priority = 'medium'; 
    public $alamat;
    
    public $lampiran = [];

    // Properti buat Dropdown Kategori Kustom
    public $search_kategori = '';
    public $nama_kategori_terpilih = '';
    public $listKategori = [];

    public function mount()
    {
        $this->loadData();
    }

    public function loadData()
    {
        $this->daftarProyek = RProject::latest()->get();
        $this->listKategori = ProjectCategory::orderBy('nama_kategori')->get();
    }

    public function updatedSearchKategori($value)
    {
        if (strlen($value) > 0) {
            $this->listKategori = ProjectCategory::where('nama_kategori', 'like', '%' . $value . '%')->get();
        } else {
            $this->listKategori = ProjectCategory::orderBy('nama_kategori')->get();
        }
    }

    public function pilihKategori($id, $nama)
    {
        $this->category_id = $id;
        $this->nama_kategori_terpilih = $nama;
        $this->search_kategori = '';
    }

    // Navigasi State Tampilan
    public function tampilkanDetail($id)
    {
        $this->proyekId = $id;
        $this->detailProyek = RProject::with(['category', 'user'])->findOrFail($id);
        $this->viewMode = 'detail';
    }

    public function kembaliKeList()
    {
        $this->viewMode = 'list';
        $this->resetForm();
        $this->loadData();
    }

    public function bukaModal()
    {
        $this->resetForm();
        $this->isEdit = false;
        $this->listKategori = ProjectCategory::orderBy('nama_kategori')->get();
        $this->isModalOpen = true;
    }

    public function tutupModal()
    {
        $this->isModalOpen = false;
    }

    public function resetForm()
    {
        $this->reset([
            'category_id', 'nama_projek', 'nama_pelanggan', 'pic_pelanggan',
            'no_hp', 'deskripsi_proyek', 'target_waktu', 'estimasi_budget', 
            'priority', 'alamat', 'lampiran', 'search_kategori', 'nama_kategori_terpilih'
        ]);
        $this->priority = 'medium';
    }

    // Aksi: Simpan Data Baru
    public function simpanProyek()
    {
        $this->validateRules();

        $requestNo = 'REQ/TJT/' . date('Y/m') . '/' . str_pad(RProject::whereMonth('created_at', date('m'))->count() + 1, 4, '0', STR_PAD_LEFT);

        $proyek = RProject::create([
            'request_no' => $requestNo,
            'id_user' => Auth::id(),
            'nama_projek' => $this->nama_projek,
            'category_id' => $this->category_id,
            'nama_pelanggan' => $this->nama_pelanggan,
            'pic_pelanggan' => $this->pic_pelanggan,
            'no_hp' => $this->no_hp,
            'deskripsi_proyek' => $this->deskripsi_proyek,
            'target_waktu' => $this->target_waktu,
            'estimasi_budget' => $this->estimasi_budget,
            'priority' => $this->priority,
            'alamat' => $this->alamat,
            'status_proyek' => 'pending'
        ]);

        $this->prosesLampiran($proyek->id);
        $this->kirimNotifikasi($requestNo, $this->nama_projek);

        session()->flash('sukses', "Proyek {$requestNo} berhasil dibuat!");
        $this->tutupModal();
        $this->loadData();
    }

    // Aksi: Mengisi Form untuk Edit
    public function editProyek($id)
    {
        $proyek = RProject::findOrFail($id);
        $this->proyekId = $id;
        $this->isEdit = true;

        // Populate properti form
        $this->category_id = $proyek->category_id;
        $this->nama_kategori_terpilih = $proyek->category->nama_kategori ?? '';
        $this->nama_projek = $proyek->nama_projek;
        $this->nama_pelanggan = $proyek->nama_pelanggan;
        $this->pic_pelanggan = $proyek->pic_pelanggan;
        $this->no_hp = $proyek->no_hp;
        $this->deskripsi_proyek = $proyek->deskripsi_proyek;
        $this->target_waktu = $proyek->target_waktu;
        $this->estimasi_budget = $proyek->estimasi_budget;
        $this->priority = $proyek->priority;
        $this->alamat = $proyek->alamat;

        $this->listKategori = ProjectCategory::orderBy('nama_kategori')->get();
        $this->isModalOpen = true;
    }

    // Aksi: Update Data Proyek
    public function updateProyek()
    {
        $this->validateRules();

        $proyek = RProject::findOrFail($this->proyekId);
        $proyek->update([
            'nama_projek' => $this->nama_projek,
            'category_id' => $this->category_id,
            'nama_pelanggan' => $this->nama_pelanggan,
            'pic_pelanggan' => $this->pic_pelanggan,
            'no_hp' => $this->no_hp,
            'deskripsi_proyek' => $this->deskripsi_proyek,
            'target_waktu' => $this->target_waktu,
            'estimasi_budget' => $this->estimasi_budget,
            'priority' => $this->priority,
            'alamat' => $this->alamat,
        ]);

        $this->prosesLampiran($proyek->id);

        session()->flash('sukses', "Data proyek {$proyek->request_no} berhasil diperbarui!");
        $this->tutupModal();
        
        if ($this->viewMode === 'detail') {
            $this->tampilkanDetail($proyek->id); // Refresh data di halaman detail
        } else {
            $this->loadData();
        }
    }

    // Aksi: Hapus Proyek
    public function hapusProyek($id)
    {
        $proyek = RProject::findOrFail($id);
        $proyek->delete();

        session()->flash('sukses', "Proyek berhasil dihapus dari sistem.");
        $this->kembaliKeList();
    }

    // Helper: Validasi terpusat
    private function validateRules()
    {
        $this->validate([
            'nama_projek' => 'required|string|max:255',
            'category_id' => 'required', 
            'nama_pelanggan' => 'required|string|max:255',
            'pic_pelanggan' => 'nullable|string|max:255', 
            'no_hp' => 'nullable|string|max:255', 
            'deskripsi_proyek' => 'nullable|string', 
            'target_waktu' => 'nullable|date', 
            'estimasi_budget' => 'nullable|numeric', 
            'priority' => 'required|in:low,medium,high', 
            'alamat' => 'nullable|string', 
        ], [
            'category_id.required' => 'Kategori proyek wajib dipilih dari daftar pencarian.'
        ]);
    }

    // Helper: Simpan attachment berkas
    private function prosesLampiran($proyekId)
    {
        if (!empty($this->lampiran)) {
            foreach ($this->lampiran as $file) {
                ProjectAttachment::create([
                    'r_project_id' => $proyekId,
                    'file_name' => $file->getClientOriginalName(),
                    'file_path' => $file->store('project', 'public'),
                    'file_type' => $file->extension()
                ]);
            }
            $this->lampiran = []; // Reset input file setelah diproses
        }
    }

    // Helper: Broadcast Notifikasi
   private function kirimNotifikasi($requestNo, $namaProjek)
{
    $penerimaNotif = User::whereIn('role', ['direktur', 'engineering'])->get();
    $namaPenulis = Auth::user()->username ?? 'Tim Marketing';

    foreach ($penerimaNotif as $user) {

        // default URL
        $url = '/direktur/persetujuan/' . $requestNo;

        // kalau engineering, arahkan ke RAB
        if ($user->role === 'engineering') {
            $url = '/engineering/kelola-rab/' . $requestNo;
        }

        Notification::create([
            'id_user' => $user->id,
            'judul' => 'Inisiasi Proyek Baru',
            'pesan' => "Request Proyek {$requestNo} ({$namaProjek}) telah diajukan oleh {$namaPenulis}.",
            'url_tujuan' => $url,
            'is_read' => false
        ]);
    }
}

    public function render()
    {
        return view('livewire.marketing.kelola-proyek')->layout('components.layouts.app');
    }
}