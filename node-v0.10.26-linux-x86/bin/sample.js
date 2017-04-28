require("http").createServer( function(req,res){
	var file=require("fs").createReadStream("sample.js");
	file.on("data",function(data){
		if(!res.write(data)){
			file.pause();
		}
	});
	res.on("drain",function(){
		file.resume();
	});
	file.on("end",function(){
		res.end();
		console.log("Request accomplished");
	});
}).listen(3333);
