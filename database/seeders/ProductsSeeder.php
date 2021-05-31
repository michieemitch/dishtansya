<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use DB;


class ProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Product::truncate();


        $items =  [
            [
                'name'  => 'Keyboard',
                'available_stock' => '15',
            ],
            [
                'name'  => 'Mouse',
        	    'available_stock' => '24',
            ],
            [
                'name'  => 'Speaker',
        	    'available_stock' => '5',
            ],
        ];

        Product::insert($items);
    }
}
