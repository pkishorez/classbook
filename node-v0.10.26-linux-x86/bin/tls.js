var fs = require('fs');
var https = require('https');
var options = {
key: fs.readFileSync('keys/server_key.pem'),
cert: fs.readFileSync('keys/server_cert.pem'),
requestCert : true,
};
var server = https.createServer(options, function(req, res) {
res.writeHead(200, {'Content-Type': 'text/plain'});
res.end('Hello World!');
});
server.listen(3333,function(){
	console.log("Server is listening on port "+server.address().port);
});
