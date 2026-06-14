<?php
namespace App\Livewire\Engineering;

use Livewire\Component;
use App\Models\Material;
use App\Models\Rab;
use App\Models\RabItem;
use App\Models\DocumentCommit;
use App\Models\RProject;
use App\Models\MaterialRequest;
use Illuminate\Support\Facades\Auth;

class RabWorkspace extends Component
{
    public $projectId;
    public $selectedProject;
    public $rabAktif;

    public $rabId;
    public $no_boq;
    public $tanggal_dokumen;
    public $overhead_cost = 0;

    public $commit_message;
    public $nama_editor;

    public $newKategori;
    
    // Variabel buat Modal Request Material yang lu lupain
    public $showRequestModal = false;
    public $reqNamaMaterial;
    public $reqDeskripsi;
    public $reqKebutuhan;
    public $reqSatuan;
    public $reqTargetWaktu;
    
    // State untuk pencarian material per baris
    public $searchMaterialId = null;
    public $materialSearchKeyword = '';
    public $materialResults = [];

    protected $listeners = ['refreshComponent' => '$refresh'];

    public function mount($id)
    {
        $this->projectId = $id;
        $this->selectedProject = RProject::with('attachments')->findOrFail($id);
        $this->rabAktif = Rab::where('id_r_project', $id)->firstOrFail();

        $this->rabId = $this->rabAktif->id;
        $this->no_boq = $this->rabAktif->no_boq;
        $this->tanggal_dokumen = $this->rabAktif->tgl_boq;
        $this->overhead_cost = $this->rabAktif->overhead_cost;
    }

    public function kembaliKeList()
    {
        return $this->redirectRoute('engineering.rab.detail', ['id' => $this->projectId], navigate: true);
    }

    // INSTANT CREATION: Bikin baris kosong langsung di database
    public function tambahKategori()
    {
        $this->validate(['newKategori' => 'required|min:3']);
        RabItem::create([
            'id_rab' => $this->rabId, 'parent_id' => null, 'tipe' => 'kategori',
            'deskripsi_pekerjaan' => strtoupper($this->newKategori), 'qty' => 0, 'harga_awal' => 0, 'subtotal' => 0
        ]);
        $this->newKategori = '';
        $this->hitungTotal();
    }

    public function tambahSubBab($parentId)
    {
        RabItem::create([
            'id_rab' => $this->rabId, 'parent_id' => $parentId, 'tipe' => 'item',
            'deskripsi_pekerjaan' => 'Uraian Pekerjaan Baru', 'qty' => 1, 'harga_awal' => 0, 'subtotal' => 0
        ]);
        $this->hitungTotal();
    }

    public function tambahSubSubBab($parentId)
    {
        $parentItem = RabItem::find($parentId);
        RabItem::create([
            'id_rab' => $this->rabId, 'parent_id' => $parentId, 'tipe' => 'sub-rincian',
            'deskripsi_pekerjaan' => 'Detail Material Baru', 'qty' => 1, 
            'harga_awal' => 0, 'subtotal' => 0,
            'id_material' => $parentItem->id_material ?? null // Warisi material atasnya kalau ada
        ]);
        $this->hitungTotal();
    }

    // INSTANT AUTO-SAVE: Dipicu pas user klik luar (blur) atau tekan Enter
    public function updateInline($itemId, $field, $value)
    {
        $item = RabItem::find($itemId);
        if ($item) {
            $item->$field = $value;
            if (in_array($field, ['qty', 'harga_awal'])) {
                $item->subtotal = (float)$item->qty * (int)$item->harga_awal;
            }
            $item->save();
            $this->hitungTotal();
        }
    }

    // PENCARIAN MATERIAL INLINE
    public function aktifkanPencarianMaterial($itemId)
    {
        $this->searchMaterialId = $itemId;
        $this->materialSearchKeyword = '';
        $this->materialResults = [];
    }

    public function updatedMaterialSearchKeyword($value)
{
    if (empty($value) || strlen($value) < 2) {
        $this->materialResults = [];
        return;
    }

    $keywords = explode(' ', strtolower($value));
    $query = Material::query();

    foreach ($keywords as $word) {
        if (is_numeric($word) || strlen($word) < 2) continue;
        $query->where(function($q) use ($word) {
            $q->where('nama_barang', 'like', "%{$word}%")
              ->orWhere('deskripsi', 'like', "%{$word}%")
              ->orWhere('merk', 'like', "%{$word}%");
        });
    }

    $this->materialResults = $query->take(10)->get();
}

    public function pilihMaterial($itemId, $materialId)
    {
        $mat = Material::find($materialId);
        $item = RabItem::find($itemId);
        
        if ($mat && $item) {
            $ratio = $mat->jumlah > 0 ? $mat->jumlah : 1;
            $hargaSatuanMurni = $mat->harga / $ratio;

            $item->update([
                'id_material' => $mat->id,
                'harga_awal' => $hargaSatuanMurni,
                'subtotal' => $item->qty * $hargaSatuanMurni
            ]);
            
            $this->searchMaterialId = null;
            $this->hitungTotal();
        }
    }

    public function hapusItem($itemId)
    {
        $item = RabItem::find($itemId);
        if($item) {
            if($item->tipe === 'kategori') {
                $childrenIds = RabItem::where('parent_id', $item->id)->pluck('id');
                RabItem::whereIn('parent_id', $childrenIds)->delete();
                RabItem::where('parent_id', $item->id)->delete();
            } elseif ($item->tipe === 'item') {
                RabItem::where('parent_id', $item->id)->delete();
            }
            $item->delete();
            $this->hitungTotal();
        }
    }

    private function hitungTotal()
    {
        // Menghitung total murni dari level terdalam agar tidak double-counting
        $totalPekerjaan = RabItem::where('id_rab', $this->rabId)
            ->where(function($q) {
                $q->where('tipe', 'sub-rincian')
                  ->orWhere(function($subQ) {
                      $subQ->where('tipe', 'item')->whereDoesntHave('children');
                  });
            })->sum('subtotal');
                                 
        $overhead = (int)($this->overhead_cost ?? 0);
        $this->rabAktif->update([
            'overhead_cost' => $overhead,
            'grand_total' => $totalPekerjaan + $overhead
        ]);
    }
public function ajukanMaterialBaru()
    {
        $this->validate([
            'reqNamaMaterial' => 'required|min:3',
            'reqKebutuhan' => 'required|numeric|min:0.1',
            'reqSatuan' => 'required',
            'reqTargetWaktu' => 'required|date|after:now'
        ]);

        // 1. Simpan data request material ke tabel utama
        MaterialRequest::create([
            'r_project_id' => $this->projectId,
            'nama_material' => $this->reqNamaMaterial,
            'deskripsi' => $this->reqDeskripsi,
            'estimasi_kebutuhan' => $this->reqKebutuhan,
            'satuan' => $this->reqSatuan,
            'target_waktu_dibutuhkan' => $this->reqTargetWaktu,
            'status' => 'pending',
            'requested_by' => Auth::id() ?? 1
        ]);

        // 2. TEMBAK NOTIFIKASI KE PURCHASING
        $purchasing = \App\Models\User::where('role', 'purchasing')->first();
        if ($purchasing) {
            \App\Models\Notification::create([
                'id_user' => $purchasing->id,
                'judul' => 'Permintaan Material Baru',
                'pesan' => "Dibutuhkan: {$this->reqNamaMaterial} ({$this->reqKebutuhan} {$this->reqSatuan}) untuk proyek.",
'url_tujuan' => route('direktur.persetujuan.detail', ['id' => $this->projectId]),                'is_read' => false,
                'created_at' => now()
            ]);
        }

        // 3. Bersihkan sisa form & tutup popup
        $this->showRequestModal = false;
        $this->reset(['reqNamaMaterial', 'reqDeskripsi', 'reqKebutuhan', 'reqSatuan', 'reqTargetWaktu']);
        
        session()->flash('sukses', '✅ Request material berhasil dikirim ke antrean Purchasing!');
    }


    public function submitKeDirektur()
    {
        $this->validate([
            'nama_editor' => 'required|min:3',
            'commit_message' => 'required|min:5',
        ]);

        $this->hitungTotal();

        // 1. Tarik semua data RAB di detik ini juga sampai ke akar-akarnya
        $snapshotKategori = RabItem::where('id_rab', $this->rabId)
            ->where('tipe', 'kategori')
            ->whereNull('parent_id')
            ->with(['children' => function($q) {
                $q->with('children.material', 'material');
            }])->get();

        // 2. Simpan ke tabel Commits beserta data array-nya
        DocumentCommit::create([
            'id_user' => Auth::id() ?? 1, 
            'user_name' => $this->nama_editor,
            'id_rab' => $this->rabId, 
            'id_r_project' => $this->projectId,
            'jenis_aksi' => 'submitted', 
            'komentar_commit' => $this->commit_message,
            'total_nilai' => $this->rabAktif->grand_total,
            'snapshot_data' => $snapshotKategori->toArray(), 
            'created_at' => now()
        ]);

        // 3. Ubah status utama RAB jadi nunggu bos
        $this->rabAktif->update(['status_rab' => 'pending']);

        // 4. TEMBAK NOTIFIKASI KE DIREKTUR BIAR LONCENGNYA BUNYI
        $direktur = \App\Models\User::where('role', 'direktur')->first();
        if ($direktur) {
            \App\Models\Notification::create([
                'id_user' => $direktur->id,
                'judul' => 'Pengajuan RAB Membutuhkan Review',
                'pesan' => "RAB telah disubmit oleh {$this->nama_editor}. Catatan: {$this->commit_message}",
                'url_tujuan' => route('direktur.persetujuan.detail', $this->proyek->id),
                'is_read' => false,
                'created_at' => now()
            ]);
        }

        // 5. Kembalikan ke halaman depan
        session()->flash('sukses', 'RAB berhasil diajukan dan Snapshot berhasil direkam.');
        return $this->redirectRoute('engineering.rab.index', navigate: true);
    }

    public function render()
    {
        $kategoris = RabItem::where('id_rab', $this->rabId)
            ->where('tipe', 'kategori')
            ->whereNull('parent_id')
            ->with(['children' => function($q) {
                $q->with('children.material', 'material');
            }])->get();

        $totalPekerjaan = RabItem::where('id_rab', $this->rabId)
            ->where(function($q) {
                $q->where('tipe', 'sub-rincian')
                  ->orWhere(function($subQ) {
                      $subQ->where('tipe', 'item')->whereDoesntHave('children');
                  });
            })->sum('subtotal');

        $overhead = (int)($this->overhead_cost ?? 0);

        return view('livewire.engineering.rab-workspace', [
            'kategoris' => $kategoris,
            'totalPekerjaan' => $totalPekerjaan,
            'overhead' => $overhead,
            'grandTotal' => $totalPekerjaan + $overhead,
            'isApproved' => strtolower($this->rabAktif->status_rab) === 'approved'
        ])->layout('components.layouts.app');
    }
}