<template>
  <v-container fill-height>
  <v-layout row wrap align-center>
    <v-flex class="text-xs-center">
      <h2>Login to BAbook</h2>
      <h3 v-if="error">Unable to sign in with these credentials!</h3>
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

    <v-btn @click="login">submit</v-btn>
    <v-btn @click="clear">clear</v-btn>
  </v-form>
</v-flex>
</v-layout>
</v-container>
</template>

<script>
import auth from '../../js/auth.js';
import router from '../../router/index.js'
import { validationMixin } from 'vuelidate'
import { required, maxLength, email } from 'vuelidate/lib/validators'

export default {
    mixins: [validationMixin],
    validations: {
      email: { required, email },
      password: { required }
    },
    data() {
            return {
                email: '',
                password: '',
                error: false,
                e1: true,
                auth: auth
            }
        },
        mounted: function() {
        this.check()
      },
        methods: {
          check: function() {
            let token = localStorage.getItem('id_token')
            if(!token) {
              router.push('/login')
            } else {
              router.push('/')
            }
          },
          clear () {
            this.$v.$reset()
            this.name = ''
            this.email = ''
            this.select = null
            this.checkbox = false
          },
            login(event) {
                event.preventDefault()
                auth.login(this, this.email, this.password)
            }
        },
        computed: {
          emailErrors () {
            const errors = []
            if (!this.$v.email.$dirty) return errors
            !this.$v.email.email && errors.push('Must be valid e-mail')
            !this.$v.email.required && errors.push('E-mail is required')
            return errors
          },
          passwordErrors () {
            const errors = []
            if (!this.$v.password.$dirty) return errors
            !this.$v.password.required && errors.push('Password is required')
            return errors
          }
        }
}
</script>
