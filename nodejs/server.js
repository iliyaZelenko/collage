// Использовать пока Vue вместо React, разобратся с babel под nodejs
// import Express from 'express'
// import express  from 'express';
// import http  from 'http';
//
// const app = express();

var  app = require('express')();
const PORT = 3000;
var server = app.listen(PORT);
var  io = require('socket.io')(server);
var  redis = require('redis');

// var chatUsers = [];



console.log(`Listening on ${PORT}...`);



io.on('connection', function (socket) {
    var redisClient = redis.createClient();

    // socket.emit('setup', {
    //     rooms: chatUsers
    // });

    redisClient.on("message", function(channel, dataJson) {
        var data = JSON.parse(dataJson);

        console.log(`[redisClient]:${channel} | [${data.user}]: ${data.message}`);
        socket.emit( channel, JSON.stringify(data) );
    });
    // redisClient.on("userConnect", function(channel, dataJson) {
    //     var data = JSON.parse(dataJson);
    //
    //     console.log(`[redisClient]:${channel} | ${data.user} has connected`);
    //     io.emit('userConnect', data);
    // });

    redisClient.subscribe('message');

    socket.on('userConnect', function(data) {
        console.log(`User ${data['username']} connected`);
    });
    socket.on('message', function(data) {
        io.emit('client_message', data);
        console.log(`[${data['user']}]: ${data['message']}`);
    });
    socket.on('disconnect', function() {
        console.log('User disconnected');
        redisClient.quit();
    });
});