<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Negara;

class NegaraSeeder extends Seeder
{
    public function run()
    {
        $negara = ['Taiwan', 'Hongkong', 'Singapura', 'Jepang', 'Korea Selatan'];

        foreach ($negara as $n) {
            Negara::create(['nama' => $n]);
        }
    }
}