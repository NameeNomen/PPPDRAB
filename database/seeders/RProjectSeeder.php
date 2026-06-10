<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\RProject;
use App\Models\User;
use App\Models\ProjectCategory;
use App\Models\ProjectAttachment; // Tambahkan ini untuk akses tabel lampiran
use Faker\Factory as Faker;

class RProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Ambil semua ID user dan kategori untuk mencegah error Foreign Key
        $userIds = User::pluck('id')->toArray();
        $categoryIds = ProjectCategory::pluck('id')->toArray();

        if (empty($userIds) || empty($categoryIds)) {
            $this->command->error('Tabel users atau project_categories masih kosong! Isi dulu ya.');
            return;
        }

        $faker = Faker::create('id_ID');

        // Bikin 5 Proyek Dummy
        for ($i = 1; $i <= 5; $i++) {
            $proyek = RProject::create([
                'request_no'       => 'REQ-' . date('Ymd') . '-' . str_pad($i, 4, '0', STR_PAD_LEFT),
                'id_user'          => $faker->randomElement($userIds),
                'nama_projek'      => 'Proyek ' . $faker->words(3, true),
                'nama_pelanggan'   => $faker->company,
                'pic_pelanggan'    => $faker->name,
                'no_hp'            => $faker->phoneNumber,
                'deskripsi_proyek' => "Catatan Teknis:\n- " . $faker->sentence . "\n- " . $faker->sentence,
                'target_waktu'     => $faker->dateTimeBetween('now', '+6 months')->format('Y-m-d'),
                'estimasi_budget'  => $faker->numberBetween(50000000, 2000000000), // 50 Juta - 2 Miliar
                'priority'         => $faker->randomElement(['low', 'medium', 'high']),
                'alamat'           => $faker->address,
                'status_proyek'    => $faker->randomElement(['pending', 'on_progress', 'completed']),
                'category_id'      => $faker->randomElement($categoryIds),
            ]);

            // === GENERATE LAMPIRAN DUMMY UNTUK PROYEK INI ===
            // Acak mau bikin 1 sampai 3 lampiran per proyek
            $jumlahLampiran = rand(1, 3);
            
            for ($j = 0; $j < $jumlahLampiran; $j++) {
                $tipeFile = $faker->randomElement(['png', 'jpg', 'pdf']);
                $namaAsli = '';

                // Penamaan file agar terlihat realistis seperti kerjaan Engineering
                if ($tipeFile === 'png') {
                    $namaAsli = 'AutoCAD_Blueprint_Tampak_Depan.png';
                } elseif ($tipeFile === 'jpg') {
                    $namaAsli = 'Sketsa_Lapangan_Fabrikasi.jpg';
                } else {
                    $namaAsli = 'Dokumen_Spesifikasi_Material.pdf';
                }

                ProjectAttachment::create([
                    'r_project_id' => $proyek->id,
                    'file_name'    => $namaAsli,
                    // Karena ini data dummy, kita arahkan path-nya ke file bohongan
                    'file_path'    => 'project/dummy_attachment_' . $tipeFile . '.png', 
                    'file_type'    => $tipeFile
                ]);
            }
        }
    }
}