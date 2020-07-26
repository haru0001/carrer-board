<template>
    <div>
        <table class="table table-hover">
            <thead class="thead-light">
                <tr>
                    <th scope="col">Name</th>
                    <th scope="col">SE</th>
                    <th scope="col">Introduction</th>

                    <th scope="col">Detail</th>
                    <th scope="col">Edit</th>
                    <th scope="col">Delete</th>
                </tr>
            </thead>

            <tbody>
                <tr v-for="(user, index) in users" v-bind:key="user.id">
                    <th scope="row">{{ user.name }}</th>
                    <td>{{ user.se_career }}年目</td>
                    <td>{{ user.introduction }}</td>
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
                            class="btn btn-danger"
                            @click="userDelete(index, user.id)"
                        >
                            Delete
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
export default {
    data() {
        return {
            users: []
        };
    },
    methods: {
        userDelete(index, id) {
            axios
                .delete("/api/user/" + id)
                .then(response => {
                    this.users.slice(id, 1);

                    // console.log(index + ":" + id);
                    alert("削除しました");
                    location.href = "http://localhost:10080/user";
                })
                .catch(error => console.log(error));
        }
    },
    created() {
        axios
            .get("/api/user")
            .then(response => {
                this.users = response.data.users;
            })
            .catch(error => {
                console.log(error);
            });
    }
};
</script>
;
