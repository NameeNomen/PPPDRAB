<?php

namespace App\Livewire\Marketing;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Bidding;
use App\Models\RProject;

class BiddingIndex extends Component
{
    use WithPagination;
    
    public $search = '';
    public $filterStatus = 'all';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingFilterStatus()
    {
        $this->resetPage();
    }

    public function lihatDetail($id)
    {
        // ✅ CEK APAKAH SUDAH ADA BIDDING UNTUK PROYEK INI
        $bidding = Bidding::where('id_r_project', $id)->first();
        
        if ($bidding) {
            // ✅ SUDAH ADA → KE HALAMAN LOG-BIDDING (Preview + Kontrol)
            return $this->redirectRoute('marketing.bidding.log', ['id' => $id], navigate: true);
        } else {
            // ✅ BELUM ADA → KE HALAMAN BIDDING-DETAIL (Form Input)
            return $this->redirectRoute('marketing.bidding.detail', ['id' => $id], navigate: true);
        }
    }

    public function render()
    {
        // 1. Ambil proyek yang RAB-nya udah Approved tapi belum dibikinin Bidding
        $siapBidding = RProject::whereHas('rab', function ($q) {
            $q->where('status_rab', 'approved');
        })->whereDoesntHave('biddings')->get();

        // 2. Ambil histori Bidding dengan relasinya
        $query = Bidding::with('project')->orderBy('created_at', 'desc');

        if (!empty($this->search)) {
            $query->where(function ($q) {
                $q->where('nama_pelanggan_snapshot', 'like', '%' . $this->search . '%')
                  ->orWhere('no_penawaran', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->filterStatus !== 'all') {
            $query->where('status_bidding', $this->filterStatus);
        }

        $daftarBidding = $query->paginate(12);

        return view('livewire.marketing.bidding-index', [
            'siapBidding' => $siapBidding,
            'daftarBidding' => $daftarBidding
        ])->layout('components.layouts.app');
    }
}