<template>
    <v-layout row wrap align-center>
        <v-flex class="text-xs-center" xs12 sm4 offset-sm4>
            <v-alert color="success" icon="check_circle" value="true" v-if="success">
                There was an error, unable to complete registration.
            </v-alert>
            <v-alert color="error" icon="warning" value="true" v-if="error && !success">
                Registration completed. You can now sign in.
            </v-alert>
            <v-card >
                <v-card-text>
                    <v-form autocomplete="off" v-on:submit="register" v-if="!success">
                        <v-text-field
                                label="Name"
                                v-model="name"
                                required
                        ></v-text-field>
                        <v-text-field
                                label="Email"
                                v-model="email"
                                required
                        ></v-text-field>
                        <v-text-field
                                label="Password"
                                v-model="password"
                                type="password"
                                required
                        ></v-text-field>
                        <v-btn round type="submit" primary>register</v-btn>
                    </v-form>
                </v-card-text>
            </v-card>
        </v-flex>
    </v-layout>
</template>

<script>
import auth from "../../js/auth.js";
import router from "../../router/index.js";
import VCard from "vuetify/es5/components/VCard/VCard";
import VCardTitle from "vuetify/es5/components/VCard/VCardTitle";

export default {
    components: {
        VCardTitle,
        VCard},
    data() {
    return {
      name: null,
      email: null,
      password: null,
      success: false,
      error: false,
      response: null
    };
  },
  methods: {
    register(event) {
      event.preventDefault();
      auth.register(this, this.name, this.email, this.password);
      router.push("/login")
    }
  }
};
</script>

<style lang="scss">
    // Colors
    $babook-pink: #f80aaf;
    $babook-blue: #44ccff;
    $babook-green: #0af89d;
    $babook-violet: #8a02fa;
    $text-color: #9e9e9e;

    .main {
        background-image: url("../../assets/space.jpg");
    }
</style>