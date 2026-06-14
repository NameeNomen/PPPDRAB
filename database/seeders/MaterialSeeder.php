<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MaterialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('material')->insert([
            [
                'nama_barang' => 'Besi Hollow 4x4',
                'deskripsi'   => 'Material konstruksi untuk rangka kanopi',
                'satuan'      => 'batang',
                'jumlah'      => 100,
                'harga'       => 75000.00,
                'supplier'    => 'PT Baja Jaya',
                'id_user'     => 1, // sesuaikan dengan id user yang ada
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'nama_barang' => 'Semen Portland',
                'deskripsi'   => 'Semen untuk pondasi dan dinding',
                'satuan'      => 'sak',
                'jumlah'      => 50,
                'harga'       => 60000.00,
                'supplier'    => 'PT Semen Indonesia',
                'id_user'     => 1,
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'nama_barang' => 'Pasir Hitam',
                'deskripsi'   => 'Pasir untuk campuran beton',
                'satuan'      => 'kubik',
                'jumlah'      => 20,
                'harga'       => 250000.00,
                'supplier'    => 'CV Pasir Makmur',
                'id_user'     => 1,
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
        ]);
    }
}
