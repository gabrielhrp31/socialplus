<template>
    <div id="findUser">
        <Base>
            <v-layout align-center justify-center row class="ma-8">
                <v-flex xs8 lg10>
                    <v-text-field v-model="search" placeholder="Pesquise por Email ou Nome" @keypress.enter="find"></v-text-field>
                </v-flex>
                <v-flex xs4 lg2 class="pa-4">
                    <v-btn block color="primary" @click="find"><v-icon>mdi-account-search</v-icon> Pesquisar</v-btn>
                </v-flex>
            </v-layout>
            <v-layout align-center justify-center row class="ma-8">
                <v-flex>
                    <UsersList type="find"/>
                </v-flex>
            </v-layout>
        </Base>
    </div>
</template>

<script>
    import Base from "../Layouts/Base";
    import UsersList from "../components/UsersList";

    export default {
        name: "FindUser",
        components:{
            Base,
            UsersList
        },
        data:()=>({
            users: null,
            search: '',
        }),
        methods:{
            find(){
                this.$http
                    .post(
                        this.$apiUrl+'user/find',{
                            search: this.search
                        },
                        {
                            headers: {
                                authorization:
                                    "Bearer " + this.$store.state.auth.user.token
                            }
                        }
                    )
                    .then(response => {
                        if(response.data.status){
                            this.$store.commit('setUsersFound',response.data.users);
                        }
                    })
                    .catch(error=>{

                    });
            }
        },
        computed:{
            user(){
                return this.$store.state.auth.user;
            },
        },
        created() {
            this.$store.commit("authenticated",  "/find/user/");
        }
    }
</script>

<style scoped>

</style>