<?php
namespace App\Livewire\Engineering;

use Livewire\Component;
use App\Models\RProject;
use App\Models\Rab;
use Illuminate\Support\Facades\Auth;

class RabDetail extends Component
{
    public $projectId;
    public $selectedProject;
    public $rabAktif;

    public function mount($id)
    {
        $this->projectId = $id;
        // Bawa relasi attachment biar panel kiri lu bisa nampilin lampiran marketing
        $this->selectedProject = RProject::with('attachments')->findOrFail($id);
        $this->rabAktif = Rab::where('id_r_project', $id)->first();
    }

    public function kembaliKeList()
    {
        return $this->redirectRoute('engineering.rab.index', navigate: true);
    }

    public function editRab()
    {
        if (!$this->rabAktif) {
            $rabBaru = Rab::create([
                'id_r_project'  => $this->projectId,
                'id_user'       => Auth::id() ?? 1,
                'no_boq'        => 'BOQ/' . date('Y/m/d') . '/' . $this->projectId,
                'tgl_boq'       => date('Y-m-d'),
                'overhead_cost' => 0,
                'grand_total'   => 0,
                'status_rab'    => 'draft'
            ]);
            $this->rabAktif = $rabBaru;
        }

        return $this->redirectRoute('engineering.rab.workspace', ['id' => $this->projectId], navigate: true);
    }

    public function hapusDokumenRab()
    {
        if ($this->rabAktif) {
            $this->rabAktif->delete();
            $this->rabAktif = null;
            session()->flash('sukses', 'Dokumen RAB berhasil dihapus.');
        }
    }

    public function render()
    {
        return view('livewire.engineering.rab-detail')->layout('components.layouts.app');
    }
}
