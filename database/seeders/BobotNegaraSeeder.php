<?php

namespace Database\Seeders;

use App\Models\BobotNegara;
use App\Models\Kriteria;
use App\Models\Negara;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BobotNegaraSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            'Taiwan' => ['Gaji' => 3, 'Biaya Hidup' => 3, 'Budaya' => 4, 'Bahasa' => 3, 'Keamanan' => 5, 'Proses Migrasi' => 3],
            'Hongkong' => ['Gaji' => 3, 'Biaya Hidup' => 2, 'Budaya' => 4, 'Bahasa' => 4, 'Keamanan' => 5, 'Proses Migrasi' => 4],
            'Singapura' => ['Gaji' => 3, 'Biaya Hidup' => 2, 'Budaya' => 5, 'Bahasa' => 5, 'Keamanan' => 5, 'Proses Migrasi' => 4],
            'Jepang' => ['Gaji' => 4, 'Biaya Hidup' => 3, 'Budaya' => 3, 'Bahasa' => 2, 'Keamanan' => 5, 'Proses Migrasi' => 4],
            'Korea Selatan' => ['Gaji' => 5, 'Biaya Hidup' => 3, 'Budaya' => 3, 'Bahasa' => 2, 'Keamanan' => 4, 'Proses Migrasi' => 5],
        ];

        foreach ($data as $negaraName => $nilaiKriteria) {
            $negara = Negara::where('nama', $negaraName)->first();

            foreach ($nilaiKriteria as $namaKriteria => $nilai) {
                $kriteria = Kriteria::whereRaw('LOWER(TRIM(nama)) = ?', [strtolower(trim($namaKriteria))])->first();

                if (!$negara) {
                    dump("❌ Negara $negaraName tidak ditemukan di tabel.");
                }
                if (!$kriteria) {
                    dump("❌ Kriteria $namaKriteria tidak ditemukan.");
                }


                BobotNegara::updateOrCreate([
                    'negara_id' => $negara->id,
                    'kriteria_id' => $kriteria->id,
                ], [
                    'nilai_bobot' => $nilai
                ]);
            }
        }
    }
}
