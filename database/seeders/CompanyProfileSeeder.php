<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CompanyProfile;

class CompanyProfileSeeder extends Seeder
{
    public function run(): void
    {
        CompanyProfile::updateOrCreate(
            ['id' => 1],
            [
                'nama_perusahaan' => 'PT. TRI JAYA TEKNIK KARAWANG',

                'alamat' => 'JL. Alternatif Krajan II Warung Bambu - Karawang Timur',

                'email' => 'pt.tjtk@yahoo.com',

                'telepon' => '(0267) 8615387',

                // Ganti sesuai NPWP asli
                'npwp' => '00.000.000.0-000.000',

                'website' => null,

                // Nama direktur bisa diganti nanti
                'direktur' => 'Fatimah Siti',

                'jabatan_penandatangan' => 'Direktur Utama',

                // simpan path relatif
                'logo' => 'gambar/tjt.png',

                // ISO 9001 atau sertifikasi lain
                'stempel' => null,

                'iso_logo' => 'gambar/iso.png',
            ]
        );
    }
}