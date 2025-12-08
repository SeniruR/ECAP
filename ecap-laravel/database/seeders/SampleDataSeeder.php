<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SampleDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = now();

        $typeId = DB::table('itemtypes')->updateOrInsert(
            ['name' => 'Default'],
            [
                'inactive_status' => false,
                'short_discription' => 'Default short description',
                'discription' => 'Default full description',
                'updated_at' => $now,
                'created_at' => $now,
            ]
        );

        // updateOrInsert returns boolean; fetch the id explicitly
        $typeNo = DB::table('itemtypes')->where('name', 'Default')->value('no');

        if ($typeNo) {
            DB::table('items')->updateOrInsert(
                ['name' => 'Sample Item'],
                [
                    'short_dis' => 'Short description',
                    'long_dis' => 'Long description',
                    'type' => $typeNo,
                    'inactive_status' => false,
                    'content' => 'Contents',
                    'benefits' => 'Benefits',
                    'trademark' => 'Brand',
                    'price' => 1999.00,
                    'created' => $now,
                    'created_at' => $now,
                    'updated_at' => $now,
                ]
            );

            $itemNo = DB::table('items')->where('name', 'Sample Item')->value('no');

            if ($itemNo) {
                DB::table('itemimages')->updateOrInsert(
                    ['itemno' => $itemNo, 'image' => './images/products/sample1.jpg'],
                    [
                        'created_at' => $now,
                        'updated_at' => $now,
                    ]
                );
            }
        }
    }
}
