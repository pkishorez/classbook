var options={
	host : "www.google.co.in",
	port : 80,
	path : "/index.html",
	method : "GET"
};
var request=require("http").request(options,function(response){
	console.log("response Status  :  "+response.statusCode);
	response.on("data",function(data){
		console.log(data.toString());
	});
});
