<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ProjectCategory;

class ProjectCategorySeeder extends Seeder
{
    public function run(): void
    {
        ProjectCategory::updateOrCreate(
            ['nama_kategori' => 'Fabrication'],
            ['deskripsi' => 'Pembuatan tanki, conveyor, pallet, ducting dan struktur fabrikasi']
        );

        ProjectCategory::updateOrCreate(
            ['nama_kategori' => 'Machining'],
            ['deskripsi' => 'Pengerjaan komponen menggunakan proses bubut, milling dan machining']
        );

        ProjectCategory::updateOrCreate(
            ['nama_kategori' => 'Stamping Part'],
            ['deskripsi' => 'Produksi komponen stamping untuk kebutuhan industri manufaktur']
        );

        ProjectCategory::updateOrCreate(
            ['nama_kategori' => 'Jig & Dies'],
            ['deskripsi' => 'Pembuatan jig, fixture dan dies untuk proses produksi']
        );

        ProjectCategory::updateOrCreate(
            ['nama_kategori' => 'Special Purpose Machine'],
            ['deskripsi' => 'Perancangan dan pembuatan mesin otomatisasi khusus']
        );

        ProjectCategory::updateOrCreate(
            ['nama_kategori' => 'Conveyor System'],
            ['deskripsi' => 'Pembuatan dan instalasi conveyor industri']
        );

        ProjectCategory::updateOrCreate(
            ['nama_kategori' => 'Tank Fabrication'],
            ['deskripsi' => 'Pembuatan tangki stainless steel dan carbon steel']
        );

        ProjectCategory::updateOrCreate(
            ['nama_kategori' => 'Ducting System'],
            ['deskripsi' => 'Pembuatan dan pemasangan ducting industri']
        );

        ProjectCategory::updateOrCreate(
            ['nama_kategori' => 'Electrical Panel'],
            ['deskripsi' => 'Pembuatan panel kontrol dan panel distribusi']
        );

        ProjectCategory::updateOrCreate(
            ['nama_kategori' => 'Civil Project'],
            ['deskripsi' => 'Pekerjaan sipil dan konstruksi pendukung industri']
        );
    }
}