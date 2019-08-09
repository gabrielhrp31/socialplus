<template>
    <div class="home">
        <Base>
            <v-layout class="mt-5">
                <v-flex>
                    <h2 class="text-center">Perfil</h2>
                </v-flex>
            </v-layout>
            <v-layout class="ma-8">
                <v-flex>
                    <v-alert v-if="updated" type="success">
                        Informações Atualizadas com Sucesso!
                    </v-alert>
                </v-flex>
            </v-layout>
            <v-layout class="ma-8">
                <v-flex xs2 lg1 offset-lg2>
                    <v-img
                        :src="user.image"
                    ></v-img>
                </v-flex>
                <v-flex xs10 lg5 offset-lg1>
                    <v-form>
                        <v-text-field
                            label="Nome"
                            id="name"
                            name="name"
                            prepend-icon="mdi-account"
                            type="text"
                            v-model="user.name"
                            :error-messages="inputErrors.name"
                            :disabled="!edit"
                        ></v-text-field>
                        <!--<v-layout>-->
                            <!--<v-flex xs lg8>-->
                                <v-input
                                    :disabled="!edit"
                                    append-icon="mdi-attachment"
                                    prepend-icon="mdi-camera"
                                    ref="inputFileName"
                                    @click:append="$refs.inputUpload.click()"
                                >
                                    <v-text-field class="pa-0 ma-0" :disabled="true" v-model="fileName"></v-text-field>
                                </v-input>
                            <!--</v-flex>-->
                            <!--<v-flex xs lg-4 class="ml-2">-->
                                <!--<v-btn   color="primary" class="float-right mt-4">Selecionar</v-btn>-->
                            <!--</v-flex>-->
                        <!--</v-layout>-->
                        <input
                            v-show="false"
                            ref="inputUpload"
                            type="file"
                            accept="image/png, image/jpeg, image/bmp"
                            @change="storeImage"
                        />
                        <v-text-field
                            label="E-mail"
                            id="email"
                            name="email"
                            prepend-icon="mdi-email"
                            type="text"
                            v-model="user.email"
                            :error-messages="inputErrors.email"
                            :disabled="!edit"
                        ></v-text-field>
                        <v-text-field
                            id="password"
                            label="Password"
                            name="password"
                            prepend-icon="mdi-lock"
                            type="password"
                            v-model="user.password"
                            :error-messages="inputErrors.password"
                            :disabled="!edit"
                        ></v-text-field>
                        <v-text-field
                            id="confirm_password"
                            label="Password"
                            name="confirm_password"
                            prepend-icon="mdi-lock"
                            v-model="user.password_confirmation"
                            :error-messages="inputErrors.password_confirmation"
                            type="password"
                            :disabled="!edit"
                        ></v-text-field>
                        <v-btn
                            class="float-right"
                            v-if="!edit"
                            @click="edit = true"
                            color="accent"
                            >Editar</v-btn
                        >
                        <v-btn
                            class="float-right"
                            v-if="edit"
                            color="success"
                            @click="save()"
                            >Atualizar</v-btn
                        >
                    </v-form>
                </v-flex>
            </v-layout>
        </Base>
    </div>
</template>

<script>
import Base from "../Layouts/Base";

export default {
    name: "Profile",
    components: {
        Base
    },
    data: () => ({
        edit: false,
        fileName: '',
    }),
    computed: {
        user() {
            return this.$store.state.auth.user;
        },
        inputErrors() {
            return this.$store.state.auth.inputErrors;
        },
        updated() {
            return this.$store.state.auth.updated;
        }
    },
    methods: {
        storeImage(e) {
            let file = e.target.files[0] || e.target.dataTransfer[0];
            this.fileName = file.name;
            this.$store.commit("storeImage", e);
        },
        save() {
            this.edit = false;
            this.$store.commit("updateProfile");
        }
    },
    created() {
        this.$store.commit("authenticated", "/profile");
    },
    destroyed() {
        this.$store.commit("resetUpdated");
    }
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped></style>
