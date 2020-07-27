<template>
  <div>
    <!-- 次回のバージョンアップでは認証機能を導入する予定。その時に以下を使う可能性があるのでコメントアウトで残しておきます。 hamada-->
    <!-- 不必要なら削除してOKです hamada -->
    <!-- <div>
      <h1>ユーザ更新</h1>
      <p>User Id: {{ user.id }}</p>
      <form @submit.prevent="updateUser">
        <div class="form-group">
          <label for="name">Name:</label>
          <input v-model="user.name" />
        </div>
        <div class="form-group">
          <label for="email">Email:</label>
          <input v-model="user.email" />
        </div>
        <button type="submit">更新</button>
      </form>
    </div>-->
    <div>
      <form @submit.prevent="updateUser">
        <div class="form-row">
          <div class="user-form-left">
            <div class="user-form-left-top">
              <div class="form-group" id="name-form">
                <label for="name">氏名</label>
                <input v-model="user.name" type="text" class="form-control" placeholder="氏名" />
              </div>

              <div class="form-group col-md-4" id="se-career-form">
                <label for="se_career">エンジニア歴</label>
                <input v-model="user.se_career" type="text" class="form-control" />
              </div>
            </div>

            <div class="form-group" id="introduction-form">
              <label for="introduction">自己紹介</label>
              <textarea v-model="user.introduction" class="form-control" rows="4"></textarea>
            </div>
          </div>

          <div class="user-form-right">
            <label for="inputEmail4">アイコン</label>
            <!-- 画像の有無で表示切り替え -->
            <img v-if="user.img_path === null" :src="'/image/face2.jpg'" alt id="user-image" />
            <img v-else v-bind:src="'/storage/'+user.img_path" alt="画像はありません" id="user-image" />
          </div>
        </div>

        <!-- <button class="btn btn-success" @click="userDelete(index,user.id)">保存する</button> -->
        <!-- TODO  表示位置を変更 -->
        <!-- <button class="btn btn-success" style="flexbox">保存する</button> -->
        <div id="submitBtnWrapper">
          <button class="btn btn-success" id="submitBtn" type="submit">更新</button>
        </div>

        <!-- とりあえずHTMLでレイアウト調整 後で削除 -->
        <br />
        <br />
        <hr />
        <br />
        <br />
        <br />

        <!-- ユーザーのスキル一覧 -->
        <!-- TODO ユーザーのスキル一覧はまだ未完成。Tagsテーブルと接続しないといけない。 -->
        <table class="table table-hover">
          <thead class="thead-light">
            <tr>
              <th scope="col">Skill</th>
              <th scope="col">SkillLevel</th>
              <th scope="col">Delete</th>
            </tr>
          </thead>

          <tbody>
            <tr v-for　="(tag,index) in tags" id="tags-wrapper">
              <td>{{ tag.ct_name}}</td>
              <td>{{ tag.ct_level }}</td>

              <td>
                <!-- TODO あとで改善する。ポップアップの確認画面を作成したが、結局うまくskillDelete(tag.id)が機能しなかった。v-forで回しているはずだけど正しいtag.idの順番の値を取れなかった。 -->
                <button class="btn btn-danger" @click="skillDelete(tag.id)">Delete</button>
              </td>
            </tr>
          </tbody>
        </table>

        <!-- start 目印 -->
        <!--TODO とりあえずHTMLで幅表生  -->
        <br />
        <br />
        <hr />
        <br />
        <br />
        <!-- 追加するスキルを表示 -->
        <!-- スキル追加フォーム -->
        <div class="vue-simple-suggest-wrapper">
          <vue-simple-suggest
            v-model="selected"
            :min-length="2"
            :list="simpleSuggestionList"
            :filter-by-query="true"
            aria-autocomplete="off"
            v-on:suggestion-click="creatSearchTag"
            class="vue-simple-suggest-form"
          >
            <div class="input-group mb-3">
              <div id="carrerSearchFormWrapper">
                <input
                  type="text"
                  class="form-control"
                  placeholder="Search"
                  aria-label="Recipient's username"
                  aria-describedby="button-addon2"
                  id="carrerSearchForm"
                  autocomplete="off"
                />
              </div>
            </div>
          </vue-simple-suggest>
          <div id="skillLevelWrapper">
            <fieldset id="skillLevelFielfset">
              <input
                id="item-1"
                class="radio-inline__input btn-outline-primary"
                type="radio"
                name="accessible-radio"
                value="item-1"
                checked="checked"
              />
              <label class="radio-inline__label" for="item-1">1</label>
              <input
                id="item-2"
                class="radio-inline__input"
                type="radio"
                name="accessible-radio"
                value="item-2"
              />
              <label class="radio-inline__label" for="item-2">2</label>
              <input
                id="item-3"
                class="radio-inline__input"
                type="radio"
                name="accessible-radio"
                value="item-3"
              />
              <label class="radio-inline__label" for="item-3">3</label>
            </fieldset>
          </div>

          <div class="input-group-append">
            <button
              class="btn btn-outline-secondary btn-info"
              type="button"
              id="button-addon2"
              v-on:click="addSearchTag"
            >追加</button>
          </div>
        </div>

        <!--TODO とりあえずHTMLで幅表生  -->
        <br />
        <br />
        <br />
        <!-- 追加するスキルを表示 -->

        <div>
          <transition-group name="list" tag="div" class="list-item-wrapper">
            <span
              v-for="(searchWordList,
                                index) in searchWordLists"
              v-bind:key="searchWordList"
              class="list-item"
            >
              <button
                type="button"
                class="close"
                aria-label="Close"
                v-on:click="
                                        searchWordLists.splice(index, 1)
                                    "
              >
                <svg
                  class="bi bi-x-circle hama-close"
                  width="1em"
                  height="1em"
                  viewBox="0 0 16 16"
                  fill="currentColor"
                  xmlns="http://www.w3.org/2000/svg"
                >
                  <path
                    fill-rule="evenodd"
                    d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"
                  />
                  <path
                    fill-rule="evenodd"
                    d="M11.854 4.146a.5.5 0 0 1 0 .708l-7 7a.5.5 0 0 1-.708-.708l7-7a.5.5 0 0 1 .708 0z"
                  />
                  <path
                    fill-rule="evenodd"
                    d="M4.146 4.146a.5.5 0 0 0 0 .708l7 7a.5.5 0 0 0 .708-.708l-7-7a.5.5 0 0 0-.708 0z"
                  />
                </svg>
              </button>
              {{ searchWordList }}
            </span>
          </transition-group>
        </div>

        <div id="registrate-btn-wrapper">
          <button
            type="button"
            class="btn btn-primary"
            id="registrate-btn"
            data-toggle="tooltip"
            data-placement="top"
            title="スキルを追加"
            v-on:click="postSkillInfos"
          >スキル追加</button>
        </div>

        <!-- end 目印 -->
      </form>
    </div>
  </div>
</template>

<script src="https://cdnjs.cloudflare.com/ajax/libs/velocity/1.2.3/velocity.min.js"></script>
<style scoped>
.user-form-left {
  display: inline-block;
  width: 72%;
}

.user-form-left-top {
  display: inline-block;
  width: 100%;
}

#name-form {
  display: inline-block;
  width: 60%;
}

#se-career-form {
  display: inline-block;
  /* TODO CSS部分でse_career_formのwidthが変更できないのはなぜ？HTMLのタグ内に直接書き込む方法ではきちんと動くのに。 */
  /* width: 50%; */
}

#introduction-form {
  display: inline-block;
  margin-top: 3%;
  width: 100%;
}

.user-form-right {
  display: inline-block;
  width: 23%;
  margin-left: 3%;
}

#user-image {
  width: 94%;
  padding: 1%;
  border: 1px solid lightslategray;
}

#upload-image-btn-wrapper {
  text-align: center;
}

#upload-image-btn {
  width: 70%;
  margin: 0 auto;
}

/* flexboxを使ってみる */
.vue-simple-suggest-wrapper {
  display: flex;
  justify-content: center;
  margin-top: 20px;
}

.vue-simple-suggest-form {
  display: inline-block;
  width: 40%;
}

#result-list-wrapper {
  display: inline-block; /*todo なぜ親要素のコレがinline-blockじゃないと横に並ばないの？ */
}

.bounce-enter-active {
  animation: bounce-in 0.5s;
}
.bounce-leave-active {
  animation: bounce-in 0.5s reverse;
}
@keyframes bounce-in {
  0% {
    transform: scale(0);
  }
  50% {
    transform: scale(1.5);
  }
  100% {
    transform: scale(1);
  }
}
.selected-tag-with-anime-wrapper {
  width: 100%;
}
.selected-tag-with-anime {
  display: inline-block;
  width: 600px;
  padding: 20px;
  font-size: 160%;
  background-color: red;
  border-radius: 15px;
}

.list-item {
  display: inline-block;
  position: relative;
  font-size: 100%;
  font: bold;
  padding: 15px 15px;
  background-color: lightcyan;
  margin-right: 20px;
  margin-top: 10px;
  border-radius: 10px;
}
.list-item :hover {
  background-color: aqua;
}
.close {
  position: absolute;
  right: -12px;
  top: -12px;
  opacity: 0.2;
  animation: all 5s;
}
.hama-close {
  font-size: 120%;
}

/* 追加するスキルを検索するフォーム */
.mb-3 {
  width: 100%;
}

/* 追加ボタンのラッパー */
.input-group-append {
  display: inline-block;
  margin: 0 5%;
  width: 20%;
}

#carrerSearchFormWrapper {
  display: inline-block;
  width: 100%;
}

#button-addon2 {
  display: inline-block;
  color: aliceblue;
  font: bolder;
  background: green;
}

.list-enter-active {
  /* transition: all 1s; */
  animation: bounce-in 0.5s;
}
.list-leave-active {
  animation: bounce-in 0.5s reverse;
}
.list-enter, .list-leave-to /* .list-leave-active for below version 2.1.8 */ {
  opacity: 0;
  transform: translateY(30px);
}
@keyframes bounce-in {
  0% {
    transform: scale(0);
  }
  50% {
    transform: scale(1.5);
  }
  100% {
    transform: scale(1);
  }
}

/* レベル選択のラジオボタンの装飾 */
/* @import url(https://fonts.googleapis.com/css?family=Open+Sans); */

#skillLevelWrapper {
  display: inline-block;
  margin: 0 2%;
}

fieldset {
  display: inline-block;
  border: none;
  text-align: center;
}

.radio-inline__input {
  margin: 0 5px;
  clip: rect(1px, 1px, 1px, 1px);
  position: absolute !important;
}

.radio-inline__label {
  display: inline-block;
  padding: 0.5rem 1rem;
  margin-right: 1px;
  border-radius: 3px;
  transition: all 0.2s;
  background-color: lightgrey;
}

.radio-inline__input:checked + .radio-inline__label {
  background: #ff8856;
  color: #fff;
  text-shadow: 0 0 1px rgba(0, 0, 0, 0.7);
}

.radio-inline__input:focus + .radio-inline__label {
  outline-color: #4d90fe;
  outline-offset: -2px;
  outline-style: auto;
  outline-width: 5px;
}

#registrate-btn-wrapper {
  text-align: center;
  margin-top: 100px;
}
#registrate-btn {
  display: inline-block;
  width: 20%;
  font-size: 130%;
}
#submitBtnWrapper {
  display: flex;
  justify-content: center;
  margin-top: 20px;
}
#submitBtn {
  flex-basis: 20%;
}
</style>

<script>
import VueSimpleSuggest from "vue-simple-suggest";
import "vue-simple-suggest/dist/styles.css";
export default {
  components: {
    VueSimpleSuggest,
  },
  data() {
    return {
      id: this.$route.params.id,
      user: {
        id: "",
        name: "",
        email: "",
        se_career: "",
        introduction: "",
        img_path: "",
      },
      tags: [],
      selected: null,
      postSkillDeleteData: [],
      simpleSuggestionList: [],
      searchWordLists: [],
      //実行順番を制御しないといけないためにユーザー情報とスキル情報は別に管理する必要があった。そのためにスキル情報を管理する配列を宣言する。
      postSkillData: [
        {
          name: "",
          skillName: "",
          skillLevel: "",
        },
      ],
    };
  },
  methods: {
    updateUser() {
      axios
        .patch("/api/user/" + this.user.id, {
          user: this.user,
        })
        .then((response) => {
          this.user = response.data.user;
          //this.$router.pushで画面遷移　同時にparamsも持たせることができる。(便利！)
          this.$router.push({
            name: "user_detail",
            params: { id: this.$route.params.id },
          });
        })
        .catch((error) => console.log(error));
    },
    skillDelete(id) {
      this.postSkillDeleteData.push({
        userId: this.user.id,
        skillId: id,
      });

      axios
        .get("/api/skillDelete/", {
          params: this.postSkillDeleteData,
        })
        .then((response) => {
          this.tags.slice(id, 1);

          //TODO 画面遷移先を編集画面のままにする。
          //画面が詳細画面に遷移してしまうのは、<form @submit.prevent="updateUser">で、
          //           this.$router.push({
          //   name: "user_detail",
          //   params: { id: this.$route.params.id },
          // });
          //してしまっているから。これを変更すると、ユーザー情報を更新したあとも、この画面に留まってしまうことになるので、要相談。
        })
        .catch((error) => console.log(error));
    },
    //ユーザースキルを取得
    getUserSkills() {
      axios
        .get("/api/userSkills/" + this.user.id)
        .then((response) => {
          this.tags = response.data;
        })
        .catch((erorr) => console.log(error));
    },
    creatSearchTag: function () {
      //
    },
    addSearchTag: function () {
      // タグ検索フォームを空にする
      $("#carrerSearchForm").val("");

      //スキルレベルのラジオボタンの値を取得
      var elements = document.getElementsByName("accessible-radio");

      //選択されたレベルをチェック
      var selectSkillLevel = 0;
      if (elements[0].checked == true) {
        selectSkillLevel = 1;
      } else if (elements[1].checked == true) {
        selectSkillLevel = 2;
      } else if (elements[2].checked == true) {
        selectSkillLevel = 3;
      } else {
        alert("レベルを正しく選択してください。");
      }

      //ユーザーが選択したスキル情報を、オブジェクトを内包する配列に格納→Controllerで取り扱いやすくするため
      this.postSkillData.push({
        name: "",
        skillName: this.selected,
        skillLevel: selectSkillLevel,
      });

      //ユーザーが指定したスキルを可視化できるように格納
      this.searchWordLists.push(this.selected);
    },
    //スキル登録
    postSkillInfos() {
      //追加ボタン押下時に、Controller側でDB参照時に使用するユーザー名を、スキル情報を格納するpostSkillDataに格納する
      this.postSkillData[0].name = this.user.name;
      axios
        .get("/api/skillInfos/", {
          params: this.postSkillData,
        })
        .then((response) => {
          alert("スキル登録が完了しました。");
          location.href = "http://localhost:10080/user/" + this.user.id;
        })
        .catch((error) => console.log(error));
    },
    getSuggestionListTags: function () {
      axios.get("/api/getSuggestionListTags").then((res) => {
        var array = res.data.skillTags;

        //JSONで取得したオブジェクトを配列に格納し、検索フォームでサジェスチョンできるようにする。
        for (var key in array) {
          var ct_name = array[key].ct_name;
          this.simpleSuggestionList.push(ct_name);
        }
      });
    },
  },
  created() {
    axios
      .get("/api/user/" + this.id)
      .then((response) => {
        this.user = response.data.user;
        this.getUserSkills();
      })
      .catch((erorr) => console.log(error));

    this.getSuggestionListTags();
  },
};
</script>