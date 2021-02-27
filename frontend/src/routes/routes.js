import DashboardLayout from "@/views/Layout/DashboardLayout.vue";
import AuthLayout from "@/views/Pages/AuthLayout.vue";
import jwt from "jsonwebtoken";
import NotFound from "@/views/NotFoundPage.vue";

function forgotStorage() {
  localStorage.removeItem("token");
  localStorage.removeItem("user");
}

function isAuthorized() {
  var token = localStorage.getItem("token");
  if (!!token) {
    try {
      const data = jwt.verify(
        token,
        "o9Tovt1M024PC0ep8zbggtGioLT2C1N70rCm7ZKf3aHTVdDFZj3QXnWNBFqeosR4"
      );
      const expires = new Date(data.exp * 1000);
      if (expires > new Date()) return true;
    } catch (e) {
      forgotStorage();
      return false;
    }
  }
  forgotStorage();
  return false;
}

const routes = [
  {
    path: "/",
    redirect: "dashboard",
    component: DashboardLayout,
    beforeEnter(to, from, next) {
      try {
        if (isAuthorized()) {
          next();
        } else {
          next({
            name: "login" // back to safety route //
          });
        }
      } catch (e) {
        next({
          name: "login" // back to safety route //
        });
      }
    },
    children: [
      {
        path: "/dashboard",
        name: "dashboard",
        // route level code-splitting
        // this generates a separate chunk (about.[hash].js) for this route
        // which is lazy-loaded when the route is visited.
        component: () =>
          import(/* webpackChunkName: "demo" */ "../views/Dashboard.vue")
      },
      {
        path: "/users",
        name: "users",
        component: () =>
          import(/* webpackChunkName: "demo" */ "../views/Users.vue")
      },
      {
        path: "/users/create",
        name: "createUser",
        component: () =>
          import(/* webpackChunkName: "demo" */ "../views/Users.vue")
      },
      {
        path: "/users/edit/:id",
        name: "user",
        component: () =>
          import(/* webpackChunkName: "demo" */ "../views/Users.vue")
      }
    ]
  },
  {
    path: "/",
    redirect: "login",
    component: AuthLayout,
    children: [
      {
        path: "/login",
        name: "login",
        component: () =>
          import(/* webpackChunkName: "demo" */ "../views/Pages/Login.vue")
      },
      {
        path: "/register",
        name: "register",
        component: () =>
          import(/* webpackChunkName: "demo" */ "../views/Pages/Register.vue")
      },
      { path: "*", component: NotFound }
    ]
  }
];

export default routes;
