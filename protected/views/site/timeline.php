<html>
	<head>
	<title>
		Time Line
	</title>
	<link href="/classbook/css/wall.css" type="text/css"  rel="stylesheet">
	<link href="/classbook/css/chat.css" type="text/css"  rel="stylesheet">	
	<link href="/classbook/css/timeline.css" type="text/css"  rel="stylesheet">
	<link href="/classbook/css/css/font-awesome.min.css" type="text/css"  rel="stylesheet">
	<script type="text/javascript">
	<?php
		$user=  Yii::app()->user->id;
		$likedComments= Yii::app()->db->createCommand(
				"select comment_id from comment_likes where user_id='$user'"
		)->queryAll();
		$likedWalls=Yii::app()->db->createCommand(
				"select wall_id from wall_likes where user_id='$user'"
		)->queryAll();
		$lcomments=array();
		$lwalls=array();
		foreach ($likedComments as $value) {
			$lcomments["comment".$value["comment_id"]]=true;
		}
		foreach ($likedWalls as $value) {
			$lwalls["wall".$value["wall_id"]]=true;
		}
	?>
		var AllUsers=<?php
			$userquery= Yii::app()->db->createCommand(
					"select id, orig_name, name from user where first_time_login=0"
			)->queryAll();
			$users=array();
			$indexedUsers=array();
			$count=0;
			foreach ($userquery as  $value) {
				$users[$value["id"]]=array("origname"=>$value["orig_name"],"name"=>$value["name"],"online"=>false);
				$indexedUsers["iterate$count"]=array(
					"id"=>$value["id"],
					"online"=>false
				);
				$count++;
			}
			$indexedUsers["count"]=$count;
			echo CJSON::encode($users);
		?>;
		var IndexedAllUsers=<?php echo CJSON::encode($indexedUsers);?>;
		var userId="<?php echo Yii::app()->user->id;?>";
		var likedComments=<?php echo CJSON::encode($lcomments);?>;
		var likedWalls=<?php echo CJSON::encode($lwalls);?>;
//		var AllUsers=<?php
//			$userquery= Yii::app()->db->createCommand(
//					"select id, orig_name, name from user"
//			)->queryAll();
//			$users=array();
//			foreach ($userquery as  $value) {
//				$users[$value["id"]]=array("origname"=>$value["orig_name"],"name"=>$value["name"]);
//			}
//			echo CJSON::encode($users);
		?>//;
//		var userId="<?php echo Yii::app()->user->id;?>";
//		var likedComments=<?php echo CJSON::encode($lcomments);?>;
//		var likedWalls=<?php echo CJSON::encode($lwalls);?>;
		var timelineOf="<?php echo $timelineuserid;?>";
	</script>
	</head>
	<body  style="background:rgba(212,212,212,0.6);">
		<div id="cover_page" style="background-image: url('<?php echo "/classbook/images/covers/".$timelineuserid.".jpeg?rndm=".rand();?>');background-position:0px <?php echo $details["cover_photo_top"];?>px;position:relative;width:879px;height:50%;float:left;border:1px solid rgba(212,212,212,0.8);">
		<p class="user_name" data-h="user_id" ><?php echo $details->name;?></p>
		<button class="cover_save_changes" style="display: none;position:absolute;bottom: 0px;right: 0px;"><i class="fa fa-pencil"></i> Save Changes</button>
		<?php if (Yii::app()->user->id==$timelineuserid):?><div id="upload_cover" style="border:1px solid green;">
			<button><i class="fa fa-pencil"></i> Change Cover</button>
		</div>
		<?php endif;?>
	    <div id='profile_image'>
			<img src="/classbook/images/profiles/<?php echo $details->id;?>.jpeg" style="position:absolute;top:0px;left:0px;height:145px;width:145px;margin:5px;" >
			<?php if (Yii::app()->user->id==$timelineuserid):?>
				<button class="change_image_button"><i class="fa fa-pencil"></i> Edit Profile Picture</button>
			<?php endif;?>
		</div>
		<!-- Showing Options -->
		<div id="show_options1">
			<div class="unit">
				<i class="fa fa-plus-circle"> </i> Upload Image
			</div>
			<div class="unit">
				<i class="fa fa-folder-open"> </i> Choose From photos
			</div>
			<div class="unit">
				<i class="fa fa-minus-circle"> </i> Remove Cover Image
			</div>
		</div>
		<div id="show_options2">
			<div class="unit">
				<i class="fa fa-plus-circle"> </i> Upload Image
			</div>
			<div class="unit">
				<i class="fa fa-folder-open"> </i> Choose From photos
			</div>
			<div class="unit">
				<i class="fa fa-minus-circle"> </i> Remove Profile Image
			</div>
		</div>
	    <div id="change_cover"></div>
		</div>	
	<div style="clear:both;margin-left:5%;float:left;width:65%;color:rgba(234,234,234,0.9);height:42px;background:#fff;border:1px solid rgba(212,212,212,0.9);">
		<div style="float:left;margin-left:22%;height:100%;background:#fff;font-size:14px;font-family:Arial;">
			<table id="nav_horizontal">
				<tr>
					<td class="active">
						Time Line
						</td>
						<!--
					<td class="inactive"> 
						About
						</td>
					<td class="inactive"> 
						Photos <b class="menu_text" data-h="num_photos">21</b>
						</td>
					<td class="inactive"> 
						Friends <b class="menu_text" data-h="num_frds">60</b>
						</td>
	  -->
				</tr>
			</table>
		</div>

	</div>
<div id="main_container">
	<div id="left_panel">
		<div class="dummy"></div>
	<div id="about">
		<div id="header">
			<p>
			About
			</p>
		</div>
		<div class="about_unit">
			<div><i class="fa fa-frown-o"></i> ID Num <b><?php echo $timelineuserid?></b>
			</div>
		</div>
		<div class="about_unit">
			<div><i class="fa fa-frown-o"></i> Name <b><?php echo $details["name"];?></b>
			</div>
		</div>
		
		<!--
		<div class="about_unit">
			<div><i class="fa fa-home"></i> Lives in <b> Kotikesavaram</b>
			</div>
		</div>
		<div class="about_unit">
			<div><i class="fa fa-map-marker"></i> From <b>Rajhamundry </b>
			</div>
		</div>
		-->
	</div>
		<!--
	 <div id="showing_photos">
		<div id="header">
			<p>
			Photos <b style="padding-left:5px;font-weight:normal;" data-h="num_photos"> 21</b>
			</p>
		</div>
		
	   <div id="photos">
			<div class="photo_unit">
					<img src="/classbook/images/profiles/sm.jpg">
			</div>
			<div class="photo_unit">
				<img src="/classbook/images/profiles/sm.jpg">
			</div>
			<div class="photo_unit">
				<img src="/classbook/images/profiles/sm.jpg">
			</div>
			<div class="photo_unit">
					<img src="/classbook/images/profiles/sm.jpg">
			</div>
			<div class="photo_unit">
				<img src="/classbook/images/profiles/sm.jpg">
			</div>
			<div class="photo_unit">
				<img src="/classbook/images/profiles/sm.jpg">
			</div>
	   </div>

	</div>	
	
	<div id="showing_frds">
		<div id="header">
			<p>
			Friends <b style="padding-left:5px;font-weight:normal;" data-h="num_photos"> 60</b>
			</p>
		</div>
	   <div id="photos">
			<div class="photo_unit">
					<img src="/classbook/images/profiles/sm.jpg">	
					  <b data-h="user_name">Ashok Kumar</b>
			</div>
			<div class="photo_unit">
				<img src="/classbook/images/profiles/sm.jpg">
				<b data-h="user_name">Ashok kumar</b>
			</div>
			<div class="photo_unit">
				<img src="/classbook/images/profiles/sm.jpg">
				<b data-h="user_name">Ashok Kumar</b>
			</div>
			<div class="photo_unit">
					<img src="/classbook/images/profiles/sm.jpg">
					<b data-h="user_name">Ashok Kumar</b>
			</div>
			<div class="photo_unit">
				<img src="/classbook/images/profiles/sm.jpg">
				<b data-h="user_name">Ashok Kumar</b>
			</div>
			<div class="photo_unit">
				<img src="/classbook/images/profiles/sm.jpg">
				<b data-h="user_name">Ashok Kumar</b>
			</div>
	   </div>
	</div>
  -->
</div>

<div id="right_panel">
<div class="wall_post" id="timeline_status">
	<div id="header">
		<p class="update_text" onclick="$('.wall_post .update_text').removeClass('active');$(this).addClass('active');$('#post_images').slideUp();"><i style="color:darkgoldenrod;" class="fa fa-edit"></i>Update status</p>
		<p class="update_text" onclick="$('.wall_post .footer').show('slow');$('.wall_post .update_text').removeClass('active');$(this).addClass('active');$('.footer',$(this).parent()).show();$('#post_images').show('slow')" title="Upload Images"><i style="color:darkgoldenrod;" class="fa fa-edit"></i>Post Image</p>
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
<!--	<div class="wall_post" id="timeline_status">
		<div id="header">
			<p>Post on Timeline</p>
		</div>
	<textarea id="wc_edit" onfocus="isFocussed(this)" onblur="isBlurred(this)" class="autogrow" placeholder="Message you wanna post"></textarea>
	<div id="post_images" style="display: none;">
		<span class="img_add" id="upload_div">
			<span class="table">+</span>
		</span>
	</div>
	<span class="footer" style="display:none;">
		<input type="button" class="post_button" value="Post" onclick="Wall.post()">
		<div class="Browse_Image" > <i onclick="$('#post_images').show('slow')" class="fa fa-file"   title="Upload Images"></i></div>
	</span>
	</div>-->

	<div id="posts"></div>
	<div class="loading_wall" >
		<img src="/classbook/images/loading.gif"/>
		<span>No more Stories</span>
	</div>
</div>
</div>

<?php
	include(Yii::getPathOfAlias("application")."/views/templates/wall.php");
?>


<script  type="text/javascript" src="/classbook/js/jquery.js"></script>
<script type="text/javascript" src="/classbook/js/wall.js"></script>
<script type="text/javascript" src="/classbook/js/SimpleAjaxUploader.min.js"></script>
<script type="text/javascript">
	var uploaddivs=[];
	var upload_files=[];
	var uploader = new ss.SimpleUpload({
		button: document.getElementById("upload_div"), // HTML element used as upload button
		url: '/classbook/wall/uploadImage', // URL of server-side upload handler
		name: 'uploadfile' ,// Parameter name of the uploaded file
		allowedExtensions: ['jpg', 'jpeg', 'png', 'gif'],
		responseType: 'json',
		multiple:true,
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
			var elem=document.createElement("div");
			$(elem).addClass("p_img");
			var i=document.createElement("i");
			$(i).addClass("fa fa-times");
			$(elem).mouseover(function(){
				$("img",elem).css("opacity","0.3");
				$(i).show();
			});
			$(elem).mouseout(function(){
				$("img",elem).css("opacity","1");
				$(i).hide();
			});
			$(elem).append("<img style='' src='/classbook/images/loading.gif' />").append(i);
			$("img",elem).addClass("loading");
			$("#upload_div").before(elem);
			uploaddivs.push(elem);
		},
		onComplete: function(filename, response, uploadbtn) {
			if (!response["success"]) {
				alert(filename + 'upload failed'+ response["message"]);
				return false;
			}
			upload_files.push(response["file"]);
			var elem=uploaddivs.pop();
			$(".fa",elem).click(function(){
				var ind=upload_files.indexOf(response["file"]);
				upload_files.splice(ind, 1);
				$(elem).remove();
			});
			$("img",elem)[0].src=Urls.imageBase+"tmp/"+userId+"/"+response["file"]+"?rnd="+Math.random();
			$("img",elem).removeClass("loading");
			// do something with response...
		}
	});
</script>
<script type="text/javascript">
	<?php if (Yii::app()->user->id==$timelineuserid):?>
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
			alert("error uploading file "+filename+". Erro is : "+statusText);
		},
		onSubmit:function(){
		},
		onComplete: function(filename, response, uploadbtn) {
			if (response["error"]) {
				alert(filename + 'upload failed'+ response["message"]);
				return false;
			}
			$("#profile_image img")[0].src=Urls.profileImage+"?random="+Math.random();
			// do something with response...
		}
	});
	<?php endif;?>
	var timeline={
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
</script>
</body>
</html>



