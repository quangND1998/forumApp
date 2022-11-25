var app = require('express')();
var http = require('http').Server(app);
var io = require('socket.io')(http);
var Redis = require('ioredis');
var redis = new Redis();
redis.psubscribe('replie_event.*', function(err, count) {});
redis.psubscribe('device-session.*', function(err, count) {});
redis.subscribe('sovled-conversation', function(err, count) {});
redis.subscribe('active-device', function(err, count) {});
redis.subscribe('like_event', function(err, count) {});
redis.subscribe('conversation_event', function(err, count) {});
redis.subscribe('deleteConversation_event', function(err, count) {});

redis.on('message', function(channel, message) {
    message = JSON.parse(message);
    console.log('Message Recieved: ' + message.event);
    console.log('Message Recieved: ' + message);
    io.emit(channel + ':' + message.event, message.data, send_to_self = false);
    // io.sockets.on("connect", (socket) => {
    //     console.log('connect', socket)
    //     socket.broadcast.emit(channel + ':' + message.event, message.data, send_to_self = false);
    // })

});
redis.on('pmessage', function(pattern, channel, message) {
    message = JSON.parse(message);
    console.log('pmessage', channel);
    console.log('Message Recieved pmessage: ' + message.event);
    io.emit(channel + ':' + message.event, message.data);
    // io.sockets.on("connection", (socket) => {
    //     console.log('connect', socket)
    //     socket.broadcast.emit(channel + ':' + message.event, message.data, send_to_self = false);
    // })


});

http.listen(3000, function() {
    console.log('Listening on Port 3000');
});