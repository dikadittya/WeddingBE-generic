<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\DataProperty;

class DataPropertySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $properties = [
            ['satuan' => 'plong', 'nama' => 'Terop Lorong / VVIP (4x6)'],
            ['satuan' => 'plong', 'nama' => 'Terop VIP (4x6)'],
            ['satuan' => 'plong', 'nama' => 'Terop + Tabir (4x6)'],
            ['satuan' => 'plong', 'nama' => 'Terop Kuncup'],
            ['satuan' => 'pcs', 'nama' => 'Kursi + Cover'],
            ['satuan' => 'pcs', 'nama' => 'Kursi Biasa'],
            ['satuan' => 'pcs', 'nama' => 'Meja + Cover'],
            ['satuan' => 'pcs', 'nama' => 'Kipas Air'],
            ['satuan' => 'pcs', 'nama' => 'Kipas Angin / Blower'],
            ['satuan' => 'pcs', 'nama' => 'Kipas Angin'],
            ['satuan' => 'm', 'nama' => 'Karpet'],
            ['satuan' => 'plong', 'nama' => 'Terop Double Slayer (4x6)'],
        ];

        foreach ($properties as $property) {
            DataProperty::create($property);
        }
    }
}
