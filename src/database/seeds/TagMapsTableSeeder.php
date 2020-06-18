<?php

use Illuminate\Database\Seeder;
use App\TagMap;

class TagMapsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TagMap::insert([
            'user_id' => 1,
            'tag_id' => 1,
            'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
        ]);
    }
}
