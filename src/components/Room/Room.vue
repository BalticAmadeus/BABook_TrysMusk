   <template>
     <v-layout row>
            <v-flex xs12 sm8 offset-sm2>
                <v-card>
                    <v-card-title>
                        <v-flex class="text-xs-center">
                            <v-btn round primary v-on:click="start" :disabled="disabled">
                                Start discussion
                            </v-btn>
                        </v-flex>
                    </v-card-title>
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
                                        required
                                ></v-text-field>
                                <v-flex class="text-xs-right">
                                    <v-btn id="sendMessage">Send</v-btn>
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

export default {
  data() {
    return {
      disabled: false,
     
    };
  },
  methods: {
    start: function() {
      this.disabled = true
      var connection = $.hubConnection("http://trycatch2017.azurewebsites.net");
      var chatHubProxy = connection.createHubProxy("ChatHub");

      chatHubProxy.on("broadcastMessage", function(name, message) {
        var encodedName = $("<div />")
          .text(name)
          .html();
        var encodedMsg = $("<div />")
          .text(message)
          .html();
        // Add the message to the page.
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

        if (token != null) {
          $.ajax({
            url: "http://trycatch2017.azurewebsites.net/api/user",
            type: "GET",
            beforeSend: function(xhr, settings) {
              xhr.setRequestHeader("Authorization", "Bearer " + token);
            },
            success: function(res) {
              $("#displayname").val(res.name);
              chatHubProxy.invoke(
                "Send",
                $("#displayname").val(),
                " now connected!"
              );
              $("#message")
                .val("")
                .focus();
            }
          });

          $("#sendMessage").on("click", function() {
            chatHubProxy.invoke("Send", $("#displayname").val(), $("#message").val());
            $("#message").empty();
          });
        }
      });
    }
  },

};
</script>


<style lang="css">

</style>
