var httpd=require("http").createServer();var io=require("socket.io").listen(httpd);var fs=require("fs");httpd.listen(3333);var userSockets={};var onlineList=[];var notifications=[];io.sockets.on("connection",function(e){e.on("clientMessage",function(t){e.emit("serverMessage","You said: "+t);e.broadcast.emit("serverMessage",e.id+" said: "+t)});e.on("broadcast",function(e){});e.on("wall_liked",function(t){e.get("username",function(n,r){if(n)throw n;notifications.push({action:"like",data:t});e.broadcast.emit("wall_liked",t)})});e.on("wall_unliked",function(t){e.get("username",function(n,r){if(n)throw n;notifications.push({action:"unlike",data:t});e.broadcast.emit("wall_unliked",t)})});e.on("wall_commented",function(t){e.get("username",function(n,r){if(n)throw n;notifications.push({action:"comment",data:t});e.broadcast.emit("wall_commented",t)})});e.on("wall_comment_deleted",function(t){e.broadcast.emit("wall_comment_deleted",t)});e.on("wall_delete",function(t){e.broadcast.emit("deletewall",t)});e.on("message",function(e){if(userSockets[e["to"]]!==undefined){userSockets[e["to"]].emit("message",e)}});e.on("seen",function(t){e.get("username",function(e,n){if(userSockets[t["from"]]!==undefined)userSockets[t["from"]].emit("seen",t)})});e.on("newwall",function(t,n){e.get("username",function(n,r){e.broadcast.emit("newwall",t)})});e.on("login",function(t){e.set("username",t,function(n){if(n){throw n}onlineList.push(t);userSockets[t]=e;e.emit("loggedin",t);e.emit("notifications",notifications);e.emit("updateonlinelist",onlineList);e.broadcast.emit("online",t)})});e.on("disconnect",function(){e.get("username",function(t,n){e.broadcast.emit("offline",n);onlineList.splice(onlineList.indexOf(n),1);userSockets[n]=undefined})});e.emit("login");e.on("emergency",function(t){e.get("username",function(n,r){if(n)throw n;if(r=="N090041"){if(t=="all")e.broadcast.emit("emergency");else{if(userSockets[t]!=undefined)userSockets[t].emit("emergency")}}})})})