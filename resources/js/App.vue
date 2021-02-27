<template>
    <div>
        <div class="container" v-if="token && !expiredToken()">
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <div class="collapse navbar-collapse">
                    <div class="navbar-nav">
                        <router-link to="/" class="nav-item nav-link"
                            >Users List</router-link
                        >
                        <router-link to="/create" class="nav-item nav-link"
                            >Create User</router-link
                        >
                    </div>
                </div>
            </nav>
            <router-view> </router-view>
        </div>
        <div v-if="!token || expiredToken()">
            <router-view> </router-view>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            token: this.$jwt.getToken()
        };
    },
    methods: {
        expiredToken() {
            // you will get a true / false response
            // true  -> if the token is already expired
            // false -> if the token is not expired
            return this.$jwt.isExpired(this.token);
        }
    }
};
</script>
