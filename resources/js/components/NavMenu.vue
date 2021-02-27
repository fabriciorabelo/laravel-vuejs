<template>
    <header>
        <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
            <div class="container">
                <a class="navbar-brand" href="#">Laravel + Vue.js</a>
                <button
                    class="navbar-toggler"
                    type="button"
                    data-toggle="collapse"
                    data-target="#navbarCollapse"
                    aria-controls="navbarCollapse"
                    aria-expanded="false"
                    aria-label="Toggle navigation"
                >
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse">
                    <div class="navbar-nav mr-auto">
                        <router-link to="/" class="nav-item nav-link"
                            >Users List</router-link
                        >
                        <router-link to="/create" class="nav-item nav-link"
                            >Create User</router-link
                        >
                    </div>
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="#" v-on:click="logout()"
                                >Logout</a
                            >
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>
</template>

<script>
export default {
    name: "nav-menu",
    data() {
        return {
            token: this.$jwt.getToken()
        };
    },
    methods: {
        async logout() {
            await this.axios
                .post(
                    `auth/logout`,
                    {},
                    {
                        headers: {
                            Authorization: `Bearer ${this.token}`
                        }
                    }
                )
                .then(res => {
                    localStorage.removeItem("token");
                    localStorage.removeItem("user");
                    this.$router.push("/login");
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
};
</script>
