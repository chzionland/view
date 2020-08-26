<?php

use App\Author;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class AuthorTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Author::create([
            'admin_id' => '1',
            'name' => ['cn'=>'牟其中', 'en'=>'Qizhong Mou'],
            'slug' => 'qizhong-mou',
            'is_published' => '1',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        Author::create([
            'admin_id' => '1',
            'name' => ['cn'=>'总裁办', 'en'=>"CEO Office"],
            'slug' => 'ceo-office',
            'is_published' => '1',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }
}
