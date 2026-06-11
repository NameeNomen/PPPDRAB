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
    public $deskripsiInput = [];
    public $volumeInput = [];
    public $hargaInput = [];
    
    public $materialSearch = [];
    public $materialResults = [];
    public $selectedMaterial = [];

    public $showRequestModal = false;
    public $reqNamaMaterial, $reqDeskripsi, $reqKebutuhan, $reqSatuan, $reqTargetWaktu;

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

    public function updatedOverheadCost()
    {
        $this->hitungTotal();
    }

    public function updatedMaterialSearch($value, $key = null)
    {
        if (is_array($value)) return;
        $id = str_contains($key, '.') ? last(explode('.', $key)) : $key;

        if (empty($value) || strlen($value) < 2) {
            $this->materialResults[$id] = [];
            return;
        }

        $keywords = explode(' ', strtolower($value));
        $query = Material::query();

        foreach ($keywords as $word) {
            if (is_numeric($word) || strlen($word) < 2) continue;
            $query->where(function($q) use ($word) {
                $q->where('nama_barang', 'like', "%{$word}%")
                  ->orWhere('deskripsi', 'like', "%{$word}%");
            });
        }

        $this->materialResults[$id] = $query->take(5)->get();
    }

    public function pilihMaterial($parentId, $materialId, $namaMaterial, $harga, $satuan, $jumlahMaster)
    {
        $this->selectedMaterial[$parentId] = [
            'id' => $materialId, 'nama' => $namaMaterial, 
            'harga_master' => $harga, 'satuan' => $satuan, 'jumlah_master' => $jumlahMaster > 0 ? $jumlahMaster : 1
        ];
        $this->hargaInput[$parentId] = $harga / ($jumlahMaster > 0 ? $jumlahMaster : 1);
        $this->materialSearch[$parentId] = '';
        $this->materialResults[$parentId] = [];
    }

    public function batalPilihMaterial($parentId)
    {
        unset($this->selectedMaterial[$parentId], $this->hargaInput[$parentId]);
    }

    public function tambahKategori()
    {
        $this->validate(['newKategori' => 'required|min:3']);
        RabItem::create([
            'id_rab' => $this->rabId, 'parent_id' => null, 'tipe' => 'kategori',
            'deskripsi_pekerjaan' => $this->newKategori, 'qty' => 0, 'harga_awal' => 0, 'subtotal' => 0
        ]);
        $this->newKategori = '';
        $this->hitungTotal();
    }

    public function simpanItemBaru($parentId, $tipe = 'item')
    {
        $this->validate([
            "deskripsiInput.{$parentId}" => 'required',
            "volumeInput.{$parentId}" => 'required|numeric|min:0.01',
            "hargaInput.{$parentId}" => 'required|numeric|min:0',
        ]);

        $qty = $this->volumeInput[$parentId];
        $harga_satuan = $this->hargaInput[$parentId];
        $subtotal = $qty * $harga_satuan;

        RabItem::create([
            'id_rab' => $this->rabId,
            'parent_id' => $parentId,
            'tipe' => $tipe,
            'id_material' => $this->selectedMaterial[$parentId]['id'] ?? null,
            'deskripsi_pekerjaan' => $this->deskripsiInput[$parentId],
            'qty' => $qty,
            'harga_awal' => $harga_satuan,
            'subtotal' => $subtotal
        ]);

        unset($this->deskripsiInput[$parentId], $this->volumeInput[$parentId], $this->hargaInput[$parentId], $this->selectedMaterial[$parentId]);
        $this->hitungTotal();
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
        // Rumus matematika pencegah double-counting: Hanya hitung item murni yang gak punya sub-item, ATAU sub-item itu sendiri
        $totalPekerjaan = RabItem::where('id_rab', $this->rabId)
            ->where(function($q) {
                $q->where('tipe', 'sub-rincian')
                  ->orWhere(function($subQ) {
                      $subQ->where('tipe', 'item')
                           ->whereDoesntHave('children');
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
            'reqNamaMaterial' => 'required',
            'reqKebutuhan' => 'required|numeric|min:0.1',
            'reqSatuan' => 'required',
            'reqTargetWaktu' => 'required|date'
        ]);

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

        $this->showRequestModal = false;
        $this->reset(['reqNamaMaterial', 'reqDeskripsi', 'reqKebutuhan', 'reqSatuan', 'reqTargetWaktu']);
        session()->flash('sukses', 'Request material berhasil dikirim ke Purchasing.');
    }

    // TARUH FUNGSI INI DI DALAM CLASS RabWorkspace
    public function updateInline($itemId, $field, $value)
    {
        $item = RabItem::find($itemId);
        if ($item) {
            $item->$field = $value;
            // Kalau yang diubah itu qty atau harga, otomatis hitung ulang subtotalnya
            if (in_array($field, ['qty', 'harga_awal'])) {
                $item->subtotal = $item->qty * $item->harga_awal;
            }
            $item->save();
            $this->hitungTotal();
        }
    }

    public function submitKeDirektur()
    {
        $this->validate([
            'nama_editor' => 'required|min:3',
            'commit_message' => 'required|min:5',
        ]);

        $this->hitungTotal();
        $this->rabAktif->update(['status_rab' => 'pending']);

        DocumentCommit::create([
            'id_user' => Auth::id() ?? 1, 'user_name' => $this->nama_editor,
            'id_rab' => $this->rabId, 'id_r_project' => $this->projectId,
            'jenis_aksi' => 'submitted', 'komentar_commit' => $this->commit_message,
            'created_at' => now()
        ]);

        session()->flash('sukses', 'Dokumen RAB diajukan ke Direktur.');
        return $this->redirectRoute('engineering.rab.index', navigate: true);
    }

    public function render()
    {
        $kategoris = RabItem::where('id_rab', $this->rabId)
            ->where('tipe', 'kategori')
            ->whereNull('parent_id')
            ->with(['children' => function($q) {
                $q->with('children.material', 'material');
            }])
            ->get();

        $totalPekerjaan = RabItem::where('id_rab', $this->rabId)
            ->where(function($q) {
                $q->where('tipe', 'sub-rincian')
                  ->orWhere(function($subQ) {
                      $subQ->where('tipe', 'item')
                           ->whereDoesntHave('children');
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