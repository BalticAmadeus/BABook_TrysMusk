<template>
  <v-container fill-height>
        <v-layout row wrap align-center>
          <v-flex class="text-xs-center">
            <h2>Create new event!</h2>
            <v-form v-model="valid" ref="form" lazy-validation>
              <v-select
                label="Group"
                v-model="select"
                :items="items"
                :rules="[v => !!v || 'Item is required']"
                required
                item-value="value"
              ></v-select>
              <v-text-field
                label="Title"
                v-model="title"
                :rules="titleRules"
                :counter="10"
                required
              ></v-text-field>
              <v-text-field
                label="Location"
                v-model="location"
                :rules="locationRules"
                required
              ></v-text-field>
              <v-menu
        lazy
        :close-on-content-click="false"
        v-model="menu"
        transition="scale-transition"
        offset-y
        full-width
        :nudge-right="40"
        max-width="290px"
        min-width="290px"
      >
        <v-text-field
          slot="activator"
          label="Pick a date"
          v-model="date"
          :rules="dateRules"
          readonly
          required
        ></v-text-field>
        <v-date-picker v-model="date" no-title scrollable actions>
          <template scope="{ save, cancel }">
            <v-card-actions>
              <v-spacer></v-spacer>
              <v-btn flat color="primary" @click="cancel">Cancel</v-btn>
              <v-btn flat color="primary" @click="save">OK</v-btn>
            </v-card-actions>
          </template>
        </v-date-picker>
      </v-menu>

      <v-menu
        lazy
        :close-on-content-click="false"
        v-model="menu2"
        transition="scale-transition"
        offset-y
        full-width
        :nudge-right="40"
        max-width="290px"
        min-width="290px"
      >
        <v-text-field
          slot="activator"
          label="Pick the time"
          v-model="time"
          readonly
          :rules="timeRules"
          required
        ></v-text-field>
        <v-time-picker v-model="time" autosave format="24hr"></v-time-picker>
      </v-menu>

      <v-text-field
        label="Comment"
        v-model="comment"
      ></v-text-field>

              <v-btn
              primary
                @click="submit"
                :disabled="!valid"
              >
                submit
              </v-btn>
              <v-btn @click="clear">clear</v-btn>
            </v-form>
          </v-flex>
        </v-layout>
      </v-container>

</template>

<script>
import auth from "../../js/auth.js";
import router from "../../router/index.js";
export default {
  data: () => ({
    valid: true,
    select: null,
    items: [],
    title: "",
    titleRules: [
      v => !!v || "Title is required",
      v => (v && v.length <= 10) || "Title must be less than 10 characters"
    ],
    location: "",
    locationRules: [v => !!v || "Location is required"],
    date: null,
    dateRules: [v => !!v || "Date is required"],
    menu: false,
    time: null,
    timeRules: [v => !!v || "Time is required"],
    menu2: false,
    comment: "",
    auth: auth
  }),
  methods: {
    check: function() {
      auth.check();
      let token = localStorage.getItem("id_token");
      if (!token) {
        router.push("/login");
      }
    },
    submit: function() {
      if (this.$refs.form.validate()) {
        var data = {
          userId: auth.user.id,
          groupId: this.select,
          title: this.title,
          location: this.location,
          date: this.date + " " + this.time,
          comment: this.comment
        };
        this.$http
          .post("events", data, {
            headers: {
              Authorization: "Bearer " + localStorage.getItem("id_token")
            }
          })
          .then(response => {
            this.$router.push("/");
          });
      }
    },
    getGroups: function() {
      this.$http
        .get("groups", {
          headers: {
            Authorization: "Bearer " + localStorage.getItem("id_token")
          }
        })
        .then(function(response) {
          var data = [];
          response.data.forEach(function(element) {
            var temp = {
              text: element.name,
              value: element.groupId
            };
            data.push(temp);
          });
          this.items = data;
        });
    },
    clear() {
      this.$refs.form.reset();
    }
  },
  created: function() {
    this.check();
    this.getGroups();
  }
};
</script>

<style lang="css">

</style>
