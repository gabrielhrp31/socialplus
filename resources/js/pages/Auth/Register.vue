<template>
    <Auth>
        <template v-slot:top>
            <span class="white--text ml-4 font-weight-bold">
                    Cadastrar
            </span>
            <v-spacer></v-spacer>
            <v-btn text small to="/login">
                <v-icon>mdi-arrow-left</v-icon> Voltar
            </v-btn>
        </template>
        <v-form>
            <v-text-field
                label="Nome"
                id="name"
                name="name"
                prepend-icon="mdi-account"
                type="text"
                v-model="user.name"
                :error-messages="inputErrors.name"
            ></v-text-field>
            <v-text-field
                label="E-mail"
                id="email"
                name="email"
                prepend-icon="mdi-email"
                type="text"
                v-model="user.email"
                :error-messages="inputErrors.email"
            ></v-text-field>

            <v-text-field
                id="password"
                label="Password"
                name="password"
                prepend-icon="mdi-lock"
                type="password"
                v-model="user.password"
                :error-messages="inputErrors.password"
            ></v-text-field>
            <v-text-field
                id="confirm_password"
                label="Password"
                name="confirm_password"
                prepend-icon="mdi-lock"
                v-model="user.password_confirmation"
                :error-messages="inputErrors.password_confirmation"
                type="password"
            ></v-text-field>
        </v-form>
        <template v-slot:actions>
            <v-container class="pt-0">
                <v-row>
                    <v-col cols="12" class="pt-0">
                        <v-btn color="primary" block @click="register">Cadastrar</v-btn>
                    </v-col>
                </v-row>
            </v-container>
        </template>
    </Auth>
</template>

<script>
import Auth from "../../Layouts/Auth";

export default {
    name: "Register",
    components: {
        Auth
    },
    computed:{
        user(){
            return this.$store.state.auth.user;
        },
        inputErrors(){
            return this.$store.state.auth.inputErrors;
        },

    },
    methods:{
        register(){
            this.$store.commit('register');
        }
    },
    created() {
        this.$store.commit("authRedirect", "/register");
    }
};
</script>

<style scoped></style>
