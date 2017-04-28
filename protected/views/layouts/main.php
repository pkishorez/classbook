<?php /* @var $this Controller */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<link rel="icon" href="/classbook/images/clogo.png" type="image/x-icon" />
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />

	<!-- blueprint CSS framework -->
	<!--[if lt IE 8]>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection" />
	<![endif]-->

	<?php if ($this->information["isTimeline"]):?>
		<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/k_timeline.css" />
	<?php endif;?>
	<?php if (!$this->information["isTimeline"]):?>
		<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/index.css" />
	<?php endif;?>
<!--	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/test.css" />-->
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/css/font-awesome.min.css" />
	<?php if (!Yii::app()->user->isGuest):?>
		<script type="text/javascript" src="http://localhost:3333/socket.io/socket.io.js"></script>
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
		var timelineOf=<?php if ($this->information["isTimeline"]) echo  '"'.$this->information["timelineuserid"].'"'; else echo "undefined"?>;
		<?php $details=  User::model()->findByPk($user);?>
	</script>
	<?php endif;?>
	<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.js"></script>
	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>
	
	<div class="main_container">
		<div class="main_content">
			<?php echo $content;?>
		</div>
	<div class="chat">
		<div id="chatinstances">
			<div class="chat_instance template_chat_instance firstChild" style="visibility: hidden;">
				<div class="max" data-h="maximized">
					<div class="head" data-h="minimize">
						<div class="close" data-h="close">
							<span><i style="color:white;font-size: 12px;cursor:pointer;" class="fa fa-times"></i></span>
						</div>
						<span class="user">
							<i class="fa fa-rss" style="color:lightgreen;"></i>
							<span data-h="chat_with">Nagur Mogal</span>
						</span>
					</div>
					<div class="body">
						<img src="/classbook/images/loading.gif" class="loading" data-h="ploading"/>
						<div class="messages" style="clear: both;" data-h="messages">
							<div class="unit mesageunit" style="display: none">
								<img class="from_img cur_user"  data-h="from_img" src="/classbook/images/tick.gif">
								<span class="message" data-h="message"></span>
								<div style="clear:both;"></div>
							</div>
						</div>
						<div class="status" data-h="seen"><i class="fa fa-check"></i> seen <span class="time"></span></div>
					</div>
					<div class="chat_post">
						<textarea placeholder="message here"></textarea>

					</div>
				</div>
				<div class="min" data-h="minimized">
					<span data-h="unseen_count" class="count"></span>
					<i class="fa fa-times" data-h="close"></i>
					<span data-h="chat_with">Kishore</span>
				</div>
			</div>
		</div>
		<div class="online_list" id="online_list" data-h="online_list">
<!--
-->
		</div>

	</div>
		<div class="main_header">
			<div class="h_content">
				<div class="header_left">
					<span class="logo">
						Classbook
					</span>
					<span>
						<input type="text" style="width: 200px;" class="search" placeholder="search for friends and walls" />
					</span>
				</div>
				<div class="header_right">
					<span class="hover" style="max-width: 300px; overflow: hidden;" onclick="document.location='/classbook/site/timeline?user=<?php echo Yii::app()->user->id;?>'">
						<img style="width:20px;vertical-align: middle" src="/classbook/images/profiles/<?php echo Yii::app()->user->id;?>.jpeg" />
						<?php echo $details["name"];?>
					</span>
					<span class="hover" onclick="window.location.href='/classbook/site'">
						<i class="fa fa-home"></i> Home
					</span>
					<span class="hover" onclick="document.location='/classbook/site/editProfile'">
						<i class="fa fa-pencil"></i> Edit Profile
					</span>
					<span class="hover notifications" style="display: none;" id="notifications">
						<div><i class="fa fa-globe"></i>
							<div class="arrow_box">
								<div class="n_unit">
									<img src="/classbook/images/n_comment.png" />
									<span class="profile">Kishore Kittu</span> also commented on your post.<br/>
									(What is your good name please?)
									<span class="time">today at 11 o clock pm</span>
									<div style="clear: both;padding: 0px;margin: 0px;"></div>
								</div>
								<div class="n_unit">
									<img src="/classbook/images/n_like.png" />
									<span class="profile">Kishore Kittu</span> liked your post.<br/>
									<span class="time">today at 11 o clock pm</span>
									<div style="clear: both;"></div>
								</div>
								<div class="n_unit">
									<img src="/classbook/images/n_comment.png" />
									<span class="profile">Kishore Kittu</span> also commented on your post.<br/>
									<span class="time">today at 11 o clock pm</span>
									<div style="clear: both;padding: 0px;margin: 0px;"></div>
								</div>
							</div>
						</div>
					</span>
					<span class="hover notifications" style="display: none;" id="messages">
						<div><i class="fa fa-envelope" style="font-size: 14px;"></i>
							<div class="arrow_box">
								<div class="n_unit">
									<img src="/classbook/images/profiles/N090041.jpeg" class="small_img" />
									<span class="profile">Kishore Kittu</span> messaged you.<br/>
									<span class="time">today at 11 o clock pm</span>
									<div style="clear: both;padding: 0px;margin: 0px;"></div>
								</div>
								<div class="n_unit">
									<img src="/classbook/images/profiles/N090041.jpeg" class="small_img"/>
									<span class="profile">Kishore Kittu</span> messaged you.<br/>
									<span class="time">today at 11 o clock pm</span>
									<div style="clear: both;padding: 0px;margin: 0px;"></div>
								</div>
								<div class="n_unit">
									<img src="/classbook/images/profiles/N090041.jpeg" class="small_img"/>
									<span class="profile">Kishore Kittu</span> messaged you.<br/>
									<span class="time">today at 11 o clock pm</span>
									<div style="clear: both;padding: 0px;margin: 0px;"></div>
								</div>
							</div>
						</div>
					</span>
					<span class="hover" onclick="if (!confirm('Do you really want to logout?')) return;window.location.href='/classbook/site/logout'">
						<i class="fa fa-power-off"></i>
					</span>
				</div>
				<div style="clear:both;"></div>
			</div>
			<div style="clear:both;"></div>
		</div>
	</div>


<div class="wcontainer" style="float:left;">
</div>
<div style="clear: both;"></div>
<div class="main_footer">
	Copyright &copy; <?php echo date('Y'); ?> by Classbook.<br/>
	All Rights Reserved.<br/>
</div><!-- footer -->








<!-- Templates for wall and all goes here!!!-->

<?php	include Yii::getPathOfAlias("application").'/views/templates/wall.php';?>

<!-- Template definitions are over here-->






<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/wall.js"></script>
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
</body>
</html>
