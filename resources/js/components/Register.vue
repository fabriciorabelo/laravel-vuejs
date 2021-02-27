<template>
    <form class="form-signup" @submit.prevent="register()">
        <img
            class="mb-4"
            src="https://getbootstrap.com/docs/4.6/assets/brand/bootstrap-solid.svg"
            alt=""
            width="72"
            height="72"
        />
        <h1 class="h3 mb-3 font-weight-normal">Register</h1>
        <label for="inputName" class="sr-only">Name</label>
        <input
            type="text"
            id="inputName"
            class="form-control"
            placeholder="Name"
            v-model="user.name"
            required
            autofocus
        />
        <label for="inputEmail" class="sr-only">Email</label>
        <input
            type="email"
            id="inputEmail"
            class="form-control"
            placeholder="Email"
            v-model="user.email"
            required
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
        <label for="inputPasswordConfirmation" class="sr-only"
            >Password Confirmation</label
        >
        <input
            type="password"
            id="inputPasswordConfirmation"
            class="form-control"
            placeholder="Password Confirmation"
            v-model="user.password_confirmation"
            required
        />
        <button class="btn btn-lg btn-primary btn-block" type="submit">
            Register
        </button>
        <div class="mt-5 mb-5">
            <a href="#" v-on:click="$router.push('/login')">Login</a>
        </div>
        <p class="mt-5 mb-3 text-muted">&copy; 2021</p>
    </form>
</template>

<script>
export default {
    data() {
        return {
            user: {
                name: "",
                email: "",
                password: "",
                password_confirmation: ""
            }
        };
    },
    methods: {
        async register() {
            if (this.user.password_confirmation !== this.user.password) {
                alert("Password does not match.");
                return;
            }

            await this.axios
                .post("auth/register", {
                    name: this.user.email.trim(),
                    email: this.user.email.trim().toLowerCase(),
                    password: this.user.password.trim(),
                    password_confirmation: this.user.password_confirmation.trim()
                })
                .then(res => {
                    alert("User registered successfully!");
                    this.$router.push("/login");
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
        this.toggleBodyClass("addClass", "body-signup");
    },
    destroyed() {
        this.toggleBodyClass("removeClass", "body-signup");
    }
};
</script>
