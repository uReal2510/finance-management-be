<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('types')->insert([
            [
                'name' => 'Pemasukan', 
                'created_at' => Carbon::now(), 
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Pengeluaran', 
                'created_at' => Carbon::now(), 
                'updated_at' => Carbon::now()
            ],
        ]);
    }
}
