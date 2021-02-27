import Vue from "vue";
import axios from "axios";

const AxiosClient = {
  install(Vue) {
    const token = localStorage.getItem("token");

    Vue.prototype.$http = axios.create({
      baseURL: "http://localhost:8000/api/",
      headers: {
        Authorization: token ? `Bearer ${token}` : ""
      }
    });
  }
};

export default AxiosClient;
