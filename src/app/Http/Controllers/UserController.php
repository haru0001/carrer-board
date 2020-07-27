<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\User;
use App\Tag;
use App\TagMap;
use phpDocumentor\Reflection\DocBlock\Tag as DocBlockTag;

class UserController extends Controller
{

    public function userList(Request $request)
    {
        $users = User::all();

        return response()->json(['users' => $users]);
    }

    public function userCreate(Request $request)
    {

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

        return ['success' => '登録しました!'];
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

    public function skillDelete(Request $request)
    {
        $skillIds = $request->all();
        foreach ($skillIds as $key => $valueAsJson) {
            $value = json_decode($valueAsJson, true);
        }

        TagMap::where('tag_id', $value['skillId'])->where('user_id', $value['userId'])->delete();

        return ['success' => 'スキル削除完了'];
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
    public function getUserSkills($userId)
    {

        $result = TagMap::select('tag_id')->where('user_id', $userId)->get();

        //TODO DBを検索して、対象のスキルを持ったユーザーをJSONで返す
        return
            Tag::select('id', 'ct_name', 'ct_level')->whereIn('id', $result)->get();
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

        //ユーザーが検索したいワードがあるTagテーブルの中のレコードを取得
        $resultSkillsId = Tag::select('id')->whereIn('ct_name', $searchWord)->get();

        //上記で取得したスキルのidを使用して中間テーブルでそれに対応するユーザーIDを取得
        $resultUserId = TagMap::select('user_id')->whereIn('tag_id', $resultSkillsId)->get();

        //上記で取得したユーザーIDに対応するユーザー情報をUserテーブルから取得
        $result = User::select('id', 'name', 'se_career', 'introduction', 'img_path')->whereIn('id', $resultUserId)->get();

        return $result;
    }
}