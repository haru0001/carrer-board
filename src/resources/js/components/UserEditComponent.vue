<template>
  <div>
    <div>
      <div class="form-row">
        <div class="user-form-left">
          <div class="user-form-left-top">
            <div class="form-group" id="name-form">
              <label for="name">氏名</label>
              <input v-model="user.name" type="text" class="form-control" placeholder="氏名" />
            </div>

            <div class="form-group col-md-4" id="se-career-form">
              <label for="se_career">エンジニア歴</label>
              <!-- <input v-model="user.se_career" type="text" class="form-control" /> -->
              <select v-model="user.se_career" class="form-control" style="width:128%;">
                <!-- TODO 40個用意したいが、直書きを避けたい -->
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
                <option value="6">6</option>
                <option value="7">7</option>
                <option value="8">8</option>
                <option value="9">9</option>
                <option value="10">10</option>
                <option value="11">11</option>
                <option value="12">12</option>
                <option value="13">13</option>
                <option value="14">14</option>
                <option value="15">15</option>
                <option value="16">16</option>
                <option value="17">17</option>
                <option value="18">18</option>
                <option value="19">19</option>
                <option value="20">20</option>
                <option value="21">21</option>
                <option value="22">22</option>
                <option value="23">23</option>
                <option value="24">24</option>
                <option value="25">25</option>
                <option value="26">26</option>
                <option value="28">28</option>
                <option value="29">29</option>
                <option value="30">30</option>
                <option value="31">31</option>
                <option value="32">32</option>
                <option value="33">33</option>
                <option value="34">34</option>
                <option value="35">35</option>
                <option value="36">36</option>
                <option value="37">37</option>
                <option value="38">38</option>
                <option value="39">39</option>
                <option value="40">40</option>
              </select>
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
          <!-- TODO 画像の再アップロード時に、既存の画像が非表示になる現象を解決しないといけない -->
          <div class="content">
            <p>
              <input type="file" v-on:change="imageSelect" />
            </p>
          </div>
        </div>
      </div>

      <div id="submitBtnWrapper">
        <button class="btn btn-success" id="submitBtn" type="button" v-on:click="updateUser">更新</button>
      </div>

      <br />
      <br />
      <hr />
      <br />
      <br />
      <br />

      <!-- ユーザーのスキル一覧 -->
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
              <button class="btn btn-danger" @click="skillDelete(tag.id)">Delete</button>
            </td>
          </tr>
        </tbody>
      </table>

      <br />
      <br />
      <hr />
      <br />
      <br />

      <!-- スキル追加フォーム -->
      <div class="vue-simple-suggest-wrapper">
        <vue-simple-suggest
          v-model="selected"
          :min-length="2"
          :list="simpleSuggestionList"
          :filter-by-query="true"
          aria-autocomplete="off"
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

        <!-- スキル一覧をポップアップするための"i"アイコンを表示 -->
        <svg
          width="1em"
          height="1em"
          viewBox="0 0 16 16"
          class="bi bi-info-square btn"
          fill="currentColor"
          xmlns="http://www.w3.org/2000/svg"
          data-toggle="modal"
          data-target="#exampleModalLong"
          id="btn-primary-skill-list"
        >
          <path
            fill-rule="evenodd"
            d="M14 1H2a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z"
          />
          <path
            d="M8.93 6.588l-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588z"
          />
          <circle cx="8" cy="4.5" r="1" />
        </svg>

        <!-- Modal -->
        <div
          class="modal fade"
          id="exampleModalLong"
          tabindex="-1"
          role="dialog"
          aria-labelledby="exampleModalLongTitle"
          aria-hidden="true"
        >
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">スキル一覧</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <p
                  v-for="skillName in simpleSuggestionList"
                  v-bind:key="skillName.id"
                  id="introductionText"
                >{{ skillName}}</p>
              </div>
              <div class="modal-footer">
                <button
                  type="button"
                  class="btn btn-primary"
                  data-dismiss="modal"
                  id="hama-modal-close-btn"
                >閉じる</button>
              </div>
            </div>
          </div>
        </div>

        <!-- スキルレベル -->
        <div id="skillLevelWrapper">
          <fieldset id="skillLevelFielfset">
            <input
              id="item-1"
              class="radio-inline__input btn-outline-primary input_level_1"
              type="radio"
              name="accessible-radio"
              value="item-1"
              checked="checked"
            />
            <label class="radio-inline__label" for="item-1">1</label>
            <input
              id="item-2"
              class="radio-inline__input input_level_2"
              type="radio"
              name="accessible-radio"
              value="item-2"
            />
            <label class="radio-inline__label" for="item-2">2</label>
            <input
              id="item-3"
              class="radio-inline__input input_level_3"
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

      <br />
      <br />
      <br />

      <div>
        <transition-group name="list" tag="div" class="list-item-wrapper">
          <span
            v-for="(searchWordList,
                                index) in searchWordLists"
            v-bind:key="searchWordList"
            class="list-item"
            :id="wordColorChange(index)"
          >
            <button
              type="button"
              class="close"
              aria-label="Close"
              v-on:click="
                                        searchWordLists.splice(index, 1);
                                        adjustpostSkillData(index);
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
          class="btn btn-success"
          id="registrate-btn"
          data-toggle="tooltip"
          data-placement="top"
          title="スキルを追加"
          v-on:click="postSkillInfos"
        >スキル追加</button>
      </div>
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

.vue-simple-suggest-wrapper {
  display: flex;
  justify-content: center;
  margin-top: 20px;
}

.vue-simple-suggest-form {
  display: inline-block;
  width: 40%;
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
  animation: bounce-in 0.5s;
}
.list-leave-active {
  animation: bounce-in 0.5s reverse;
}
.list-enter,
.list-leave-to {
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
}
#submitBtnWrapper {
  display: flex;
  justify-content: center;
  margin-top: 20px;
}
#submitBtn {
  flex-basis: 20%;
}

.input_level_1:checked + .radio-inline__label {
  color: #fff;
  text-shadow: 0 0 1px rgba(0, 0, 0, 0.7);
  background: #00cc99;
}
.input_level_2:checked + .radio-inline__label {
  color: #fff;
  text-shadow: 0 0 1px rgba(0, 0, 0, 0.7);
  background: lightcoral;
}
.input_level_3:checked + .radio-inline__label {
  color: #fff;
  text-shadow: 0 0 1px rgba(0, 0, 0, 0.7);
  background: #cc9933;
}
#skill-level-1 {
  background-color: #00cc99;
}
#skill-level-2 {
  background-color: lightcoral;
}
#skill-level-3 {
  background-color: #cc9933;
}
#btn-primary-skill-list {
  position: relative;
  right: 2.3rem;
  padding: 6px;
  font-size: 230%;
}
.modal-content {
  text-align: center;
}
#exampleModalLongTitle,
#hama-modal-close-btn {
  display: block;
  margin: 0 auto;
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
      flagEditPicture: false,
      postSkillDeleteData: [],
      simpleSuggestionList: [],
      searchWordLists: [],
      //実行順番を制御しないといけないためにユーザー情報とスキル情報は別に管理する必要があった。そのためにスキル情報を管理する配列を宣言する。
      postSkillData: [
        {
          skillName: "",
          skillLevel: "",
        },
      ],
    };
  },
  methods: {
    updateUser() {
      // 画像ファイルは一度ストレージに保存され、そのパスをDBにて管理する。そのために従来のユーザー情報更新の方法だとうまくいかない。無理やり感はあるが、ユーザー登録と同じロジックで、更新機能を実現する
      // axios;
      // .patch("/api/user/" + this.user.id, {
      //   user: this.user,
      // })
      const formData = new FormData();

      formData.append("id", this.user.id);
      formData.append("img_path", this.user.img_path);
      formData.append("name", this.user.name);
      formData.append("se_career", this.user.se_career);
      formData.append("introduction", this.user.introduction);
      formData.append("flagEditPicture", this.flagEditPicture);

      axios
        .post("/api/user/update", formData)
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
          this.getUserSkills();
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
    imageSelect(event) {
      this.flagEditPicture = true;
      this.user.img_path = event.target.files[0];
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

          //画面を適切にする(スキルの更新,追加スキルの削除)
          this.getUserSkills();
          this.searchWordLists = "";
          this.postSkillData = "";
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
    adjustpostSkillData: function (index) {
      this.postSkillData.splice(index + 1, 1);
    },
    //選択したスキルに応じて、そのスキルの背景色を変化
    wordColorChange: function (index) {
      //postSkillData[0]にはコントローラー側に渡すユーザーの氏名情報が格納させているだけなので、index+1にする必要がある。
      if (this.postSkillData[index + 1]["skillLevel"] == 1) {
        return "skill-level-1";
      } else if (this.postSkillData[index + 1]["skillLevel"] == 2) {
        return "skill-level-2";
      } else if (this.postSkillData[index + 1]["skillLevel"] == 3) {
        return "skill-level-3";
      } else {
        alert("[エラー]ページを再読み込みしてください。");
        return;
      }
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