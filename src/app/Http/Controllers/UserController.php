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

        $userIdRecord = User::select('id')->where('name', $request->name)->get();
        $userId = $userIdRecord[0]['id'];
        info("taka-si");
        info($userId);

        return response()->json(['userId' => $userId]);
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


    //編集画面での画像再登録機能では、バック側で画像保存のパスを設定しないといけないため、シンプルなこれらのコードを解体し、新しいロジックを導入する必要がある。そのためにコメントアウトする。
    // public function userEdit(User $user, Request $request)
    // {
    //     $user->update($request->user);
    //     return response()->json(['user' => $user]);
    // }
    public function userEdit(Request $request)
    {
        if (request()->img_path) {
            //TODO 古い画像もストレージに溜まっていく一方。削除する処理が必要か？
            $file_name = time() . '.' . request()->img_path->getClientOriginalName();
            request()->img_path->storeAs('public/image', $file_name);

            $img_path =
                'image/' . $file_name;
        } else {
            $img_path = null;
        }

        $update_column = [
            'name' => $request->name,
            'se_career' => $request->se_career,
            'introduction' => $request->introduction,
            'img_path' => $img_path
        ];

        $user = User::select('id', 'name', 'se_career', 'introduction', 'img_path')->where('id', $request->id)->update($update_column);

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

    //検索画面
    public function searchSkills(Request $request)
    {

        $skillInfos = $request->all();
        $searchRecord = [];

        //ユーザーが検索したいワードがあるTagテーブルの中のレコードを取得
        foreach ($skillInfos as $key => $valueAsJson) {
            if ($key == 0) {
                continue; //skillInfos[0]はスキル情報を持たないため Vue側でユーザーが検索スキルを消す動作を実現するために必要
            } else {
                $value = json_decode($valueAsJson, true);
                $userSkill = Tag::select('id')->where('ct_name', $value['skillName'])->where('ct_level', $value['skillLevel'])->get();
                $searchRecord[] = $userSkill[0]['id'];
            }
        }

        //上記で取得したスキルのidを使用して中間テーブルでそれに対応するユーザーIDを取得
        $resultUserId = TagMap::select('user_id')->whereIn('tag_id', $searchRecord)->get();

        //上記で取得したユーザーIDに対応するユーザー情報をUserテーブルから取得
        $result = User::select('id', 'name', 'se_career', 'introduction', 'img_path')->whereIn('id', $resultUserId)->get();

        return $result;
    }
}