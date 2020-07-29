<template>
  <div class="container">
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
        >検索</button>
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

    <div v-for　="resultList in resultLists" id="result-list-wrapper">
      <div class="card" style="width: 12rem;">
        <!-- 画像の有無で表示切り替え -->
        <img v-if="resultList.img_path === null" :src="'/image/face2.jpg'" class="card-img-top" />
        <img v-else v-bind:src="'/storage/' + resultList.img_path" class="card-img-top" />

        <div class="card-body">
          <h5 class="card-title">{{ resultList.name }}</h5>
          <!-- 余計なユーザー情報は削除 -->
          <!-- <p class="card-text">{{ resultList.se_carrer }}</p> -->
          <!-- <p class="card-text">{{ resultList.introduction }}</p> -->
          <router-link :to="`/user/${resultList.id}`" class="btn btn-primary">詳細ページへ</router-link>
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped>
.container {
  width: 100%;
  text-align: center;
}

.card {
  display: inline-block;
  width: 25%;
  margin: 20px;
  background-color: cornflowerblue;
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
#button-addon2 {
  color: aliceblue;
  font: bolder;
}
#result-list-wrapper {
  display: inline-block;
}

/* アニメーション*/
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

/* サーチ単語のアニメーション */
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

/* 追加ボタンのラッパー */
.input-group-append {
  display: inline-block;
  margin: 0 2%;
  width: 10%;
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
.radio-inline__input {
  margin: 0 5px;
  clip: rect(1px, 1px, 1px, 1px);
  position: absolute !important;
}
#skillLevelWrapper {
  display: inline-block;
  margin: 0 2%;
}
/* 追加するスキルを検索するフォーム */
.mb-3 {
  width: 100%;
}
#carrerSearchFormWrapper {
  display: inline-block;
  width: 100%;
}
</style>

<script src="https://cdnjs.cloudflare.com/ajax/libs/velocity/1.2.3/velocity.min.js"></script>
<script>
import VueSimpleSuggest from "vue-simple-suggest";
import "vue-simple-suggest/dist/styles.css";

export default {
  components: {
    VueSimpleSuggest,
  },
  data() {
    return {
      selected: null,
      simpleSuggestionList: [],
      toggle: false,
      searchWordLists: [],
      resultLists: [],
      postSkillData: [
        {
          skillName: "",
          skillLevel: "",
        },
      ],
    };
  },
  methods: {
    adjustpostSkillData: function (index) {
      this.postSkillData.splice(index + 1, 1);

      //検索スキルを削除したあと、配列が空なら全てのユーザーを表示させる。
      if (this.searchWordLists.length == 0) {
        this.getResult();
        return;
      }

      axios
        .get("/api/search_carrer/", {
          params: this.postSkillData,
        })
        .then((res) => {
          this.resultLists = res.data;
        })
        .catch((error) => console.log(error));
    },

    //押下した時に検索を実行する
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

      this.postSkillData.push({
        skillName: this.selected,
        skillLevel: selectSkillLevel,
      });

      //画面に選択したスキルTagを表示させるために、配列に格納する
      this.searchWordLists.push(this.selected);
      axios
        .get("/api/search_carrer/", {
          params: this.postSkillData,
        })
        .then((res) => {
          this.resultLists = res.data;
        })
        .catch((error) => console.log(error));
    },

    getResult() {
      axios.get("/api/show-all-user").then((res) => {
        this.resultLists = res.data;
      });
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
    //選択したスキルに応じて、そのスキルの背景色を変化
    wordColorChange: function (index) {
      if (this.postSkillData.length == 0) {
        return;
      }
      //this.postSkillData[0]には何も格納されていない→コントローラー側の都合のため
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
  mounted() {
    this.getResult();
    this.getSuggestionListTags();
  },
};
</script>
