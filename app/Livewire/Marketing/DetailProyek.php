<?php

namespace App\Livewire\Marketing;

use Livewire\Component;
use App\Models\RProject;

class DetailProyek extends Component
{
    public $proyek;

    public function mount($id)
    {
        // Ambil data proyek beserta relasinya
        $this->proyek = RProject::with(['category', 'attachments', 'user'])->findOrFail($id);
    }

    public function render()
    {
        return view('livewire.marketing.detail-proyek')->layout('components.layouts.app');
    }
}