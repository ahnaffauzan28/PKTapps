<?php

namespace Database\Seeders;

use App\Models\Komparteman;
use App\Models\Kompartemen;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class KompartemenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Array of data to seed
        $kompartemenData = [
            ['kode_kompartemen' => 'D001100000', 'nama_kompartemen' => 'Satuan Pengawasan Intern'],
            ['kode_kompartemen' => 'D001200000', 'nama_kompartemen' => 'Sekretaris Perusahaan'],
            ['kode_kompartemen' => 'D002100000', 'nama_kompartemen' => 'Komp. Operasi I'],
            ['kode_kompartemen' => 'D002200000', 'nama_kompartemen' => 'Komp. Operasi II'],
            ['kode_kompartemen' => 'D002300000', 'nama_kompartemen' => 'Komp. Teknologi'],
            ['kode_kompartemen' => 'D002400000', 'nama_kompartemen' => 'Komp. Pemeliharaan'],
            ['kode_kompartemen' => 'D002500000', 'nama_kompartemen' => 'Jasa Pelayanan Pabrik'],
            ['kode_kompartemen' => 'D003100000', 'nama_kompartemen' => 'Komp. Teknik'],
            ['kode_kompartemen' => 'D003200000', 'nama_kompartemen' => 'Komp. Pengembangan'],
            ['kode_kompartemen' => 'D003300000', 'nama_kompartemen' => 'Komp. Pengadaan'],
            ['kode_kompartemen' => 'D004100000', 'nama_kompartemen' => 'Komp. Pemasaran PSO'],
            ['kode_kompartemen' => 'D004200000', 'nama_kompartemen' => 'Komp. Pemasaran Non PSO'],
            ['kode_kompartemen' => 'D004300000', 'nama_kompartemen' => 'SEVP Komersil'],
            ['kode_kompartemen' => 'D004400000', 'nama_kompartemen' => 'Komp. Administrasi Keuangan'],
            ['kode_kompartemen' => 'D006100000', 'nama_kompartemen' => 'Komp. SDM'],
            ['kode_kompartemen' => 'D006200000', 'nama_kompartemen' => 'Komp. Umum'],
            ['kode_kompartemen' => 'D00001', 'nama_kompartemen' => 'Proyek Pengembangan Infrastruktur'],
            ['kode_kompartemen' => 'D002600000', 'nama_kompartemen' => 'Kepala Shift'],
            ['kode_kompartemen' => 'D002700000', 'nama_kompartemen' => 'Komp. Investasi & Pengembangan'],
            ['kode_kompartemen' => 'D002800000', 'nama_kompartemen' => 'Komp. Teknik & ICT'],
            ['kode_kompartemen' => 'D002900000', 'nama_kompartemen' => 'Komp. Pengadaan'],
            ['kode_kompartemen' => 'D002D00000', 'nama_kompartemen' => 'Proyek Pengembangan Bio Fertilizer'],
            ['kode_kompartemen' => 'D002G00000', 'nama_kompartemen' => 'Proyek Amonium Nitrat'],
            ['kode_kompartemen' => 'D003500000', 'nama_kompartemen' => 'Komp. SDM'],
            ['kode_kompartemen' => 'D003600000', 'nama_kompartemen' => 'Komp. Umum'],
            ['kode_kompartemen' => 'D008100000', 'nama_kompartemen' => 'Komp Transformasi Bisnis'],
            ['kode_kompartemen' => 'D007000013', 'nama_kompartemen' => 'Proyek CCM'],
            ['kode_kompartemen' => 'D007000014', 'nama_kompartemen' => 'Proyek Agrosolution'],
            ['kode_kompartemen' => 'D007020226', 'nama_kompartemen' => 'Proyek Pabrik Amurea Bintuni'],
            ['kode_kompartemen' => 'D00009', 'nama_kompartemen' => 'Proyek Pembangunan Sarana Bahan Baku'],
            ['kode_kompartemen' => 'D007020227', 'nama_kompartemen' => 'Tim Proyek IPO PKT'],
            ['kode_kompartemen' => 'D00002', 'nama_kompartemen' => 'Proyek NPK'],
            ['kode_kompartemen' => 'D007000008', 'nama_kompartemen' => 'Tim Transformasi Digital'],
            ['kode_kompartemen' => 'D670110001', 'nama_kompartemen' => 'Tim Adhoc RTRW PKT'],
            ['kode_kompartemen' => 'D002K00000', 'nama_kompartemen' => 'Proyek Soda Ash'],
            ['kode_kompartemen' => 'D00004', 'nama_kompartemen' => 'Proyek Go Pupuk'],
            
        ];

        // Loop through the data and create each record
        foreach ($kompartemenData as $data) {
            Komparteman::create([
        
                'kode_kompartemen' => $data['kode_kompartemen'],
                'nama_kompartemen' => $data['nama_kompartemen'],
            ]);
        }
    }
}
