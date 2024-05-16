<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MarcasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * php artisan db:seed --class=MarcasTableSeeder
     * 
     * @return void
     */
    public function run()
    {
        $marcas = [
            ['nombre' => 'Renault'],
            ['nombre' => 'Mazda'],
            ['nombre' => 'Hyundai'],
            ['nombre' => 'Kia'],
            ['nombre' => 'Honda'],
            ['nombre' => 'Ford'],
            ['nombre' => 'Toyota'],
            ['nombre' => 'General Motors (Chevrolet, GMC)'],
            ['nombre' => 'Volkswagen (VW)'],
            ['nombre' => 'Nissan'],
        ];

        // Insertar los datos en la tabla 'marcas'
        DB::table('marcas')->insert($marcas);        
    }
}
