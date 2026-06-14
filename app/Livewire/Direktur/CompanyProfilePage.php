<?php

namespace App\Livewire\Direktur;

use Livewire\Component;
use App\Models\CompanyProfile;

class CompanyProfilePage extends Component
{
    public $nama_perusahaan;
    public $alamat;
    public $email;
    public $telepon;
    public $npwp;
    public $website;
    public $direktur;
    public $jabatan_penandatangan = 'Direktur';

    public function mount()
    {
        $company = CompanyProfile::first();

        if ($company) {
            $this->fill($company->toArray());
        }
    }

    public function simpan()
    {
        $this->validate([
            'nama_perusahaan' => 'required',
            'alamat' => 'required',
        ]);

        CompanyProfile::updateOrCreate(
            ['id' => 1],
            [
                'nama_perusahaan' => $this->nama_perusahaan,
                'alamat' => $this->alamat,
                'email' => $this->email,
                'telepon' => $this->telepon,
                'npwp' => $this->npwp,
                'website' => $this->website,
                'direktur' => $this->direktur,
                'jabatan_penandatangan' => $this->jabatan_penandatangan,
            ]
        );

        session()->flash('sukses', 'Profil perusahaan berhasil disimpan.');
    }

    public function render()
    {
        return view('livewire.direktur.company-profile-page')
            ->layout('components.layouts.app');
    }
}