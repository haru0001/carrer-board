<template>
  <div>
    <div>
      <h1>ユーザ詳細</h1>
      <ul>
        <li>User Id: {{ user.id }}</li>
        <li>User Name: {{ user.name }}</li>
        <li>User Email: {{ user.email }}</li>
        <li>User se_career: {{ user.se_career }}</li>
        <li>User introduction: {{ user.introduction }}</li>
      </ul>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      id: this.$route.params.id,
      user: ""
    };
  },
  created() {
    axios
      .get("/api/user/" + this.id)
      .then(response => (this.user = response.data.user))
      .catch(erorr => console.log(error));
  }
};
</script>