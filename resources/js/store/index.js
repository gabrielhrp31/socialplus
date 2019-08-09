import Vuex from "vuex";
import Vue from "vue";
import authStore from "./authStore";
import postStore from "./postStore";

Vue.use(Vuex);

const store = new Vuex.Store({
    state:{
        appName:"+Social",
        appDescription: "Teste de Descrição",
    },
    modules: {
        auth: authStore,
        posts: postStore
    }
});

export { store };
