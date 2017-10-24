<template>
  <v-layout row wrap align-center>
      <v-flex class="text-xs-center" xs12 sm4 offset-sm4>
          <v-card>
              <v-card-text>
                  <v-alert color="error" icon="warning" value="true" v-if="error">
                      Unable to sign in with these credentials!
                  </v-alert>
                 <v-select
                label="Backend to use"
                v-model="select"
                :items="items"
                required
                item-value="value"
              ></v-select>
                  <v-form>
                      <v-text-field
                              label="Email"
                              v-model="email"
                              :error-messages="emailErrors"
                              @input="$v.email.$touch()"
                              @blur="$v.email.$touch()"
                              required
                      ></v-text-field>
                      <v-text-field
                              name="input-10-1"
                              :append-icon="e1 ? 'visibility' : 'visibility_off'"
                              :append-icon-cb="() => (e1 = !e1)"
                              :type="e1 ? 'password' : 'text'"
                              label="Password"
                              v-model="password"
                              :error-messages="passwordErrors"
                              @input="$v.password.$touch()"
                              @blur="$v.password.$touch()"
                              required
                      ></v-text-field>
                      <v-btn round @click="login" primary>submit</v-btn>
                  </v-form>
              </v-card-text>
          </v-card>
      </v-flex>
  </v-layout>
</template>

<script>
import auth from "../../js/auth.js";
import router from "../../router/index.js";
import { validationMixin } from "vuelidate";
import { required, maxLength, email } from "vuelidate/lib/validators";
import * as CONFIG from '../../config.js'

export default {
  mixins: [validationMixin],
  validations: {
    email: { required, email },
    password: { required }
  },
  data() {
    return {
      email: "",
      password: "",
      error: false,
      e1: true,
      auth: auth,
      select: null,
      items: [
        {
          text: 'STUDENTAI',
          value: CONFIG.STUDENTAI
        },
        {
          text: 'TRYCATCH',
          value: CONFIG.TRYCATCH
        },
        {
          text: 'TRYSMUSK',
          value: CONFIG.TRYSMUSK
        },
        ]
    };
  },
  mounted: function() {
    this.check();
  },
  methods: {
    check: function() {
      let token = localStorage.getItem("access_token");
      if (!token) {
        router.push("/login");
      } else {
        router.push("/");
      }
    },
    login(event) {
      event.preventDefault();
      auth.login(this, this.email, this.password);
    }
  },
  computed: {
    emailErrors() {
      const errors = [];
      if (!this.$v.email.$dirty) return errors;
      !this.$v.email.email && errors.push("Must be valid e-mail");
      !this.$v.email.required && errors.push("E-mail is required");
      return errors;
    },
    passwordErrors() {
      const errors = [];
      if (!this.$v.password.$dirty) return errors;
      !this.$v.password.required && errors.push("Password is required");
      return errors;
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


    main{
        background-image: url("../../assets/space.jpg");
        background-position: center;
        background-size: cover;
        height: 100vh;
        display: flex;
        flex-direction: column;
    }
</style>