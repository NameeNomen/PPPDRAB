<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ProjectCategory;

class ProjectCategorySeeder extends Seeder
{
    public function run(): void
    {
        ProjectCategory::updateOrCreate(
            ['nama_kategori' => 'Konstruksi Bangunan'],
            ['deskripsi' => 'Proyek pembangunan gedung, rumah, pabrik']
        );

        ProjectCategory::updateOrCreate(
            ['nama_kategori' => 'Fabrikasi Baja'],
            ['deskripsi' => 'Pembuatan struktur baja, kanopi, rangka']
        );

        ProjectCategory::updateOrCreate(
            ['nama_kategori' => 'Instalasi & Maintenance'],
            ['deskripsi' => 'Pemasangan dan perawatan mesin atau sistem']
        );

        ProjectCategory::updateOrCreate(
            ['nama_kategori' => 'Interior & Finishing'],
            ['deskripsi' => 'Pekerjaan finishing dan estetika bangunan']
        );
    }
}