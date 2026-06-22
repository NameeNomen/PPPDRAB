<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\RProject;
use App\Models\ProjectAttachment;
use App\Models\ProjectCategory;
use App\Models\User;

class RProjectSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::first();

        $projects = [

    [
        'request_no' => 'REQ-2026-001',
        'nama_projek' => 'Pembuatan Conveyor Line Assembly',
        'nama_pelanggan' => 'PT Astra Otoparts',
        'kategori' => 'Conveyor System',
        'deskripsi' => 'Pembuatan conveyor line assembly untuk area produksi.',
        'images' => [
            'https://images.unsplash.com/photo-1565008447742-97f6f38c985c',
            'https://images.unsplash.com/photo-1581094794329-c8112a89af12'
        ]
    ],

    [
        'request_no' => 'REQ-2026-002',
        'nama_projek' => 'Fabrikasi Tanki Mixing 5000 Liter',
        'nama_pelanggan' => 'PT Nestle Indonesia',
        'kategori' => 'Fabrication',
        'deskripsi' => 'Pembuatan tanki mixing stainless steel kapasitas 5000 liter.',
        'images' => [
            'https://images.unsplash.com/photo-1513828583688-c52646db42da',
            'https://images.unsplash.com/photo-1509395176047-4a66953fd231'
        ]
    ],

    [
        'request_no' => 'REQ-2026-003',
        'nama_projek' => 'Machining Shaft Conveyor',
        'nama_pelanggan' => 'PT Yamaha Indonesia',
        'kategori' => 'Machining',
        'deskripsi' => 'Pembuatan shaft conveyor menggunakan proses bubut dan milling.',
        'images' => [
            'https://images.unsplash.com/photo-1565793298595-6a879b1d9492',
            'https://images.unsplash.com/photo-1517048676732-d65bc937f952'
        ]
    ],

    [
        'request_no' => 'REQ-2026-004',
        'nama_projek' => 'Pembuatan Jig Welding Frame',
        'nama_pelanggan' => 'PT Denso Indonesia',
        'kategori' => 'Jig & Dies',
        'deskripsi' => 'Pembuatan jig welding untuk proses produksi frame.',
        'images' => [
            'https://images.unsplash.com/photo-1503387762-592deb58ef4e',
            'https://images.unsplash.com/photo-1486406146926-c627a92ad1ab'
        ]
    ],

    [
        'request_no' => 'REQ-2026-005',
        'nama_projek' => 'Automatic Leak Tester Machine',
        'nama_pelanggan' => 'PT Honda Prospect Motor',
        'kategori' => 'Special Purpose Machine',
        'deskripsi' => 'Pembuatan mesin leak tester otomatis untuk quality control.',
        'images' => [
            'https://images.unsplash.com/photo-1581092918056-0c4c3acd3789',
            'https://images.unsplash.com/photo-1581092160607-ee22621dd758'
        ]
    ],

    [
        'request_no' => 'REQ-2026-006',
        'nama_projek' => 'Renovasi Area Produksi',
        'nama_pelanggan' => 'PT Toyota Motor Manufacturing Indonesia',
        'kategori' => 'Civil Project',
        'deskripsi' => 'Renovasi area produksi dan pembangunan pondasi mesin.',
        'images' => [
            'https://images.unsplash.com/photo-1504307651254-35680f356dfd',
            'https://images.unsplash.com/photo-1497366754035-f200968a6e72'
        ]
    ],

];

        foreach ($projects as $item) {

            $category = ProjectCategory::where(
                'nama_kategori',
                $item['kategori']
            )->first();

            $project = RProject::create([
                'request_no' => $item['request_no'],
                'id_user' => $user->id,
                'nama_projek' => $item['nama_projek'],
                'nama_pelanggan' => $item['nama_pelanggan'],
                'pic_pelanggan' => 'Budi Santoso',
                'no_hp' => '081234567890',
                'deskripsi_proyek' => $item['deskripsi'],
                'target_waktu' => now()->addDays(rand(30,120)),
                'estimasi_budget' => rand(100000000,3000000000),
                'priority' => collect(['low','medium','high'])->random(),
                'alamat' => 'Karawang, Jawa Barat',
                'status_proyek' => 'pending',
                'category_id' => $category?->id
            ]);

            foreach ($item['images'] as $index => $image) {

                ProjectAttachment::create([
                    'id_r_project' => $project->id,
                    'file_name' => 'referensi_' . ($index + 1) . '.jpg',
                    'file_path' => $image,
                    'file_type' => 'jpg',
                    'attachment_category' => 'reference_image'
                ]);
            }
        }
    }
}