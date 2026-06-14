<?php

namespace App\Livewire\Marketing;

use Livewire\Component;
use App\Models\Bidding;
use App\Models\RProject;
use App\Models\DocumentCommit;
use App\Models\CompanyProfile;
use App\Models\User;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;

class BiddingDetail extends Component
{
    public $projectId;
    public $proyek;
    public $biddingAktif;
    public $rabAktif;
    
    // Field Form sesuai skema tabel biddings
    public $no_penawaran, $tgl_penawaran, $perihal, $kepada, $up;
    public $surat_pengantar, $catatan;
    public $term_of_payment, $masa_berlaku, $waktu_pengerjaan, $garansi;
    
    // Kalkulasi Harga
    public $harga_dasar = 0;
    public $total_penawaran = 0;
    public $margin_persen = 0;
    
    public $komentar_commit = '';
    public $nama_penulis = '';

    public function mount($id)
    {
        // 1. Cek Profil Perusahaan
        $company = CompanyProfile::first();
        if (!$company) {
            session()->flash('error', 'Profil perusahaan belum dilengkapi oleh Direktur. Anda tidak dapat membuat dokumen Bidding.');
            return $this->redirectRoute('marketing.bidding.index', navigate: true);
        }

        $this->projectId = $id;
        
        // Menerapkan Aturan: Hanya ambil RAB yang statusnya sudah 'approved'
        $this->proyek = RProject::with(['rabs' => function ($q) {
            $q->where('status_rab', 'approved')->latest();
        }, 'user'])->findOrFail($id);

        $this->rabAktif = $this->proyek->rabs->first();

        // Validasi: Jika tidak ada RAB yang approved, tolak pembuatan bidding
        if (!$this->rabAktif) {
            session()->flash('error', 'Sistem mendeteksi proyek ini belum memiliki RAB yang berstatus Approved. Bidding tidak dapat dibuat.');
            return $this->redirectRoute('marketing.bidding.index', navigate: true);
        }

        $this->biddingAktif = Bidding::where('id_r_project', $id)->first();

        // 2. Tarik Data Bidding jika sudah ada, atau buat Default jika baru
        if ($this->biddingAktif) {
            $this->no_penawaran = $this->biddingAktif->no_penawaran;
            $this->tgl_penawaran = $this->biddingAktif->tgl_penawaran;
            $this->perihal = $this->biddingAktif->perihal;
            $this->kepada = $this->biddingAktif->nama_pelanggan_snapshot ?? $this->biddingAktif->kepada;
            $this->up = $this->biddingAktif->pic_pelanggan_snapshot ?? $this->biddingAktif->up;
            $this->surat_pengantar = $this->biddingAktif->surat_pengantar;
            $this->catatan = $this->biddingAktif->catatan;
            $this->term_of_payment = $this->biddingAktif->term_of_payment;
            $this->masa_berlaku = $this->biddingAktif->masa_berlaku;
            $this->waktu_pengerjaan = $this->biddingAktif->waktu_pengerjaan;
            $this->garansi = $this->biddingAktif->garansi;
            $this->harga_dasar = $this->biddingAktif->harga_dasar;
            $this->total_penawaran = $this->biddingAktif->total_penawaran;

            // Kalkulasi ulang margin persen berdasarkan harga yang tersimpan
            if ($this->harga_dasar > 0) {
                $this->margin_persen = round((($this->total_penawaran - $this->harga_dasar) / $this->harga_dasar) * 100, 2);
            }
        } else {
            // Default Values Bidding Baru
            $this->no_penawaran = 'PEN/' . date('Y/m/d') . '/' . $id;
            $this->tgl_penawaran = date('Y-m-d');
            $this->perihal = 'Penawaran Harga Pekerjaan ' . $this->proyek->nama_projek;
            
            // Ambil dari r_project
            $this->kepada = $this->proyek->nama_pelanggan;
            $this->up = $this->proyek->pic_pelanggan;
            
            // Ambil Base Price dari RAB yang Approved
            $this->harga_dasar = $this->rabAktif->grand_total ?? 0;
            $this->total_penawaran = $this->harga_dasar;
            $this->margin_persen = 0;
            
            $this->masa_berlaku = 14;
            $this->term_of_payment = "DP 30% Setelah PO terbit.\nPelunasan 70% Setelah Berita Acara Serah Terima (BAST).";
            $this->surat_pengantar = "Bersama surat ini kami mengajukan proposal penawaran harga untuk pelaksanaan pekerjaan tersebut.";
        }

        $this->nama_penulis = Auth::user()->username ?? 'Tim Marketing';
    }

    public function updatedMarginPersen($value)
    {
        $val = floatval($value);
        $this->total_penawaran = $this->harga_dasar + ($this->harga_dasar * ($val / 100));
    }

    public function updatedTotalPenawaran($value)
    {
        $val = floatval($value);
        if ($this->harga_dasar > 0) {
            $this->margin_persen = round((($val - $this->harga_dasar) / $this->harga_dasar) * 100, 2);
        }
    }

    public function kembaliKeList()
    {
        return $this->redirectRoute('marketing.bidding.index', navigate: true);
    }

    public function simpanBidding()
    {
        $this->validate([
            'no_penawaran' => 'required',
            'tgl_penawaran' => 'required|date',
            'perihal' => 'required|string',
            'kepada' => 'required|string',
            'total_penawaran' => 'required|numeric|min:0',
            'masa_berlaku' => 'required|numeric|min:1',
            'term_of_payment' => 'required|string',
            'komentar_commit' => 'required|string|min:5',
            'nama_penulis' => 'required|string',
        ]);

        $dataForm = [
            'id_r_project' => $this->projectId,
            'id_user' => Auth::id() ?? 1,
            'no_penawaran' => $this->no_penawaran,
            'tgl_penawaran' => $this->tgl_penawaran,
            'perihal' => $this->perihal,
            'nama_pelanggan_snapshot' => $this->kepada,
            'pic_pelanggan_snapshot' => $this->up,
            'surat_pengantar' => $this->surat_pengantar,
            'catatan' => $this->catatan,
            'term_of_payment' => $this->term_of_payment,
            'masa_berlaku' => $this->masa_berlaku,
            'waktu_pengerjaan' => $this->waktu_pengerjaan,
            'garansi' => $this->garansi,
            'harga_dasar' => $this->harga_dasar,
            'total_penawaran' => $this->total_penawaran,
            'status_bidding' => 'pending',
        ];

        if (!$this->biddingAktif) {
            $this->biddingAktif = Bidding::create($dataForm);
            $jenisAksi = 'created';
        } else {
            $this->biddingAktif->update($dataForm);
            $jenisAksi = 'updated';
        }

        // Catat Aktivitas
        DocumentCommit::create([
            'id_user' => Auth::id() ?? 1,
            'user_name' => $this->nama_penulis,
            'id_r_project' => $this->projectId,
            'id_bidding' => $this->biddingAktif->id,
            'jenis_aksi' => $jenisAksi,
            'komentar_commit' => $this->komentar_commit,
            'total_penawaran' => $this->total_penawaran,
            'created_at' => now()
        ]);

        // ✅ TEMBAK NOTIFIKASI KE DIREKTUR BIAR LONCENGNYA BUNYI
        $direktur = User::where('role', 'direktur')->first();
        if ($direktur) {
            $totalFormatted = number_format($this->total_penawaran, 0, ',', '.');
            Notification::create([
                'id_user' => $direktur->id,
                'judul' => 'Pengajuan Penawaran Membutuhkan Review',
                'pesan' => "Dokumen penawaran untuk proyek {$this->proyek->nama_pelanggan} telah disubmit oleh {$this->nama_penulis}. Total: Rp {$totalFormatted}. Catatan: {$this->komentar_commit}",
                'url_tujuan' => route('direktur.persetujuan.detail', $this->proyek->id),
              'is_read' => false,
                'created_at' => now()
            ]);
        }

        session()->flash('sukses', 'Dokumen Penawaran berhasil diajukan untuk disetujui Direktur!');
        return $this->kembaliKeList();
    }

    public function render()
    {
        $historiRevisi = DocumentCommit::where('id_bidding', $this->biddingAktif?->id ?? 0)
            ->orderBy('created_at', 'desc')->get();

        return view('livewire.marketing.bidding-detail', [
            'historiRevisi' => $historiRevisi
        ])->layout('components.layouts.app');
    }
}