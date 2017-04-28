<div class="template_wall post" style="display: none">
	<div class="head">
		<span class="delete" data-h="delete_wall"><i class="fa fa-times"></i></span>
		<img class="profile_image" data-h="profile_img">
		<div class="details">
			<span class="owner"	 data-h="posted_by">kishore kittu</span>
			<span class="description" data-h="description"></span>
		</div>
	</div>
	<div class="body">
		<div class="content" data-h="content">
		</div>
		<div class="collapse" data-h="collapse_content" style="display: none;margin-top: 10px;">show more</div>
	</div>
	<div class="images" data-h="images">
		
	</div>
	<div class="tail">
		<div class="funcs">
			<span class="show_likes" data-h="show_likes">
				<i style="cursor: pointer" class="fa fa-thumbs-o-up icon_color"></i>
				<span class="option others" data-h="like_numberstats"></span>
			</span>
			<span class="option wall_like" data-h="wall_like" >Like</span>
			<i class="fa fa-comment-o icon_color"></i>
			<span class="option wall_comment" data-h="comment">
				<span  data-h="comment_numberstats"></span> Comments
			</span>
			<span class="status" data-h="wall_status"></span>
		</div>
		<hr>
		<div class="section" data-h="section">
			<div class="comments" data-h="comments">
			</div>
		</div>
			<div class="add_comment">
				<img class="image" src="<?php echo Yii::app()->urlManager->baseUrl."/images/profiles/".Yii::app()->user->id.".jpeg";?>">
				<textarea name="input_comment" class="blurred autogrow" placeholder="write a comment" data-h="comment_add" ></textarea>
				<div class="div" data-h="add_comment_image">
					<i class="fa fa-camera add_image"></i>
				</div><br>
				<div class="comment_image_container" data-h="comment_image_container">
					
				</div>
			</div>
			<div style="clear:both"></div>
	</div>
</div>

<div class="template_comment" style="display: none">
	<span class="delete" data-h="delete"><i class="fa fa-times"></i></span>
	<img class="prof_image" data-h="profile_img">
	<div class="content">
		<div class="msg">
			<span class="comment_by" data-h="by"></span>
			<span class="message" data-h='message'></span>
			<div class="image" data-h="image"></div>
		</div>
		<div class="funcs">
			<span class="option like" data-h="comment_like">like</span>
			<span class="show_likes" data-h="show_likes">
				<i style="cursor: pointer" class="fa fa-thumbs-o-up icon_color"></i>
				<span class="option others n_likes" data-h="n_likes">0</span>
			</span>
			<span class="status" data-h="status"></span>
		</div>
	</div>
	<hr>
</div>

<div class="template_online_unit" style="display: none;">
	<img src="/classbook/images/profiles/N090041.jpeg" data-h="image" class="prof_image">
	<div>
		<span class="status" data-h="status">online</span>
	</div>
	<span data-h="name">kishore kittu</span><span data-h="notify"></span>
</div>




<div id="flash">
	<div class="fadeout">
	</div>
	<div class="user_action funit">
		<div class="head">
			<span data-h="name"></span>
			<i class="close fa fa-times" onclick="flash_out()"></i>
		</div>
		<div class="option" data-h="vprofile">View Profile</div>
		<div class="option" data-h="message">Chat with <span class="name"></span></div>
		<div class="option watch" data-h="watch">Watch <span class="name"></span></div>
	</div>
	<div id="zoomImage" class="funit">
		<div class="container">
			<div class="prevImage"><i class="fa fa-arrow-circle-left"></i></div>
			<img src="/classbook/images/profiles/<?php echo Yii::app()->user->id?>.jpeg" />
			<div class="nextImage"><i class="fa fa-arrow-circle-right"></i></div>
		</div>
		<div class="stats">1/1</div>
	</div>
	<div id="likeList" class="funit">
		<div class="head">
			<span data-h="n_likes"></span>
			<span >likes</span>
			<i class="fa fa-times" onclick="flash_out();"></i>
		</div>
		<div class="body"></div>
	</div>
</div>
