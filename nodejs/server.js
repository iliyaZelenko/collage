// Использовать пока Vue вместо React, разобратся с babel под nodejs
// import Express from 'express'
// import express  from 'express';
// import http  from 'http';
//
// const app = express();

const app = Express();
const port = 3000;
var server = app.listen(port);
var io = require('socket.io')(server);
var redis = require('redis');

console.log(`Listening on ${port}...`);

io.on('connection', function (socket) {

    console.log("User connected");
    // var redisClient = redis.createClient();
    // redisClient.subscribe('message');

    // redisClient.on("message", function(channel, data) {
    //     console.log("New message add in queue "+ data['message'] + " channel");
    //     socket.emit(channel, data);
    // });
    socket.on('message', function(data) {
        io.emit('message', data);
        console.log(`[${data['user']}]: ${data['message']}`);
    });

    socket.on('disconnect', function() {
        console.log('User disconnected');
        // redisClient.quit();
    });
});