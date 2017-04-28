<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name;
?>
<div class="column1">
	<div class="profile_info">
		<img src="/classbook/images/profiles/<?php echo Yii::app()->user->id;?>.jpeg" />
		Name : <span class="name"><?php echo $this->information["details"]["name"];?></span>
		<br><br>
		<a href="/classbook/site/editprofile">edit profile</a>
	</div>
</div>
<div class="column2">
	<div class="wall_post">
		<div class="wall_post_options">
			<a class="update_text" onclick="$('.wall_post .update_text').removeClass('active');$(this).addClass('active');$('#post_images').slideUp();"><i style="color:darkgoldenrod;" class="fa fa-edit"></i>Update status</a>
			<a class="update_text" onclick="$('.wall_post .footer').show('slow');$('.wall_post .update_text').removeClass('active');$(this).addClass('active');$('.footer',$(this).parent()).show();$('#post_images').show('slow')" title="Upload Images"><i style="color:darkgoldenrod;" class="fa fa-edit"></i>Post Image</a>
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


	<div class="options">
		<span data-url="/classbook/site/index?type=1">Top Stories</span>
		<span data-url="/classbook/site/index?type=1">Recent Stories</span>
<?php if (Yii::app()->user->id=="N090041"):?>
		<span onclick="socket.emit('emergency',prompt('Enter user  :  '));">Emergency.</span>
<?php endif;?>
	</div>
	<div style="clear:both"></div>
	<div id="posts">
	</div>
	<div class="loading_wall" >
			<img src="/classbook/images/loading.gif"/>
			<span>No more Stories</span>
	</div>
</div>
<div class="column3">
	<div class="notifications">
		<div class="head">Notifications</div>
		<div id="rt_notifications">
			<div id="t_notification_unit" style="display:none;" data-wallof="wallid" class="unit notify">
				<span class="n_because_of name" data-h="dueTo"></span>
				<span class="n_status" data-h="n_status">also liked</span>
				<span class="n_post_of name" data-h="wall_owner">masthan vali</span>'s status
			</div>
		</div>
	</div>
</div>
