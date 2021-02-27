<template>
    <form class="form-signin" @submit.prevent="login()">
        <img
            class="mb-4"
            src="https://getbootstrap.com/docs/4.6/assets/brand/bootstrap-solid.svg"
            alt=""
            width="72"
            height="72"
        />
        <h1 class="h3 mb-3 font-weight-normal">Please sign in</h1>
        <label for="inputEmail" class="sr-only">Email</label>
        <input
            type="email"
            id="inputEmail"
            class="form-control"
            placeholder="Email"
            v-model="user.email"
            required
            autofocus
        />
        <label for="inputPassword" class="sr-only">Password</label>
        <input
            type="password"
            id="inputPassword"
            class="form-control"
            placeholder="Password"
            v-model="user.password"
            required
        />
        <button class="btn btn-lg btn-primary btn-block" type="submit">
            Sign in
        </button>
        <p class="mt-5 mb-3 text-muted">&copy; 2021</p>
    </form>
</template>

<script>
export default {
    data() {
        return {
            user: {
                email: "contato@fabricioprabelo.com.br",
                password: "123456"
            }
        };
    },
    methods: {
        async login() {
            await this.axios
                .post("http://localhost:8000/api/auth/login", {
                    email: this.user.email.trim().toLowerCase(),
                    password: this.user.password.trim()
                })
                .then(res => {
                    localStorage.setItem("token", res.data.access_token);
                    localStorage.setItem("user", JSON.stringify(res.data.user));
                    this.$router.push("/");
                })
                .catch(err => console.error(err));
        },
        toggleBodyClass(addRemoveClass, className) {
            const el = document.body;

            if (addRemoveClass === "addClass") {
                el.classList.add(className);
            } else {
                el.classList.remove(className);
            }
        }
    },
    mounted() {
        this.toggleBodyClass("addClass", "body-signin");
    },
    destroyed() {
        this.toggleBodyClass("removeClass", "body-signin");
    }
};
</script>
