<?php

use App\Category;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::create([
            'admin_id' => '1',
            'name' => ['cn'=>'未分类', 'en'=>'uncategorized'],
            'slug' => 'uncategorized',
            'is_published' => '1',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        Category::create([
            'admin_id' => '1',
            'name' => ['cn'=>'南德理论', 'en'=>'Land Theory'],
            'slug' => 'land-theory',
            'is_published' => '1',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        Category::create([
            'admin_id' => '1',
            'name' => ['cn'=>'南德往事', 'en'=>'Land History'],
            'slug' => 'land-history',
            'is_published' => '1',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        Category::create([
            'admin_id' => '1',
            'name' => ['cn'=>'万尾鲨鱼苗', 'en'=>'Shark Pups'],
            'slug' => 'shark-pups',
            'is_published' => '1',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        Category::create([
            'admin_id' => '1',
            'name' => ['cn'=>'长江计划', 'en'=>'Yangtze Project'],
            'slug' => 'shark-pups',
            'is_published' => '1',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }
}
