<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Lot;
use Illuminate\Database\Seeder;

class LotSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories_id = Category::all()->pluck('id');
        $lots = Lot::factory()->count(20)->create();
        $lots->each(function ($lot) use ($categories_id) {
            $lot->categories()->attach($categories_id->random(3));
        });
    }
}
