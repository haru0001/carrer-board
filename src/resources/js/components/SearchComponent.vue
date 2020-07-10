<template>

    <div class="container">
        <div class="vue-simple-suggest-wrapper">
            <vue-simple-suggest 
            v-model="selected"
            :min-length="2"
            :list="simpleSuggestionList"
            :filter-by-query="true"
            aria-autocomplete="off"
            v-on:suggestion-click="creatSearchTag"
            class="vue-simple-suggest-form">

            <!--autocomplete="off"でブラウザの予測変換機能を停止。-->
            <!-- <input type="text" id="carrerSearchForm" placeholder="Search" autocomplete="off"> -->
            <!-- <button @click.stop="remove(suggestion)">remove from list</button> -->
            <!-- <b>Selected:</b> {{ selected || "not chosen" }}. -->
            <!-- <button type="button" class="btn btn-info" id="vue-simple-suggest-send-button" v-on:click="addSearchTag">追加</button> -->


            <div class="input-group mb-3">
                <input type="text" class="form-control" placeholder="Search" aria-label="Recipient's username" aria-describedby="button-addon2" id="carrerSearchForm" autocomplete="off">

                <div class="input-group-append">

                    <button class="btn btn-outline-secondary btn-info" type="button" id="button-addon2" v-on:click="addSearchTag">追加</button>
                </div>
            </div>            
            </vue-simple-suggest>

        </div>


        <div>

            <transition-group name="list" tag="p">
                <span v-for="searchWordList in searchWordLists" v-bind:key="searchWordList" class="list-item">
                    <button type="button" class="close" aria-label="Close">
                        <svg class="bi bi-x-circle hama-close" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                            <path fill-rule="evenodd" d="M11.854 4.146a.5.5 0 0 1 0 .708l-7 7a.5.5 0 0 1-.708-.708l7-7a.5.5 0 0 1 .708 0z"/>
                            <path fill-rule="evenodd" d="M4.146 4.146a.5.5 0 0 0 0 .708l7 7a.5.5 0 0 0 .708-.708l-7-7a.5.5 0 0 0-.708 0z"/>
                        </svg>
                            <!-- <span aria-hidden="true" class="close-font">&times;</span> -->
                    </button>
                    <!-- 検索対象のタグを表示する -->
                {{ searchWordList }}
                </span>
            </transition-group>
        </div>


        <div v-for　="resultList in resultLists" id="result-list-wrapper">
            <div class="card" style="width: 18rem;">
                <!-- <img src="image/harumaki.jpeg" class="card-img-top" alt=""> -->
                <!-- v-bind:href="'#' + project.id" -->
                <img v-bind:src="'/storage/'+resultList.img_path" class="card-img-top" alt="画像なし">
                
                <div class="card-body">
                    <h5 class="card-title">{{ resultList.name }}</h5>
                    <p class="card-text">{{ resultList.se_carrer }}</p>
                    <p class="card-text">{{ resultList.introduction }}</p>
                    <router-link :to="`/user/${resultList.id}`" class="btn btn-primary">詳細ページへ</router-link>
                </div>
            </div>


            <!-- ('id','name','se_carrer','introduction','ct_id')->get(); -->
            <!-- <th scope="row">{{ resultList.id }}</th>
            <td>{{ resultList.name }}</td>
            <td>{{ resultList.se_carrer }}</td>
            <td>{{ resultList.introduction }}</td>
            <td>{{ resultList.ct_id }}</td> -->
            <!-- <td>
                <router-link v-bind:to="{name: 'task.show', params: {taskId: resultList.id }}">
                    <button class="btn btn-primary">Show</button>
                </router-link>
            </td>

            <td>
                <button class="btn btn-danger" v-on:click="deleteTask(task.id)">Delete</button>
            </td> -->
        </div>


    </div>
</template>


<style scoped>
.container{
    width: 100%;
    text-align: center;
}



.card{
    display: inline-block;
    width: 25%;
    margin: 20px;
    background-color: cornflowerblue;
   
    /*todo　背景色の変化でレベル分けを表現するのが簡単だった。*/
}


.vue-simple-suggest-wrapper{
    width: 40%;
    height: 100%;
    margin: 50px auto;
    
}
.vue-simple-suggest-form{
    display: inline-block;
    width: 70%;
    height: 100%;
}
#button-addon2{
    color: aliceblue;
    font: bolder;
}
#result-list-wrapper{
    display: inline-block;/*todo なぜ親要素のコレがinline-blockじゃないと横に並ばないの？ */
}

/* hamada　アニメーション実験*/
.bounce-enter-active {
  animation: bounce-in .5s;
}
.bounce-leave-active {
  animation: bounce-in .5s reverse;
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
.selected-tag-with-anime-wrapper{
    width: 100%;
}
.selected-tag-with-anime{
    display: inline-block;
    width:600px;
    padding: 20px;
    font-size: 160%;
    background-color: red;
    border-radius: 15px;

}
/*実験２ */
.list-item {
  display: inline-block;
  position: relative;
  font-size: 200%;
  font:bold;
  padding: 10px 25px;
  background-color: red;
  margin-right: 35px;
  border-radius: 10px;
}
.list-item :hover{
background-color: aqua;
}
.close{
    position: absolute;
    right: -12px;
    top: -12px;
    opacity: 0.2;
    animation: all 5s;
    
}
.hama-close{
    font-size: 120%;
}





.list-enter-active{
  /* transition: all 1s; */
  animation: bounce-in .5s;
}
.list-leave-active {
  animation: bounce-in .5s reverse;
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




</style>

<script src="https://cdnjs.cloudflare.com/ajax/libs/velocity/1.2.3/velocity.min.js"></script>
<script>
import VueSimpleSuggest from 'vue-simple-suggest'
import 'vue-simple-suggest/dist/styles.css'

export default {
  components: {
    VueSimpleSuggest
  },
  data() {
    return {
      selected: null,
      simpleSuggestionList: ['Java','PHP','JavaScript','C++','Ruby','Swift','JavaEE','JDK','VSCode','object-c','TypeScript','Docker','GitHub','AWS','ER図','Python','Azure','aaa'],
      toggle: false,
      searchWordLists:[],
      resultLists:[],//ajaxから挿入
    }
  },
    methods:{
        
        creatSearchTag:function(){
            //
        },
        // 押下した時にサーチして、getResult()を実行する。
        addSearchTag:function(){


            // タグ検索フォームを空にする
            $("#carrerSearchForm").val("");
            
            //ユーザーが指定したタグを、タグ管理リスト(searchWordLists)に追加
            this.searchWordLists.push(this.selected);

            
            // this.items.splice(this.items.length-1, 0,"Java");
            // this.searchWordLists.splice(this.searchWordLists.length-1, 0,this.selected);
            //this.searchWordLists.splice(this.searchWordLists.length-1, 0,'');

            //リストにして渡したらいい感じになると思う。
            //todo リストでコントローラーに渡して、適合する全てのtagのIDを取得すれば、OKなはず。
            //todo　検索タグを、罰ボタンとかで消したら、同じくリストから削除して、再検索すればいい感じになる。
            //その時のアニメーションをなめらか〜にする。
            
            
            axios.get('/api/search_carrer?tag=' + this.searchWordLists)
            
            // axios.get('/api/search_carrer?tag=' + this.selected)

            // this.searchWordListsの中身は配列
            //PHP,Python,AWS,JavaScript


            //.thenで通信が成功したあとの処理を記述している。
            //引数のresは通信の結果、得たもの
            .then((res) => {
                
                this.resultLists = res.data;//res.dataで取得。引数に合わせてOK
            });
        },
        getResult() {
            //パスはLaravelのルータ-に合わせることが出来る
            axios.get('/api/show-all-user')
            //.thenで通信が成功したあとの処理を記述している。
            //引数のresは通信の結果、得たもの
            .then((res) => {
                this.resultLists = res.data;//res.dataで取得。引数に合わせてOK
            });
        },


    },
    //mounted()がページを読み込んだ時に行う処理？※マウントとは、既存のDOM要素をVue.jsが生成するDOM要素で置き換えること。
    mounted() {
        this.getResult();
    }
}

</script>















