<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductMasterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'product_id' => 1,
                'product_name' => 'Mobile',
                'rate' => '20000.00',
                'unit' => '1',
                'created_at' => '2023-08-26 18:30:00',
                'updated_at' => '2023-08-26 18:30:00',
            ],
            [
                'product_id' => 2,
                'product_name' => 'Laptop',
                'rate' => '50000.00',
                'unit' => '1',
                'created_at' => '2023-08-27 06:56:28',
                'updated_at' => '2023-08-27 06:56:28',
            ],
        ];

        DB::table('product_masters')->insert($data);
    }
}
