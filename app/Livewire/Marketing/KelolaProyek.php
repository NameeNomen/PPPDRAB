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
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class KelolaProyek extends Component
{
    use WithFileUploads;

    // State Modal & Edit
    public $daftarProyek = [];
    public $isModalOpen = false;
    public $isEdit = false;
    public $proyekId;
    public $metode_input = 'manual';
    public $existingAttachments = [];

    // Search & Filter
    public $search = '';
    public $filterStatus = '';
    public $filterCategory = '';
    public $search_kategori = '';
    public $nama_kategori_terpilih = '';
    public $listKategori = [];

    // Form Inputs
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

    // File Uploads
    public $file_rfq;
    public $file_referensi = [];
    public $file_lokasi = [];
    public $file_drawing = [];

    // Replace Foto State
    public $replaceAttachmentId = null;
    public $replaceFile = null;

    // Detail Popup State
    public $isDetailOpen = false;
    public $detailProyek = null;

    public function mount() { 
        $this->loadData(); 
    }

    public function loadData()
    {
        $query = RProject::with(['category', 'attachments'])->latest();
        if ($this->search) {
            $query->where(function($q) {
                $q->where('nama_projek', 'like', '%' . $this->search . '%')
                  ->orWhere('request_no', 'like', '%' . $this->search . '%')
                  ->orWhere('nama_pelanggan', 'like', '%' . $this->search . '%');
            });
        }
        if ($this->filterStatus) $query->where('status_proyek', $this->filterStatus);
        if ($this->filterCategory) $query->where('category_id', $this->filterCategory);

        $this->daftarProyek = $query->get();
        $this->listKategori = ProjectCategory::orderBy('nama_kategori')->get();
    }

    public function updatedSearch() { $this->loadData(); }
    public function updatedFilterStatus() { $this->loadData(); }
    public function updatedFilterCategory() { $this->loadData(); }

    public function updatedSearchKategori($value) {
        $this->listKategori = $value
            ? ProjectCategory::where('nama_kategori', 'like', '%' . $value . '%')->get()
            : ProjectCategory::orderBy('nama_kategori')->get();
    }

    public function pilihKategori($id, $nama) {
        $this->category_id = $id;
        $this->nama_kategori_terpilih = $nama;
        $this->search_kategori = '';
    }

    // --- MODAL ACTIONS ---
    public function bukaModal() {
        $this->resetForm();
        $this->isEdit = false;
        $this->isModalOpen = true;
    }

    public function tutupModal() { 
        $this->isModalOpen = false; 
    }

    public function resetForm() {
        $this->reset([
            'category_id', 'nama_projek', 'nama_pelanggan', 'pic_pelanggan',
            'no_hp', 'deskripsi_proyek', 'target_waktu', 'estimasi_budget',
            'priority', 'alamat', 'file_rfq', 'search_kategori', 'nama_kategori_terpilih',
            'proyekId', 'existingAttachments', 'replaceFile', 'replaceAttachmentId'
        ]);
        
        $this->file_referensi = [];
        $this->file_lokasi = [];
        $this->file_drawing = [];
        
        $this->priority = 'medium';
        $this->metode_input = 'manual';
    }

    // --- DETAIL POPUP ---
    public function bukaDetail($id) {
        $this->detailProyek = RProject::with(['category', 'attachments', 'user'])->findOrFail($id);
        $this->isDetailOpen = true;
    }
    
    public function tutupDetail() {
        $this->isDetailOpen = false;
        $this->detailProyek = null;
    }

    // --- CREATE & UPDATE ---
    public function simpanProyek() {
        $this->validateRules(); 

        $requestNo = 'REQ/TJT/' . date('Y/m') . '/' . str_pad(
            RProject::whereYear('created_at', date('Y'))->whereMonth('created_at', date('m'))->count() + 1, 4, '0', STR_PAD_LEFT
        );

        DB::beginTransaction();
        $storedFiles = [];

        try {
            $proyek = RProject::create([
                'request_no' => $requestNo,
                'tanggal_request' => now(),
                'id_user' => Auth::id(), 
                'nama_projek' => $this->nama_projek,
                'category_id' => $this->category_id,
                'nama_pelanggan' => $this->nama_pelanggan,
                'pic_pelanggan' => $this->pic_pelanggan,
                'no_hp' => $this->no_hp,
                'deskripsi_proyek' => $this->metode_input === 'rfq' ? 'Berdasarkan Proposal/RFQ Terlampir' : $this->deskripsi_proyek,
                'target_waktu' => $this->target_waktu,
                'estimasi_budget' => $this->estimasi_budget,
                'priority' => $this->priority,
                'alamat' => $this->alamat,
                'status_proyek' => 'pending',
                'requires_site_survey' => $this->metode_input === 'manual',
            ]);

            $storedFiles = $this->uploadSemuaLampiran($proyek->id);
            $this->kirimNotifikasi($proyek->id, $proyek->request_no, $proyek->nama_projek);            
            
            DB::commit();

            session()->flash('sukses', "Proyek {$requestNo} berhasil dibuat!");
            $this->tutupModal();
            $this->loadData(); 

        } catch (\Throwable $e) {
            DB::rollBack();
            foreach ($storedFiles as $p) {
                if ($p && Storage::disk('public')->exists($p)) Storage::disk('public')->delete($p);
            }
            session()->flash('gagal', 'Gagal menyimpan: ' . $e->getMessage());
        }
    }

    public function editProyek($id) {
        $proyek = RProject::with(['category', 'attachments'])->findOrFail($id);
        $this->proyekId = $id;
        $this->isEdit = true;
        $this->replaceFile = null;
        $this->replaceAttachmentId = null;

        $this->nama_projek = $proyek->nama_projek;
        $this->category_id = $proyek->category_id;
        $this->nama_kategori_terpilih = $proyek->category->nama_kategori ?? '';
        $this->nama_pelanggan = $proyek->nama_pelanggan;
        $this->pic_pelanggan = $proyek->pic_pelanggan;
        $this->no_hp = $proyek->no_hp;
        $this->deskripsi_proyek = $proyek->deskripsi_proyek;
        $this->target_waktu = $proyek->target_waktu;
        $this->estimasi_budget = $proyek->estimasi_budget;
        $this->priority = $proyek->priority;
        $this->alamat = $proyek->alamat;

        $this->existingAttachments = [
            'reference_image'   => $proyek->attachments->where('attachment_category', 'reference_image')->values(),
            'location_photo'    => $proyek->attachments->where('attachment_category', 'location_photo')->values(),
            'technical_drawing' => $proyek->attachments->where('attachment_category', 'technical_drawing')->values(),
            'proposal'          => $proyek->attachments->where('attachment_category', 'proposal')->first(),
        ];

        $this->metode_input = !empty($this->existingAttachments['proposal']) ? 'rfq' : 'manual';
        $this->isModalOpen = true;
    }

    public function updateProyek() {
        $this->validateRules();

        DB::beginTransaction();
        $storedFiles = [];
        try {
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

            $storedFiles = $this->uploadSemuaLampiran($proyek->id);
            DB::commit();

            session()->flash('sukses', "Data proyek {$proyek->request_no} berhasil diperbarui!");
            $this->tutupModal();
            $this->loadData();
        } catch (\Throwable $e) {
            DB::rollBack();
            foreach ($storedFiles as $p) {
                if ($p && Storage::disk('public')->exists($p)) Storage::disk('public')->delete($p);
            }
            session()->flash('gagal', 'Gagal update: ' . $e->getMessage());
        }
    }

    public function hapusProyek($id) {
        $proyek = RProject::findOrFail($id);
        foreach ($proyek->attachments as $at) {
            if (Storage::disk('public')->exists($at->file_path)) {
                Storage::disk('public')->delete($at->file_path);
            }
            $at->delete();
        }
        $proyek->delete();
        session()->flash('sukses', "Proyek berhasil dihapus.");
        $this->loadData();
    }

    // --- FILE HANDLING & REPLACE ---
    public function replaceFoto($attachmentId) {
        $this->validate(['replaceFile' => 'required|image|mimes:jpg,jpeg,png,webp|max:5120']);
        $attachment = ProjectAttachment::findOrFail($attachmentId);

        if (Storage::disk('public')->exists($attachment->file_path)) {
            Storage::disk('public')->delete($attachment->file_path);
        }

        $newPath = $this->replaceFile->store('gambarProyek', 'public');
        $attachment->update([
            'file_name' => $this->replaceFile->getClientOriginalName(),
            'file_path' => $newPath,
            'file_type' => $this->replaceFile->extension(),
        ]);

        $this->replaceFile = null;
        $this->replaceAttachmentId = null;
        session()->flash('sukses', 'Foto berhasil diganti!');
        $this->editProyek($this->proyekId);
    }

    public function hapusFoto($attachmentId) {
        $attachment = ProjectAttachment::findOrFail($attachmentId);
        if (Storage::disk('public')->exists($attachment->file_path)) {
            Storage::disk('public')->delete($attachment->file_path);
        }
        $attachment->delete();
        session()->flash('sukses', 'Foto berhasil dihapus!');
        $this->editProyek($this->proyekId);
    }

    private function uploadSemuaLampiran($proyekId) {
        $savedPaths = [];

        if ($this->file_rfq) {
            $saved = $this->simpanSingleFile($proyekId, $this->file_rfq, 'proposal');
            if ($saved) $savedPaths[] = $saved;
        }

        if ($this->metode_input === 'manual') {
            $kategoriMapping = [
                'file_referensi' => 'reference_image',
                'file_lokasi' => 'location_photo',
                'file_drawing' => 'technical_drawing'
            ];

            foreach ($kategoriMapping as $propertyName => $categoryEnum) {
                if (!empty($this->$propertyName) && is_array($this->$propertyName)) {
                    foreach ($this->$propertyName as $file) {
                        $saved = $this->simpanSingleFile($proyekId, $file, $categoryEnum);
                        if ($saved) $savedPaths[] = $saved;
                    }
                }
            }
        }
        return $savedPaths;
    }

    private function simpanSingleFile($proyekId, $file, $category) {
        if (!$file) return null;

        $path = $file->store('gambarProyek', 'public');

        ProjectAttachment::create([
            'id_r_project' => $proyekId, // Sesuai dengan foreign key di model ProjectAttachment
            'file_name' => $file->getClientOriginalName(),
            'file_path' => $path,
            'file_type' => $file->extension(),
            'attachment_category' => $category,
        ]);

        return $path;
    }

    private function validateRules() {
        $rules = [
            'nama_projek' => 'required|string|max:255',
            'category_id' => 'required|exists:project_categories,id',
            'nama_pelanggan' => 'required|string|max:255',
            'pic_pelanggan' => 'required|string|max:255',
            'no_hp' => 'required|string|max:30',
            'priority' => 'required|in:low,medium,high',
        ];

        if ($this->metode_input === 'manual') {
            $rules['target_waktu'] = 'required|date';
            $rules['estimasi_budget'] = 'required|numeric|min:0';
            $rules['alamat'] = 'required|string';
            $rules['deskripsi_proyek'] = 'required|string';

            if (!empty($this->file_referensi)) $rules['file_referensi.*'] = 'image|mimes:jpg,jpeg,png,webp|max:5120';
            if (!empty($this->file_lokasi)) $rules['file_lokasi.*'] = 'image|mimes:jpg,jpeg,png,webp|max:5120';
            if (!empty($this->file_drawing)) $rules['file_drawing.*'] = 'image|mimes:jpg,jpeg,png,webp|max:5120';
        } else {
            $hasExistingProposal = !empty($this->existingAttachments['proposal']);
            if (!$this->isEdit || !$hasExistingProposal) {
                $rules['file_rfq'] = 'required|file|mimes:pdf|max:10240';
            } else {
                $rules['file_rfq'] = 'nullable|file|mimes:pdf|max:10240';
            }
        }

        $this->validate($rules);
    }

    private function kirimNotifikasi($idProyek, $requestNo, $namaProjek) {
        $penerimaNotif = User::whereIn('role', ['direktur', 'engineering'])->get();

        foreach ($penerimaNotif as $user) {
            $urlTujuan = $user->role === 'direktur'
                ? '/direktur/persetujuan/' . $idProyek
                : '/engineering/kelola-rab/' . $idProyek . '/detail';

            Notification::create([
                'id_user' => $user->id,
                'judul' => 'Inisiasi Proyek Baru',
                'pesan' => "Proyek {$requestNo} ({$namaProjek}) diajukan oleh " . (Auth::user()->username ?? 'Marketing'),
                'url_tujuan' => $urlTujuan,
                'is_read' => false,
            ]);
        }
    }

    public function render() {
        return view('livewire.marketing.kelola-proyek')->layout('components.layouts.app');
    }
}