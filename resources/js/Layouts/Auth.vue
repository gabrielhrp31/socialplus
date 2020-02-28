<template>
    <v-content>
        <v-container fluid fill-height>
            <v-layout align-center justify-center>
                <v-flex xs12 sm8 md4>
                    <v-alert v-if="connectionError" type="error">
                        Erro ao conectar-se com o servidor!
                    </v-alert>
                    <v-card class="elevation-12">
                        <v-carousel
                            hide-delimiters
                            :show-arrows="false"
                            height="200"
                            continuous
                            cycle
                        >
                            <v-container style="position: absolute;z-index:100;">
                                <v-row>
                                    <slot name="top"></slot>
                                    <!--slot para titulo-->
                                </v-row>
                            </v-container>
                            <v-carousel-item
                                v-for="(item, i) in items"
                                :key="i"
                                :src="item.src"
                            ></v-carousel-item>
                        </v-carousel>
                        <v-card-text>
                            <!--slot para conteudo-->
                            <slot></slot>
                        </v-card-text>
                        <v-card-actions>
                            <!--slot para botões de ação-->
                            <slot name="actions"></slot>
                        </v-card-actions>
                    </v-card>
                </v-flex>
            </v-layout>
        </v-container>
    </v-content>
</template>

<script>
export default {
    name: "Auth",
    data: () => ({
        items: [
            {
                src: "https://cdn.vuetifyjs.com/images/carousel/squirrel.jpg"
            },
            {
                src: "https://cdn.vuetifyjs.com/images/carousel/sky.jpg"
            },
            {
                src: "https://cdn.vuetifyjs.com/images/carousel/bird.jpg"
            },
            {
                src: "https://cdn.vuetifyjs.com/images/carousel/planet.jpg"
            }
        ]
    }),
    computed: {
        connectionError() {
            return this.$store.state.auth.connectionError;
        },
        isLoading(){
            return this.$store.state.auth.isLoading;
        }
    }
};
</script>

<style scoped></style>
