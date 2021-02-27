<template>
    <div>
        <nav-menu />
        <div class="container">
            <h3 class="text-center">Edit User</h3>
            <div class="row">
                <div class="col-md-6">
                    <form @submit.prevent="updateUser">
                        <div class="form-group">
                            <label>Name</label>
                            <input
                                type="text"
                                class="form-control"
                                v-model="user.name"
                                required
                            />
                        </div>
                        <div class="form-group">
                            <label>E-mail</label>
                            <input
                                type="email"
                                class="form-control"
                                v-model="user.email"
                                required
                            />
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <input
                                type="password"
                                class="form-control"
                                v-model="user.password"
                            />
                        </div>
                        <button type="submit" class="btn btn-primary">
                            Update
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            user: {},
            token: this.$jwt.getToken()
        };
    },
    async created() {
        await this.axios
            .get(`users/${this.$route.params.id}`, {
                headers: {
                    Authorization: `Bearer ${this.token}`
                }
            })
            .then(res => {
                this.user = res.data;
            })
            .catch(error => {
                if (error.response.data.message) {
                    alert(error.response.data.message);
                } else {
                    alert(error.message);
                }
            });
    },
    methods: {
        async updateUser() {
            await this.axios
                .put(`users/${this.$route.params.id}`, this.user, {
                    headers: {
                        Authorization: `Bearer ${this.token}`
                    }
                })
                .then(res => {
                    this.$router.push({ name: "home" });
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
        }
    }
};
</script>
