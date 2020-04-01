import axios from "axios";
import router from "../router";
import { apiUrl } from "../config";

const authStore = {
    state: {
        user: {
            name: "",
            email: "",
            password: "",
            image: "",
            password_confirmation: "",
            token: ""
        },
        inputErrors: {},
        updated: false,
        connectionError: false,
    },
    mutations: {
        storeImage(state, e) {
            let file = e.target.files || e.target.dataTransfer.files;
            if (!file.length) {
                return;
            }
            let reader = new FileReader();
            reader.onloadend = e => {
                state.user.image = e.target.result;
            };
            reader.readAsDataURL(file[0]);
        },
        updateProfile(state) {
            axios
                .put(
                    apiUrl + "user/update",
                    {
                        name: state.user.name,
                        email: state.user.email,
                        image: state.user.image,
                        password: state.user.password,
                        password_confirmation: state.user.password_confirmation
                    },
                    {
                        headers: {
                            authorization: "Bearer " + state.user.token
                        }
                    }
                )
                .then(function(response) {
                    if (response.data.token) {
                        state.user = response.data;
                        state.updated = true;
                        localStorage.setItem(
                            "user",
                            JSON.stringify(state.user)
                        );
                        state.inputErrors = "";
                    } else {
                        state.inputErrors = response.data;
                    }
                })
                .catch(function(error) {
                    state.connectionError = true;
                });
        },
        resetUpdated(state) {
            state.updated = false;
        },
        register(state) {
            axios
                .post(apiUrl + "register", {
                    name: state.user.name,
                    email: state.user.email,
                    password: state.user.password,
                    password_confirmation: state.user.password_confirmation
                })
                .then(function(response) {
                    if (response.data.token) {
                        state.user = response.data;
                        localStorage.setItem(
                            "user",
                            JSON.stringify(state.user)
                        );
                        state.inputErrors = "";
                        router.push("/");
                    } else {
                        state.inputErrors = response.data;
                    }
                })
                .catch(function(error) {
                    state.connectionError = true;
                });
        },
        login(state) {
            axios
                .post(apiUrl + "login", {
                    email: state.user.email,
                    password: state.user.password
                })
                .then(function(response) {
                    if (response.data.token) {
                        state.user = response.data;
                        localStorage.setItem(
                            "user",
                            JSON.stringify(state.user)
                        );
                        state.inputErrors = "";
                        state.authError = false;
                        router.push("/");
                    } else if (response.data.code === 400) {
                        state.inputErrors = {
                            password: response.data.message,
                            authError: true
                        };
                    } else {
                        state.inputErrors = response.data;
                    }
                })
                .catch(function(error) {
                    state.connectionError = true;
                });
        },
        logout(state) {
            state.user = {
                name: "",
                email: "",
                password: "",
                password_confirmation: "",
                token: ""
            };
            localStorage.clear();
            router.push("/login");
        },
        async authenticated(state, routeName) {
            let auxUser = localStorage.getItem("user");
            if (auxUser) {
                state.user = JSON.parse(auxUser);
                if(router.currentRoute.path!==routeName) {
                    router.push(routeName);
                }
                axios
                    .post(
                        apiUrl + "checkLogin/",
                        {},
                        {
                            headers: {
                                authorization: "Bearer " + state.user.token
                            }
                        }
                    )
                    .catch(() => {
                        localStorage.clear();
                    });
            } else {
                router.push("/login");
            }
            state.isLoading=false;
        },
        async authRedirect(state, routeName) {
            let auxUser = localStorage.getItem("user");
            if (auxUser) {
                state.user = JSON.parse(auxUser);
                router.push("/");
                axios
                    .post(
                        apiUrl + "checkLogin",
                        {},
                        {
                            headers: {
                                authorization: "Bearer " + state.user.token
                            }
                        }
                    )
                    .catch(() => {
                        localStorage.clear();
                        router.push(routeName);
                    });
            } else {
                if(router.currentRoute.path!==routeName){
                    router.push(routeName);
                }
            }
            state.isLoading=false;
        }
    }
};
export default authStore;
