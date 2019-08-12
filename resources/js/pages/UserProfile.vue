<template xmlns:v-slot="http://www.w3.org/1999/XSL/Transform">
    <div class="userProfile">
        <Base>
            <v-layout align-center justify-center row class="ma-8">
                <v-flex xs4 sm3 lg2>
                    <v-img style="border-radius:100%;" :src="profileUser.image"></v-img>
                </v-flex>
                <v-flex xs8 sm5  lg4 class="ml-5">
                    <h3 class="muted">{{profileUser.name}}</h3>
                    <h4 class="mt-1 muted">{{profileUser.email}}</h4>
                    <h5 class="mt-4" @click="profileUser.followers.length>0 ? dialogFollowers=true:false"><b>{{profileUser.followers_count}}</b> Seguidores</h5>
                    <h5 class="mt-2" @click="profileUser.followed.length>0 ? dialogFollowed=true:false"><b>{{profileUser.followed_count}}</b> Seguindo</h5>
                    <v-dialog v-model="dialogFollowers" persistent max-width="290">
                        <v-card>
                            <v-card-title class="headline">
                                Seguidores
                            </v-card-title>
                            <v-card-text>
                                <UsersList  type="followers"/>
                            </v-card-text>
                            <v-card-actions>
                                <v-spacer></v-spacer>
                                <v-btn color="primary" text @click="dialogFollowers = false">Fechar</v-btn>
                            </v-card-actions>
                        </v-card>
                    </v-dialog>
                    <v-dialog v-model="dialogFollowed" persistent max-width="290">
                        <v-card>
                            <v-card-title class="headline">
                                Seguindo
                            </v-card-title>
                            <v-card-text>
                                <UsersList type="followed"/>
                            </v-card-text>
                            <v-card-actions>
                                <v-spacer></v-spacer>
                                <v-btn color="primary" text @click="dialogFollowed = false">Fechar</v-btn>
                            </v-card-actions>
                        </v-card>
                    </v-dialog>
                    <template v-if="user.id !== profileUser.id">
                        <v-btn v-if="!profileUser.following" class="mt-5"   small rounded color="primary" @click="toggleFollow">
                            <v-icon>mdi-plus</v-icon> Seguir
                        </v-btn>
                        <v-btn v-else  class="mt-5" small rounded outlined color="primary" @click="toggleFollow">
                            <v-icon>mdi-close</v-icon> Deixar de Seguir
                        </v-btn>
                    </template>
                </v-flex>
            </v-layout>
            <v-divider></v-divider>
            <v-layout class="ma-8">
                <v-flex xs12>
                    <ContentCard
                            v-for="(post, i) in posts"
                            v-bind:key="i"
                            :post="post"
                            :user="post.user"
                    ></ContentCard>
                </v-flex>
            </v-layout>
            <v-layout class="ma-8" >
                <v-flex>
                    <v-btn v-if="getMoreUrl" outlined block color="primary" @click="getMore()" :loading="loadingPosts"><v-icon>mdi-plus</v-icon>Ver mais posts...</v-btn>
                    <v-btn v-else text block color="accent" ><v-icon>mdi-emoticon-sad-outline</v-icon>Você viu todos os posts!</v-btn>
                </v-flex>
            </v-layout>
        </Base>
    </div>
</template>

<script>
    import Base from '../Layouts/Base'
    import ContentCard from '../components/ContentCard'
    import UsersList from '../components/UsersList'

    export default {
        name: "UserProfile",
        components: {
            Base,
            ContentCard,
            UsersList
        },
        data:()=> ({
            getMoreUrl: '',
            loadingPosts: false,
            dialogFollowers: false,
            dialogFollowed: false,
        }),
        computed:{
            posts(){
                return this.$store.state.posts.profilePosts;
            },
            profileUser(){
                return this.$store.state.posts.profileUser;
            },
            user(){
                return this.$store.state.auth.user;
            },
        },
        methods:{
            getMore(){
                this.$http
                    .get(
                        this.getMoreUrl,
                        {
                            headers: {
                                authorization:
                                    "Bearer " + this.$store.state.auth.user.token
                            }
                        }
                    )
                    .then(response => {
                        if(response.data.status){
                            this.$store.commit('addProfilePosts',response.data.posts.data);
                            this.getMoreUrl = response.data.posts.next_page_url;
                        }
                    })
                    .catch(error=>{

                    });
            },
            scroll(){
                window.onscroll = () => {
                    let bottomOfWindow = document.documentElement.scrollTop + window.innerHeight === document.documentElement.offsetHeight;
                    if (bottomOfWindow && !this.loadingPosts) {
                        this.loadingPosts =true;
                        this.getMore();
                    }
                };
            },
            toggleFollow(){
                this.$http
                    .post(
                        this.$apiUrl+'user/follow/'+this.$route.params.id,{},
                        {
                            headers: {
                                authorization:
                                    "Bearer " + this.$store.state.auth.user.token
                            }
                        }
                    )
                    .then(response => {
                        if(response.data.status){
                            this.$store.commit('setProfileUser',response.data.user);
                        }
                    })
                    .catch(error=>{

                    });
            },
            updatePage(){
                this.dialogFollowed =false;
                this.dialogFollowers = false;
                this.$http
                    .get(
                        this.$apiUrl + "user/"+this.$route.params.id,
                        {
                            headers: {
                                authorization:
                                    "Bearer " + this.$store.state.auth.user.token
                            }
                        }
                    )
                    .then(response => {
                        if(response.data.status){
                            this.$store.commit('setProfilePosts',response.data.posts.data);
                            this.$store.commit('setProfileUser',response.data.user);
                            this.getMoreUrl = response.data.posts.next_page_url;
                            this.loadingPosts = false;
                        }
                    })
                    .catch(error=>{

                    });
            }
        },
        watch:{
            '$route':'updatePage',
        },
        created(){
            let url = "/user/"+this.$route.params.id;
            if(this.$route.params.name){
                url= url+this.$route.params.name;
            }
            this.$store.commit("authenticated", url);
            this.updatePage();
        },
        mounted() {
            this.scroll();
        },
        destroyed() {
            this.$store.commit('setProfilePosts',[]);
            this.$store.commit('setProfileUser',[]);
        }
    }
</script>

<style scoped>

    .muted{
        color:#6c6c6c!important;
    }

    a{
        text-decoration: none;
    }
</style>