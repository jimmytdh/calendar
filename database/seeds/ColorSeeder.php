<?php

use Illuminate\Database\Seeder;

class ColorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('colors')->insert([
            'color' => 'yellow',
            'code' => '#f39c12'
        ]);

        DB::table('colors')->insert([
            'color' => 'red',
            'code' => '#f56954'
        ]);

        DB::table('colors')->insert([
            'color' => 'blue',
            'code' => '#0073b7'
        ]);

        DB::table('colors')->insert([
            'color' => 'green',
            'code' => '#00a65a'
        ]);
    }
}
