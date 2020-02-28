import Vuex from "vuex";
import Vue from "vue";
import authStore from "./authStore";
import postStore from "./postStore";

Vue.use(Vuex);

const store = new Vuex.Store({
    state:{
        appName:"+Social",
        appDescription: "Teste de Descrição",
        usersFound:null,
    },
    mutations:{
        alterUsersFound(state, newUserData){

            state.usersFound.forEach((user,index)=>{
                if(user.id===newUserData.id){
                    state.usersFound[index] = newUserData;
                }
            });

            //this is for vue reaction
            state.usersFound.push('dog-nail');
            state.usersFound.splice(-1,1);
        },
        setUsersFound(state, users){
            state.usersFound = users;
        }
    },
    modules: {
        auth: authStore,
        posts: postStore
    }
});

export { store };
