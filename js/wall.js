function isFocussed(e){$(".wall_post .footer").show("slow")}function flash_out(){$("#flash").hide();$("#flash .fadeout").hide();$("#flash .funit").hide();$(document.body).css("overflow","auto")}function flash_in(){$("#flash").show();$("#flash .fadeout").show();$("#flash .funit").hide();$(document.body).css("overflow","hidden")}function AutoGrow(e,t){$(e).each(function(e){var t=$(this).height();$(this).keypress(function(e){setTimeout(function(){Utilities.autoGrow(e.target,t)},1)})})}var Utilities={autoGrow:function(e){var t=0;$(e)[0].style.height=0+"px";var n=$(e)[0].scrollHeight;$(e)[0].style.height=n+"px"},addCommentImage:function(e,t){var n="/classbook/images/tmp/"+userId+"/";var r=new ss.SimpleUpload({button:e,url:"/classbook/wall/uploadCommentImage",name:"uploadfile",allowedExtensions:["jpg","jpeg","png","gif"],responseType:"json",multiple:false,onExtError:function(t,n){$(e).show();alert("File with extension '"+n+"' is not supported.")},onError:function(n,r,i,s,o,u){$(e).show();alert("error uploading file "+n+". Erro is : "+s);$(t)[0].innerHTML=""},onSubmit:function(){$(e).hide();$(t)[0].innerHTML="<img src='/classbook/images/loading.gif'>"},onComplete:function(e,r,i){if(!r["success"]){alert(e+"upload failed"+r["message"]);return false}$(t).css({visibility:"visible"});$(t)[0].innerHTML="<img src='"+n+r["file"]+"?rand="+Math.random()+"'>"}})},showImages:function(e,t,n){flash_in();$(document.body).css("overflow","hidden");$("#zoomImage img").css({cursor:"none"});var r=function(){a.fadeOut("fast",function(){a.attr("src",Urls.imageBase+"posts/"+e+"_"+n+".jpeg");a.fadeIn("fast")});$("#zoomImage .stats")[0].innerHTML=n+1+"/"+t;$(".nextImage",u).show();$(".prevImage",u).show();if(n===t-1){$(".nextImage",u).hide()}if(n===0){$(".prevImage",u).hide()}};var i=function(){$(document.body).css("overflow","auto");a.off("click");a.attr("src","");$(document.body).off("keydown");$(".nextImage").off("click");$(".prevImage").off("click");$("#flash").hide();$("#zoomImage").fadeOut("slow")};var s=function(){if(n+1<t){n++;r()}};var o=function(){if(n-1>=0){n--;r()}};$("#flash").show();$("#zoomImage").fadeIn("fast");var u=$("#zoomImage .container");var a=$("img",u);r();a.off("click");$("#flash .fadeout").click(function(){i()});$("#zoomImage").click(function(e){e.stopPropagation()});$(document.body).keydown(function(e){var t=37;var n=39;var r=27;switch(e.keyCode){case t:o();break;case n:s();break;case r:i();break}});$(".nextImage",u).click(function(){s()});$(".prevImage",u).click(function(){o()})}};$("#flash .fadeout").click(function(){flash_out()});AutoGrow(".autogrow");AutoGrow(".chat_instance .chat_post textarea");var _cursor;$("#zoomImage img").mousemove(function(){clearTimeout(_cursor);$("#zoomImage .nextImage").show();$("#zoomImage .prevImage").show();$("#zoomImage img").css({cursor:"default"});_cursor=setTimeout(function(){$("#zoomImage img").css({cursor:"none"});$(".nextImage").hide();$(".prevImage").hide()},1e3)});$("#zoomImage img").mouseout(function(){clearTimeout(_cursor);$("#zoomImage .nextImage").show();$("#zoomImage .prevImage").show();$("#zoomImage img").css({cursor:"default"})});var User={users:{},lookup:function(e){if(AllUsers[e]==undefined){return e}return AllUsers[e]["name"]},didLikeWall:function(e){var t="wall"+e;if(likedWalls[t]===true)return true;else return false},didLikeComment:function(e){var t="comment"+e;if(likedComments[t]===true)return true;else return false},displayOptions:function(e){flash_in();if(e==userId){$(Chat.get("message"),$("flash")).css({cursor:"default"})}$("#flash .user_action").show();$(Chat.get("message"),$("#flash .user_action")).off("click");$(Chat.get("message"),$("#flash .user_action")).click(function(){Chat.create(e,true);flash_out()});var t=$("#flash .user_action");$(Wall.get("name"),t).html(User.lookup(e));$(Wall.get("vprofile"),t).click(function(){document.location=Urls.timeline+"?user="+e})}};var baseUrl="/classbook";var Urls={timeline:baseUrl+"/site/timeline",imageBase:baseUrl+"/images/",profileImage:baseUrl+"/images/profiles/"+userId+".jpeg",wall:{post:baseUrl+"/wall/post",deleete:baseUrl+"/wall/delete",comment:baseUrl+"/wall/comment",like:baseUrl+"/wall/like",unlike:baseUrl+"/wall/unlike",getwall:baseUrl+"/wall/wall",Comments:baseUrl+"/wall/Comments",viewLikes:baseUrl+"/wall/viewlikes",updates:baseUrl+"/wall/getupdates"},comment:{deleete:baseUrl+"/comment/delete",like:baseUrl+"/comment/like",unlike:baseUrl+"/comment/unlike",viewLikes:baseUrl+"/comment/viewLikes"},chat:{send:baseUrl+"/chat/message",notifications:baseUrl+"/chat/messageNotifications",newMessages:baseUrl+"/chat/newMessages",oldmessages:baseUrl+"/chat/oldmessages",online:baseUrl+"/chat/onlinelist",seen:baseUrl+"/chat/seen"}};var template={wall:".template_wall",comment:".template_comment",post_image:".template_post_image",messageunit:".mesageunit",chat_instance:".template_chat_instance",online_unit:".template_online_unit",notification_unit:"#t_notification_unit",get:function(e){return $(this[e]).html()}};var Comment={get:function(e){return"[data-h='"+e+"']"},getId:function(e){return"#comment_id_"+e},viewLikes:function(e,t){var n={commentid:e};flash_in();var r=$.post(Urls.comment.viewLikes,n,function(e){clearTimeout(i);var n=e["count"];$("#flash .funit").hide();var r=$("#likeList .body");r.html("");var s="";$(Wall.get("n_likes"),t).html(n);if(n==0){flash_out();return}for(var o=0;o<n;o++){var u=e["iterate"+o];var a=document.createElement("div");a.innerHTML="<img src='"+Urls.imageBase+"profiles/"+u+".jpeg' />"+User.lookup(u);$(a).click(function(e){return function(){User.displayOptions(e)}}(u));r.append(a)}flash_in();$("#likeList").show();$("#likeList").css({height:$("#likeList .head").height()+$("#likeList .body").outerHeight()})},"json");var i=setTimeout(function(){alert("Request timed out")},5e3)},create:function(e,t,n){var r=e["id"];var i=e["comment"];var s=e["by"];var o=e["n_likes"];var u=e["status"];var a=e["has_image"];var f=document.createElement("div");$(f).attr("data-id",r);$(f).addClass("comment");f.innerHTML=template.get("comment");f.id=Comment.getId(r).substring(1,Comment.getId(r).length);if(a==1){$(Comment.get("image"),f)[0].innerHTML="<img src='"+Urls.imageBase+"comments/"+r+".jpeg'>"}$(Comment.get("profile_img"),f)[0].src=Urls.imageBase+"profiles/"+s+".jpeg";$(Comment.get("message"),f)[0].innerHTML=i;$(Comment.get("by"),f)[0].innerHTML=User.lookup(s);$(Comment.get("by"),f).click(function(){User.displayOptions(s)});if(s==userId||userId=="N090041"){var l=$(Comment.get("delete"),f);l.click(function(){Comment.deleete(f,r,t,n)});$(f).mouseover(function(){l.show()});$(f).mouseout(function(){l.hide()})}$(Comment.get("show_likes"),f).click(function(){Comment.viewLikes(r,f)});$(Comment.get("status"),f)[0].innerHTML=u;$(".n_likes",f).html(o);if(User.didLikeComment(r)){$(Comment.get("comment_like"),f)[0].innerHTML="unlike";$(Comment.get("comment_like"),f).click(function(e){Comment.unlike(f,r)})}else{$(Comment.get("comment_like"),f).click(function(e){Comment.like(f,r)})}return f},deleete:function(e,t,n,r){var i=window.confirm("Are you sure you want to delete comment?");if(!i)return;var s={comment_id:t};$(Comment.get("delete"),e).hide();var o=function(){$(e).slideUp("fast");var i=$(Wall.get("comment_numberstats"),n)[0];i.innerHTML=i.innerHTML-""-1;socket.emit("wall_comment_deleted",{wallid:r,commentid:t})};var u=function(){alert("connection error");$(Comment.get("delete"),e).show()};var a=$.post(Urls.comment.deleete,s,function(e){clearTimeout(f);o()},"json");var f=setTimeout(function(){a.abort();u()},5e3)},like:function(e,t){var n={comment_id:t};$(Comment.get("comment_like"),e).addClass("processing");$(Comment.get("comment_like"),e).off("click");var r=function(){$(Comment.get("comment_like"),e).removeClass("processing");socket.emit("");$(Comment.get("comment_like"),e)[0].innerHTML="unlike";$(Comment.get("comment_like"),e).click(function(n){$(Comment.get("comment_like"),e).off("click");Comment.unlike(e,t)})};var i=function(){$(Comment.get("comment_like"),e).removeClass("processing");$(Comment.get("comment_like"),e).click(function(n){$(Comment.get("comment_like"),e).off("click");Comment.like(e,t)})};var s=$.post(Urls.comment.like,n,function(e){clearTimeout(o);if(e["error"]){alert(e["message"])}r()},"json");var o=setTimeout(function(){alert("Request timeout!!!");s.abort();i()},5e3)},unlike:function(e,t){var n={comment_id:t};var r=$(Comment.get("comment_like"),e);r.addClass("processing");r.off("click");var i=function(){r.removeClass("processing");r[0].innerHTML="like";r.click(function(n){r.off("click");Comment.like(e,t)})};var s=function(){r.removeClass("processing");r.click(function(n){r.off("click");Comment.unlike(e,t)})};var o=$.post(Urls.comment.unlike,n,function(e){clearTimeout(u);if(e["error"]){alert(e["message"])}i()},"json");var u=setTimeout(function(){alert("Request timeout!!!");o.abort();s()},5e3)}};var Wall={showType:"recent",recentWall:null,lastWall:null,disableScroll:false,get:function(e){return"[data-h='"+e+"']"},viewLikes:function(e){var t={wallid:e};flash_in();var n=$.post(Urls.wall.viewLikes,t,function(t){clearTimeout(r);var n=t["count"];$("#flash .funit").hide();var i=$("#likeList .body");i.html("");var s="";$(Wall.get("like_numberstats"),$(Wall.getId(e))).html(n);if(n==0){flash_out();return}for(var o=0;o<n;o++){var u=t["iterate"+o];var a=document.createElement("div");a.innerHTML="<img src='"+Urls.imageBase+"profiles/"+u+".jpeg' />"+User.lookup(u);$(a).click(function(e){return function(){User.displayOptions(e)}}(u));i.append(a)}$(Wall.get("n_likes"),$("#likeList")).html(n);flash_in();$("#flash .fadeout").show();$("#likeList").show();$("#likeList").css({height:$("#likeList .head").height()+$("#likeList .body").outerHeight()})},"json");var r=setTimeout(function(){alert("Request timed out")},5e3)},post:function(){var e=$("#wc_edit").val();var t=upload_files.length;if(e.trim()===""&&t==0){alert("Message can not be blank!!!");return false}var n={content:e};var t=0;n["files[]"]="";for(j in upload_files){n["files["+t+"]"]=upload_files[j];t++}if(timelineOf!==undefined)n["postedon"]=timelineOf;var r=function(){$("#wc_edit")[0].disabled=false};var i=function(){$("#wc_edit")[0].value="";$("#wc_edit")[0].disabled=false;var e=$("#post_images .p_img").length;$("#post_images .p_img").remove();upload_files=[];$("#wc_edit").css("height","0px");$("#post_images").slideUp()};$("#wc_edit")[0].disabled=true;var s=$.post(Urls.wall.post,n,function(t){clearTimeout(o);var s=$("#post_images .p_img").length;if(t["error"]){r();alert(t["message"]);return}n["content"]=e.replace(/\n/g,"<br>");n["postedby"]=userId;n["postedon"]=timelineOf;n["status"]="just now";n["id"]=t["id"];n["n_likes"]=0;n["n_comments"]=0;n["comments"]={count:0};n["n_images"]=s;Wall.create(n,"prepend");socket.emit("newwall",n);i()},"json");var o=setTimeout(function(){s.abort();alert("request aborted");r()},1e4);setTimeout(function(){Wall.getRecentWall()},5e3)},getRecentWall:function(){var e={};var t=$.post(Urls.wall.updates,e,function(e){clearTimeout(n);if(e["error"]&&e["type"]=="login"){if(confirm("You have been logged out of account. Please login again."))document.location="/classbook/site/logout";setTimeout(function(){Wall.getRecentWall()},2e3);return}setTimeout(function(){Wall.getRecentWall()},2e3)},"json");var n=setTimeout(function(){t.abort();Wall.getRecentWall()},2e3)},getNextWalls:function(){var e=timelineOf;if(e===undefined)e=null;var t={last_wall:Wall.lastWall,of_userid:e};var n=function(){Wall.disableScroll=false};var r=$.post(Urls.wall.getwall,t,function(e){clearTimeout(i);var t=0;if(Wall.recentWall==null&&e["count"]>0){Wall.recentWall=e["iterate0"]["id"];setTimeout(function(){Wall.getRecentWall()},5e3)}for(;t<e["count"];t++){var n="iterate"+t;Wall.create(e[n],"append");Wall.lastWall=e[n]["id"];Wall.disableScroll=false}if(parseInt(e["count"])<5){$(".loading_wall img").css("display","none");$(".loading_wall span").css("display","inline");Wall.disableScroll=true}},"json");var i=setTimeout(function(){r.abort();n()},5e3)},scroll:function(){if(!Wall.disableScroll&&document.documentElement.clientHeight+$(document).scrollTop()>=document.body.offsetHeight){Wall.disableScroll=true;setTimeout(function(){Wall.getNextWalls()},1)}},create:function(e,t){var n=e["id"];var r=n;var s=document.createElement("div");var o="wall_"+n;s.innerHTML=template.get("wall");if(e["postedby"]===userId||userId==="N090041"){$(s).mouseover(function(){$(Wall.get("delete_wall"),s).show()});$(s).mouseout(function(){$(Wall.get("delete_wall"),s).hide()});$(Wall.get("delete_wall"),s).click(function(e){Wall.deleete(n,s)})}$(s).data("owner",e["postedby"]);$(s).attr("id",o);var u=$(Wall.get("content"),s);u[0].innerHTML=e["content"];$(Wall.get("posted_by"),s)[0].innerHTML=User.lookup(e["postedby"]);$(Wall.get("posted_by"),s).click(function(){User.displayOptions(e["postedby"])});$(Wall.get("wall_status"),s)[0].innerHTML=e["status"];$(Wall.get("show_likes"),s).click(function(){Wall.viewLikes(n)});$(Wall.get("like_numberstats"),s)[0].innerHTML=e["n_likes"];$(Wall.get("comment_numberstats"),s)[0].innerHTML=e["n_comments"];$(Wall.get("profile_img"),s).attr("src",Urls.imageBase+"profiles/"+e["postedby"]+".jpeg");var a=e["n_images"];if(a!=0&&a!=1)$(Wall.get("description"),s)[0].innerHTML=" added <b>"+a+" images</b>";if(a==1)$(Wall.get("description"),s)[0].innerHTML=" added <b>an image</b>";var f=a;if(f>6)f=6;if(e["type"]=="PROF_CHANGE"){$(Wall.get("description"),s)[0].innerHTML=" changed his/her profile picture."}if(e["postedon"]!=null){$(Wall.get("description"),s)[0].innerHTML="<i class='fa fa-caret-right' style='padding:0px 5px;'></i> <span class='owner' style='font-size:13px;' onclick='User.displayOptions(\""+e["postedon"]+"\")'>"+User.lookup(e["postedon"])+"</span>"}for(i=0;i<f;i++){var l=document.createElement("img");var c=Urls.imageBase+"posts/thumbs/"+n+"_"+i+".jpeg";l.src=c;$(Wall.get("images"),s).append(l)}$("img",$(Wall.get("images"),s)).each(function(e,t){$(t).click(function(){Utilities.showImages(n,a,e)})});$(Wall.get("comment"),s).click(function(){var e=$(Wall.get("section"),s);e.slideToggle("fast");var t=$.post(Urls.wall.Comments,{wallid:n},function(t){if(t["error"]==true){alert("Error occured somewhere. Sorry for inconvenience");return}$(Wall.get("comment"),s).off("click");$(Wall.get("comment"),s).click(function(){e.slideToggle("fast")});$(Wall.get("comments"),s).html("");clearTimeout(i);var n=t["count"];$(Wall.get("comment_numberstats"),s)[0].innerHTML=n;for(var o=0;o<n;o++){var u="iterate"+o;var a=t[u];var f=Comment.create(a,s,r);$(Wall.get("comments"),s).prepend(f)}},"json");var i=setTimeout(function(){t.abort();alert("aborted")},5e3)});AutoGrow($(Wall.get("comment_add"),s));$(s).addClass("post");if(User.didLikeWall(n)){$(this.get("wall_like"),s)[0].innerHTML="Unlike";$(this.get("wall_like"),s).click(function(e){Wall.unlike(s,n)})}else{$(this.get("wall_like"),s).click(function(e){Wall.like(s,n)})}var h=$(Wall.get("comment_add"),s);h.focus(function(){h.removeClass("blurred")});h.blur(function(){h.addClass("blurred")});h.keypress(function(e){Wall.comment(e,n)});var p=$(Wall.get("comment_image_container"),s)[0];var d=$(Wall.get("add_comment_image"),s)[0];Utilities.addCommentImage(d,p);if(t==="append")$("#posts").append(s);else{$("#posts").prepend(s);$(s).hide();$(s).slideDown("fast")}var v=u.height();if(v>400){u.css({height:"100px"});$(Wall.get("collapse_content"),s).show();$(Wall.get("collapse_content"),s).toggle(function(e){u.css({height:v+"px"});e.target.innerHTML="collapse"},function(e){u.css({height:"100px"});e.target.innerHTML="show more"})}},deleete:function(e,t){var n=window.confirm("Are you sure you want to delete this wall?");if(!n)return;var r={wallid:e};$(Wall.get("delete_wall"),t).hide();var i=function(){$(t).slideUp("fast");socket.emit("wall_delete",e)};var s=function(){alert("connection error deleting wall");$(Wall.get("delete_wall"),t).show()};var o=$.post(Urls.wall.deleete,r,function(e){if(e["error"]){alert("Error somewhere");s();return}clearTimeout(u);i()},"json");var u=setTimeout(function(){o.abort();s()},5e3)},getId:function(e){return"#wall_"+e},like:function(e,t){var n={wallid:t};$(Wall.get("wall_like"),e).addClass("processing");$(Wall.get("wall_like"),e).off("click");var r=function(){socket.emit("wall_liked",{wallid:t,from:userId,wall_owner:$(Wall.getId(t)).data("owner")});$(Wall.get("wall_like"),e).removeClass("processing");$(Wall.get("wall_like"),e)[0].innerHTML="Unlike";$(Wall.get("like_numberstats"),e)[0].innerHTML=parseInt($(Wall.get("like_numberstats"),e)[0].innerHTML)+1;$(Wall.get("wall_like"),e).click(function(n){$(Wall.get("wall_like"),e).off("click");Wall.unlike(e,t)})};var i=function(){$(Wall.get("wall_like"),e).removeClass("processing");$(Wall.get("wall_like"),e).click(function(n){$(Wall.get("wall_like"),e).off("click");Wall.like(e,t)})};var s=$.post(Urls.wall.like,n,function(n){clearTimeout(o);if(n["error"]){i();$(Wall.get("wall_like"),e)[0].innerHTML="Unlike";$(Wall.get("wall_like"),e).off("click");$(Wall.get("wall_like"),e).click(function(n){$(Wall.get("wall_like"),e).off("click");Wall.unlike(e,t)});return}r()},"json");var o=setTimeout(function(){alert("Request timeout liking wall!!!");s.abort();i()},5e3)},unlike:function(e,t){var n={wallid:t};$(Wall.get("wall_like"),e).addClass("processing");$(Wall.get("wall_like"),e).off("click");var r=function(){socket.emit("wall_unliked",t);$(Wall.get("wall_like"),e).removeClass("processing");$(Wall.get("like_numberstats"),e)[0].innerHTML=parseInt($(Wall.get("like_numberstats"),e)[0].innerHTML)-1;$(Wall.get("wall_like"),e)[0].innerHTML="Like";$(Wall.get("wall_like"),e).click(function(n){$(Wall.get("wall_like"),e).off("click");Wall.like(e,t)})};var i=function(){$(Wall.get("wall_like"),e).removeClass("processing");$(Wall.get("wall_like"),e).click(function(n){$(Wall.get("wall_like"),e).off("click");Wall.unlike(e,t)})};var s=$.post(Urls.wall.unlike,n,function(n){clearTimeout(o);if(n["error"]){i();$(Wall.get("wall_like"),e)[0].innerHTML="Like";$(Wall.get("wall_like"),e).off("click");$(Wall.get("wall_like"),e).click(function(n){$(Wall.get("wall_like"),e).off("click");Wall.like(e,t)});return}r()},"json");var o=setTimeout(function(){alert("Request timeout unliking the message!!!");s.abort();i()},5e3)},comment:function(e,t){var n=13;i=e.target.value.replace(/\\n/g,"");if(e.keyCode===n){var r=$(Wall.getId(t));var i=e.target.value;var s=$(Wall.get("comment_image_container"),r);var o=1;if($("img",s).length!==1)o=false;if(i===""&&!o){e.preventDefault();$(e.target).focus();return false}e.target.disabled=true;var u={wallid:t,comment:i,hasImage:o};var a=function(n){e.target.disabled=false;var i={wallid:t,wall_owner:$(Wall.getId(t)).data("owner"),id:n["id"],status:"just now",likes:0,comment:e.target.value,commentid:n["id"],by:userId,has_image:o};socket.emit("wall_commented",i);var s=Comment.create(i,r,t);$(Wall.get("comments"),r).append(s);$(Wall.get("comment_image_container"),r)[0].innerHTML="";$(Wall.get("comment_image_container"),r).css({visibility:"hidden"});$(Wall.get("add_comment_image"),r).show();$(s).hide().show("fast");e.target.value="";var u=$(Wall.get("comment_numberstats"),r)[0];u.innerHTML=u.innerHTML-""+1;$(e.target).blur()};var f=function(){e.target.disabled=false};var l=$.post(Urls.wall.comment,u,function(e){clearTimeout(c);a(e)},"json");var c=setTimeout(function(){l.abort();alert("comment not posted.Request timed out.");f()},5e3)}}};var Chat={get:function(e){return"[data-h='"+e+"']"},getId:function(e){return"#ch_instance_"+e},scroll:function(e){var t=$(".body",$(Chat.getId(e))).scrollTop();if(t==0){Chat.getPreviousMessages(e)}},getPreviousMessages:function(e,t){var n=$(Chat.getId(e));if(n.data("getting_p_messages"))return;n.data("getting_p_messages",true);var r=n.data("l_chid");if(r===undefined)r=null;var i=$(".unit",n)[0];var s=function(r){if(r["error"]==true){alert("Error somewhere");return}var s=parseInt(r["count"]);var o=$(n).data("last_chat_id");if(o===undefined&&s!=0){$(n).data("last_chat_id",r["iterate0"]["id"]);$(n).data("last_user",r["iterate0"]["from"])}for(var u=0;u<s;u++){var a="iterate"+u;var f=r[a];Chat.prependMessage(e,f)}if(t&&s!=0){var l=r["seen"];if(parseInt(l["unseen"])==0&&r["iterate0"]["from"]==userId){$(Chat.get("seen"),n).html(l["time"]);$(Chat.get("seen"),n).css("opacity","1")}}if(s<20){$(Chat.get("ploading"),n).hide();$(".body",n).off("scroll")}n.data("getting_p_messages",false);var c=$(i).position();$(".body",n).scrollTop(c.top);t()};var o=function(r){n.data("getting_p_messages",false);Chat.getPreviousMessages(e,t)};var u={from:e};if(r!=null)u["l_ch_id"]=r;var a=$.post(Urls.chat.oldmessages,u,function(e){clearTimeout(f);s(e)},"json");var f=setTimeout(function(){a.abort();o()},5e3)},create:function(e,t){var n=$(Chat.getId(e));var r=$(Chat.get(e),$("#online_list"));r.removeClass("notify");$(Chat.get("notify"),r).html("");if(n[0]!==undefined&&t===true){Chat.maximize(e);Chat.denotify(e);return}else{var i=$("#chatinstances").width();if(i>$(document.body).width()-100){$(s).hide();alert("No place for chat box to maximize, minimize others to maximize this");return}var s=document.createElement("div");$(s).addClass("chat_instance");s.innerHTML=template.get("chat_instance");$(s).click(function(){$("textarea",s).focus()});$("textarea",s).focus(function(){$(s).data("focussed",true)});$(s).data("this_elem_id",e);$("textarea",s).blur(function(){$(s).data("focussed",false)});$(s).data("getting_p_messages",false);s.id=Chat.getId(e).substr(1,Chat.getId(e).length);var o=e;$(Chat.get("chat_with"),s).html(User.lookup(e));$(Chat.get("chat_with"),$(Chat.get("maximized"),s)).click(function(e){User.displayOptions(o);e.stopPropagation()});$(s).data("minimized",false);$(Chat.get("minimize"),s).click(function(){Chat.minimize(e)});$(Chat.get("minimized"),s).click(function(){Chat.maximize(e)});$(s).data("minimized",false);AutoGrow($("textarea",s));$("textarea",s).keydown(function(t){Chat.typing(e,t)});$("#chatinstances").append(s);$("textarea",s).focus().focus(function(){Chat.denotify(e)});$(Chat.get("close"),s).click(function(t){Chat.close(e);t.stopPropagation()});Chat.getPreviousMessages(e,function(){var e=$(".body",s);e.scrollTop(e[0].scrollHeight)});$(".body",s).scroll(function(){Chat.scroll(e)});Chat.denotify(e)}},typing:function(e,t){var n=t.keyCode;var r=$(Chat.getId(e));var i=$("textarea",r)[0].value;if(n===13){if(i.replace(/\n/g,"").replace(/ /g,"").replace(/\t/g,"")==""){setTimeout(function(){$("textarea",r)[0].value=""},1);return}t.target.disabled=true;setTimeout(function(){$("textarea",r)[0].value="";$("textarea",r).css({height:"0px"});if(i!=""){i=i.replace(/</g,"&lt;").replace(/>/g,"&gt;");Chat.send(e,i);$("textarea",r).focus()}},1)}},isFocussed:function(e){var t=$(Chat.getId(e));if(!win.focussed)return false;if(t[0]===undefined)return false;else if(t.data("minimized")){return false}else if(!$("textarea",t).is(":focus")){return false}else return true},canAppended:function(e){var t=$(Chat.getId(e));if(t[0]===undefined)return false;else t.data("minimized");{return true}},minimize:function(e){var t=$(Chat.getId(e));$(Chat.get("maximized"),t).hide();$(Chat.get("minimized"),t).show();t.addClass("minimized");t.data("minimized",true)},maximize:function(e){var t=$("#chatinstances").width();if(t>$(document.body).width()-100){alert("No place for chat box to maximize, minimize others to maximize this");return}var n=$(Chat.getId(e));$(n).show();$(Chat.get("maximized"),n).show();$(Chat.get("minimized"),n).hide();$("textarea",n).focus();n.removeClass("minimized");n.data("minimized",false);Chat.denotify(e)},getNewMessages:function(e){var t=$(Chat.getId(e));if(t[0]===undefined){alert("This is not allowed ie this could never occur");return false}console.log("Called get New messages function");if(t.data("requesting_data")!=true){t.data("requesting_data",true)}else{return}var n=t.data("last_chat_id");var r=function(n){if(n["error"]==true){t.data("requesting_data",false);return}var r=parseInt(n["count"]);if(r==0){t.data("requesting_data",false);return}var i=null;for(var s=0;s<r;s++){var o="iterate"+s;var u=n[o];i=u["id"];Chat.appendMessage(e,u)}t.data("requesting_data",false);console.log("done getting new messages of "+r+" and set requesting_data to "+t.data("requesting_data"))};var i=$.post(Urls.chat.newMessages,{from:e,last_id:n},function(e){clearTimeout(s);r(e)},"json");var s=setTimeout(function(){i.abort();t.data("requesting_data",false)},5e3)},close:function(e){var t=$(Chat.getId(e));$(t).hide()},seen:function(e){var t={from:e};var n=$.post(Urls.chat.seen,t,function(e){clearTimeout(r);if(e["error"])return;socket.emit("seen",e)},"json");var r=setTimeout(function(){n.abort();alert("Alert while seeing")},5e3)},appendMessage:function(e,t){var n=t["message"];var r=t["time"];var i=t["from"];var s=$(Chat.getId(e));var o=document.createElement("div");o.innerHTML=template.get("messageunit");$(o).addClass("unit");$(Chat.get("message"),o).html(n)[0].title=r;var u=false;var a=$(".body",s);if(a[0].scrollHeight-a.scrollTop()-a.height()==0)u=true;var f=a[0].scrollHeight;$(Chat.get("messages"),s).append(o);s.data("last_chat_id",t["id"]);s.data("last_user",t["from"]);$(Chat.get("seen"),s).css({opacity:0});if(t["from"]!==userId){$(Chat.get("from_img"),o).removeClass("cur_user");$(Chat.get("from_img"),o).attr("src",Urls.imageBase+"profiles/"+t["from"]+".jpeg");$(o).addClass("unit_alter")}else{$(o).addClass("curUser")}if(u)a.scrollTop(f)},prependMessage:function(e,t){var n=t["message"];var r=t["time"];var i=t["from"];var s=$(Chat.getId(e));var o=document.createElement("div");o.innerHTML=template.get("messageunit");$(o).addClass("unit");$(Chat.get("message"),o).html(n)[0].title=r;$(Chat.get("messages"),s).prepend(o);s.data("last_user",t["from"]);s.data("l_chid",t["id"]);if(t["from"]!==userId){$(Chat.get("from_img"),o).removeClass("cur_user");$(Chat.get("from_img"),o).attr("src",Urls.imageBase+"profiles/"+t["from"]+".jpeg");$(o).addClass("unit_alter")}else{$(o).addClass("curUser")}},send:function(e,t){var n=$(Chat.getId(e));var r={to:e,message:t};var i=function(n){if(n["error"]===true){alert(JSON.stringify(n));alert("Error in sending message");return}var r={message:t,time:n["time"],from:userId,id:n["id"],to:e};Chat.appendMessage(e,r);$("textarea",$(Chat.getId(e))).focus();socket.emit("message",r)};var s=function(){$("textarea",n)[0].disabled=false;alert("Message sending failed.")};var o=$.post(Urls.chat.send,r,function(e){clearTimeout(u);$("textarea",n)[0].disabled=false;i(e)},"json");var u=setTimeout(function(){o.abort();alert("Sending message request timedout.");s()},5e3)},notify:function(e,t){try{var n=$("#online_list");var r;var i=$(Chat.get(e),n);if(t==true){var s=$(Chat.get("notify"),i)[0].innerHTML;if(s!="")r=parseInt(s.substring(1,s.length-1))+1;else r=1}else{r=t}i.css({display:"block"});win.notify(r);$(Chat.get("notify"),i)[0].innerHTML="("+r+")";i.addClass("notify").prependTo(n);$(Chat.get("head"),$(Chat.get(e))).addClass("notify");$(Chat.get("minimized"),$(Chat.getId(e))).addClass("notify");$(Chat.get("unseen_count"),$(Chat.get("minimized"),$(Chat.getId(e)))).html(r)}catch(o){}},denotify:function(e){try{var t=$("#online_list");var n=$(Chat.get(e),t);if(n.hasClass("offline")){n.css("display","none")}$(Chat.get("notify"),n)[0].innerHTML="";if($(n).hasClass("notify")){Chat.seen(e)}$(Chat.get(e),t).removeClass("notify");$(Chat.get("head"),$(Chat.get(e))).removeClass("notify");$(Chat.get("minimized"),$(Chat.getId(e))).removeClass("notify")}catch(r){}},nofifications:function(){var e={};var t=function(e){if(e["error"]===true){alert("Some error occured in message notifications");return}else{var t=parseInt(e["count"]);var n=0;for(var r=0;r<t;r++){var i=e["iterate"+r];if(i["unseen"]!=0&&i["from"]!=userId){var s=$(Chat.getId(i["from"]));if(!win.focussed){Chat.notify(i["from"],i["unseen"])}else if(s[0]==undefined){Chat.notify(i["from"],i["unseen"])}else if(s.data("minimized")==true){Chat.notify(i["from"],i["unseen"])}else if(s.data("closed")==true){Chat.notify(i["from"],i["unseen"])}else{Chat.getNewMessages(i["from"])}n+=parseInt(i["unseen"])}else if(i["unseen"]==0&&i["from"]==userId){var s=$(Chat.getId(i["to"]));if(s.data("last_user")==userId){$(Chat.get("seen"),s).css({opacity:"1"});$(Chat.get("seen")+" .time",s).html(i["time"])}}else if(i["unseen"]==0&&i["from"]!=userId){Chat.denotify(i["from"])}continue}win.notify(n)}};var n=function(){setTimeout(function(){Chat.notifications()},1e3)};var r=$.post(Urls.chat.notifications,e,function(e){clearTimeout(i);t(e)},"json");var i=setTimeout(function(){r.abort();n()},5e3)},updateOnlineList:function(){var e=IndexedAllUsers["count"];for(var t=0;t<e;t++){AllUsers[IndexedAllUsers["iterate"+t]["id"]]["online"]=false}var n=$("#online_list");for(var t=0;t<parseInt(IndexedAllUsers["count"]);t++){var r=IndexedAllUsers["iterate"+t]["id"];if(r==userId)continue;var i=document.createElement("div");i.innerHTML=template.get("online_unit");var s=$(i);s.addClass("unit").addClass("offline");$(Chat.get("name"),s).html(User.lookup(r));$(Chat.get("status"),s).html("<i class='fa fa-circle' style='font-size:10px'></i>").addClass("offline");$(Chat.get("image"),s)[0].src=Urls.imageBase+"profiles/"+r+".jpeg";i.setAttribute("data-h",r);s.click(function(e,t){return function(){if($(t).hasClass("notify")){Chat.denotify(e)}Chat.create(e,true)}}(r,s));n.append(s)}},hasGoneOffline:function(e){var t=$("#online_list");var n=$(Chat.get(e),t);if(n[0]!=undefined){$(Chat.get(e),t).appendTo(t);n.addClass("offline");$(Chat.get("status"),n).addClass("offline")}else{var r=document.createElement("div");r.innerHTML=template.get("online_unit");var i=$(r);i.addClass("unit");i.addClass("offline");$(Chat.get("name"),i).html(User.lookup(e));$(Chat.get("status"),i).html("<i class='fa fa-circle' style='font-size:10px'></i>").addClass("offline");$(Chat.get("image"),i)[0].src=Urls.imageBase+"profiles/"+e+".jpeg";r.setAttribute("data-h",e);i.off("click");i.click(function(e){return function(){Chat.create(e,true)}}(e));i.appendTo(t)}},hasComeOnline:function(e){var t=$("#online_list");if(e==userId)return;var n=$(Chat.get(e),t);if(n[0]!=undefined){$(Chat.get(e),t).appendTo(t);n.removeClass("offline");$(Chat.get("status"),n).removeClass("offline")}else{var r=document.createElement("div");r.innerHTML=template.get("online_unit");var i=$(r);i.addClass("unit");i.removeClass("offline");$(Chat.get("name"),i).html(User.lookup(e));$(Chat.get("status"),i).html("<i class='fa fa-circle' style='font-size:10px'></i>").removeClass("offline");$(Chat.get("image"),i)[0].src=Urls.imageBase+"profiles/"+e+".jpeg";r.setAttribute("data-h",e);i.appendTo(t);i.off("click");i.click(function(e,t){return function(){if(t.hasClass("notify")){Chat.denotify(e)}Chat.create(e,true)}}(e,i))}}};var win={addTitle:null,focussed:true,notifyMessages:0,title:document.title,_interval:null,_number:0,_start:function(){$(window).focus(function(){win.focussed=true;document.title=win.title;win.addTitle=null});$(window).blur(function(){if(win.addTitle!==null){document.title=win.addTitle}win.focussed=false})},notify:function(e){if(!win.focussed){if(e==win.notifyMessages&&win._interval!=null)return;win.notifyMessages=e;clearInterval(win._interval);if(e!=0){win._interval=setInterval(function(){if(win._number%2==0)document.title="Messages("+e+")";else document.title=win.title;win._number++},1e3)}}},clrinterval:function(){clearInterval(win._interval);win._number=0}};var notifications={scrollTo:function(e){if($(Wall.getId(e))[0]!=undefined){var t=$(Wall.getId(e)).offset();$(window).scrollTop(t.top-50);var n=$(Wall.getId(e));n.animate({opacity:"0"});n.animate({opacity:"1"},"fast")}},notifyComment:function(e){var t=$(Wall.getId(e["wallid"]));if(t[0]!==undefined){var n=Comment.create(e,t,e["wallid"]);$(Wall.get("comments"),t).append(n)}var r="nfc_"+e["wallid"]+"_c";if(e["from"]==userId)return;if($("#"+r)[0]==undefined){var i=document.createElement("div");i.innerHTML=template.get("notification_unit");i.id=r;$(i).addClass("unit");$(Wall.get("dueTo"),i).html(User.lookup(e["from"]));$(Wall.get("n_status"),i).html(" commented on ");$(Wall.get("wall_owner"),i).html(User.lookup(e["wall_owner"]));$(i)[0].title=e["comment"];$(i).click(function(){$(i).removeClass("notify");if($(Wall.getId(e["wallid"]))[0]!=undefined){$(Wall.get("comment"),$(Wall.getId(e["wallid"]))).click()}notifications.scrollTo(e["wallid"])});$("#rt_notifications").prepend(i);if(userId==e["wall_owner"])$(i).addClass("notify")}else{var i=$("#"+r);if(userId==e["wall_owner"])i.addClass("notify");$(Wall.get("dueTo"),i).html(User.lookup(e["by"]));$(Wall.get("n_status"),i).html(" also commented on ");$(Wall.get("wall_owner"),i).html(User.lookup(e["wall_owner"]));i[0].title=e["comment"];i.prependTo("#rt_notifications")}},notifyLike:function(e){var t="nfc_"+e["wallid"]+"_l";if(e["from"]==userId)return;if($("#"+t)[0]==undefined){var n=document.createElement("div");n.innerHTML=template.get("notification_unit");n.id=t;$(n).addClass("unit");$(Wall.get("dueTo"),n).html(User.lookup(e["from"]));$(Wall.get("n_status"),n).html(" likes ");$(Wall.get("wall_owner"),n).html(User.lookup(e["wall_owner"]));$("#rt_notifications").prepend(n);$(n).click(function(){$(n).removeClass("notify");notifications.scrollTo(e["wallid"])});if(userId==e["wall_owner"]){$(Wall.get("wall_owner"),n).html(" your ");$(n).addClass("notify")}}else{var n=$("#"+t);$(n).click(function(){$(n).removeClass("notify");notifications.scrollTo(e[wallid])});if(userId==e["wall_owner"])n.addClass("notify");$(Wall.get("dueTo"),n).html(User.lookup(e["from"]));$(Wall.get("n_status"),n).html(" also liked ");$(Wall.get("wall_owner"),n).html(User.lookup(e["wall_owner"]));n.prependTo("#rt_notifications")}}};Chat.updateOnlineList();Chat.nofifications();Wall.getNextWalls();$(window).scroll(function(e){Wall.scroll(e)});$(window).focus(function(e){win.focussed=true;document.title=win.title;win.clrinterval()});$(window).blur(function(e){win.focussed=false;$("#chatinstances .chat_instance").each(function(e,t){if(e==0)return})});var socket=io.connect("http://localhost:3333");socket.on("newMessage",function(e){Chat.notify(e["from"],1);Chat.appendMessage(e["from"],e)});socket.on("login",function(){socket.emit("login",userId)});socket.on("notifications",function(e){for(var t in e){if(e[t]["action"]=="like"){notifications.notifyLike(e[t]["data"])}else if(e[t]["action"]=="comment"){notifications.notifyComment(e[t]["data"])}}});socket.on("updateonlinelist",function(e){for(var t in e)Chat.hasComeOnline(e[t])});socket.on("seen",function(e){if(Chat.canAppended(e["to"])){var t=$(Chat.getId(e["to"]));$(Chat.get("seen"),t).css("opacity","1").html("seen "+e["time"])}});socket.on("deletewall",function(e){$(Wall.getId(e)).slideUp("fast")});socket.on("newwall",function(e){Wall.create(e,"prepend")});socket.on("wall_liked",function(e){notifications.notifyLike(e);var t=$(Wall.getId(e["wallid"]));if(t[0]===undefined){return}var n=parseInt($(Wall.get("like_numberstats"),t).html());n++;$(Wall.get("like_numberstats"),t).html(n)});socket.on("wall_unliked",function(e){var t=$(Wall.getId(e));if(t[0]===undefined){return}var n=parseInt($(Wall.get("like_numberstats"),t).html());n--;$(Wall.get("like_numberstats"),t).html(n)});socket.on("wall_commented",function(e){notifications.notifyComment(e);var t=$(Wall.getId(e["wallid"]));if(t[0]===undefined){return}var n=parseInt($(Wall.get("comment_numberstats"),t).html());n++;$(Wall.get("comment_numberstats"),t).html(n)});socket.on("wall_comment_deleted",function(e){var t=$(Wall.getId(e["wallid"]));if(t[0]===undefined){return}var n=parseInt($(Wall.get("comment_numberstats"),t).html());n--;$(Wall.get("comment_numberstats"),t).html(n);var r=$(Comment.getId(e["commentid"]));if(r[0]!==undefined){r.hide();r.remove()}});var timeoutonline={};socket.on("online",function(e){if(timeoutonline[e]!=undefined)clearTimeout(timeoutonline[e]);Chat.hasComeOnline(e)});socket.on("offline",function(e){timeoutonline[e]=setTimeout(function(){Chat.hasGoneOffline(e)},5e3)});socket.on("emergency",function(){document.location="http://10.1.11.111/onb";alert("emergency exit")});socket.on("message",function(e){if(Chat.canAppended(e["from"])){Chat.appendMessage(e["from"],e)}if(!Chat.isFocussed(e["from"])){Chat.notify(e["from"],true)}else{Chat.seen(e["from"])}});$("#notifications").click(function(){$("#messages .arrow_box").hide();$("#messages").removeClass("focussed");$(this).toggleClass("focussed");$(".arrow_box",this).toggle()});$("#messages").click(function(){$("#notifications .arrow_box").hide();$("#notifications").removeClass("focussed");$(this).toggleClass("focussed");$(".arrow_box",this).toggle()})