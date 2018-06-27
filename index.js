// var server = require('http').Server();
var app = require('express')();
var server = require('http').Server(app);
//var io = require('socket.io')(server);
var io = require('socket.io')(server);

const PORT = process.env.PORT || 3000;
server.listen(PORT, () => console.log(`Listening on ${ PORT }`));
// server.listen(3000);


io.on('connection', function(socket){
	console.log('New User Conected here');
socket.on('Typing',function(data , room){
// console.log(data + '  ' + room);	
	socket.to(room).emit('roomTyping',data);

	//socket.to(room).emit('clientMessage',data);

});

socket.on('newMessage',function(data , room){
	//console.log(data);
	socket.to(room).emit('clientMessage',data);

});

socket.on('newUserJoin', function(data ,room ){
	socket.to(room).emit('joinNewUser',data);	
	});

socket.on('joinRoom', function(room ){

	//console.log('Join in  this Room '+ room);
	socket.join(room);
	
	});

});


// redis.on('message', function(channel, message) {
// 	console.log(message);
// 	socket.join(channel);
//     message = JSON.parse(message);

//     socket.to(channel).emit(channel + ':' + message.event, message.data);
// });

// var Redis = require('ioredis');
// var redis = new Redis();

// redis.subscribe('Forsan');