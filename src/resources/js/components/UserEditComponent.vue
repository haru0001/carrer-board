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
      <div class="form-row">
        <div class="user-form-left">

          <div class="user-form-left-top">
              <!-- 氏名フォーム -->
              <div class="form-group" id="name-form">
                <label for="name">氏名</label>
                <input v-model="user.name" type="text" class="form-control" placeholder="氏名" readonly>
              </div>

              <!-- エンジニア歴フォーム -->
              <div class="form-group col-md-4" id="se-career-form">
                <label for="se_career">エンジニア歴</label>
                <input v-model="user.se_career" type="text" class="form-control" readonly>
              </div>

          </div>

            <!-- 自己紹介フォーム -->
            <div class="form-group" id="introduction-form">
              <label for="introduction">自己紹介</label>
              <textarea v-model="user.introduction" class="form-control" rows="4" readonly></textarea>
            </div>

        </div>

        <div class="user-form-right">
          <label for="inputEmail4">アイコン</label>
          
          <img v-bind:src="'/storage/'+user.img_path" alt="画像はありません" id="user-image">
        </div>

      </div> 

  </div>
</template>

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
      }
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
  }
};
</script>