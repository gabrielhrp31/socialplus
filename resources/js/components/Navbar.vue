<template>
    <div id="navbarRoot">
        <v-navigation-drawer
            app
            :expand-on-hover="true"
            v-model="drawer"
            width="200"
        >
            <v-list>
                <v-list-item>
                    <v-list-item-avatar>
                        <v-img :src="user.image"></v-img>
                    </v-list-item-avatar>
                    <!--<span @click="drawer=!drawer"><v-icon small color="danger">mdi-close</v-icon></span>-->
                </v-list-item>

                <v-list-item link>
                    <v-list-item-content>
                        <v-list-item-title class="title">{{
                            user.name
                        }}</v-list-item-title>
                        <v-list-item-subtitle>{{
                            user.email
                        }}</v-list-item-subtitle>
                    </v-list-item-content>
                </v-list-item>
            </v-list>
            <v-divider></v-divider>
            <v-list nav dense>
                <v-list-item-group v-model="item" color="primary">
                    <v-list-item
                        v-for="(item, i) in items"
                        :key="i"
                        :to="item.link ? getLink(item) : '#'"
                    >
                        <v-list-item-icon>
                            <v-icon v-text="item.icon"></v-icon>
                        </v-list-item-icon>

                        <v-list-item-content>
                            <v-list-item-title
                                v-text="item.text"
                            ></v-list-item-title>
                        </v-list-item-content>
                    </v-list-item>
                    <v-list-item @click="logout">
                        <v-list-item-icon>
                            <v-icon>mdi-arrow-left</v-icon>
                        </v-list-item-icon>

                        <v-list-item-content>
                            <v-list-item-title>Sair</v-list-item-title>
                        </v-list-item-content>
                    </v-list-item>
                </v-list-item-group>
            </v-list>
        </v-navigation-drawer>
        <v-app-bar
            app
            inset
            :color="color"
            :elevate-on-scroll="true"
            id="navbar"
        >
            <v-app-bar-nav-icon
                class="hidden-lg-and-up"
                @click.stop="drawer = !drawer"
            ></v-app-bar-nav-icon>
            <v-toolbar-title
                ><v-btn
                    text
                    color="secondary"
                    :ripple="false"
                    v-bind:to="url || '/'"
                    >{{appName}}</v-btn
                ></v-toolbar-title
            >

            <v-spacer></v-spacer>
        </v-app-bar>
    </div>
</template>

<script>
export default {
    name: "Navbar",
    props: ["logo", "url", "color"],
    data: () => ({
        drawer: null,
        item: 0,
        items: [
            { text: "Feed", icon: "mdi-home", link: "/" },
            { text: "Meu Feed", icon: "mdi-file", link: "/user/" },
            { text: "Perfil", icon: "mdi-account", link: "/profile" },
            { text: "Procurar", icon: "mdi-account-search", link: "/find/user/" }
        ]
    }),
    computed: {
        user() {
            return this.$store.state.auth.user;
        },
        appName(){
            console.log(this.$store);
            return this.$store.state.appName;
        },
    },
    methods: {
        logout() {
            this.$store.commit("logout");
        },
        getLink(item){
            if(item.link==='/user/'){
                return item.link+this.user.id+'/';
            }
            return item.link;
        }
    }
};
</script>

<style scoped>
span {
    position: absolute;
    cursor: pointer;
    top: 10px;
    right: 20px;
}
</style>
