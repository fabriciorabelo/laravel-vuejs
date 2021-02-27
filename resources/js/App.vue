<template>
    <router-view> </router-view>
</template>

<script>
export default {
    data() {
        return {
            token: this.$jwt.getToken()
        };
    },
    methods: {
        async logout() {
            await this.axios
                .post(
                    `http://localhost:8000/api/auth/logout`,
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
        },
        expiredToken() {
            // you will get a true / false response
            // true  -> if the token is already expired
            // false -> if the token is not expired
            return this.$jwt.isExpired(this.token);
        }
    }
};
</script>
