<template xmlns:v-slot="http://www.w3.org/1999/XSL/Transform">
  <Auth>
    <template v-slot:top>
        <span class="white--text ml-4 font-weight-bold">
            Fazer Login
        </span>
        <v-spacer></v-spacer>
        <v-btn text small color="primary" to="/register" class="mr-2"><v-icon>mdi-arrow-right</v-icon> Cadastre-se</v-btn>
    </template>
    <v-form>
      <v-text-field
        label="E-mail"
        id="email"
        name="email"
        v-model="user.email"
        :error="inputErrors.authError"
        :error-messages="inputErrors.email"
        prepend-icon="mdi-email"
        type="text"
      ></v-text-field>

      <v-text-field
        id="password"
        label="Password"
        name="password"
        v-model="user.password"
        :error-messages="inputErrors.password"
        prepend-icon="mdi-lock"
        type="password"
        @keypress.enter="login"
      ></v-text-field>
    </v-form>
    <template v-slot:actions>
        <v-container class="pt-0">
            <v-row>
                <v-col cols="12" class="pt-0">
                    <v-btn block color="primary" @click="login">Login</v-btn>
                </v-col>
            </v-row>
        </v-container>
    </template>
  </Auth>
</template>

<script>
    import Auth from "../../Layouts/Auth";

    export default {
        name: "Login",
        components:{
            Auth,
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
          login(){
            this.$store.commit('login');
          }
        },
        created(){
            this.$store.commit('authRedirect','/login')
        }
    }
</script>

<style scoped>

</style>
