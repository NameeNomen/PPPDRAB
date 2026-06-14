<?php
namespace App\Livewire\Purchasing;

use Livewire\Component;
use App\Models\RProject; // Asumsi nama model dari tabel r_project
use Livewire\WithPagination;

class ReviewRequest extends Component
{
    use WithPagination;

    public $detailRequest = null;
    public $isModalOpen = false;

    // Buka detail untuk di-review
    public function lihatDetail($id)
    {
        // Load data berserta file attachment-nya
        $this->detailRequest = RProject::with('attachments', 'engineer')->findOrFail($id);
        $this->isModalOpen = true;
    }

    public function tutupModal()
    {
        $this->isModalOpen = false;
        $this->detailRequest = null;
    }

    public function setujuiRequest($id)
    {
        $request = RProject::findOrFail($id);
        $request->update(['status' => 'approved_by_purchasing']);
        
        // Opsional: Kirim notifikasi balik ke Engineering
        
        $this->tutupModal();
        session()->flash('sukses', 'Request material berhasil disetujui. Siap untuk proses PO.');
    }

    public function tolakRequest($id)
    {
        $request = RProject::findOrFail($id);
        $request->update(['status' => 'rejected']);
        
        $this->tutupModal();
        session()->flash('error', 'Request dikembalikan ke Engineering.');
    }

    public function render()
    {
        // Ambil request yang butuh diproses purchasing
        $requests = RProject::whereIn('status', ['pending', 'submitted'])
                            ->orderBy('created_at', 'asc')
                            ->paginate(10);

        return view('livewire.purchasing.review-request', compact('requests'))
               ->layout('components.layouts.app');
    }
}