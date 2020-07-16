<template>
<div>
  <div>
    <form @submit.prevent="createUser">
      <div class="form-row">
        <div class="user-form-left">

          <div class="user-form-left-top">
              <!-- 氏名フォーム -->
              <div class="form-group" id="name-form">
                <label for="name">氏名</label>
                <input v-model="user.name" type="text" class="form-control" placeholder="氏名">
              </div>

              <!-- エンジニア歴フォーム -->
              <div class="form-group col-md-4" id="se-career-form">
                <label for="se_career">エンジニア歴</label>
                <select v-model="user.se_career" class="form-control" style="width:128%;">
                  <!-- TODO エンジニア歴はどれくらいの区切りを設けるか？ -->
                  <option selected>Choose...</option>
                  <option value="1">1</option>
                  <option value="2">2</option>
                  <option value="3">3</option>
                  <option value="4">4</option>
                  <option value="5">5</option>
                  <option value="6">6~10</option>
                  <option value="7">10~</option>
                </select>
              </div>

          </div>

            <!-- 自己紹介フォーム -->
            <div class="form-group" id="introduction-form">
              <label for="introduction">自己紹介</label>
              <textarea v-model="user.introduction" class="form-control" rows="4" placeholder="（例）フロントエンドが得意です。最近はAWSの勉強をはじめました。"></textarea>
            </div>

        </div>

        <div class="user-form-right">
          <label for="inputEmail4">アイコン</label>
          <img :src="'/image/face2.jpg'" alt="" id="user-image">

          <div id="upload-image-btn-wrapper">
            <!-- TODO アップロードボタンの表示と、アップロード機能の導入 -->
              <div class="content">
                <p><input type="file" v-on:change="imageSelect"></p>
            </div>
          </div>
        </div>
      </div> 
    
      <!-- スキル追加フォーム -->
      <div class="vue-simple-suggest-wrapper">
        <vue-simple-suggest 
        v-model="selected"
        :min-length="2"
        :list="simpleSuggestionList"
        :filter-by-query="true"
        aria-autocomplete="off"
        v-on:suggestion-click="creatSearchTag"
        class="vue-simple-suggest-form">


          <div class="input-group mb-3">
            <div id="carrerSearchFormWrapper">
              <input type="text" class="form-control" placeholder="Search" aria-label="Recipient's username" aria-describedby="button-addon2" id="carrerSearchForm" autocomplete="off">
            </div>

            <div id="skillLevelWrapper">
              <fieldset>
                  <input id="item-1" class="radio-inline__input btn-outline-primary" type="radio" name="accessible-radio" value="item-1" checked="checked"/>
                  <label class="radio-inline__label" for="item-1">
                      1
                  </label>
                  <input id="item-2" class="radio-inline__input" type="radio" name="accessible-radio" value="item-2"/>
                  <label class="radio-inline__label" for="item-2">
                      2
                  </label>
                  <input id="item-3" class="radio-inline__input" type="radio" name="accessible-radio" value="item-3"/>
                  <label class="radio-inline__label" for="item-3">
                      3
                  </label>
              </fieldset>
            </div>


            <div class="input-group-append">
                <button class="btn btn-outline-secondary btn-info" type="button" id="button-addon2" v-on:click="addSearchTag">追加</button>
            </div>
          </div>            
        </vue-simple-suggest>
      </div>


      <!-- 追加するスキルを表示 -->
      <div>
        <transition-group name="list" tag="p">
          <span v-for="(searchWordList,index) in searchWordLists" v-bind:key="searchWordList" class="list-item">
            <button type="button" class="close" aria-label="Close" v-on:click="searchWordLists.splice(index, 1)">
              <svg class="bi bi-x-circle hama-close" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                <path fill-rule="evenodd" d="M11.854 4.146a.5.5 0 0 1 0 .708l-7 7a.5.5 0 0 1-.708-.708l7-7a.5.5 0 0 1 .708 0z"/>
                <path fill-rule="evenodd" d="M4.146 4.146a.5.5 0 0 0 0 .708l7 7a.5.5 0 0 0 .708-.708l-7-7a.5.5 0 0 0-.708 0z"/>
              </svg>
            </button>
          {{ searchWordList }}
          </span>
        </transition-group>
      </div>

      <div id="registrate-btn-wrapper">
        <button type="submit" class="btn btn-primary" id="registrate-btn">登録する</button>  
      </div>
    
    </form>
  </div>
</div>
</template>

<style scoped>

.user-form-left{
display: inline-block;
width: 72%;
}

.user-form-left-top{
display: inline-block;
width: 100%;

}

#name-form{
display: inline-block;
width: 60%;
}



#se-career-form{
display: inline-block;
/* TODO CSS部分でse_career_formのwidthが変更できないのはなぜ？HTMLのタグ内に直接書き込む方法ではきちんと動くのに。 */
/* width: 50%; */
}


#introduction-form{
display: inline-block;
margin-top: 3%;
width: 100%;
}



.user-form-right{
display: inline-block;
width: 23%;
margin-left: 3%;

}

#user-image{
width: 94%;
padding: 1%;
border: 1px solid lightslategray;
}

#upload-image-btn-wrapper{
text-align: center;
}

#upload-image-btn{
width: 70%;
margin: 0 auto;
}

.vue-simple-suggest-wrapper{
  width: 40%;
  height: 100%;
  margin-top: 70px;
}
.vue-simple-suggest-form{
  display: inline-block;
  width: 70%;
  height: 100%;
}


#result-list-wrapper{
  display: inline-block;/*todo なぜ親要素のコレがinline-blockじゃないと横に並ばないの？ */
}

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

.list-item {
display: inline-block;
position: relative;
font-size: 200%;
font:bold;
padding: 10px 25px;
background-color: lightcyan;
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

/* 追加するスキルを検索するフォーム */
.mb-3{
width:300%;
}

/* 追加ボタンのラッパー */
.input-group-append{
display: inline-block;
margin: 0 5%;
width: 10%;
}

#carrerSearchFormWrapper{
display: inline-block;
width: 40%;
}

#button-addon2{
display: inline-block;
color: aliceblue;
font: bolder;
background: green;
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

/* レベル選択のラジオボタンの装飾 */
/* @import url(https://fonts.googleapis.com/css?family=Open+Sans); */

#skillLevelWrapper{
display: inline-block;
width: 20%;
margin: 0 5% 0 10%;
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
  transition: all .2s;
  background-color: lightgrey;
}

.radio-inline__input:checked + .radio-inline__label {
  background: #FF8856;
  color: #fff;
  text-shadow: 0 0 1px rgba(0,0,0,.7);
}

.radio-inline__input:focus + .radio-inline__label {
  outline-color: #4D90FE;
  outline-offset: -2px;
  outline-style: auto;
  outline-width: 5px;
}


#registrate-btn-wrapper{
text-align: center;
margin-top: 100px;
}
#registrate-btn{
display: inline-block;
width: 20%;
font-size: 130%;
}


</style>

<script src="https://cdnjs.cloudflare.com/ajax/libs/velocity/1.2.3/velocity.min.js"></script>

<script>
import VueSimpleSuggest from 'vue-simple-suggest'
import 'vue-simple-suggest/dist/styles.css'
export default {
  components: {
    VueSimpleSuggest
  },

data() {
  return {
    user: {
      name: "",
      email: "",
      password: "",
      se_career:"",
      introduction:"",
      img_path:""
    },
    selected: null,
      simpleSuggestionList: ['Java','PHP','JavaScript','C++','Ruby','Swift','JavaEE','JDK','VSCode','object-c','TypeScript','Docker','GitHub','AWS','ER図','Python','Azure','aaa'],
    toggle: false,
    searchWordLists:[],
  };
},
methods: {
  createUser() {
    const formData = new FormData();

    formData.append('img_path',this.user.img_path);
    formData.append('name', this.user.name);
    formData.append('se_career', this.user.se_career);
    formData.append('introduction', this.user.introduction);
    formData.append('email', this.user.email);
    formData.append('password', this.user.password);
    
    // axios.post('/api/user',formData).then(response =>{
    //     console.log(response)
    // });
    axios
      .post("/api/user", 
          formData
      )
      .then(response => {
        console.log(response.data.success);
        this.img_path = "";
        this.name = "";
        this.se_career = "";
        this.introduction = "";
        this.email = "";
        this.password = "";

        alert("登録しました");
        // location.href="http://localhost:10080/user";
      })
      .catch(error => console.log(error));
  },
  imageSelect(event){
    this.user.img_path = event.target.files[0];
  },
  addSearchTag:function(){
    // タグ検索フォームを空にする
    $("#carrerSearchForm").val("");
    
    //ユーザーが指定したタグを、タグ管理リスト(searchWordLists)に追加
    this.searchWordLists.push(this.selected);
  },
  creatSearchTag:function(){
  //
  },
  mounted: function() {

    
    $('#option1').click(function() {
      $(this).button('toggle')
    });


  }
}
};
</script>