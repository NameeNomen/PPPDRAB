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
                'nama_projek' => 'Pembangunan Gudang Produksi',
                'nama_pelanggan' => 'PT Astra Otoparts',
                'kategori' => 'Konstruksi Bangunan',
                'deskripsi' => 'Pembangunan gudang produksi baru seluas ±1500 m².',
                'images' => [
                    'https://images.unsplash.com/photo-1517048676732-d65bc937f952',
                    'https://images.unsplash.com/photo-1486406146926-c627a92ad1ab'
                ]
            ],

            [
                'request_no' => 'REQ-2026-002',
                'nama_projek' => 'Fabrikasi Struktur Baja Workshop',
                'nama_pelanggan' => 'PT Indomobil',
                'kategori' => 'Fabrikasi Baja',
                'deskripsi' => 'Pembuatan struktur baja workshop bentang 20 meter.',
                'images' => [
                    'https://images.unsplash.com/photo-1504307651254-35680f356dfd',
                    'https://images.unsplash.com/photo-1503387762-592deb58ef4e'
                ]
            ],

            [
                'request_no' => 'REQ-2026-003',
                'nama_projek' => 'Maintenance Conveyor Line',
                'nama_pelanggan' => 'PT Yamaha Indonesia',
                'kategori' => 'Instalasi & Maintenance',
                'deskripsi' => 'Perbaikan conveyor dan gearbox line produksi.',
                'images' => [
                    'https://images.unsplash.com/photo-1565008447742-97f6f38c985c',
                    'https://images.unsplash.com/photo-1581094794329-c8112a89af12'
                ]
            ],

            [
                'request_no' => 'REQ-2026-004',
                'nama_projek' => 'Renovasi Interior Kantor Direksi',
                'nama_pelanggan' => 'PT Denso Indonesia',
                'kategori' => 'Interior & Finishing',
                'deskripsi' => 'Renovasi ruang direktur dan meeting room.',
                'images' => [
                    'https://images.unsplash.com/photo-1497366754035-f200968a6e72',
                    'https://images.unsplash.com/photo-1497366412874-3415097a27e7'
                ]
            ],

            [
                'request_no' => 'REQ-2026-005',
                'nama_projek' => 'Platform Maintenance dan Tangga Akses',
                'nama_pelanggan' => 'PT Nestle Indonesia',
                'kategori' => 'Fabrikasi Baja',
                'deskripsi' => 'Pembuatan platform maintenance galvanis sesuai drawing.',
                'images' => [
                    'https://images.unsplash.com/photo-1513828583688-c52646db42da',
                    'https://images.unsplash.com/photo-1509395176047-4a66953fd231'
                ]
            ]
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