<?php

namespace App\Livewire\Marketing;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Bidding;
use App\Models\Rab;
use App\Models\RProject;
use App\Models\DocumentCommit;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Notifications\RevisiBiddingNotification;

class KelolaBidding extends Component
{
    use WithPagination;

    // ==========================================
    // 1. VARIABEL FORM TAMBAH/EDIT
    // ==========================================
    public $id_r_project, $nama_proyek_terpilih;
    public $no_penawaran, $tgl_penawaran, $total_penawaran, $masa_berlaku;
    public $nama_perusahaan, $email_perusahaan, $alamat_perusahaan, $term_of_payment, $surat_pengantar;
    public $komentar_commit = '';
    public $nama_penulis = '';

    // ==========================================
    // 2. VARIABEL SEARCH & FILTER
    // ==========================================
    public $search = '';
    public $filterStatus = '';

    // ==========================================
    // 3. VARIABEL KONTROL MODAL & STATE
    // ==========================================
    public $isModalOpen = false;
    public $isRevisiModalOpen = false;
    public $isEdit = false;              // LOGIC STATE: Buat nandain ini mode edit atau tambah baru
    public $edit_bidding_id = null;      // LOGIC STATE: Nyimpen ID bidding yang lagi diedit

    public $detailBidding = null;
    public $historiRevisi = [];

    // ==========================================
    // LIFECYCLE HOOKS
    // ==========================================
    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingFilterStatus()
    {
        $this->resetPage();
    }

    // ==========================================
    // FUNGSI KONTROL MODAL UTAMA
    // ==========================================
    public function bukaModalInisiasi($id_project, $nama_pelanggan)
    {
        $this->resetFormUtama();
        $this->id_r_project = $id_project;
        $this->nama_proyek_terpilih = $nama_pelanggan;
        $this->isEdit = false; // Pastikan state-nya "Tambah Baru"
        $this->isModalOpen = true;
    }

    public function tutupModal()
    {
        $this->isModalOpen = false;
        $this->resetFormUtama();
    }

    private function resetFormUtama()
    {
        $this->reset([
            'id_r_project', 'nama_proyek_terpilih', 'no_penawaran', 'tgl_penawaran',
            'total_penawaran', 'masa_berlaku', 'nama_perusahaan', 'email_perusahaan',
            'alamat_perusahaan', 'term_of_payment', 'surat_pengantar',
            'isEdit', 'edit_bidding_id' // Reset state edit juga biar bersih
        ]);
        $this->resetValidation();
    }

    // ==========================================
    // FUNGSI EKSEKUSI DATA (CREATE & UPDATE)
    // ==========================================
    public function simpanBidding()
    {
        // 1. Validasi dinamis
        $rules = [
            'id_r_project' => 'required',
            'no_penawaran' => 'required',
            'tgl_penawaran' => 'required|date',
            'total_penawaran' => 'required|numeric',
            'nama_perusahaan' => 'required|string',
        ];

        // Validasi wajib isi komentar dan nama penulis pas revisi
        if ($this->isEdit) {
            $rules['komentar_commit'] = 'required|string|min:5';
            $rules['nama_penulis'] = 'required|string|min:3';
        }

        $this->validate($rules, [
            'komentar_commit.required' => 'Wajib kasih alasan revisi!',
            'nama_penulis.required' => 'Nama penulis wajib diisi!',
        ]);

        $dataForm = [
            'id_r_project' => $this->id_r_project,
            'no_penawaran' => $this->no_penawaran,
            'tgl_penawaran' => $this->tgl_penawaran,
            'total_penawaran' => $this->total_penawaran,
            'masa_berlaku' => $this->masa_berlaku,
            'nama_perusahaan' => $this->nama_perusahaan,
            'email_perusahaan' => $this->email_perusahaan,
            'alamat_perusahaan' => $this->alamat_perusahaan,
            'term_of_payment' => $this->term_of_payment,
            'surat_pengantar' => $this->surat_pengantar,
            'status_bidding' => 'draft',
            'id_user' => Auth::id(),
        ];

        // 2. Percabangan Edit (Create Versi Baru) vs Tambah Baru
        if ($this->isEdit) {
            // CREATE VERSI BARU
            $bidding = Bidding::create($dataForm);

            $pesanFeedback = 'berhasil direvisi (Versi Baru)';
            $jenisKomentar = 'updated';
            $teksKomentar = $this->komentar_commit;

            // Notifikasi ke Direktur
            $direktur = User::where('role', 'direktur')->first();
            if ($direktur) {
                \App\Models\Notification::create([
                    'id_user' => $direktur->id,
                    'judul' => 'Dokumen Bidding Direvisi',
                    'pesan' => "Penawaran {$this->no_penawaran} direvisi oleh {$this->nama_penulis}. Catatan: {$this->komentar_commit}",
                    'url_tujuan' => '/direktur/persetujuan/' . $this->id_r_project,
                    'is_read' => false
                ]);
            }
        } else {
            // CREATE DATA BARU (Awal)
            $bidding = Bidding::create($dataForm);

            // TIDAK PERLU UPDATE STATUS PROYEK, biar tetap rab_approved 
            // Atau sesuaikan dengan logic lu kalau mau ada status khusus saat bidding draft dibuat
            RProject::where('id', $this->id_r_project)->update(['status_proyek' => 'bidding_process']);

            $pesanFeedback = 'berhasil dibuat';
            $jenisKomentar = 'created';
            $teksKomentar = 'Dokumen Surat Penawaran awal dibuat.';
            $this->nama_penulis = Auth::user()->username;
        }

        // 3. Catat ke Document Commits (Audit Trail)
        DocumentCommit::create([
            'id_user' => Auth::id(),
            'user_name' => $this->nama_penulis,
            'id_r_project' => $this->id_r_project,
            'id_bidding' => $bidding->id,
            'jenis_aksi' => $jenisKomentar,
            'komentar_commit' => $teksKomentar,
            'created_at' => now()
        ]);

        session()->flash('sukses', "Dokumen {$this->no_penawaran} $pesanFeedback!");
        $this->tutupModal();
    }

    // ==========================================
    // FUNGSI HAPUS BIDDING (DANGER ZONE)
    // ==========================================
    public function hapusBidding($id)
    {
        $bidding = Bidding::find($id);
        
        if ($bidding) {
            // 1. Hapus histori audit/commit dulu biar DB bersih
            DocumentCommit::where('id_bidding', $id)->delete();
            
            // 2. Balikin status proyek biar muncul lagi di antrean 'Siap Bidding'
            RProject::where('id', $bidding->id_r_project)->update([
                'status_proyek' => 'rab_approved'
            ]);
            
            // 3. Eksekusi mati (Hapus Bidding)
            $bidding->delete();
            
            session()->flash('sukses', 'Dokumen Bidding berhasil dihapus dan proyek dikembalikan ke antrean!');
        }
    }

    // ==========================================
    // FUNGSI MODAL REVISI / DETAIL
    // ==========================================
    public function lihatRevisi($id)
    {
        $this->detailBidding = Bidding::find($id);
        $this->historiRevisi = DocumentCommit::with('user')
            ->where('id_bidding', $id)
            ->orderBy('created_at', 'desc')
            ->get();
        $this->isRevisiModalOpen = true;
    }

    public function tutupRevisiModal()
    {
        $this->isRevisiModalOpen = false;
        $this->reset(['detailBidding', 'historiRevisi']);
    }

    public function bukaEditDariRevisi()
    {
        $this->isRevisiModalOpen = false;

        if ($this->detailBidding) {
            // Ubah State ke Mode Edit
            $this->isEdit = true;
            $this->edit_bidding_id = $this->detailBidding->id;

            // Isi field UI dengan data dari database
            $this->id_r_project = $this->detailBidding->id_r_project;
            $this->no_penawaran = $this->detailBidding->no_penawaran;
            $this->tgl_penawaran = $this->detailBidding->tgl_penawaran;
            $this->total_penawaran = $this->detailBidding->total_penawaran;
            $this->masa_berlaku = $this->detailBidding->masa_berlaku;
            $this->nama_perusahaan = $this->detailBidding->nama_perusahaan;
            $this->email_perusahaan = $this->detailBidding->email_perusahaan;
            $this->alamat_perusahaan = $this->detailBidding->alamat_perusahaan;
            $this->term_of_payment = $this->detailBidding->term_of_payment;
            $this->surat_pengantar = $this->detailBidding->surat_pengantar;
        }

        $this->isModalOpen = true;
    }

    // ==========================================
    // RENDER HALAMAN
    // ==========================================
    public function render()
    {
        // Tarik semua proyek yang belum punya Bidding atau belum selesai
        $daftarProyek = RProject::whereDoesntHave('biddings')
                                  ->whereNotIn('status_proyek', ['finished', 'cancelled'])
                                  ->orderBy('created_at', 'desc')
                                  ->get();

        $query = Bidding::with('project')->orderBy('created_at', 'desc');

        if (!empty($this->search)) {
            $query->where(function($q) {
                $q->where('nama_perusahaan', 'like', '%' . $this->search . '%')
                  ->orWhere('no_penawaran', 'like', '%' . $this->search . '%');
            });
        }
        
        if (!empty($this->filterStatus)) {
            $query->where('status_bidding', $this->filterStatus);
        }

        $daftarBidding = $query->paginate(10);

        // Preview PDF RAB
        $previewRab = null; 
        if (!empty($this->id_r_project)) {
            $previewRab = Rab::where('id_r_project', $this->id_r_project)->first();
        }

        return view('livewire.marketing.kelola-bidding', compact('daftarProyek', 'daftarBidding', 'previewRab'))
            ->layout('components.layouts.app');
    }
}