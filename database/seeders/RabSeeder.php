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

        $statuses = [
            'approved',
            'pending',
            'draft',
            'approved',
            'revision',
            'pending'
        ];

        foreach (RProject::with('category')->get() as $index => $project) {

            $rab = Rab::create([
                'id_r_project'   => $project->id,
                'no_boq'         => 'BOQ-2026-' . str_pad($project->id, 3, '0', STR_PAD_LEFT),
                'tgl_boq'        => now()->subDays(rand(1, 30)),
                'overhead_cost'  => rand(5000000, 25000000),
                'grand_total'    => 0,
                'status_rab'     => $statuses[$index] ?? 'draft',
                'id_user'        => $user->id,
            ]);

            $kategoriProject = $project->category?->nama_kategori;

            switch ($kategoriProject) {

                case 'Conveyor System':

                    $this->createCategory(
                        $rab,
                        'PEKERJAAN FABRIKASI CONVEYOR',
                        'Assembly Conveyor',
                        [
                            ['Roller Conveyor 50mm', 100, 85000],
                            ['Bearing UCP205', 20, 150000],
                            ['Gearbox WPA 80', 2, 2450000],
                            ['Motor Listrik 2 HP', 2, 2850000],
                            ['Sensor Proximity', 6, 175000],
                        ]
                    );

                    break;

                case 'Fabrication':

                    $this->createCategory(
                        $rab,
                        'PEKERJAAN FABRIKASI TANKI',
                        'Pembuatan Tanki Stainless',
                        [
                            ['Plat SS304 3mm', 20, 1500000],
                            ['Plat SS304 5mm', 10, 2500000],
                            ['Pipa Stainless 2 Inch', 30, 325000],
                            ['Baut Hex M10', 500, 2500],
                            ['Cat Epoxy Industri', 5, 650000],
                        ]
                    );

                    break;

                case 'Machining':

                    $this->createCategory(
                        $rab,
                        'PEKERJAAN MACHINING',
                        'Machining Shaft',
                        [
                            ['Plat Carbon Steel 6mm', 10, 1650000],
                            ['Bearing UCP204', 10, 120000],
                            ['Baut Hex M12', 100, 4500],
                            ['Mur M12', 100, 1200],
                        ]
                    );

                    break;

                case 'Jig & Dies':

                    $this->createCategory(
                        $rab,
                        'PEKERJAAN JIG & DIES',
                        'Pembuatan Jig Welding',
                        [
                            ['Plat Carbon Steel 3mm', 15, 950000],
                            ['Hollow 40x40x2', 20, 95000],
                            ['Baut Hex M10', 200, 2500],
                            ['Mur M10', 200, 800],
                        ]
                    );

                    break;

                case 'Special Purpose Machine':

                    $this->createCategory(
                        $rab,
                        'PEKERJAAN ASSEMBLY MESIN',
                        'Pembuatan Leak Tester',
                        [
                            ['Motor Listrik 2 HP', 1, 2850000],
                            ['Inverter 2.2 kW', 1, 3250000],
                            ['Panel Box 600x800', 1, 1250000],
                            ['Push Button Start Stop', 4, 45000],
                            ['Sensor Proximity', 8, 175000],
                        ]
                    );

                    break;

                case 'Civil Project':

                    $this->createCategory(
                        $rab,
                        'PEKERJAAN SIPIL',
                        'Pondasi Mesin',
                        [
                            ['Semen Portland 50kg', 50, 72000],
                            ['Pasir Beton', 10, 350000],
                            ['Batu Split', 10, 420000],
                            ['Besi Beton D13', 50, 105000],
                        ]
                    );

                    break;
            }

            $grandTotal = RabItem::where('id_rab', $rab->id)
                ->where('tipe', 'sub-rincian')
                ->sum('subtotal');

            $rab->update([
                'grand_total' => $grandTotal + $rab->overhead_cost
            ]);
        }
    }

    private function createCategory(
        Rab $rab,
        string $categoryName,
        string $itemName,
        array $materials
    ): void {

        $category = RabItem::create([
            'id_rab' => $rab->id,
            'parent_id' => null,
            'tipe' => 'kategori',
            'deskripsi_pekerjaan' => $categoryName,
            'qty' => 0,
            'harga_awal' => 0,
            'subtotal' => 0,
        ]);

        $item = RabItem::create([
            'id_rab' => $rab->id,
            'parent_id' => $category->id,
            'tipe' => 'item',
            'deskripsi_pekerjaan' => $itemName,
            'qty' => 1,
            'harga_awal' => 0,
            'subtotal' => 0,
        ]);

        $itemTotal = 0;

        foreach ($materials as $materialData) {

            $material = Material::where(
                'nama_barang',
                $materialData[0]
            )->first();

            $subtotal = $materialData[1] * $materialData[2];

            RabItem::create([
                'id_rab' => $rab->id,
                'parent_id' => $item->id,
                'tipe' => 'sub-rincian',
                'id_material' => $material?->id,
                'deskripsi_pekerjaan' => $materialData[0],
                'qty' => $materialData[1],
                'harga_awal' => $materialData[2],
                'subtotal' => $subtotal,
            ]);

            $itemTotal += $subtotal;
        }

        $item->update([
            'subtotal' => $itemTotal
        ]);

        $category->update([
            'subtotal' => $itemTotal
        ]);
    }
}