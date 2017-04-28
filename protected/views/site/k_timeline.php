<link rel="stylesheet" href="/classbook/css/k_timeline.css"/>
<?php include("_timeline.php");?>
	<div class="cover_options">
		<span onclick="document.location='timeline?user=<?php echo $this->information["details"]["id"];?>';" class="active">Timeline</span>
		<span onclick="document.location=('viewProfile?user=<?php echo $this->information["details"]["id"];?>')">About</span>
	</div>
</div>
<div class="content">
	<div class="column1">
		<div class="about">
			<div class="about_unit">About</div>
			<div class="about_content">
				OrigName : <?php echo $this->information["details"]["orig_name"];?>
			</div>
		</div>
	</div>
	<div class="column2">
		<div class="wall_post">
			<div class="wall_post_options">
				<a class="update_text" onclick="$('.wall_post .update_text').removeClass('active');$(this).addClass('active');"><i style="color:darkgoldenrod;" class="fa fa-edit"></i>Update status</a>
				<a class="update_text" onclick="$('.wall_post .update_text').removeClass('active');$(this).addClass('active');$('.footer',$(this).parent()).show();$('#post_images').show('slow')" title="Upload Images"><i style="color:darkgoldenrod;" class="fa fa-edit"></i>Post Image</a>
			</div>
			<textarea id="wc_edit" rows="1" onfocus="isFocussed(this)" onblur="isBlurred(this)" class="autogrow" placeholder="What's on your mind?"></textarea>
			<div id="post_images" style="display: none;">
				<span class="img_add" id="upload_div">
					<span class="table">+</span>
				</span>
				<div style="clear:both;"></div>
			</div>
			<span class="footer" style="display:none;">
				<input type="button" class="post_button" value="Post" onclick="Wall.post()">
			</span>
		</div>
		<div id="posts">
		</div>
		<div class="loading_wall" >
				<img src="/classbook/images/loading.gif"/>
				<span>No more Stories</span>
		</div>
	</div>
</div>
<script type="text/javascript">
	$(function(){
		new ss.SimpleUpload({
			button: document.getElementById("upload_cover"), // HTML element used as upload button
			url: '/classbook/wall/uploadCover', // URL of server-side upload handler
			name: 'coverpicture' ,// Parameter name of the uploaded file
			allowedExtensions: ['jpg', 'jpeg', 'png'],
			responseType: 'json',
			multiple:false,
			hoverClass:"visiblevisible",
			onExtError:function(filename,extension)
			{
				alert("File with extension '"+extension+"' is not supported.");
			},
			onError:function(filename, errorType, status, statusText, response, uploadBtn )
			{
				alert("error uploading file "+filename+". Erro is : "+statusText);
				$($("#post_images .loading")[0]).parent().remove();
			},
			onSubmit:function(){
				$("#cover_page").addClass("loading_background");
			},
			onComplete: function(filename, response, uploadbtn) {

				if (response["error"]) {
					alert(filename + 'upload failed'+ response["message"]);
					return false;
				}
				timeline.restoreBackgroundPosition=$("#cover_page").css("backgroundPosition");
				$("#cover_page").css("backgroundPosition","0px 0px");
				timeline.coverapplied=true;
				$(".cover_save_changes").show();
				$("#cover_page .changecover").hide();
				$("#reposition_cover").hide();
				$("#upload_cover").hide();
				$("#cover_page").removeClass("loading_background");
				$("#cover_page").css("backgroundImage","url("+Urls.imageBase+"tmp/"+userId+"/"+response["file"]+"?rnd="+Math.random()+")");
				// do something with response...
			}
		});
		new ss.SimpleUpload({
			button: $(".change_image_button"), // HTML element used as upload button
			url: '/classbook/wall/changeprofilepic', // URL of server-side upload handler
			name: 'profilepic' ,// Parameter name of the uploaded file
			allowedExtensions: ['jpg', 'jpeg', 'png'],
			responseType: 'json',
			multiple:false,
			hoverClass:"visiblevisible",
			onExtError:function(filename,extension)
			{
				alert("File with extension '"+extension+"' is not supported.");
			},
			onError:function(filename, errorType, status, statusText, response, uploadBtn )
			{
				//alert("error uploading file "+filename+". Erro is : "+statusText+"response  :  "+response);
			},
			onSubmit:function(){
			},
			onComplete: function(filename, response, uploadbtn) {
				if (response["error"]) {
					alert(filename + 'upload failed'+ response["message"]);
					return false;
				}
				$("#profile_image img")[0].src=Urls.profileImage+"?random="+Math.random();
				var json={"id":response["id"],"type":"PROF_CHANGE","n_comments":0,"n_likes":0,"n_images":1,"content":"","postedby":userId,"status":response["time"]};
				Wall.create(json,"prepend");
				socket.emit("newwall",json);
				alert("Emitted");
				// do something with response...
			}
		});
		timeline={
			restoreBackgroundPosition:0,
			coverapplied:false,
			top:0,
			tmptop:0,
			prevY:null,
			candrag:false,
			moving:function(e)
			{
				if (!timeline.candrag)
					return;
				var x = e.pageX - e.target.offsetLeft;
				var y = e.pageY - e.target.offsetTop;
				if ((timeline.top+(y-timeline.prevY))>0)
					return;
				timeline.tmptop=(timeline.top+(y-timeline.prevY));
				$("#cover_page")[0].style.backgroundPosition="0px " +(timeline.top+(y-timeline.prevY))+"px";
			},
			saveChanges:function()
			{
				$("#cover_page .changecover").show();
				$(".cover_save_changes").hide();
				$("#upload_cover").show();
				$("#reposition_cover").show();

				var xhr=$.post("/classbook/wall/SetCoverPosition",{"cover_top":timeline.top},function(data){
					clearTimeout(timeout);
					if (data["error"])
					{
						alert("error occured in saving the timeline cover photo");
						return;
					}
					timeline.coverapplied=false;
				},"json");
				var timeout=setTimeout(function(){alert("request timed out");},5000);
			}
		};
		$("#cover_page").mousedown(function(e){
			if (!timeline.coverapplied)
				return;
			timeline.prevY=e.pageY - this.offsetTop;
			timeline.candrag=true;
			$(this).css("cursor","move");
		});
		$("#cover_page").mouseup(function(){
			if (!timeline.coverapplied)
				return;
			timeline.candrag=false;
			timeline.top=timeline.tmptop;
			$(this).css("cursor","default");
		});
		$("#cover_page").mousemove(function(e){
			timeline.moving(e);
		});
		$(".cover_save_changes").click(function(){
			timeline.saveChanges();
		});
	})
</script>