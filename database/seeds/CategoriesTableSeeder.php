<?php

use App\Category;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriesTableSeeder extends Seeder
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
            'name' => ['cn'=>'长江计划', 'en'=>'Rever Development'],
            'slug' => 'rever_development',
            'is_published' => '1',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        Category::create([
            'admin_id' => '2',
            'name' => ['cn'=>'历史档案', 'en'=>'History'],
            'slug' => 'history',
            'is_published' => '1',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        Category::create([
            'admin_id' => '3',
            'name' => ['cn'=>'发射卫星', 'en'=>'Satellite'],
            'slug' => 'satellite',
            'is_published' => '1',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        Category::create([
            'admin_id' => '4',
            'name' => ['cn'=>'换飞机', 'en'=>'Airplane'],
            'slug' => 'airplane',
            'is_published' => '1',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        Category::create([
            'admin_id' => '5',
            'name' => ['cn'=>'鲨鱼苗', 'en'=>'Babyshark'],
            'slug' => 'babyshark',
            'is_published' => '1',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }
}
