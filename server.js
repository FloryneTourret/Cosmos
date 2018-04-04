var http=require('http');

var port=8080;
var chat='';

var server=http.createServer(function (req, res) {
    res.writeHead(200);
    res.write('Ok...');
    res.end();
});

var io=require('socket.io').listen(server);

io.sockets.on('connection', function (socket) {
    io.sockets.emit('serveurversclient', chat);

    socket.on('clientversserveur', function (texte) {
        chat +=texte+"<br> \n";
        io.sockets.emit('serveurversclient', chat);
    });
});

server.listen(port);
console.log("On écoute sur le port "+port);