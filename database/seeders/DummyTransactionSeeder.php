<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\ProjectCategory;
use App\Models\RProject;
use App\Models\ProjectAttachment;
use App\Models\Rab;
use App\Models\Bidding;
use App\Models\DocumentCommit;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DummyTransactionSeeder extends Seeder
{
    public function run()
    {
        // 1. Ambil User Role
        $mkt = User::where('role', 'marketing')->first();
        $eng = User::where('role', 'engineering')->first();
        $dir = User::where('role', 'direktur')->first();

        if (!$mkt || !$eng || !$dir) {
            $this->command->error('User utama tidak lengkap! Pastikan seeder user sudah jalan.');
            return;
        }

        // 2. Buat Data Kategori Proyek
        $catIT = ProjectCategory::firstOrCreate(['nama_kategori' => 'IT & Networking']);
        $catCCTV = ProjectCategory::firstOrCreate(['nama_kategori' => 'Instalasi Keamanan']);
        $catSipil = ProjectCategory::firstOrCreate(['nama_kategori' => 'Sipil & Konstruksi']);

        // 3. Array Data 9 Proyek (3 Won, 3 Waiting, 3 Lost)
        $dataProyek = [
            // --- 3 PROYEK APPROVED (WON) ---
            ['pt' => 'PT Makmur Jaya', 'pic' => 'Bpk. Andi', 'cat' => $catIT->id, 'budget' => 45000000, 'status' => 'won'],
            ['pt' => 'PT Toyota Motor', 'pic' => 'Ibu Siska', 'cat' => $catSipil->id, 'budget' => 150000000, 'status' => 'won'],
            ['pt' => 'PT Astra Honda', 'pic' => 'Bpk. Budi', 'cat' => $catCCTV->id, 'budget' => 35000000, 'status' => 'won'],
            
            // --- 3 PROYEK MENUNGGU (WAITING) ---
            ['pt' => 'CV Indah Sentosa', 'pic' => 'Ibu Rina', 'cat' => $catIT->id, 'budget' => 20000000, 'status' => 'waiting_rab'],
            ['pt' => 'PT Kencana Wungu', 'pic' => 'Bpk. Joko', 'cat' => $catSipil->id, 'budget' => 85000000, 'status' => 'bidding_process'],
            ['pt' => 'PT Tri Jaya Gemilang', 'pic' => 'Bpk. Eko', 'cat' => $catCCTV->id, 'budget' => 12000000, 'status' => 'waiting_rab'],

            // --- 3 PROYEK KALAH (LOST) ---
            ['pt' => 'PT Pembangunan Jaya', 'pic' => 'Bpk. Dodi', 'cat' => $catSipil->id, 'budget' => 250000000, 'status' => 'lost'],
            ['pt' => 'RS Citra Medika', 'pic' => 'Dr. Ratna', 'cat' => $catCCTV->id, 'budget' => 60000000, 'status' => 'lost'],
            ['pt' => 'Sekolah Global Indo', 'pic' => 'Ibu Tari', 'cat' => $catIT->id, 'budget' => 15000000, 'status' => 'lost'],
        ];

        // 4. Looping Eksekusi Pembuatan Data
        foreach ($dataProyek as $index => $dp) {
            $urutan = $index + 1;
            
            // A. Insert ke r_project 
            $proyek = RProject::create([
                'request_no' => 'REQ/TJT/2026/05/000' . $urutan,
                'id_user' => $mkt->id,
                'category_id' => $dp['cat'],
                'nama_pelanggan' => $dp['pt'],
                'pic_pelanggan' => $dp['pic'],
                'no_hp' => '0812' . rand(10000000, 99999999),
                'deskripsi_proyek' => 'Pekerjaan inisiasi untuk klien ' . $dp['pt'],
                'target_waktu' => Carbon::now()->addDays(30),
                'estimasi_budget' => $dp['budget'],
                'priority' => ($urutan % 3 == 0) ? 'high' : 'medium', // Variasi prioritas
                'status_proyek' => $dp['status'],
                'alamat' => 'Alamat Klien ' . $urutan
            ]);

            // B. Insert Dummy Attachment (Pake nama tabel yang bener)
            ProjectAttachment::create([
                'r_project_id' => $proyek->id,
                'file_name' => 'Dokumen_Pendukung_' . $urutan . '.pdf',
                'file_path' => 'dokumen_proyek/dummy_path_' . $urutan . '.pdf',
                'file_type' => 'pdf'
            ]);

            // C. Logika Pembuatan RAB & Bidding berdasarkan Status
            if ($dp['status'] == 'won') {
                // WON: RAB Approved, Bidding Approved
                $rab = Rab::create([
                    'id_r_project' => $proyek->id, 'id_user' => $eng->id, 'no_boq' => 'BOQ/2026/0' . $urutan,
                    'tgl_boq' => Carbon::now()->subDays(10), 'overhead_cost' => $dp['budget'] * 0.05,
                    'grand_total' => $dp['budget'] * 0.8, 'status_rab' => 'approved'
                ]);
                $bidding = Bidding::create([
                    'id_r_project' => $proyek->id, 'id_user' => $mkt->id, 'no_penawaran' => 'BID/2026/00' . $urutan,
                    'tgl_penawaran' => Carbon::now()->subDays(5), 'nama_perusahaan' => $dp['pt'],
                    'email_perusahaan' => 'client' . $urutan . '@mail.com', 'alamat_perusahaan' => 'Alamat ' . $urutan,
                    'total_penawaran' => $dp['budget'], 'term_of_payment' => 'DP 50%', 'masa_berlaku' => 14,
                    'status_bidding' => 'approved'
                ]);

            } elseif ($dp['status'] == 'lost') {
                // LOST: RAB Approved (udah dihitung), Bidding Rejected (Ditolak klien/kalah tender)
                $rab = Rab::create([
                    'id_r_project' => $proyek->id, 'id_user' => $eng->id, 'no_boq' => 'BOQ/2026/0' . $urutan,
                    'tgl_boq' => Carbon::now()->subDays(15), 'overhead_cost' => $dp['budget'] * 0.05,
                    'grand_total' => $dp['budget'] * 0.8, 'status_rab' => 'approved'
                ]);
                $bidding = Bidding::create([
                    'id_r_project' => $proyek->id, 'id_user' => $mkt->id, 'no_penawaran' => 'BID/2026/00' . $urutan,
                    'tgl_penawaran' => Carbon::now()->subDays(12), 'nama_perusahaan' => $dp['pt'],
                    'email_perusahaan' => 'client' . $urutan . '@mail.com', 'alamat_perusahaan' => 'Alamat ' . $urutan,
                    'total_penawaran' => $dp['budget'], 'term_of_payment' => 'DP 50%', 'masa_berlaku' => 14,
                    'status_bidding' => 'rejected' // KALAH
                ]);

            } elseif ($dp['status'] == 'bidding_process') {
                // MENUNGGU (Bidding Process): RAB Approved, Bidding masih Draft/Sent
                $rab = Rab::create([
                    'id_r_project' => $proyek->id, 'id_user' => $eng->id, 'no_boq' => 'BOQ/2026/0' . $urutan,
                    'tgl_boq' => Carbon::now()->subDays(2), 'overhead_cost' => $dp['budget'] * 0.05,
                    'grand_total' => $dp['budget'] * 0.8, 'status_rab' => 'approved'
                ]);
                $bidding = Bidding::create([
                    'id_r_project' => $proyek->id, 'id_user' => $mkt->id, 'no_penawaran' => 'BID/2026/00' . $urutan,
                    'tgl_penawaran' => Carbon::now()->subDays(1), 'nama_perusahaan' => $dp['pt'],
                    'email_perusahaan' => 'client' . $urutan . '@mail.com', 'alamat_perusahaan' => 'Alamat ' . $urutan,
                    'total_penawaran' => $dp['budget'], 'term_of_payment' => 'DP 50%', 'masa_berlaku' => 14,
                    'status_bidding' => 'draft' // MASIH NUNGGU
                ]);

            } elseif ($dp['status'] == 'waiting_rab') {
                // MENUNGGU (Waiting RAB): RAB masih Pending, Bidding belum ada
                Rab::create([
                    'id_r_project' => $proyek->id, 'id_user' => $eng->id, 'no_boq' => 'BOQ/2026/0' . $urutan,
                    'tgl_boq' => Carbon::now(), 'overhead_cost' => $dp['budget'] * 0.05,
                    'grand_total' => $dp['budget'] * 0.8, 'status_rab' => 'pending'
                ]);
            }
        }

        $this->command->info('Data Dummy sukses: 3 Won, 3 Waiting, 3 Lost. Tabel attachment aman.');
    }
}