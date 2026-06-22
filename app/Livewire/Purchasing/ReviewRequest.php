<?php

namespace App\Livewire\Purchasing;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\MaterialRequest;
use App\Models\Material;
use App\Models\Notification; // Pastikan model ini di-import
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ReviewRequest extends Component
{
    use WithPagination;

    public $detailRequest = null;
    public $isModalOpen = false;
    public $catatan_purchasing = '';

    public function lihatDetail($id)
    {
        $this->detailRequest = MaterialRequest::findOrFail($id);
        $this->catatan_purchasing = $this->detailRequest->catatan_purchasing ?? '';
        $this->isModalOpen = true;
    }

    public function tutupModal()
    {
        $this->isModalOpen = false;
        $this->detailRequest = null;
        $this->catatan_purchasing = '';
    }

    public function setujuiRequest($id)
    {
        $this->validate(['catatan_purchasing' => 'nullable|string|max:1000']);

        $request = MaterialRequest::findOrFail($id);
        
        $request->update([
            'status' => 'approved',
            'catatan_purchasing' => $this->catatan_purchasing
        ]);

        // LOGIKA NOTIFIKASI KE ENGINEERING (Pola yang lu minta)
        $engineer = User::find($request->requested_by);
        if ($engineer) {
            Notification::create([
                'id_user'    => $engineer->id,
                'judul'      => 'Request Material Disetujui',
                'pesan'      => "Silahkan Kembali Kerjakan RAB anda karena Material {$request->nama_material} telah disetujui Purchasing. Catatan: {$this->catatan_purchasing}",
                'url_tujuan' => route('engineering.rab.index'), // Sesuaikan route-nya sama punya lu
                'is_read'    => false,
                'created_at' => now()
            ]);
        }

        $this->tutupModal();
        session()->flash('sukses', 'Request disetujui! Notifikasi terkirim ke Engineer.');
        
        return redirect()->route('purchasing.material-create', ['request_id' => $request->id]);
    }

    public function tolakRequest($id)
    {
        $this->validate([
            'catatan_purchasing' => 'required|string|min:5|max:1000'
        ]);

        $request = MaterialRequest::findOrFail($id);
        
        $request->update([
            'status' => 'rejected',
            'catatan_purchasing' => $this->catatan_purchasing
        ]);

        // LOGIKA NOTIFIKASI KE ENGINEERING (Pola yang lu minta)
        $engineer = User::find($request->requested_by);
        if ($engineer) {
            Notification::create([
                'id_user'    => $engineer->id,
                'judul'      => 'Request Material Ditolak',
                'pesan'      => "Material {$request->nama_material} ditolak. Alasan: {$this->catatan_purchasing}",
                'url_tujuan' => route('engineering.rab.index'), // Sesuaikan route-nya
                'is_read'    => false,
                'created_at' => now()
            ]);
        }

        $this->tutupModal();
        session()->flash('error', 'Request ditolak dan notifikasi terkirim.');
    }

    public function render()
    {
        $requests = MaterialRequest::where('status', 'pending')
            ->orderBy('created_at', 'asc')
            ->paginate(10);

        $countMaterial = Material::count();
        $countRequest = MaterialRequest::where('status', 'pending')->count();

        return view('livewire.purchasing.review-request', compact('requests', 'countMaterial', 'countRequest'))
            ->layout('components.layouts.app');
    }
}