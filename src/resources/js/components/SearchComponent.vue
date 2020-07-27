<template>
  <div class="container">
    <div class="vue-simple-suggest-wrapper">
      <!-- スキル追加フォーム -->
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
          <input
            type="text"
            class="form-control"
            placeholder="Search"
            aria-label="Recipient's username"
            aria-describedby="button-addon2"
            autocomplete="off"
            id="carrerSearchForm"
          />
        </div>
      </vue-simple-suggest>
      <!-- TODO スキル検索の時のレベル指定はとりあえず保留　（バージョン１のリリースに間に合うか分からないので） -->
      <!-- TODO バージョンアップに伴い、機能を拡張する時、コメントアウトを解除して機能を実装する -->
      <!-- <div id="skillLevelWrapper">
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
      </div>-->

      <div class="input-group-append">
        <button
          class="btn btn-outline-secondary btn-info"
          type="button"
          id="button-addon2"
          v-on:click="addSearchTag"
        >追加</button>
      </div>
    </div>

    <div>
      <transition-group name="list" tag="p">
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
            clickSearchBtn(index);
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
          <!-- 検索対象のタグを表示する -->
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

  /*todo　背景色の変化でレベル分けを表現するのが簡単だった。*/
}

.vue-simple-suggest-wrapper {
  display: flex;
  justify-content: center;
}
.vue-simple-suggest-form {
  display: inline-block;
  width: 35%;
}
#button-addon2 {
  color: aliceblue;
  font: bolder;
}
#result-list-wrapper {
  display: inline-block; /*todo なぜ親要素のコレがinline-blockじゃないと横に並ばないの？ */
}

/* hamada　アニメーション実験*/
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
/* 追加ボタンのラッパー */
.input-group-append {
  display: inline-block;
  margin: 0 3%;
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
      resultLists: [], //APIから挿入
    };
  },
  methods: {
    creatSearchTag: function () {
      //
    },
    clickSearchBtn: function (index) {
      this.searchWordLists.splice(index, 1);

      //検索スキルを削除したあと、配列が空なら全てのユーザーを表示させる。
      if (this.searchWordLists.length == 0) {
        this.getResult();
        return;
      }

      const data = {
        searchWord: this.searchWordLists,
      };

      axios.post("/api/search_carrer/", data).then((res) => {
        this.resultLists = res.data;
      });
    },
    // 押下した時にサーチして、getResult()を実行する。
    addSearchTag: function () {
      // タグ検索フォームを空にする
      $("#carrerSearchForm").val("");

      //ユーザーが指定したタグを、タグ管理リスト(searchWordLists)に追加
      //画面に選択したスキルTagを表示させるために、配列に格納する
      this.searchWordLists.push(this.selected);

      //JSONでデータのやり取りを行うためにJSON形式にする
      //TODO 本当にこれはJSONか？
      const data = {
        searchWord: this.searchWordLists,
      };

      axios.post("/api/search_carrer/", data).then((res) => {
        // テストのため返り値をコンソールに表示
        this.resultLists = res.data;
        // alert(res.data.success);
        // alert("検索完了");
      });
    },

    getResult() {
      axios.get("/api/show-all-user").then((res) => {
        this.resultLists = res.data; //res.dataで取得。引数に合わせてOK
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
  },
  //mounted()がページを読み込んだ時に行う処理 ※マウントとは、既存のDOM要素をVue.jsが生成するDOM要素で置き換えること。
  mounted() {
    this.getResult();
    this.getSuggestionListTags();
  },
};
</script>
