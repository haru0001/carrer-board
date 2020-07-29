<template>
  <div>
    <table class="table table-hover">
      <thead class="thead-light">
        <tr>
          <th scope="col">Name</th>
          <th scope="col">SE</th>
          <th scope="col">Detail</th>
          <th scope="col">Edit</th>
          <th scope="col">Delete</th>
        </tr>
      </thead>

      <tbody>
        <tr v-for="user in users" v-bind:key="user.id" id="introductionText">
          <th scope="row">{{ user.name }}</th>
          <td>{{ user.se_career }}</td>
          <td>
            <router-link :to="`/user/${user.id}`">
              <button class="btn btn-primary">Detail</button>
            </router-link>
          </td>
          <td>
            <router-link :to="`/user/${user.id}/edit`">
              <button class="btn btn-success">Edit</button>
            </router-link>
          </td>
          <td>
            <button
              type="button"
              class="btn btn-danger"
              data-toggle="modal"
              data-target="#exampleModal"
              @click="insertDeleteTarget(user.id)"
            >Delete</button>
            <!-- Modal -->
            <div
              class="modal fade"
              id="exampleModal"
              tabindex="-1"
              role="dialog"
              aria-labelledby="exampleModalLabel"
              aria-hidden="true"
            >
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">本当に削除しますか？</h5>
                  </div>
                  <div class="modal-body">
                    <p>削除してしまうと復元はできません。</p>
                  </div>
                  <div class="modal-footer">
                    <button
                      type="button"
                      class="btn btn-secondary"
                      data-dismiss="modal"
                      id="model-close-btn"
                    >Close</button>
                    <button class="btn btn-danger" @click="userDelete()">Delete</button>
                  </div>
                </div>
              </div>
            </div>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<style scoped>
#introductionText {
  text-overflow: ellipsis;
}
</style>

<script>
export default {
  data() {
    return {
      users: [],
      deleteTargetUser: "",
    };
  },
  methods: {
    userDelete() {
      document.getElementById("model-close-btn").click();

      axios
        .delete("/api/user/" + this.deleteTargetUser)
        .then((response) => {
          this.users.slice(this.deleteTargetUser, 1);

          this.getUserInfo();
          alert("削除しました");
        })
        .catch((error) => console.log(error));
    },
    insertDeleteTarget(id) {
      this.deleteTargetUser = id;
    },
    getUserInfo() {
      axios
        .get("/api/user")
        .then((response) => {
          this.users = response.data.users;
        })
        .catch((error) => {
          console.log(error);
        });
    },
  },
  created() {
    this.getUserInfo();
  },
};
</script>
;
