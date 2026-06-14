<?php

namespace App\Livewire\Marketing;

use Livewire\Component;
use App\Models\Bidding;
use App\Models\RProject;
use App\Models\DocumentCommit;
use Illuminate\Support\Facades\Auth;

class BiddingDetail extends Component
{
    public $projectId;
    public $proyek;
    public $biddingAktif;

    // Form Variables
    public $no_penawaran, $tgl_penawaran, $masa_berlaku, $total_penawaran;
    public $nama_perusahaan, $email_perusahaan, $alamat_perusahaan;
    public $term_of_payment, $surat_pengantar;
    
    public $komentar_commit = '';
    public $nama_penulis = '';

    public function mount($id)
    {
        $this->projectId = $id;
        $this->proyek = RProject::with(['rab', 'user'])->findOrFail($id);
        $this->biddingAktif = Bidding::where('id_r_project', $id)->first();

        // Kalau Bidding udah ada, tarik datanya. Kalau belum, auto-generate.
        if ($this->biddingAktif) {
            $this->no_penawaran = $this->biddingAktif->no_penawaran;
            $this->tgl_penawaran = $this->biddingAktif->tgl_penawaran;
            $this->masa_berlaku = $this->biddingAktif->masa_berlaku;
            $this->total_penawaran = $this->biddingAktif->total_penawaran;
            $this->nama_perusahaan = $this->biddingAktif->nama_perusahaan;
            $this->email_perusahaan = $this->biddingAktif->email_perusahaan;
            $this->alamat_perusahaan = $this->biddingAktif->alamat_perusahaan;
            $this->term_of_payment = $this->biddingAktif->term_of_payment;
            $this->surat_pengantar = $this->biddingAktif->surat_pengantar;
        } else {
            $this->no_penawaran = 'PEN/' . date('Y/m/d') . '/' . $id;
            $this->tgl_penawaran = date('Y-m-d');
            $this->masa_berlaku = '14 (Empat Belas) Hari';
            $this->total_penawaran = $this->proyek->rab->grand_total ?? 0;
            $this->nama_perusahaan = $this->proyek->nama_pelanggan;
            $this->term_of_payment = "DP 30% Setelah PO terbit.\nPelunasan 70% Setelah Berita Acara Serah Terima (BAST) ditandatangani.";
            $this->surat_pengantar = "Sehubungan dengan rencana pekerjaan {$this->proyek->nama_projek}, bersama surat ini kami PT Tri Jaya Teknik Karawang mengajukan proposal penawaran harga untuk pelaksanaan pekerjaan tersebut.";
        }

        $this->nama_penulis = Auth::user()->username ?? 'Tim Marketing';
    }

    public function kembaliKeList()
    {
        return $this->redirectRoute('marketing.bidding.index', navigate: true);
    }

    public function simpanBidding()
    {
        // Validasi Ketat
        $this->validate([
            'no_penawaran' => 'required',
            'tgl_penawaran' => 'required|date',
            'total_penawaran' => 'required|numeric',
            'nama_perusahaan' => 'required|string',
            'komentar_commit' => 'required|string|min:5',
            'nama_penulis' => 'required|string',
        ], [
            'komentar_commit.required' => 'Wajib isi catatan versi / alasan revisi biar riwayatnya jelas!',
        ]);

        $dataForm = [
            'id_r_project' => $this->projectId,
            'id_user' => Auth::id() ?? 1,
            'no_penawaran' => $this->no_penawaran,
            'tgl_penawaran' => $this->tgl_penawaran,
            'masa_berlaku' => $this->masa_berlaku,
            'total_penawaran' => $this->total_penawaran,
            'nama_perusahaan' => $this->nama_perusahaan,
            'email_perusahaan' => $this->email_perusahaan,
            'alamat_perusahaan' => $this->alamat_perusahaan,
            'term_of_payment' => $this->term_of_payment,
            'surat_pengantar' => $this->surat_pengantar,
            'status_bidding' => 'pending', // Otomatis nunggu persetujuan
        ];

        $isNew = !$this->biddingAktif;
        
        if ($isNew) {
            $this->biddingAktif = Bidding::create($dataForm);
            $jenisAksi = 'created';
            $this->proyek->update(['status_proyek' => 'bidding_process']);
        } else {
            $this->biddingAktif->update($dataForm);
            $jenisAksi = 'updated';
        }

        // Catat di History
        DocumentCommit::create([
            'id_user' => Auth::id() ?? 1,
            'user_name' => $this->nama_penulis,
            'id_r_project' => $this->projectId,
            'id_bidding' => $this->biddingAktif->id,
            'jenis_aksi' => $jenisAksi,
            'komentar_commit' => $this->komentar_commit,
            'total_nilai' => $this->total_penawaran,
            'created_at' => now()
        ]);

        session()->flash('sukses', 'Dokumen Penawaran berhasil disimpan dan diajukan ke Direktur!');
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