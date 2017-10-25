<template lang="html">
<v-container fluid grid-list-lg style="margin-top: 0">
    <v-btn @click.stop="drawer2 = !drawer2" dark primary>Groups / Rooms</v-btn>
        <v-layout row wrap>
          <v-flex xs12 sm6 md4 v-for="event in events" :key="event.eventId">
            <v-card class="primary white--text">
              <v-container fluid grid-list-lg>
                <v-layout row>
                  <v-flex xs12>
                    <div>
                      <div class="headline">Kas? {{ event.title }}</div>
                      <div>Kur? {{ event.location }}</div>
                      <div>Kada? {{ event.date }}</div>
                      <div>{{ event.comment }}</div>
                      <v-btn v-if="event.status == 1" flat icon color="red" v-on:click="cancel(event.eventId)">
                        <v-icon>clear</v-icon>
                      </v-btn>
                      <v-btn v-else-if="event.status == 2 || event.status == 3 || event.status == 0 || event.status == null" flat icon color="green" v-on:click="attend(event.eventId)">
                        <v-icon>done</v-icon>
                      </v-btn>
                      <v-btn flat icon color="white" @click.native.stop="commentDialog = true" v-on:click="getComments(event.eventId)">
                        <v-icon>chat_bubble</v-icon>
                      </v-btn>
                      <v-btn flat icon color="white" @click.native.stop="invitableUsersDialog = true" v-on:click="getInvitableUsers(event.eventId)">
                        <v-icon>send</v-icon>
                      </v-btn>
                      <v-btn flat icon color="white" @click.native.stop="participantsDialog = true" v-on:click="getParticipants(event.eventId)">
                        <v-icon>people</v-icon>
                      </v-btn>
                    </div>
                  </v-flex>
                </v-layout>
              </v-container>
            </v-card>
          </v-flex>
        </v-layout>

      <v-dialog v-model="commentDialog" transition="dialog-bottom-transition">
        <v-card>
          <v-toolbar dark color="primary">
            <v-btn icon @click.native="commentDialog = false">
              <v-icon>close</v-icon>
            </v-btn>
            <v-toolbar-title>Comments</v-toolbar-title>
            <v-spacer></v-spacer>
            <v-toolbar-items>
              <v-btn flat :disabled="!newCommentValid"
                      v-on:click="addNewComment(tempEventId)">
                      Comment
                      </v-btn>
            </v-toolbar-items>
          </v-toolbar>
          <v-card flat fixed>
            <v-card-text>
              <v-container fluid>
            <v-layout row>
              <v-flex xs12>
                <v-text-field
                name="newComment"
                label="Your Comment"
                id="newComment"
                v-model="newComment"
                required
                ></v-text-field>
              </v-flex>
            </v-layout>
          </v-container>
        </v-card-text>
        </v-card>
        <v-container fluid>
        <v-layout row>
          <v-flex xs12>
            <v-list three-line subheader>
              <div>
                <p style="font-size: 20px;" v-for="comment in comments" :key="comment.name">{{ comment.name }} : {{ comment.comment }}</p>
              </div>
            </v-list>
          </v-flex>
        </v-layout>
        </v-container>
        </v-card>
      </v-dialog>

      <v-dialog v-model="participantsDialog">
      <v-card>
        <v-card-title>
          <v-tabs dark primary v-model="active">
      <v-tabs-bar>
        <v-tabs-item
          v-for="tab in tabs"
          :key="tab"
          :href="'#' + tab">
          {{ tabNames[tab.slice(-1) - 1] }}
        </v-tabs-item>
        <v-tabs-slider color="white"></v-tabs-slider>
      </v-tabs-bar>
      <v-tabs-items>
        <v-tabs-content
          v-for="tab in tabs"
          :key="tab"
          :id="tab">
          <v-card>
            <v-card-text v-if="tab.slice(-1) == 1" v-for="g in going" :key="g.name">{{ g.name }}</v-card-text>
            <v-card-text v-if="tab.slice(-1) == 2" v-for="n in notGoing" :key="n.name">{{ n.name }}</v-card-text>
            <v-card-text v-if="tab.slice(-1) == 3" v-for="u in unanswered" :key="u.name">{{ u.name }}</v-card-text>
          </v-card>
        </v-tabs-content>
      </v-tabs-items>
    </v-tabs>
    </v-card-title>
      </v-card>
    </v-dialog>

    <v-dialog v-model="invitableUsersDialog">
      <v-card>
        <v-card-title class="headline">Invite your friends!</v-card-title>
        <v-card-text>
          <v-list two-line subheader>
            <v-list-tile avatar v-for="invitable in invitables" v-bind:key="invitable.name">
              <v-list-tile-content>
                <v-list-tile-title>{{ invitable.name }}</v-list-tile-title>
              </v-list-tile-content>
              <v-list-tile-action>
                <v-btn icon ripple v-on:click="inviteUser(tempInviteEventId, invitable.userId)">
                  <v-icon color="primary">send</v-icon>
                </v-btn>
              </v-list-tile-action>
            </v-list-tile>
          </v-list>
        </v-card-text>
      </v-card>
    </v-dialog>
    <v-navigation-drawer
      temporary
      right
      v-model="drawer2"
      light
      absolute
    >
      <v-list class="pa-1">
        <v-list-tile>
          <v-list-tile-content>
            <v-list-tile-title>Groups</v-list-tile-title>
          </v-list-tile-content>
          </v-list-tile-action>
        </v-list-tile>
      </v-list>
      <v-list class="pt-0" dense>
        <v-divider></v-divider>
        <v-list-tile v-for="group in groups" :key="group.text" v-on:click="getEvents(group.value)">
          <v-list-tile-content>
            <v-list-tile-title>{{ group.text }}</v-list-tile-title>
          </v-list-tile-content>
        </v-list-tile>
      </v-list>
      <v-divider></v-divider>
      <v-list class="pa-1">
        <v-list-tile>
          <v-list-tile-content>
            <v-list-tile-title>Rooms</v-list-tile-title>
          </v-list-tile-content>
        </v-list-tile>
        <v-divider></v-divider>
        <v-list-tile router
        :to="{ name: 'Room' }">
          <v-list-tile-content>
            <v-list-tile-title>Pietūs</v-list-tile-title>
          </v-list-tile-content>
        </v-list-tile>
      </v-list>
    </v-navigation-drawer>
</v-container>
</template>

<script>
import auth from "../../js/auth.js";
import router from "../../router/index.js";

export default {
  data() {
    return {
      events: [],
      commentDialog: false,
      comments: [],
      tempEventId: null,
      newComment: "",
      participantsDialog: false,
      going: [],
      notGoing: [],
      unanswered: [],
      tabs: ["tab-1", "tab-2", "tab-3"],
      tabNames: ["Going", "Not Going", "Unanswered"],
      active: null,
      invitableUsersDialog: false,
      invitables: [],
      tempInviteEventId: null,
      auth: auth,
      drawer2: false,
      groups: [],
      tempGroupId: null
    };
  },
  methods: {
    check: function() {
      let token = localStorage.getItem("access_token");
      if (!token) {
        router.push("/login");
      }
    },
    addNewComment: function(eventId) {
      var data = {
        userId: auth.user.id,
        comment: this.newComment
      };
      this.$http
        .post("comments/" + eventId, data, {
          headers: {
            Authorization: "Bearer " + localStorage.getItem("access_token")
          }
        })
        .then(response => {
          this.getComments(eventId);
          this.newComment = "";
        });
    },
    getEvents: function(groupId) {
      if(groupId) {
      this.$http.get("events/group/" + groupId, {
          headers: {
            Authorization: "Bearer " + localStorage.getItem("access_token")
          }
        })
        .then(function(response) {
          this.events = response.data;
          this.tempGroupId = groupId;
          this.drawer2 = false
        });
      } else {
        this.$http.get("events", {
          headers: {
            Authorization: "Bearer " + localStorage.getItem("access_token")
          }
        })
        .then(function(response) {
          this.events = response.data;
        });
      }
      
    },
    getComments: function(eventId) {
      this.$http
        .get("comments/" + eventId, {
          headers: {
            Authorization: "Bearer " + localStorage.getItem("access_token")
          }
        })
        .then(function(response) {
          this.comments = response.data.reverse();
          this.tempEventId = eventId;
        });
    },
    getParticipants: function(eventId) {
      this.$http
        .get("userevent/" + eventId, {
          headers: {
            Authorization: "Bearer " + localStorage.getItem("access_token")
          }
        })
        .then(function(response) {
          var going = [];
          var notGoing = [];
          var unanswered = [];
          response.data.forEach(function(element) {
            if (element.status == 1) {
              going.push(element);
            }
            if (element.status == 2) {
              notGoing.push(element);
            }
            if (element.status == 3) {
              unanswered.push(element);
            }
          });
          this.going = going;
          this.notGoing = notGoing;
          this.unanswered = unanswered;
        });
    },
    getGroups: function() {
      this.$http
        .get("groups", {
          headers: {
            Authorization: "Bearer " + localStorage.getItem("access_token")
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
          this.groups = data;
        });
    },
    attend: function(eventId) {
      var data = {
        userId: this.auth.user.id,
        status: 1,
        eventId: eventId
      };
      this.$http
        .post("userevent", data, {
          headers: {
            Authorization: "Bearer " + localStorage.getItem("access_token")
          }
        })
        .then(response => {
          this.getEvents(this.tempGroupId);
        });
    },
    cancel: function(eventId) {
      var data = {
        userId: this.auth.user.id,
        status: 2,
        eventId: eventId
      };
      this.$http
        .post("userevent", data, {
          headers: {
            Authorization: "Bearer " + localStorage.getItem("access_token")
          }
        })
        .then(response => {
          this.getEvents(this.tempGroupId);
        });
    },
    next() {
      this.active = this.tabs[
        (this.tabs.indexOf(this.active) + 1) % this.tabs.length
      ];
    },
    getInvitableUsers: function(eventId) {
      this.$http
        .get("userevent/invitable/" + eventId, {
          headers: {
            Authorization: "Bearer " + localStorage.getItem("access_token")
          }
        })
        .then(function(response) {
          this.invitables = response.data;
          this.tempInviteEventId = eventId;
        });
    },
    inviteUser: function(eventId, userId) {
      var data = {
        userId: userId,
        eventId: eventId,
        status: 3
      };
      this.$http
        .post("userevent", data, {
          headers: {
            Authorization: "Bearer " + localStorage.getItem("access_token")
          }
        })
        .then(response => {
          this.invitableUsersDialog = false
        });
    }
  },
  computed: {
    newCommentValid() {
      return this.newComment !== "";
    }
  },
  created: function() {
    this.check();
    this.getEvents(null)
    this.getGroups();
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

div.dialog.dialog--active {
  max-width: 500px !important;
  max-height: 500px !important;
}
.main {
  background-image: url("../../assets/space.jpg");
}
</style>
