<template>
    <v-app id="app">
        <Navbar color="primary" />
        <v-main>
            <v-container >
                <slot></slot>
                <div class="padding-bottom-bar d-flex d-lg-none"></div>
            </v-container>
        </v-main>
<!--        <Footer color="accent">-->
<!--            <v-subheader class="white&#45;&#45;text">Links</v-subheader>-->
<!--            <v-list-item-->
<!--                ><a href="#" class="white&#45;&#45;text">Link 1</a></v-list-item-->
<!--            >-->
<!--            <v-list-item-->
<!--                ><a href="#" class="white&#45;&#45;text">Link 1</a></v-list-item-->
<!--            >-->
<!--        </Footer>-->
    </v-app>
</template>

<script>
import Navbar from "../components/Navbar";
import Footer from "../components/Footer";

export default {
    name: "Base",
    components: {
        Navbar,
        Footer
    },
    data: () => ({}),
};
</script>

<style scoped>
    .padding-bottom-bar{
        height: 80px;
    }
</style>
