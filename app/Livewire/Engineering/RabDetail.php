<?php
namespace App\Livewire\Engineering;

use Livewire\Component;
use App\Models\RProject;
use App\Models\Rab;
use App\Models\DocumentCommit;
use Illuminate\Support\Facades\Auth;

class RabDetail extends Component
{
    public $projectId;
    public $selectedProject;
    public $rabAktif;

    public function mount($id)
    {
        $this->projectId = $id;
        // Ambil data proyek beserta berkas lampirannya
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

    public function render()
    {
        // Ambil data commit versi terakhir untuk keperluan cetak
        $latestCommit = null;
        $latestRevisiComment = null;

        if ($this->rabAktif) {
            $latestCommit = DocumentCommit::where('id_rab', $this->rabAktif->id)->latest()->first();

            // Tangkap instruksi revisi dari Direktur
            $revisi = DocumentCommit::where('id_rab', $this->rabAktif->id)
                ->where('jenis_aksi', 'revised')
                ->latest()
                ->first();
                
            if ($revisi) {
                $latestRevisiComment = $revisi->komentar_commit;
            }
        }

        return view('livewire.engineering.rab-detail', [
            'latestCommit' => $latestCommit,
            'latestRevisiComment' => $latestRevisiComment
        ])->layout('components.layouts.app');
    }
}