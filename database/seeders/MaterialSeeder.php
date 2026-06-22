<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MaterialSeeder extends Seeder
{
    public function run(): void
    {
        // ======================
        // SUPPLIERS
        // ======================
        DB::table('suppliers')->insert([
            [
                'nama_supplier' => 'PT Baja Jaya',
                'telepon' => '081234567890',
                'email' => 'sales@bajajaya.com',
                'alamat' => 'Bandung',
                'pic' => 'Budi',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_supplier' => 'PT Steel Indo',
                'telepon' => '081234567891',
                'email' => 'sales@steelindo.com',
                'alamat' => 'Jakarta',
                'pic' => 'Andi',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_supplier' => 'PT Logam Makmur',
                'telepon' => '081234567892',
                'email' => 'sales@logammakmur.com',
                'alamat' => 'Surabaya',
                'pic' => 'Siti',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

       DB::table('material')->insert([

['nama_barang'=>'Plat SS304 3mm','deskripsi'=>'Plat stainless steel 304 tebal 3 mm','satuan'=>'lembar','jumlah'=>100,'harga'=>1500000,'id_user'=>1,'created_at'=>now(),'updated_at'=>now()],

['nama_barang'=>'Plat SS304 5mm','deskripsi'=>'Plat stainless steel 304 tebal 5 mm','satuan'=>'lembar','jumlah'=>80,'harga'=>2500000,'id_user'=>1,'created_at'=>now(),'updated_at'=>now()],

['nama_barang'=>'Plat Carbon Steel 3mm','deskripsi'=>'Plat baja karbon','satuan'=>'lembar','jumlah'=>120,'harga'=>950000,'id_user'=>1,'created_at'=>now(),'updated_at'=>now()],

['nama_barang'=>'Plat Carbon Steel 6mm','deskripsi'=>'Plat baja karbon','satuan'=>'lembar','jumlah'=>80,'harga'=>1650000,'id_user'=>1,'created_at'=>now(),'updated_at'=>now()],

['nama_barang'=>'Pipa SCH40 1 Inch','deskripsi'=>'Pipa carbon steel','satuan'=>'meter','jumlah'=>300,'harga'=>95000,'id_user'=>1,'created_at'=>now(),'updated_at'=>now()],

['nama_barang'=>'Pipa SCH40 2 Inch','deskripsi'=>'Pipa carbon steel','satuan'=>'meter','jumlah'=>300,'harga'=>175000,'id_user'=>1,'created_at'=>now(),'updated_at'=>now()],

['nama_barang'=>'Pipa Stainless 2 Inch','deskripsi'=>'Pipa stainless steel','satuan'=>'meter','jumlah'=>150,'harga'=>325000,'id_user'=>1,'created_at'=>now(),'updated_at'=>now()],

['nama_barang'=>'Hollow 40x40x2','deskripsi'=>'Hollow baja','satuan'=>'batang','jumlah'=>250,'harga'=>95000,'id_user'=>1,'created_at'=>now(),'updated_at'=>now()],

['nama_barang'=>'Hollow 50x50x2','deskripsi'=>'Hollow baja','satuan'=>'batang','jumlah'=>250,'harga'=>125000,'id_user'=>1,'created_at'=>now(),'updated_at'=>now()],

['nama_barang'=>'UNP 100','deskripsi'=>'Baja kanal U','satuan'=>'batang','jumlah'=>150,'harga'=>450000,'id_user'=>1,'created_at'=>now(),'updated_at'=>now()],

['nama_barang'=>'Siku 50x50','deskripsi'=>'Baja siku','satuan'=>'batang','jumlah'=>200,'harga'=>175000,'id_user'=>1,'created_at'=>now(),'updated_at'=>now()],

['nama_barang'=>'Besi WF 150','deskripsi'=>'Wide Flange','satuan'=>'batang','jumlah'=>80,'harga'=>1450000,'id_user'=>1,'created_at'=>now(),'updated_at'=>now()],

['nama_barang'=>'Roller Conveyor 50mm','deskripsi'=>'Roller conveyor galvanis','satuan'=>'pcs','jumlah'=>300,'harga'=>85000,'id_user'=>1,'created_at'=>now(),'updated_at'=>now()],

['nama_barang'=>'Bearing UCP204','deskripsi'=>'Pillow block bearing','satuan'=>'pcs','jumlah'=>150,'harga'=>120000,'id_user'=>1,'created_at'=>now(),'updated_at'=>now()],

['nama_barang'=>'Bearing UCP205','deskripsi'=>'Pillow block bearing','satuan'=>'pcs','jumlah'=>150,'harga'=>150000,'id_user'=>1,'created_at'=>now(),'updated_at'=>now()],

['nama_barang'=>'Gearbox WPA 70','deskripsi'=>'Gear reducer','satuan'=>'unit','jumlah'=>20,'harga'=>1750000,'id_user'=>1,'created_at'=>now(),'updated_at'=>now()],

['nama_barang'=>'Gearbox WPA 80','deskripsi'=>'Gear reducer','satuan'=>'unit','jumlah'=>15,'harga'=>2450000,'id_user'=>1,'created_at'=>now(),'updated_at'=>now()],

['nama_barang'=>'Motor Listrik 1 HP','deskripsi'=>'Motor induksi 1 HP','satuan'=>'unit','jumlah'=>20,'harga'=>1850000,'id_user'=>1,'created_at'=>now(),'updated_at'=>now()],

['nama_barang'=>'Motor Listrik 2 HP','deskripsi'=>'Motor induksi 2 HP','satuan'=>'unit','jumlah'=>15,'harga'=>2850000,'id_user'=>1,'created_at'=>now(),'updated_at'=>now()],

['nama_barang'=>'Inverter 2.2 kW','deskripsi'=>'Variable frequency drive','satuan'=>'unit','jumlah'=>10,'harga'=>3250000,'id_user'=>1,'created_at'=>now(),'updated_at'=>now()],

['nama_barang'=>'Panel Box 600x800','deskripsi'=>'Panel listrik','satuan'=>'unit','jumlah'=>20,'harga'=>1250000,'id_user'=>1,'created_at'=>now(),'updated_at'=>now()],

['nama_barang'=>'MCB Schneider 3P 32A','deskripsi'=>'MCB industri','satuan'=>'pcs','jumlah'=>100,'harga'=>250000,'id_user'=>1,'created_at'=>now(),'updated_at'=>now()],

['nama_barang'=>'Push Button Start Stop','deskripsi'=>'Komponen panel','satuan'=>'pcs','jumlah'=>100,'harga'=>45000,'id_user'=>1,'created_at'=>now(),'updated_at'=>now()],

['nama_barang'=>'Sensor Proximity','deskripsi'=>'Sensor induktif','satuan'=>'pcs','jumlah'=>80,'harga'=>175000,'id_user'=>1,'created_at'=>now(),'updated_at'=>now()],

['nama_barang'=>'Baut Hex M10','deskripsi'=>'Baut galvanis','satuan'=>'pcs','jumlah'=>10000,'harga'=>2500,'id_user'=>1,'created_at'=>now(),'updated_at'=>now()],

['nama_barang'=>'Baut Hex M12','deskripsi'=>'Baut galvanis','satuan'=>'pcs','jumlah'=>5000,'harga'=>4500,'id_user'=>1,'created_at'=>now(),'updated_at'=>now()],

['nama_barang'=>'Mur M10','deskripsi'=>'Mur baja','satuan'=>'pcs','jumlah'=>10000,'harga'=>800,'id_user'=>1,'created_at'=>now(),'updated_at'=>now()],

['nama_barang'=>'Mur M12','deskripsi'=>'Mur baja','satuan'=>'pcs','jumlah'=>5000,'harga'=>1200,'id_user'=>1,'created_at'=>now(),'updated_at'=>now()],

['nama_barang'=>'Cat Epoxy Industri','deskripsi'=>'Cat epoxy finishing','satuan'=>'kaleng','jumlah'=>50,'harga'=>650000,'id_user'=>1,'created_at'=>now(),'updated_at'=>now()],

['nama_barang'=>'Thinner Industri','deskripsi'=>'Pengencer cat','satuan'=>'kaleng','jumlah'=>50,'harga'=>95000,'id_user'=>1,'created_at'=>now(),'updated_at'=>now()],

]);
        // ======================
        // MATERIAL SUPPLIERS
        // ======================
        DB::table('material_suppliers')->insert([
            [
                'material_id' => 1,
                'supplier_id' => 1,
                'harga' => 1500000,
                'lead_time_hari' => 2,
                'is_preferred' => true,
                'catatan' => 'Supplier utama',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'material_id' => 1,
                'supplier_id' => 2,
                'harga' => 1450000,
                'lead_time_hari' => 5,
                'is_preferred' => false,
                'catatan' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'material_id' => 2,
                'supplier_id' => 1,
                'harga' => 175000,
                'lead_time_hari' => 3,
                'is_preferred' => true,
                'catatan' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'material_id' => 3,
                'supplier_id' => 3,
                'harga' => 2500,
                'lead_time_hari' => 1,
                'is_preferred' => true,
                'catatan' => 'Stok selalu tersedia',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}