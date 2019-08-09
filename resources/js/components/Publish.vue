<template>
    <div id="publish">
        <v-layout v-if="errors" class="ma-8">
            <v-flex>
                <v-alert type="error">
                    <p v-for="error in errors">{{error}}</p>
                </v-alert>
            </v-flex>
        </v-layout>
        <v-layout class="ma-8">
            <v-flex
                xs12
                id="publish-content"
                :style="'background-color: white;border-color:' + primary + ';'"
            >
                <v-text-field
                    v-model="post.title"
                    :solo="true"
                    :flat="true"
                    :hide-details="true"
                    class="pa-0"
                    placeholder="Titulo"
                ></v-text-field>
                <v-textarea
                    v-model="post.text"
                    placeholder="O que está acontecendo?"
                    :solo="true"
                    :hide-details="true"
                    :no-resize="true"
                    :flat="true"
                    class="ma-0"
                ></v-textarea>
                <v-text-field
                    v-model="post.link"
                    :solo="true"
                    :flat="true"
                    v-if="link"
                    :hide-details="true"
                    class="pa-0"
                    @blur="post.link === '' ? (link = false) : (link = true)"
                    placeholder="Link Externo"
                ></v-text-field>
                <v-text-field
                    v-model="post.image"
                    v-if="image"
                    :solo="true"
                    :flat="true"
                    :hide-details="true"
                    class="pa-0"
                    @blur="post.image === '' ? (image = false) : (image = true)"
                    placeholder="Url da Imagem"
                ></v-text-field>
                <v-btn text class="float-right" @click="image = !image">
                    <v-icon v-if="!image" color="primary"
                        >mdi-image-plus</v-icon
                    >
                    <v-icon v-if="image" color="primary">mdi-image</v-icon>
                </v-btn>
                <v-btn text class="float-right" @click="link = !link">
                    <v-icon v-if="!link" color="primary">mdi-link-plus</v-icon>
                    <v-icon v-if="link" color="primary">mdi-link</v-icon>
                </v-btn>
            </v-flex>
        </v-layout>
        <v-layout class="ma-8">
            <v-flex xs-12>
                <v-btn
                    v-if="post.title"
                    color="primary"
                    class="float-right"
                    @click="publish"
                    >Publicar</v-btn
                >
            </v-flex>
        </v-layout>
    </div>
</template>

<script>
export default {
    name: "Publish",
    data: () => ({
        post: {
            title: "",
            text: "",
            link: "",
            image: ""
        },
        errors:null,
        link: false,
        image: false
    }),
    methods: {
        publish() {
            this.$http
                .post(
                    this.$apiUrl + "post/create",
                    { ...this.post },
                    {
                        headers: {
                            authorization:
                                "Bearer " + this.$store.state.auth.user.token
                        }
                    }
                )
                .then(response => {
                    if (response.data.status) {
                        this.posts = {
                            title: "",
                            text: "",
                            link: "",
                            image: ""
                        };
                        this.$store.commit('setTimelinePosts', response.data.posts.data);
                    }else if(response.data.status===false && response.data.validation){
                        console.log(response.data);
                        this.errors =[];
                        for(let errors of Object.values(response.data.validation)){
                            for(let error of errors){
                                this.errors.push(error);
                            }
                        }
                    }
                })
                .catch(error => {
                    console.log(error);
                });
        }
    },
    computed: {
        primary() {
            return this.$vuetify.theme.currentTheme.primary;
        },
        getErrors(){
            return this.errors;
        }
    }
};
</script>

<style scoped>
#publish-content {
    border: 2px solid black;
    border-radius: 5px;
}
</style>
