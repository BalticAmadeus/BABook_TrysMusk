<template>
  <v-app>
    <v-navigation-drawer clipped temporary v-model="drawer" app class="primary">
      <v-list dense>
        <v-list-tile @click=""
        router
        :to="{ name: 'Login' }" v-if="!auth.user.authenticated">
          <v-list-tile-content>
            <v-list-tile-title>Login</v-list-tile-title>
          </v-list-tile-content>
        </v-list-tile>
        <v-list-tile @click=""
        router
        :to="{ name: 'Register' }" v-if="!auth.user.authenticated">
          <v-list-tile-content>
            <v-list-tile-title>Register</v-list-tile-title>
          </v-list-tile-content>
        </v-list-tile>
        <v-list-tile @click=""
        router
        :to="{ name: 'CreateEvent' }" v-if="auth.user.authenticated">
          <v-list-tile-content>
            <v-list-tile-title>New Event</v-list-tile-title>
          </v-list-tile-content>
        </v-list-tile>
        <v-list-tile @click=""
        router
        :to="{ name: 'Login' }" v-if="auth.user.authenticated" v-on:click="logout">
          <v-list-tile-content>
            <v-list-tile-title>Logout</v-list-tile-title>
          </v-list-tile-content>
        </v-list-tile>
      </v-list>
    </v-navigation-drawer>
    <v-toolbar app clipped-left class="primary" dark>
      <v-toolbar-side-icon
      @click.native.stop="drawer = !drawer"
      class="hidden-sm-and-up"
      ></v-toolbar-side-icon>
      <v-toolbar-title>
        <router-link to="/">
          <img src="static/babookWithStars.png" alt="BAbook logo" width="300px">
      </router-link>
      </v-toolbar-title>
      <v-spacer></v-spacer>
      <v-toolbar-items class="hidden-xs-only">
        <v-btn flat
        router
        :to="{ name: 'CreateEvent' }" v-if="auth.user.authenticated">New Event</v-btn>
        <v-btn flat
        router
        :to="{ name: 'Login' }" v-if="!auth.user.authenticated">Login</v-btn>
        <v-btn flat
        router
        :to="{ name: 'Register' }" v-if="!auth.user.authenticated">Register</v-btn>
        <v-btn flat v-if="auth.user.authenticated" v-on:click="logout">Logout</v-btn>
      </v-toolbar-items>
    </v-toolbar>
    <main class="main">
      <router-view></router-view>
    </main>
  </v-app>
</template>

<script>
import auth from "./js/auth.js";

export default {
  data() {
    return {
      auth: auth,
      drawer: false
    };
  },
  methods: {
    logout: function() {
      auth.logout();
    }
  },
  mounted: function() {
    this.$nextTick(function() {
      auth.check();
    });
  }
};
</script>


<style lang="scss" scoped>

</style>
