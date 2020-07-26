<?php

use Illuminate\Database\Seeder;
use App\Tag;

class TagsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //開発者側で、ユーザーが選択できるスキルTagを予め用意しておく。
        //TODO ユーザーがスキルTagを自由に追加できるようにする。

        $skillTags = ['Objective-C', 'Holon', 'Kotlin', 'Go', 'Vue.js', 'React', 'Swift', 'TypeScript', 'C言語', 'C++', 'C#', 'VisualBasic']; //追加したいスキル

        //各スキルをレベル1~3まで作成
        foreach ($skillTags as $skillTag) {
            for ($i = 0; $i < 3; $i++) {
                Tag::insert([
                    'ct_name' => $skillTag,
                    'ct_level' => $i + 1,
                    'created_at' => new DateTime(),
                    'updated_at' => new DateTime(),
                ]);
            }
        }


        //カナハルさん作成の古いseeder
        // Tag::insert([
        //     'ct_name' => 'java',
        //     'ct_level' => 1,
        //     'created_at' => new DateTime(),
        //     'updated_at' => new DateTime(),
        // ]);
        // Tag::insert([
        //     'ct_name' => 'java',
        //     'ct_level' => 2,
        //     'created_at' => new DateTime(),
        //     'updated_at' => new DateTime(),
        // ]);
    }
}