import Vue from 'vue'
import Router from 'vue-router'
import Home from '../pages/Home/Home'
import Login from "../pages/Auth/Login";
import Register from "../pages/Auth/Register"
import Profile from "../pages/Profile";

Vue.use(Router);

export default new Router({
    mode: "history",
    routes: [
        {
            path: "/",
            name: "Home",
            component: Home
        },
        {
            path: "/login/",
            name: "Login",
            component: Login
        },
        {
            path: "/register/",
            name: "Register",
            component: Register
        },
        {
            path: "/profile/",
            name: "Profile",
            component: Profile
        }
    ]
});
