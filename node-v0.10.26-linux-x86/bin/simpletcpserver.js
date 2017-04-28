var server=require("net").createServer(function(socket){
	console.log("Connection established!");
	socket.write("Hello dude what's up?");
	socket.end();
	socket.on("data",function(data){
		if (data.toString().trim()=="quit"){
			socket.write("Good bye dude...");
			return socket.end();
		}
		console.log(data.toString());
	});
	socket.on("end",function(){
		console.log("Connection ended!!!");
	});
}).listen(3333);
