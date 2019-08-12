import Vue from 'vue'
import Router from 'vue-router'
import Home from '../pages/Home/Home'
import Login from "../pages/Auth/Login";
import Register from "../pages/Auth/Register"
import Profile from "../pages/Profile";
import UserProfile from "../pages/UserProfile";
import FindUser from "../pages/FindUser";

Vue.use(Router);

export default new Router({
    mode: "history",
    routes: [
        {
            path: "/",
            name: "Home",
            meta: { title: 'Feed' },
            component: Home
        },
        {
            path: "/login/",
            name: "Login",
            meta: { title: 'Login' },
            component: Login
        },
        {
            path: "/user/:id/",
            name: "UserProfile",
            meta: { title: 'Ver Perfil' },
            component: UserProfile,
            // beforeEnter (to, from, next){
            //     console.log("to:");
            //     console.log(to);
            //     console.log("from:");
            //     console.log(from);
            //     console.log("next:");
            //     console.log(next);
            // }
        },
        {
            path: "/find/user/",
            name: "Search",
            meta: { title: 'Pesquisar' },
            component: FindUser
        },
        {
            path: "/register/",
            name: "Register",
            meta: { title: 'Cadastre-se' },
            component: Register
        },
        {
            path: "/profile/",
            name: "Profile",
            meta: { title: 'Meu Perfil' },
            component: Profile
        }
    ]
});
