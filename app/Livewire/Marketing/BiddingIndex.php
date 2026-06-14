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
        // Arahin ke halaman workspace/detail bidding (nantinya lu bikin route ini)
        return $this->redirectRoute('marketing.bidding.detail', ['id' => $id], navigate: true);
    }

    public function render()
    {
        // 1. Ambil proyek yang RAB-nya udah Approved tapi belum dibikinin Bidding
        $siapBidding = RProject::whereHas('rab', function($q) {
            $q->where('status_rab', 'approved');
        })->whereDoesntHave('biddings')->get();

        // 2. Ambil histori Bidding dengan relasinya [cite: 658-661]
        $query = Bidding::with('project')->orderBy('created_at', 'desc');

        if (!empty($this->search)) {
            $query->where(function($q) {
                $q->where('nama_perusahaan', 'like', '%' . $this->search . '%')
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