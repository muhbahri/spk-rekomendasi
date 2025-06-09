<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Kriteria;

class KriteriaSeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['nama' => 'Gaji', 'deskripsi' => 'Besaran upah atau pendapatan', 'is_benefit' => true],
            ['nama' => 'Biaya Hidup', 'deskripsi' => 'Biaya kehidupan di negara tujuan', 'is_benefit' => false],
            ['nama' => 'Budaya', 'deskripsi' => 'Kesesuaian budaya bagi PMI', 'is_benefit' => true],
            ['nama' => 'Bahasa', 'deskripsi' => 'Kemudahan dalam memahami bahasa lokal', 'is_benefit' => true],
            ['nama' => 'Keamanan', 'deskripsi' => 'Keamanan dan kestabilan negara', 'is_benefit' => true],
            ['nama' => 'Proses Migrasi', 'deskripsi' => 'Kemudahan proses migrasi dan administrasi', 'is_benefit' => true],
        ];

        foreach ($data as $item) {
            Kriteria::create($item);
        }
    }
}
