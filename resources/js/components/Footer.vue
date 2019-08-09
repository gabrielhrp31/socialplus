<template>
    <v-footer app absolute inset id="footer" :color="color">
        <v-container>
            <v-layout>
                <v-flex align-self-center xs12 lg6>
                    <h3 class="white--text">{{ appName }}</h3>
                    <p class="white--text">{{ appDescription }}</p>
                </v-flex>
                <v-flex xs12 lg6>
                    <v-list :color="color">
                        <slot></slot>
                    </v-list>
                    <v-divider color="white"></v-divider>
                </v-flex>
            </v-layout>
            <v-layout>
                <v-flex xs12>
                    <p class="text-center white--text mt-5">
                        {{ new Date().getFullYear() }} Copyright —
                        <strong>{{ appName }}</strong>
                    </p>
                </v-flex>
            </v-layout>
        </v-container>
    </v-footer>
</template>

<script>
export default {
    name: "Footer",
    props: ["color", "logo", "description"],
    data: () => ({}),
    computed: {
        appName() {
            console.log(this.$store);
            return this.$store.state.appName;
        },
        appDescription() {
            console.log(this.$store);
            return this.$store.state.appDescription;
        }
    }
};
</script>

<style scoped></style>
