<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Rab;
use App\Models\RabItem;
use App\Models\RProject;
use App\Models\User;
use App\Models\Material;

class RabSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::first();
        $material = Material::first();

        $statuses = [
            'approved',
            'pending',
            'draft',
            'approved',
            'revision'
        ];

        foreach (RProject::all() as $index => $project) {

            $rab = Rab::create([
                'id_r_project' => $project->id,
                'no_boq' => 'BOQ-2026-' . str_pad($project->id, 3, '0', STR_PAD_LEFT),
                'tgl_boq' => now()->subDays(rand(1, 30)),
                'overhead_cost' => rand(5000000, 25000000),
                'grand_total' => 0,
                'status_rab' => $statuses[$index] ?? 'draft',
                'id_user' => $user->id
            ]);

            // =============================
            // KATEGORI 1
            // =============================
            $kategori1 = RabItem::create([
                'id_rab' => $rab->id,
                'parent_id' => null,
                'tipe' => 'kategori',
                'deskripsi_pekerjaan' => 'PEKERJAAN SIPIL',
                'qty' => 0,
                'harga_awal' => 0,
                'subtotal' => 0 // Akan diupdate di bawah
            ]);

            $item1 = RabItem::create([
                'id_rab' => $rab->id,
                'parent_id' => $kategori1->id,
                'tipe' => 'item',
                'deskripsi_pekerjaan' => 'Pekerjaan Pondasi',
                'qty' => 1,
                'harga_awal' => 0,
                'subtotal' => 0 // Akan diupdate di bawah
            ]);

            RabItem::create([
                'id_rab' => $rab->id,
                'parent_id' => $item1->id,
                'tipe' => 'sub-rincian',
                'id_material' => $material?->id,
                'deskripsi_pekerjaan' => 'Beton Ready Mix',
                'qty' => 10,
                'harga_awal' => 1200000,
                'subtotal' => 12000000
            ]);

            RabItem::create([
                'id_rab' => $rab->id,
                'parent_id' => $item1->id,
                'tipe' => 'sub-rincian',
                'id_material' => $material?->id,
                'deskripsi_pekerjaan' => 'Besi Tulangan',
                'qty' => 50,
                'harga_awal' => 150000,
                'subtotal' => 7500000
            ]);

            // DYNAMIC UPDATE SUBTOTAL KATEGORI 1 & ITEM 1
            $totalItem1 = RabItem::where('parent_id', $item1->id)->sum('subtotal');
            $item1->update(['subtotal' => $totalItem1]);
            
            // Karena Kategori 1 cuma punya 1 item di seeder ini, totalnya ambil dari item1
            $totalKategori1 = RabItem::where('parent_id', $kategori1->id)->sum('subtotal');
            $kategori1->update(['subtotal' => $totalKategori1]);


            // =============================
            // KATEGORI 2
            // =============================
            $kategori2 = RabItem::create([
                'id_rab' => $rab->id,
                'parent_id' => null,
                'tipe' => 'kategori',
                'deskripsi_pekerjaan' => 'PEKERJAAN FABRIKASI BAJA',
                'qty' => 0,
                'harga_awal' => 0,
                'subtotal' => 0 // Akan diupdate di bawah
            ]);

            $item2 = RabItem::create([
                'id_rab' => $rab->id,
                'parent_id' => $kategori2->id,
                'tipe' => 'item',
                'deskripsi_pekerjaan' => 'Pembuatan Struktur Baja',
                'qty' => 1,
                'harga_awal' => 0,
                'subtotal' => 0 // Akan diupdate di bawah
            ]);

            RabItem::create([
                'id_rab' => $rab->id,
                'parent_id' => $item2->id,
                'tipe' => 'sub-rincian',
                'id_material' => $material?->id,
                'deskripsi_pekerjaan' => 'WF 300',
                'qty' => 100,
                'harga_awal' => 250000,
                'subtotal' => 25000000
            ]);

            RabItem::create([
                'id_rab' => $rab->id,
                'parent_id' => $item2->id,
                'tipe' => 'sub-rincian',
                'id_material' => $material?->id,
                'deskripsi_pekerjaan' => 'Cat Epoxy',
                'qty' => 20,
                'harga_awal' => 500000,
                'subtotal' => 10000000
            ]);

            // DYNAMIC UPDATE SUBTOTAL KATEGORI 2 & ITEM 2
            $totalItem2 = RabItem::where('parent_id', $item2->id)->sum('subtotal');
            $item2->update(['subtotal' => $totalItem2]);

            $totalKategori2 = RabItem::where('parent_id', $kategori2->id)->sum('subtotal');
            $kategori2->update(['subtotal' => $totalKategori2]);


            // Hitung grand total
            $total = RabItem::where('id_rab', $rab->id)
                ->where('tipe', 'sub-rincian')
                ->sum('subtotal');

            $rab->update([
                'grand_total' => $total + $rab->overhead_cost
            ]);

            // Sinkron status project
            if ($rab->status_rab === 'approved') {
                $project->update([
                    'status_proyek' => 'pending'
                ]);
            }
        }
    }
}