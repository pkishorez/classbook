<?php /* @var $this Controller */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />

	<link rel="stylesheet" href="css/layout.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/css/font-awesome.min.css" />
	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>

	<div class="container">
		<div class="header">
			<div class="h_content">
				<div class="left">
					<div class="logo">Classbook</div>
				</div>
				<div class="right">
					<div>logout</div>
				</div>
				<div style="clear:both;"></div>
			</div>
		</div>
		<div class="content">
			<div class="column1">
				<div>
					Kishore Kittu
				</div>
			</div>
			<div class="column2">
				<div class="_wall">
					<div class="wall_head">
						<img src="/classbook/images/profiles/N090041.jpeg" class="profileimage" />
						<div class="info">Kishore Kittu</div>
					</div>
					<div class="wall_content">
						Kishore is a good boy...
					</div>
					<div class="wall_tail">
						
					</div>
				</div>
				<div class="template_wall" style="display: none">
					<div class="head">
						<span class="delete" data-h="delete_wall"><i class="fa fa-times"></i></span>
						<img class="profile_image" data-h="profile_img">
						<div class="details">
							<span class="owner" data-h="posted_by"></span>
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
							<div class="view_previous_comments">
								<a href="#" onclick="return false">view all previous comments</a>
								<span class="total_comments"></span>
								<hr>
							</div>
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
			</div>
			<div class="column3">
				Notifications come here!!!
			</div>
		</div>
	</div>

</body>
</html>
