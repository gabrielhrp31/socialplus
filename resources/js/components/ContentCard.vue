<template>
    <div id="content-card">
        <v-card class="mx-auto mb-8">
            <v-list-item>
                <router-link :to="'/user/'+user.id" class="name" >
                    <v-list-item-avatar
                        ><v-img :src="user.image"></v-img
                    ></v-list-item-avatar>
                </router-link>
                <v-list-item-content>
                    <v-list-item-title class="headline">
                        <router-link :to="'/user/'+user.id" class="name" >{{
                            user.name
                        }}
                        </router-link>
                    </v-list-item-title>
                    <v-list-item-subtitle>{{
                        post.created_at
                    }}</v-list-item-subtitle>
                </v-list-item-content>
                <v-list-item-icon v-if="userLogged.id === user.id">
                    <v-btn icon color="primary" @click="deletePost"><v-icon>mdi-delete</v-icon></v-btn>
                </v-list-item-icon>
            </v-list-item>
            <v-img v-if="post.image" class="white--text" :src="post.image">
                <v-card-title class="align-end fill-height">{{
                    post.title
                }}</v-card-title>
            </v-img>
            <v-card-title v-else>
                {{ post.title }}
            </v-card-title>
            <v-divider></v-divider>
            <v-card-text>
                <p>{{ post.text }}</p>
                <p v-if="post.link">
                    <a :href="post.link" target="_blank">{{ post.link }}</a>
                </p>
            </v-card-text>
            <v-divider></v-divider>
            <v-card-actions>
                <v-container fluid>
                    <v-layout>
                        <v-flex xs12>
                            <v-btn v-if="post.liked" icon color="primary" @click="like()">
                                <v-icon >mdi-heart</v-icon>
                                {{post.likes_count}}
                            </v-btn>
                            <v-btn v-else icon color="primary" @click="like()">
                                <v-icon >mdi-heart-outline</v-icon>
                                {{post.likes_count}}
                            </v-btn>
                            <v-btn icon color="primary" @click="openComment()">
                                <v-icon v-if="!comment">mdi-comment-outline</v-icon>
                                <v-icon v-if="comment">mdi-comment</v-icon>
                                {{post.comments_count}}
                            </v-btn>
                        </v-flex>
                    </v-layout>
                    <v-layout v-if="comment">
                        <v-flex xs12>
                            <v-text-field class="mt-0" @click:append-outer="sendComment()" @keypress.enter="sendComment()" v-model="comment_text" placeholder="Digite seu comentario..." append-outer-icon="mdi-send"></v-text-field>
                        </v-flex>
                    </v-layout>
                    <v-layout v-if="comment">
                        <v-flex xs12>
                            <v-list two-line>
                                <template v-for="comment in post.comments" >
                                    <v-divider
                                    ></v-divider>
                                    <v-list-item :key="comment.id">
                                        <router-link :to="'/user/'+user.id" >
                                            <v-list-item-avatar>
                                                <v-img :src="comment.user.image"></v-img>
                                            </v-list-item-avatar>
                                        </router-link>

                                        <v-list-item-content>
                                            <v-list-item-subtitle class="text--primary"><router-link :to="'/user/'+user.id" class="name" ><b>{{comment.user.name}}</b></router-link> - {{ comment.created_at }}</v-list-item-subtitle>
                                            <v-list-item-subtitle>{{comment.text}}</v-list-item-subtitle>
                                        </v-list-item-content>
                                        <v-list-item-icon v-if="userLogged.id===comment.user.id || userLogged.id ===     user.id ">
                                            <v-btn icon color="primary" @click="deleteComment(comment.id)"><v-icon>mdi-delete</v-icon></v-btn>
                                        </v-list-item-icon>
                                    </v-list-item>
                                </template>
                            </v-list>
                        </v-flex>
                    </v-layout>
                </v-container>
            </v-card-actions>
        </v-card>
    </div>
</template>

<script>
export default {
    name: "ContentCard",
    props: ["post", "user"],
    data:()=>({
        comment: false,
        comment_text: '',
    }),
    computed:{
        userLogged(){
            return this.$store.state.auth.user
        }
    },
    methods:{
        like(){
            this.$http.put(this.$apiUrl+'post/like',{
                user_id: this.userLogged.id,
                post_id: this.post.id,
            },{
                headers: {
                    authorization:
                        "Bearer " + this.$store.state.auth.user.token
                }
            }).then(response=>{
                if(response.data.status){
                    if(!this.$route.params.id){
                        this.$store.commit('alterTimelinePost',response.data.post);
                    }else{
                        this.$store.commit('alterProfilePost',response.data.post);
                    }
                }
            }).catch(error=>{
                console.log(error);
            });
        },
        openComment(){
            this.comment=!this.comment;
        },
        sendComment(){
            this.$http.post(this.$apiUrl+'post/comment',{
                user_id: this.userLogged.id,
                post_id: this.post.id,
                text: this.comment_text,
            },{
                headers: {
                    authorization:
                        "Bearer " + this.$store.state.auth.user.token
                }
            }).then(response=>{
                if(response.data.status){
                    if(!this.$route.params.id){
                        this.$store.commit('alterTimelinePost',response.data.post);
                    }else{
                        this.$store.commit('alterProfilePost',response.data.post);
                    }
                    this.comment_text = '';
                }
            }).catch(error=>{
                console.log(error);
            });
        },
        deleteComment(id) {
            this.$http.post(this.$apiUrl+'post/comment/delete',{
                comment_id: id,
            },{
                headers: {
                    authorization:
                        "Bearer " + this.$store.state.auth.user.token
                }
            }).then(response=>{
                if(response.data.status){
                    if(!this.$route.params.id){
                        this.$store.commit('alterTimelinePost',response.data.post);
                    }else{
                        this.$store.commit('alterProfilePost',response.data.post);
                    }
                }
            }).catch(error=>{
                console.log(error);
            });
        },
        deletePost(){
            this.$http
                .post(this.$apiUrl+'post/delete/'+this.post.id,{},{
                    headers: {
                        authorization:
                            "Bearer " + this.$store.state.auth.user.token
                    }
                })
                .then((response)=>{
                    if(!this.$route.params.id){
                        this.$store.commit('deleteTimelinePost',this.post.id);
                    }else{
                        this.$store.commit('deleteProfilePost',this.post.id);
                    }
                })
                .catch((error)=>{
                    console.log(error);
                });
        }
    }
};
</script>

<style scoped>
    .name{
        text-decoration: none!important;
        color: #000;
    }
</style>
