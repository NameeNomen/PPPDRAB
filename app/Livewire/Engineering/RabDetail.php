<?PHP
namespace App\Livewire\Engineering;

use Livewire\Component;
use App\Models\RProject;
use App\Models\Rab;
use Illuminate\Support\Facades\Auth; // <-- Ini wajib dipanggil biar sistem tau user yang login

class RabDetail extends Component
{
    public $projectId;
    public $selectedProject;
    public $rabAktif;

    public function mount($id)
    {
        $this->projectId = $id;
        $this->selectedProject = RProject::findOrFail($id);
        $this->rabAktif = Rab::where('id_r_project', $id)->first();
    }

    public function kembaliKeList()
    {
        return $this->redirectRoute('engineering.rab.index', navigate: true);
    }

    public function editRab()
    {
        // Kalau RAB belum pernah dibuat, sistem otomatis bikinin draf kosong
        if (!$this->rabAktif) {
            $rabBaru = Rab::create([
                'id_r_project' => $this->projectId,
                'id_user' => Auth::id() ?? 1, // <-- FIX NYA DI SINI. Kasih tau siapa yang bikin RAB.
                'no_boq' => 'BOQ/' . date('Y/m/d') . '/' . $this->projectId,
                'tgl_boq' => date('Y-m-d'),
                'overhead_cost' => 0,
                'grand_total' => 0,
                'status_rab' => 'draft'
            ]);
            $this->rabAktif = $rabBaru;
        }

        // Langsung gas lempar ke halaman Spreadsheet (Tahap 3)
        return $this->redirectRoute('engineering.rab.workspace', ['id' => $this->projectId], navigate: true);
    }

    public function hapusDokumenRab()
    {
        if ($this->rabAktif) {
            $this->rabAktif->delete();
            $this->rabAktif = null;
            session()->flash('sukses', 'Dokumen RAB beserta historinya udah gue hanguskan dari sistem.');
        }
    }

    public function render()
    {
        return view('livewire.engineering.rab-detail')->layout('components.layouts.app');
    }
}