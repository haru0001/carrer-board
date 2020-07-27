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


        $skillTags = ['VBScript', 'Clojure', 'F#', 'Elixir', 'Pascal', 'LISP', 'Lua', 'Haskell', 'Groovy', 'ActionScript', 'Smalltalk', 'TypeScript', 'Processing', 'MATLAB', 'Hack', 'Bash', 'Mathematica', 'BASIC', 'Erlang', 'ES6', 'PowerShell', 'FORTRAN', 'shell(C・B・K)', 'JavaScript', 'VBA', 'VisualC', 'VisualC++', 'VisualJ#', 'Visual Basic .NET', 'Visual C# .NET', 'Visual C++ .NET', 'Visual J# .NET', 'ASP.NET', 'Delphi', 'SQL', 'Perl', 'Coldfusion', 'J2EE・J2SE・J2ME', 'JSP', 'EJB・JavaBeans', 'XML', 'Flash', 'ABAP/4', 'COBOL', 'PL/1', 'RPG', 'アセンブラ', 'Scala', 'Go', 'R言語', 'Dart']; //追加したいスキル

        // 注意！！　過去に追加したスキルを以下に明記していく
        //Java,PHP,Ruby,Objective-C ,Holon, Kotlin, Go, Vue.js, React, Swift, TypeScript, C言語, C++, C#, VisualBasic
        //'VBScript', 'Clojure', 'F#', 'Elixir', 'Pascal', 'LISP', 'Lua', 'Haskell', 'Groovy', 'ActionScript', 'Smalltalk', 'TypeScript', 'Processing', 'MATLAB', 'Hack', 'Bash', 'Mathematica', 'BASIC', 'Erlang', 'ES6', 'PowerShell', 'FORTRAN', 'shell(C・B・K)', 'JavaScript', 'VBA', 'VisualC', 'VisualC++', 'VisualJ#', 'Visual Basic .NET', 'Visual C# .NET', 'Visual C++ .NET', 'Visual J# .NET', 'ASP.NET', 'Delphi', 'SQL', 'Perl', 'Coldfusion', 'J2EE・J2SE・J2ME', 'JSP', 'EJB・JavaBeans', 'XML', 'Flash', 'ABAP/4', 'COBOL', 'PL/1', 'RPG', 'アセンブラ', 'Scala', 'Go', 'R言語', 'Dart'

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