import Login from "./components/Login.vue";
import AllUser from "./components/AllUser.vue";
import CreateUser from "./components/CreateUser.vue";
import EditUser from "./components/EditUser.vue";
import VueRouter from "vue-router";
import { VueEasyJwt } from "vue-easy-jwt";

const jwt = new VueEasyJwt();

const routes = [
    {
        name: "login",
        path: "/login",
        component: Login
    },
    {
        name: "home",
        path: "/",
        component: AllUser,
        meta: {
            requiresAuth: true
        }
    },
    {
        name: "create",
        path: "/create",
        component: CreateUser,
        meta: {
            requiresAuth: true
        }
    },
    {
        name: "edit",
        path: "/edit/:id",
        component: EditUser,
        meta: {
            requiresAuth: true
        }
    }
];

const router = new VueRouter({ mode: "history", routes });

router.beforeEach((to, from, next) => {
    to.matched.some(route => {
        if (route.meta.requiresAuth) {
            // import your token
            const yourToken = localStorage.getItem("token");

            // returns true if is expired
            // if it is an empty string, null or undefined
            // will return true (expired)
            if (jwt.isExpired(yourToken)) {
                // if is expired the user should sign in again
                next({ path: "/login" });
            } else {
                next();
            }
        } else {
            next();
        }
    });
});

export default router;
