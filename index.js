var io = require('socket.io')(6001);

io.on('connection', function (socket) {
   console.log('New connection', socket.id);
   /*socket.emit('server-info', {version : .1});*/

   socket.on('message', function (data) {
      socket.broadcast.send(data);
   });
});

/*var app = require ('express')();
var server = require ('http').Server(app);
var io = require('socket.io')(server);

server.listen(8000);

app.get('/', function (request, response) {
   response.sendFile(__dirname + '/index.html');
});

io.on('connection', function(socket){
    console.log("Connection!!!");
    socket.on('chat.message', function (message) {
        io.emit('chat.message', message);
    });
});*/
// var app = require('express')();
// var server = require('http').Server(app);
// var io = require('socket.io')(server);
// var redis = require('redis');
//
// server.listen(8001);
// io.on('connection', function (socket) {
//
//     console.log("client connected");
//     var redisClient = redis.createClient();
//     redisClient.subscribe('message');
//
//     redisClient.on("message", function(channel, data) {
//         console.log("mew message add in queue "+ data['message'] + " channel");
//         socket.emit(channel, data);
//     });
//
//     socket.on('disconnect', function() {
//         redisClient.quit();
//     });
//
// });
