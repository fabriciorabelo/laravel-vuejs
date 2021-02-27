import Vue from "vue";
import Vuex from "vuex";

Vue.use(Vuex);

const str = localStorage.getItem("user");
const user = !!str ? JSON.parse(str) : null;

export default new Vuex.Store({
  state: {
    user: {
      name: user.name || "Don Jhoe",
      email: user.email || "yourname@yourdomain.com"
    }
  },
  getters: {},
  mutations: {
    changeUser(state, payload) {
      state.user = payload;
    }
  },
  actions: {}
});
