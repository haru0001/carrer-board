<template>
  <div>
    <div>
      <h1>ユーザ作成</h1>
      <form @submit.prevent="createUser">
        <div class="form-group">
          <label for="name">Name:</label>
          <input v-model="user.name" />
        </div>
        <div class="form-group">
          <label for="email">Email:</label>
          <input v-model="user.email" />
        </div>
        <div class="form-group">
          <label for="password">Password:</label>
          <input type="password" v-model="user.password" />
        </div>
        <div class="form-group">
          <label for="se_career">キャリア:</label>
          <input v-model="user.se_career" />
        </div>
        <div class="form-group">
          <label for="introduction">自己紹介</label>
          <input v-model="user.introduction" />
        </div>
        <div class="form-group">
          <label for="img_path"></label>
          <input v-model="user.introduction" />
        </div>


        <p><input type="file" v-on:change="fileSelected">></p>
        <button v-on:click="fileUpload">アップロード</button>


        <button type="submit">作成</button>
      </form>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      user: {
        name: "",
        email: "",
        password: "",
        se_career:"",
        introduction:""
      }
    };
  },
  methods: {
    createUser() {
      axios
        .post("/api/user", {
          user: this.user
        })
        .then(response => {
          this.user = response.data.user;
          this.$router.push({ name: "user" });
        })
        .catch(error => console.log(error));
    },

    fileUpload(){
      const formData = new FormData()

      formData.append('file',this.fileInfo)

      axios.post('/api/fileupload',formData).then(response =>{
          console.log(response)
      });
    }    
  }
};
</script>