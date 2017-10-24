   <template>
     <v-container fill-height>
           <v-layout row wrap align-center>
             <v-flex class="text-xs-center">
               <h2>Chat!</h2>
               <v-flex xs12 sm12>
           <v-list>
             <v-list-tile v-for="item in items" v-bind:key="item.name">
               <v-list-tile-content>
                 <v-list-tile-title> {{ item.name }} : {{ item.comment }}</v-list-tile-title>
               </v-list-tile-content>
             </v-list-tile>
               <v-layout row align-center>
             <v-flex xs10 sm10>
               <v-text-field
               name="input-7-1"
               label="Label Text"
               multi-line
             ></v-text-field>
         </v-flex>
         <v-flex xs2 sm2>
         <v-btn color="primary">Send</v-btn>
     </v-flex>
   </v-layout>
           </v-list>
       </v-flex>
                 <v-btn
                   @click="submit"
                   :disabled="!valid"
                 >
                   submit
                 </v-btn>
                 <v-btn @click="clear">clear</v-btn>
             </v-flex>
           </v-layout>
         </v-container>

   </template>

   <script>
import auth from "../../js/auth.js";
import router from "../../router/index.js";

export default {
  data: () => ({
    items: [],
    auth: auth
  }),
  methods: {
    check: function() {
      let token = localStorage.getItem("access_token");
      if (!token) {
        router.push("/login");
      }
    }
  }
};
</script>

   <style lang="css">
textarea {
  resize: none;
}
</style>
