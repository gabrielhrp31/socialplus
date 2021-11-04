<template>
    <v-app>
        <router-view></router-view>
    </v-app>
</template>

<script>
    export default {
        name: 'App',
        mounted() {
            const theme = localStorage.getItem("dark_theme");
            if (theme) {
                if (theme == "true") {
                    this.$vuetify.theme.dark = true;
                } else {
                    this.$vuetify.theme.dark = false;
                }
            }
        }
    };
</script>
