<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\User;
use App\Tag;
use App\TagMap;


class UserController extends Controller
{

    public function userList(Request $request)
    {
        $users = User::all();

        return response()->json(['users' => $users]);
    }

    public function userCreate(Request $request)
    {
        // $hamada = 12344;
        // dd($hamada);
        // echo '<pre>' . var_export($hamada, true) . '</pre>';

        // dd($request->skills);
        // $user = User::create($request->user);
        // return response()->json(['user' => $user]);
        if (request()->img_path) {
            $file_name = time() . '.' . request()->img_path->getClientOriginalName();
            request()->img_path->storeAs('public/image', $file_name);

            $user = new User();
            $user->img_path = 'image/' . $file_name;
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = $request->password;
            $user->se_career = $request->se_career;
            $user->introduction = $request->introduction;
            $user->save();


            // return ['success' => '登録しました!'];
            //return ['success' => '登録しました!', 'hamada' => $hamada];
        } else {
            $user = new User();
            $user->img_path = null;
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = $request->password;
            $user->se_career = $request->se_career;
            $user->introduction = $request->introduction;
            $user->save();
        }


        //そのユーザーのusersテーブルでのidを取得
        //TODO 同一名のユーザーの存在を考慮していない。これの対処方法を考える必要あり
        $user = User::select('id')->where('name', $request->name)->get();

        info("kroe!");
        info($request->all());

        //test

        // $test = $request->skills[0]["skillName"];
        // $test = $request->skills[0][10];
        // $test = $request->skills[][10];
        // $counterZ = 0;






        //スキルデータの長さ
        // $skillsCount = count($request->skills);

        //オブジェクトが格納されている配列がVueから送られてきているはず。
        $skills = $request->skills;
        $skillsLevel = $request->skillsLevel;
        $test = $request->test;
        $object = $request->object;
        $hamada = $request->hamada;


        // foreach ($skills[0] as $key => $value) {
        //     //
        // }

        // $record[] = Tag::select('id')->where('ct_name', $skills->skillName)->where('ct_level', $skills->skillLevel)->get();
        // $record[] = Tag::select('id')->where('ct_name', $skills[0]['skillName'])->where('ct_level', $skills[0][])->get();
        // $record[] = Tag::select('id')->where('ct_name', $skills[0][0])->get();

        // info($skills);
        // info($skillsLevel);
        // info($test);
        // info($test[0]);
        // info("here");
        // info($object);

        // info("here2");
        // info($hamada);

        //成功への鍵
        // $json = json_encode($test, JSON_PRETTY_PRINT);
        // info($json);


        // logger($user);
        // $record = Tag::select('id')->where('ct_name', $skills[0]->skillName)->where('ct_level', $skills[0]->skillLevel)->get();
        // $record[] = Tag::select('id')->where('ct_name', "PHP")->where('ct_level', 2)->get();
        // return ['success' => '登録しました!'];



        // $record = Tag::select('id')->where('ct_name', "PHP")->where('ct_level', 2)->get();

        // 成功↓
        $record = Tag::select('id')->where('ct_name', "PHP")->where('ct_level', 2)->get();


        // $record[] = Tag::select('id')->where('ct_name', "PHP")->where('ct_level', 2)->first();



        //そのユーザーが追加したいスキルのTagsテーブルでのidを取得
        // foreach ($skills as $skill) {

        //     //tagsテーブルから、そのスキル名とレベルが等しいidのものを取得し、配列に格納
        //     $record[] = Tag::select('id')->where('ct_name', $skill->ct_name)->where('ct_level', $skill->ct_level)->get();
        // }
        $message = ['a' => 1, 'b' => 2, 'c' => 3, 'd' => 223];
        // info($message);
        return ['success' => '登録しました!'];

        //中間テーブルに反映 そのユーザーが追加したいスキルのTagsテーブルでのidを用いる
        for ($i = 0; $i < count($record); $i++) {
            $tagMap = new TagMap();
            $tagMap->user_id = $user[0]["id"];
            // $tagMap->user_id = $user[0];
            $tagMap->tag_id = $record[$i]["id"];
            $tagMap->save();
        }
        return ['success' => '登録しました!'];

        // return response()->json(['msg' => $skills]);
        // return ['success' => '登録しました!'];

        // Tag::select('id')->where('ct_name', $request->skills)->get();
    }

    //ユーザーのスキル情報を中間テーブル(tag_maps)に登録する
    public function skillInfos(Request $request)
    {
        $skillInfos = $request->all();
        $userSkillRecord = [];

        //TODO skillInfos[0]はスキル情報を持たない仕様はスマートではない。中間テーブルを用いた処理をもっと簡単、且つ綺麗にしたい。
        foreach ($skillInfos as $key => $valueAsJson) {
            if ($key == 0) {
                $value = json_decode($valueAsJson, true);
                $userIdRecord = User::select('id')->where('name', $value['name'])->get();
                $userId = $userIdRecord[0]['id'];

                continue; //skillInfos[0]はスキル情報を持たないため
            } else {
                //JSON文字列をデコードする→これをしないと、$hoge['key']のようにして値を取得できない。
                $value = json_decode($valueAsJson, true);

                //各要素をキー（skillName,skillLevel）を元に取得する
                //ここで格納されたレコードは、中間テーブルに反映される
                $userSkill = Tag::select('id')->where('ct_name', $value['skillName'])->where('ct_level', $value['skillLevel'])->get();

                //取得したレコードをキー('id')を元にして、配列に格納
                //foreachが回るたびに、そのユーザーがもっているスキルのTagsテーブルでのidが、配列に格納されていく
                $userSkillRecord[] = $userSkill[0]['id'];
            }
        }

        for ($i = 0; $i < count($userSkillRecord); $i++) {
            $tagMap = new TagMap();
            $tagMap->user_id = $userId;
            $tagMap->tag_id = $userSkillRecord[$i];
            $tagMap->save();
        }

        return ['success' => 'スキル登録完了'];
    }

    public function userDetail(User $user)
    {
        return response()->json(['user' => $user]);
    }



    public function userEdit(User $user, Request $request)
    {
        $user->update($request->user);
        return response()->json(['user' => $user]);
    }

    public function userDelete(User $user)
    {
        $user->delete();
        return response()->json(['message' => 'delete successfully']);
    }

    //検索画面を訪れた際は全てのユーザーを表示する
    public function showAllUsers()
    {

        return User::select('id', 'name', 'se_career', 'introduction', 'img_path')->get();
    }


    //ユーザーのスキルを取得
    //TODO 中間テーブルがデータ不足のため、とりあえず、Tagsテーブルの全てのデータを読み取る   
    //TODO 引数を追加(識別するためのユーザーid情報)
    public function getUserTags()
    {
        return Tag::select('id', 'ct_name', 'ct_level')->get();
    }


    //新規登録や編集画面でのスキル検索
    public function getSuggestionListTags()
    {
        //スキル名の重複を避ける
        $skillTags = Tag::select('id', 'ct_name')->where('ct_level', 1)->get();

        return response()->json(['skillTags' => $skillTags]);
    }

    //新規登録や編集画面でのスキル検索
    public function searchSkills(Request $request)
    {

        $searchWord = $request->searchWord;
        $hamada = $request->hamada;
        info($searchWord);
        info($hamada);

        //TODO DBを検索して、対象のスキルを持ったユーザーをJSONで返す
        return ['success' => $searchWord];
    }



    //test
    public function hamada(Request $request)
    {

        $hamada = $request->hamada;
        info($hamada);

        //TODO DBを検索して、対象のスキルを持ったユーザーをJSONで返す
        return ['success' => "OK"];
    }
    //test
    public function testhamada(Request $request)
    {

        info("これがみたい");
        info($request->all());
        // info($request->title); //成功 キーを元にして値を取得
        // info($request->params[0]); //成功 キーを元にして値を取得


        info($request[0]);
        $arr = json_decode($request[0], true);
        info($arr);
        info($arr['id']);

        // info($request[1]["title"]);
        // info($request[2]);
        // info($lists["title"]);

        //TODO DBを検索して、対象のスキルを持ったユーザーをJSONで返す
        return ['success' => "OK"];
    }
}