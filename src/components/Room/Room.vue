   <template>
     <v-layout row>
            <v-flex xs12 sm8 offset-sm2>
                <v-card>
                    <v-card-text>
                        <v-flex xs12 sm10 offset-sm1>
                            <div id="discussion"></div>
                        </v-flex>
                    </v-card-text>
                    <v-card-actions>
                        <v-flex  xs12 sm10 offset-sm1>
                            <v-form>
 
                                <v-text-field
                                        label="Message"
                                        type="text"
                                        id="message"
                                        v-model="message"
                                        required
                                ></v-text-field>
                                <v-flex class="text-xs-right">
                                    <v-btn id="sendMessage" v-on:click="clearMessage()">Send</v-btn>
                                </v-flex>
 
                                <input type="hidden" id="displayname" />
                            </v-form>
                        </v-flex>
                    </v-card-actions>
                </v-card>
            </v-flex>
        </v-layout>
</template>

<script>
import Vue from "vue";
import * as CONFIG from "../../config.js";
import auth from "../../js/auth";
import router from "../../router/index.js";

export default {
  data() {
    return {
      auth: auth,
      message: '',
    };
  },
  methods: {
    start: function() {
      var connection;
      var back = localStorage.getItem("back");
      back == CONFIG.STUDENTAI
        ? (connection = $.hubConnection("http://studentai.azurewebsites.net"))
        : (connection = $.hubConnection(
            "http://trycatch2017.azurewebsites.net"
          ));
      var chatHubProxy = connection.createHubProxy("ChatHub");

      chatHubProxy.on("broadcastMessage", function(name, message) {
        var encodedName = $("<div />")
          .text(name)
          .html();
        var encodedMsg = $("<div />")
          .text(message)
          .html();
        $("#discussion").append(
          "<li><strong>" +
            encodedName +
            "</strong>:&nbsp;&nbsp;" +
            encodedMsg +
            "</li>"
        );
      });
      connection.start().done(function() {
        var token = localStorage.getItem("access_token");
        var name = '';
        if (token != null) {
          $.ajax({
            url: localStorage.getItem("back") + "user",
            type: "GET",
            beforeSend: function(xhr, settings) {
              xhr.setRequestHeader("Authorization", "Bearer " + token);
            },
            success: function(res) {
              $("#displayname").val(res.name);
              name = res.name;
              chatHubProxy.invoke(
                "Send",
                $("#displayname").val(),
                " now connected!"
              );
            }
          });

          $(".logo").on("click", function(){
            $("#displayname").val(name);
            chatHubProxy.invoke(
                "Send",
                $("#displayname").val(),
                " disconnected!"
              );
          connection.stop();
          });

          window.onbeforeunload = function(e) {
            $("#displayname").val(name);
            chatHubProxy.invoke(
                "Send",
                $("#displayname").val(),
                " disconnected!"
              );
            connection.stop();
            };

            window.onhashchange = function() {
              $("#displayname").val(name);
              chatHubProxy.invoke(
                "Send",
                $("#displayname").val(),
                " disconnected!"
              );
              connection.stop();
            }

          $("#sendMessage").on("click", function() {
            chatHubProxy.invoke(
              "Send",
              $("#displayname").val(),
              $("#message").val()
            );
          });

          $("#message").keyup(function(e){ 
            var code = e.which; 
              if(code==13)e.preventDefault();
              if(code==13){
                chatHubProxy.invoke(
              "Send",
              $("#displayname").val(),
              $("#message").val()
            );
            $("#message").val("").focus();
            } 
          });   
        }
      });
    },
    check: function() {
      let token = localStorage.getItem("access_token");
      if (!token) {
        router.push("/login");
      }
    },
    clearMessage: function () {
      this.message = ''
    }
  },
  created: function() {
    this.check()
    this.start()
  }
};
</script>


<style lang="css">
.main {
  background-image: url("../../assets/space.jpg");
  background-position: center center;
  background-repeat:  no-repeat;
  background-attachment: fixed;
  background-size:  cover;
}
</style>
