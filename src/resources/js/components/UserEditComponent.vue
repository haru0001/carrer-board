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
    </div> -->
      <div>
        <form @submit.prevent="createUser">


          <div class="form-row">
            <div class="user-form-left">

              <div class="user-form-left-top">
                  <div class="form-group" id="name-form">
                    <label for="name">氏名</label>
                    <input v-model="user.name" type="text" class="form-control" placeholder="氏名" >
                  </div>

                  <div class="form-group col-md-4" id="se-career-form">
                    <label for="se_career">エンジニア歴</label>
                    <input v-model="user.se_career" type="text" class="form-control" >
                  </div>
              </div>

              <div class="form-group" id="introduction-form">
                <label for="introduction">自己紹介</label>
                <textarea v-model="user.introduction" class="form-control" rows="4" ></textarea>
              </div>

            </div>

            <div class="user-form-right">
              <label for="inputEmail4">アイコン</label>
              <!-- 画像の有無で表示切り替え -->
              <img v-if="user.img_path === null" :src="'/image/face2.jpg'" alt="" id="user-image">
              <img v-else v-bind:src="'/storage/'+user.img_path" alt="画像はありません" id="user-image">
            </div>

          </div> 
          
          <!-- <button class="btn btn-success" @click="userDelete(index,user.id)">保存する</button> -->
          <!-- TODO  表示位置を変更 -->
          <button class="btn btn-success" style="flexbox">保存する</button>

          <!-- ↓後で削除 -->
          <br><br>
          <hr>
          <br><br><br>


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
                  <tr v-for　="tag in tags" id="tags-wrapper">
                      
                      <td>{{ tag.ct_name}}</td>
                      <td>{{ tag.ct_level }}</td>

                      <!-- <td>
                          <router-link :to="`/user/${user.id}`">
                          <router-link>
                              <button class="btn btn-primary">Detail</button>
                          </router-link>
                      </td> -->
                      <td>
                          <button class="btn btn-danger" @click="userDelete(index,user.id)">Delete</button>
                      </td>
                  </tr>
              </tbody>
          </table>

      </form>
    </div>
  </div>
</template>

<script src="https://cdnjs.cloudflare.com/ajax/libs/velocity/1.2.3/velocity.min.js"></script>
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

<script>
export default {
  data() {
    return {
      id: this.$route.params.id,
      user: {
        id: "",
        name: "",
        email: "",
        se_career:"",
        introduction:"",
        img_path:""
      },
      tags: []
    };
  },
  methods: {
    updateUser() {
      axios
        .patch("/api/user/" + this.user.id, {
          user: this.user
        })
        .then(response => {
          this.user = response.data.user;
          this.$router.push({
            name: "user_detail",
            params: { id: this.$route.params.id }
          });
        })
        .catch(error => console.log(error));
    }
  },
  created() {
    axios
      .get("/api/user/" + this.id)
      .then(response => (this.user = response.data.user))
      .catch(erorr => console.log(error));
    
    //ユーザースキルを取得
    //コントローラーからのレスポンスデータを「usersテーブル」と「Tags」テーブルで分けて受け取る方法が不明なので２回axiosを実行する
    //TODO 上記の改善策があればよりシンプルなコードに直す。
    //TODO 中間テーブルがデータ不足のため、とりあえず、Tagsテーブルの全てのデータを読み取る    
    axios
      .get("/api/userTag")
      .then(response => (this.tags = response.data))
      .catch(erorr => console.log(error));
  }
};
</script>