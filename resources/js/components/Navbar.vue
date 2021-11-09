<template>
    <div id="navbarRoot">
<!--        <v-navigation-drawer-->
<!--            app-->
<!--            :expand-on-hover="true"-->
<!--            v-model="drawer"-->
<!--            width="200"-->
<!--        >-->
<!--            <v-list>-->
<!--                <v-list-item class="px-0 d-flex justify-center">-->
<!--                    <v-list-item-avatar>-->
<!--                        <v-img :src="user.image"></v-img>-->
<!--                    </v-list-item-avatar>-->
<!--                    &lt;!&ndash;<span @click="drawer=!drawer"><v-icon small color="danger">mdi-close</v-icon></span>&ndash;&gt;-->
<!--                </v-list-item>-->

<!--                <v-list-item link to="/profile">-->
<!--                    <v-list-item-content>-->
<!--                        <v-list-item-title class="title">{{-->
<!--                            user.name-->
<!--                        }}</v-list-item-title>-->
<!--                        <v-list-item-subtitle>{{-->
<!--                            user.email-->
<!--                        }}</v-list-item-subtitle>-->
<!--                    </v-list-item-content>-->
<!--                </v-list-item>-->
<!--            </v-list>-->
<!--            <v-divider></v-divider>-->
<!--            <v-list nav dense>-->
<!--                <v-list-item-group v-model="item" color="primary">-->
<!--                    <v-list-item-->
<!--                        v-for="(item, i) in items"-->
<!--                        :key="i"-->
<!--                        :to="item.link ? getLink(item) : '#'"-->
<!--                    >-->
<!--                        <v-list-item-icon>-->
<!--                            <v-icon v-text="item.icon"></v-icon>-->
<!--                        </v-list-item-icon>-->

<!--                        <v-list-item-content>-->
<!--                            <v-list-item-title-->
<!--                                v-text="item.text"-->
<!--                            ></v-list-item-title>-->
<!--                        </v-list-item-content>-->
<!--                    </v-list-item>-->
<!--                    <v-list-item @click="logout">-->
<!--                        <v-list-item-icon>-->
<!--                            <v-icon>mdi-arrow-left</v-icon>-->
<!--                        </v-list-item-icon>-->

<!--                        <v-list-item-content>-->
<!--                            <v-list-item-title>Sair</v-list-item-title>-->
<!--                        </v-list-item-content>-->
<!--                    </v-list-item>-->
<!--                </v-list-item-group>-->
<!--            </v-list>-->
<!--        </v-navigation-drawer>-->
        <v-app-bar
            app
            inset
            :color="color"
            :elevate-on-scroll="true"
            id="navbar"
        >
<!--            <v-app-bar-nav-icon-->
<!--                class="hidden-lg-and-up"-->
<!--                @click.stop="drawer = !drawer"-->
<!--            ></v-app-bar-nav-icon>-->
            <v-container class="fill-height py-0">
                <v-row no-gutters align="center" class="fill-height">
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
                    <div class="adaptative-width d-none d-sm-flex">
                        <v-tabs
                            background-color="primary"
                            centered
                            dark
                        >
                            <v-tabs-slider></v-tabs-slider>
                            <template
                                v-for="(item, i) in items"

                            >
                                <v-tab :key="i" :to="item.link ? getLink(item) : '#'">
                                    <v-icon>{{ item.icon }}</v-icon>
                                </v-tab>
                            </template>
                            <v-tab to="/profile">
                                <v-avatar size="36">
                                    <v-img :src="user.image"></v-img>
                                </v-avatar>
                            </v-tab>
                        </v-tabs>
                    </div>
                    <v-spacer></v-spacer>
                    <v-btn icon color="secondary" v-on:click="toggleDarkMode()">
                        <v-icon >mdi-theme-light-dark</v-icon>
                    </v-btn>
                </v-row>
            </v-container>
        </v-app-bar>
        <div class="bottom-bar d-flex d-sm-none">
            <v-tabs
                background-color="primary"
                centered
                dark
            >
                <v-tabs-slider></v-tabs-slider>
                <template
                    v-for="(item, i) in items"

                >
                    <v-tab :key="i" :to="item.link ? getLink(item) : '#'">
                        <v-icon size="36">{{ item.icon }}</v-icon>
                    </v-tab>
                </template>
                <v-tab to="/profile">
                    <v-avatar size="36">
                        <v-img :src="user.image"></v-img>
                    </v-avatar>
                </v-tab>
            </v-tabs>
        </div>
    </div>
</template>

<script>
export default {
    name: "Navbar",
    props: ["logo", "url", "color"],
    data: () => ({
        drawer: null,
        item: 0,
    }),
    computed: {
        user() {
            return this.$store.state.auth.user;
        },
        items(){
            return [
                { text: "Feed", icon: "mdi-home", link: "/" },
                { text: "Perfil", icon: "mdi-account", link:`/user/${this.user.id}` },
                { text: "Procurar", icon: "mdi-account-heart", link: "/find/user/" }
            ]
        },
        appName(){
            return this.$store.state.appName;
        },
    },
    methods: {
        toggleDarkMode() {
            this.$vuetify.theme.dark = !this.$vuetify.theme.dark;
            localStorage.setItem("dark_theme", this.$vuetify.theme.dark.toString());
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

.theme-switch{
    height: 100%;
    display: flex;
    align-items: center;
}


>>>.adaptative-width{
    display: flex;
    height: 100%;
    max-width: 100%;
    align-items: flex-end;
}
>>> .adaptative-width .v-tabs, >>> .adaptative-width .v-tabs .v-tabs-bar{
    height: 100%;
}

>>>.bottom-bar{
    width: 100%;
    z-index: 1000;
    position: fixed;
    bottom: 0;
}
>>>.bottom-bar .v-tabs .v-tabs-bar{
    height: 80px;
}

>>> .theme-switch .v-messages{
    display: none;
}

>>> .v-toolbar__content{
    padding: 0!important;
}
</style>
