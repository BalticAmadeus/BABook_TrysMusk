<template lang="html">
<v-container>
    <v-layout row wrap align-center v-if="!auth.user.authenticated">
     <v-flex class="text-xs-center" xs12 sm6 offset-sm3>
<v-select dark label="Backend" v-model="select" :items="items" item-value="value"></v-select>
</v-flex>
</v-layout>
</v-container>
</template>

<script>
 import Vue from 'vue'
 import auth from "../js/auth.js";
 import * as CONFIG from '../config.js'
 export default {
  data() {
    return {
     auth: auth,
     drawer: false,
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
   methods: {
 
   },
   mounted: function() {
     this.$nextTick(function() {
       auth.check();
     });
   },
   watch: {
         'select': function(){
             localStorage.setItem('back', this.select)
             Vue.http.options.root = localStorage.getItem('back')
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

main {
  background-image: url("../assets/spaceAndLogo.jpg");
  background-position: center center;
  background-repeat:  no-repeat;
  background-attachment: fixed;
  background-size:  cover;
}
</style>

