<template>
    <div>
        <nav-menu />
        <div class="container">
            <h2 class="text-center">Users List</h2>
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>E-mail</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="user in users" :key="user.id">
                        <td>{{ user.id }}</td>
                        <td>{{ user.name }}</td>
                        <td>{{ user.email }}</td>
                        <td>
                            <div class="btn-group" role="group">
                                <router-link
                                    :to="{
                                        name: 'edit',
                                        params: { id: user.id }
                                    }"
                                    class="btn btn-success"
                                    >Edit</router-link
                                >
                                <button
                                    class="btn btn-danger"
                                    @click="deleteUser(user.id)"
                                >
                                    Delete
                                </button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            users: [],
            token: this.$jwt.getToken()
        };
    },
    async created() {
        await this.axios
            .get("users", {
                headers: {
                    Authorization: `Bearer ${this.token}`
                }
            })
            .then(response => {
                this.users = response.data;
            })
            .catch(error => {
                if (error.response.data.errors) {
                    let message = "Some errors has occurred:\n\n";
                    for (const [key, value] of Object.entries(
                        error.response.data.errors
                    )) {
                        message += `${value}\n`;
                    }
                    alert(message);
                } else if (error.response.data.message) {
                    alert(error.response.data.message);
                } else {
                    alert(error.message);
                }
            });
    },
    methods: {
        async deleteUser(id) {
            if (confirm("Are you sure?")) {
                await this.axios
                    .delete(`users/${id}`, {
                        headers: {
                            Authorization: `Bearer ${this.token}`
                        }
                    })
                    .then(response => {
                        let i = this.users.map(data => data.id).indexOf(id);
                        this.users.splice(i, 1);
                    })
                    .catch(error => {
                        if (error.response.data.message) {
                            alert(error.response.data.message);
                        } else {
                            alert(error.message);
                        }
                    });
            }
        }
    }
};
</script>
