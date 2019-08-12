<template>
    <div id="usersList">
        <v-list>

            <v-list-item
                    v-for="item in users"
                    :key="item.id"
            >
                <v-list-item-avatar
                        @click="profile(item.id)"
                        style="cursor: pointer;"
                >
                    <v-img :src="item.image"></v-img>
                </v-list-item-avatar>

                <v-list-item-content
                        @click="profile(item.id)"
                        style="cursor: pointer;"
                >
                    <v-list-item-title v-text="item.name"></v-list-item-title>
                </v-list-item-content>
                <v-list-item-icon v-if="userLogged.id!==item.id">
                    <v-btn  outlined rounded small color="primary" @click="toggleFollow(item.id)">
                        <v-icon v-if="item.following" >mdi-close</v-icon>
                        <v-icon v-else >mdi-plus</v-icon>
                    </v-btn>
                </v-list-item-icon>
            </v-list-item>
        </v-list>
    </div>
</template>

<script>
    export default {
        name: "UsersList",
        props:['type'],
        computed:{
            users(){
                switch (this.type) {
                    case 'find':
                        return this.$store.state.usersFound;
                    case 'followers':
                        return this.$store.state.posts.profileUser.followers;
                    case 'followed':
                        return this.$store.state.posts.profileUser.followed;
                }
            },
            userLogged(){
                return this.$store.state.auth.user;
            }
        },
        methods:{
            profile(id){
                this.$router.push('/user/'+id);
            },
            toggleFollow(id){
                let url='';
                if(this.$route.params.id){
                    url = this.$apiUrl+'user/followOnly/'+id+'/'+this.$route.params.id
                }else{
                    url = this.$apiUrl+'user/followOnly/'+id+'/'
                }
                this.$http
                    .post(url
                        ,{},
                        {
                            headers: {
                                authorization:
                                    "Bearer " + this.$store.state.auth.user.token
                            }
                        }
                    )
                    .then(response => {
                        if(response.data.status){
                            if(this.$route.params.id) {
                                this.$store.commit('setProfileUser', response.data.user);
                            }else{
                                this.$store.commit('alterUsersFound', response.data.user);
                            }
                        }
                    })
                    .catch(error=>{

                    });
            }

        },
    }
</script>

<style scoped>

</style>