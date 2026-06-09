<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\RProject;
use App\Models\RProjectItem;
use App\Models\Material;
use App\Models\RProjectItemMaterial;
use App\Models\MaterialRequest;

class DummyTransactionSeeder extends Seeder
{
    public function run(): void
    {
      
        $project = RProject::create([
            'request_no' => 'PRJ-0001',
            'id_user' => $marketing->id,
            'nama_pelanggan' => 'PT Maju Jaya Teknik',
            'pic_pelanggan' => 'Budi Santoso',
            'no_hp' => '08123456789',
            'deskripsi_proyek' => 'Pembangunan kanopi stainless outdoor area pabrik',
            'target_waktu' => now()->addMonth(),
            'estimasi_budget' => 50000000,
            'priority' => 'high',
            'alamat' => 'Jl. Jendral Sudirman No. 45, Jakarta Pusat',
            'latitude' => -6.208763,
            'longitude' => 106.845599,
            'status_proyek' => 'draft',
            'category_id' => null
        ]);

        // ======================
        // 3. PROJECT ITEM (Marketing input)
        // ======================
        $item = RProjectItem::create([
            'r_project_id' => $project->id,
            'nama_item' => 'Kanopi Stainless Outdoor',
            'qty' => 1,
            'satuan' => 'unit',
            'spesifikasi_klien' => 'Tahan karat, outdoor, minimal grade 304',
            'is_calculated' => false
        ]);

        // ======================
        // 4. MATERIAL MASTER (Purchasing sudah approve)
        // ======================
        $material1 = Material::create([
            'nama_barang' => 'Besi Hollow Stainless 40x40',
            'deskripsi' => 'Stainless steel tahan karat outdoor',
            'satuan' => 'batang',
            'harga' => 120000,
            'supplier' => 'PT Baja Makmur',
            'id_user' => $purchasing->id
        ]);

        $material2 = Material::create([
            'nama_barang' => 'Baut Stainless 304',
            'deskripsi' => 'Baut anti karat untuk outdoor',
            'satuan' => 'pcs',
            'harga' => 2000,
            'supplier' => 'PT Fastener Indonesia',
            'id_user' => $purchasing->id
        ]);

        // ======================
        // 5. RELASI ITEM - MATERIAL
        // ======================
        RProjectItemMaterial::create([
            'project_item_id' => $item->id,
            'material_id' => $material1->id,
            'qty' => 10,
            'satuan' => 'batang',
            'status_kesesuaian' => 'exact_match',
            'catatan_engineering' => 'Sesuai spesifikasi klien'
        ]);

        RProjectItemMaterial::create([
            'project_item_id' => $item->id,
            'material_id' => $material2->id,
            'qty' => 50,
            'satuan' => 'pcs',
            'status_kesesuaian' => 'exact_match',
            'catatan_engineering' => 'OK untuk outdoor'
        ]);

        // ======================
        // 6. MATERIAL REQUEST (contoh belum ada material)
        // ======================
        MaterialRequest::create([
            'nama_material' => 'Plat Stainless Anti Panas 800C',
            'deskripsi' => 'Material khusus tahan suhu tinggi untuk industri',
            'satuan' => 'lembar',
            'status' => 'pending',
            'catatan_purchasing' => null,
            'requested_by' => $engineering->id
        ]);
    }
}