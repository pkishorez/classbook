<?php

/**
 * In all the corresponding actions of Wall Controller,
 * Wall id should be passed as parameter to apply action on that wall id.
 */
class WallController extends Controller
{
	public $images_path;
	public $wall_image_path;
	public $wall_image_thumbs_path;
	public $image_tmp_file_path;


	public function filters() {
		$this->wall_image_path=  Yii::getPathOfAlias("application")."/../images/posts/";
		$this->wall_image_thumbs_path=  Yii::getPathOfAlias("application")."/../images/posts/thumbs/";
		$this->image_tmp_file_path= Yii::getPathOfAlias("application")."/../images/tmp/".Yii::app()->user->id."/";
		$this->images_path=Yii::getPathOfAlias("application")."/../images/";
		return array(
			array(
				"application.filters.LoginFilter"
			)
		);
	}
	public function actionViewLikes(){
		$wallid=  $this->getPostParam("wallid");
		if ($wallid===NULL)
			$this->response (true, "Wallid can not be null to show likes");
		$wallLikes= Yii::app()->db->createCommand(
				"select user_id from wall_likes where wall_id=$wallid"
		)->queryAll();
		$count=0;
		$result=array();
		foreach ($wallLikes as $value) {
			$result["iterate$count"]=$value["user_id"];
			$count++;
		}
		$result["count"]=$count;
		$this->response(FALSE, "success", $result);
	}
	public function actionUploadCover()
	{
		$upload_dir= Yii::getPathOfAlias("application")."/../images/tmp/".Yii::app()->user->id."/";
		$validExtensions= Image::getValidExtensions();
		$upload=new FileUpload("coverpicture");
		$result=$upload->handleUpload($upload_dir,$validExtensions);
		$num=0;
		$ufilepath="tmp_cover.jpeg";
		$oldimagefilepath=$upload_dir.$upload->getFileName();
		$img=Image::createThumbNail($oldimagefilepath,10000,879);
		$newimagefilepath=$upload_dir.$ufilepath;
		Image::flushImage($img,$newimagefilepath);
		$this->response(false, "success",array("file"=>$ufilepath));

	}
	public function actionUploadImage()
	{
		$upload_dir= Yii::getPathOfAlias("application")."/../images/tmp/".Yii::app()->user->id."/";
		$validExtensions= Image::getValidExtensions();
		$upload=new FileUpload("uploadfile");
		$result=$upload->handleUpload($upload_dir,$validExtensions);
		$num=0;
		do
		{
			$ufilepath="tmp_img_$num.jpeg";
			$num++;
		}
		while(file_exists($upload_dir.$ufilepath));
		$oldimagefilepath=$upload_dir.$upload->getFileName();
		$img=Image::createSquareThumbNail($oldimagefilepath,410);
		$timg=Image::createThumbNail($oldimagefilepath);
		$newimagefilepath=$upload_dir.$ufilepath;
		$newReplaceimagefilepath=$upload_dir."orig_".$ufilepath;
		Image::flushImage($img,$newimagefilepath);
		Image::flushImage($timg,$newReplaceimagefilepath);
		if (!$result)
			echo CJSON::encode (array("success"=>false,"msg"=>$upload->getErrorMsg ()));
		else
			echo CJSON::encode(array('success' => true, 'file' => $ufilepath));
		unlink($oldimagefilepath);
	}
	public function actionUploadCommentImage()
	{
		$upload_dir= Yii::getPathOfAlias("application")."/../images/tmp/".Yii::app()->user->id."/";
		$validExtensions= Image::getValidExtensions();

		$upload= new FileUpload("uploadfile");
		$result=$upload->handleUpload($upload_dir,$validExtensions);
		$oldimagefilepath=$upload_dir.$upload->getFileName();

		$img=Image::createThumbNail($oldimagefilepath,200);
		$ufilename="tmp_comment.jpeg";

		$newimagefilepath=$upload_dir.$ufilename;
		Image::flushImage($img,$newimagefilepath);
		if (!$result)
			echo CJSON::encode (array("success"=>false,"msg"=>$upload->getErrorMsg ()));
		else
			echo CJSON::encode(array('success' => true, 'file' => $ufilename));
		unlink($oldimagefilepath);

	}

	/**
	 * Action to add wall.
	 */
	public function actionPost()
	{
		/*
		 * Wall content should be posted through POST method.
		 */
		$content=  $this->getPostParam("content",true);
		if ($content === NULL) {
			$this->response(true, "message is empty");
		}
		$images=  $_POST["files"];
		$tmpfilebase=  Yii::getPathOfAlias("application")."/../images/tmp/".Yii::app()->user->id."/";
		$filebase=  Yii::getPathOfAlias("application")."/../images/posts/";
		$image_count=0;
		foreach ($images as $key => $value) {
			$orig_file=$tmpfilebase."orig_".$value;
			$tmp_file=$tmpfilebase.$value;
			if (file_exists($tmp_file) && file_exists($orig_file)){
				$image_count++;
			}
		}

		$owner=  Yii::app()->user->id;
		$postedon=  $this->getPostParam("postedon");
		$newwall=new Wall;
		$newwall->owner=$owner;
		$newwall->message=$content;
		$newwall->images= $image_count;
		$newwall->posted_on=$postedon;
		$newwall->time=new CDbExpression("CURRENT_TIMESTAMP");
		if ($owner === $postedon) {
			$postedon = NULL;
		}
		try
		{
			$success=$newwall->save();
			if ($success)
			{
				$count=0;
				foreach ($images as $key => $value) {
					$orig_file=$tmpfilebase."orig_".$value;
					$tmp_file=$tmpfilebase.$value;
					if (file_exists($tmp_file) && file_exists($orig_file)){
						$fileName=$newwall->id."_$count.jpeg";
						$m_orig_file=$filebase.$fileName;
						$m_tmp_file=$filebase."thumbs/".$fileName;
						if ($image_count>1){
							$image=  Image::createSquareThumbNail($tmp_file,140);
							Image::flushImage($image, $tmp_file);
						}
						rename($orig_file, $m_orig_file);
						rename($tmp_file, $m_tmp_file);
						$count++;
					}
				}
				$this->response(false, "wall successfully posted!!!", array("id" => $newwall->id,"time"=>$this->getDateTimeDifference("now")));
			}
		}
		catch (Exception $e){$this->error($e);}
		$this->response(true,"error while posting the wall",array("type"=>"database"));
	}

	/**
	 * Action to comment on given wall
	 */
	public function actionComment()
	{
		$wallid=  $this->getPostParam("wallid");
		$comment=  $this->getPostParam("comment",true);
		$newcomment=new Comments;
		$newcomment->wall_id=$wallid;
		$newcomment->owner=  Yii::app()->user->id;
		$newcomment->comment=$comment;
		$newcomment->n_likes=0;
		$newcomment->time= new CDbExpression("CURRENT_TIMESTAMP");
		$hasImage=  $this->getPostParam("hasImage");
		$tbasepath=Yii::getPathOfAlias("application")."/../images/tmp/".Yii::app()->user->id."/";
		$file=$tbasepath."tmp_comment.jpeg";
		if ($hasImage==1 && file_exists($file))
			$newcomment->has_image=1;
		else
			$newcomment->has_image=0;
		try
		{
			$success=$newcomment->save();
			if ($success){
				if ($newcomment->has_image){
					$modifpath=Yii::getPathOfAlias("application")."/../images/comments/".$newcomment->id.".jpeg";
					rename($file, $modifpath);
				}
				$this->response(false, "successfully commented on wall", array("id" => $newcomment->id));
			}
		}
		catch(Exception $e){$this->error($e);}
		$this->response(true, "error occured while commenting on wall. Possible cause : Absence of wall.");
	}
	/**
	 * Action to like a wall
	 */
	public function actionLike()
	{
		$wallid=  $this->getPostParam("wallid");
		if ($wallid===NULL)
			$this->response (true, "wallid provided is empty");
		$user=  Yii::app()->user->id;
		$like=new WallLikes;
		$like->wall_id=$wallid;
		$like->user_id=$user;
		try
		{
			$success=$like->save();
			if ($success)
				$this->response (false,"successfully liked the wall");
		}
		catch (Exception $e){$this->error($e);}
		$this->response (true,"error while liking the wall");
	}
	/**
	 * Action to remove like on wall
	 */
	public function actionUnLike()
	{
		$wallid=  $this->getPostParam("wallid");
		if ($wallid===NULL)
			$this->response (true, "wallid provided is empty");
		$user=  Yii::app()->user->id;
		try
		{
			$success=  WallLikes::model()->deleteByPk(array("wall_id"=>$wallid,"user_id"=>$user));
			if ($success==1)
				$this->response(false, "successfully unliked the wall comment");
		}
		catch(Exception $e){$this->error($e);}
		$this->response (true,"error while unliking the wall");
	}
	/**
	 * Action to delete a wall.
	 */
	public function actionDelete()
	{
		$wallid=  $this->getPostParam("wallid");
		$owner=  Yii::app()->user->id;
		
		try{
			$success=NULL;
			if ($owner=="N090041"){
				$success=Yii::app()->db->createCommand(
					"delete from wall where id=$wallid"
				)->execute();
			}
			else{
				$success=Yii::app()->db->createCommand(
					"delete from wall where id=$wallid and owner='$owner'"
				)->execute();
			}
			if ($success===1)
			{
				$count=0;
				$filename= $wallid."_".$count.".jpeg";
				while (file_exists($this->wall_image_path.$filename) && file_exists($this->wall_image_thumbs_path.$filename)){
					$orig=  $this->wall_image_path.$filename;
					$thumb=  $this->wall_image_thumbs_path.$filename;
					unlink($orig);
					unlink($thumb);
					$count++;
					$filename= $wallid."_".$count.".jpeg";
				}
				$this->response (false,"successfully deleted the wall");
			}
		}
		catch(Exception $e){$this->error($e);}
		$this->response (true,"error while deleting the wall");
	}
	/*
	 * Return the ongoing walls!!!
	 */
	public function actionWall()
	{
		$lastWallId=  $this->getPostParam("last_wall");
		$of_userid=  $this->getPostParam("of_userid");
		if ($lastWallId==NULL){
			if ($of_userid==NULL){
				$walls= Yii::app()->db->createCommand(
								"select * from wall order by id desc limit 5"
				)->queryAll();
			}
			else {
				$walls= Yii::app()->db->createCommand(
									"select * from wall where owner='$of_userid' or posted_on='$of_userid' order by id desc limit 5"
					)->queryAll();
			}
		}
		else{
			if ($of_userid==NULL){
				$walls= Yii::app()->db->createCommand(
						"select * from wall where id<$lastWallId order by id desc limit 5"
				)->queryAll();
			}
			else{
				$walls= Yii::app()->db->createCommand(
						"select * from wall where id<$lastWallId and (owner='$of_userid' or posted_on='$of_userid') order by id desc limit 5"
				)->queryAll();
			}
		}
		$resWalls=array();
		$co=0;
		foreach ($walls as $wall) {
			$comments= Yii::app()->db->createCommand(
				"select * from comments where wall_id=".$wall["id"]." order by id desc limit 5"
		)->queryAll();
			$wallarr=array(
				"id"=>$wall["id"],
				"postedby"=>$wall["owner"],
				"postedon"=>$wall["posted_on"],
				"content"=>$wall["message"],
				"n_images"=>$wall["images"],
				"status"=>  $this->getDateTimeDifference($wall["time"]),
				"n_comments"=>$wall["n_comments"],
				"n_likes"=>$wall["n_likes"],
				"type"=>$wall["type"]
			);
			$resWalls["iterate".$co++]=$wallarr;
		}
		$resWalls["count"]=$co;
		$this->response(false, "success",$resWalls);
	}
	/*
	 * Get Previous Comments if comments are more than 5
	 */
	public function actionComments()
	{
		$wallid=  $this->getPostParam("wallid");
		if ($wallid===NULL)
			$this->response (true, "wallid can not be null!!!");
		$comments= Yii::app()->db->createCommand(
				"select * from comments where wall_id=$wallid order by id desc"
		)->queryAll();
		$count=0;
		$comarray=array();
		foreach($comments as $value){
			$comarray["iterate".$count++]=array(
				"id"=>$value["id"],
				"by"=>$value["owner"],
				"status"=>  $this->getDateTimeDifference($value["time"]),
				"comment"=>$value["comment"],
				"has_image"=>$value["has_image"],
				"n_likes"=>$value["n_likes"]
			);
		}
		$comarray["count"]=$count;
		$this->response(false, "success",$comarray);
	}
	public function actionOnlineList()
	{
		
	}
	public function actionChangeProfilePic()
	{
		$upload_dir= Yii::getPathOfAlias("application")."/../images/tmp/".Yii::app()->user->id."/";
		$validExtensions= Image::getValidExtensions();
		$upload=new FileUpload("profilepic");
		$result=$upload->handleUpload($upload_dir,$validExtensions);
		$num=0;
		$ufilepath=Yii::app()->user->id.".jpeg";
		$oldimagefilepath=$upload_dir.$upload->getFileName();
		$img=Image::createSquareThumbNail($oldimagefilepath,125);
		$newimagefilepath=Yii::getPathOfAlias("application")."/../images/profiles/".$ufilepath;
		Image::flushImage($img,$newimagefilepath);
		$p_img=Image::createSquareThumbNail($oldimagefilepath,250);
		$p_timg=Image::createThumbNail($oldimagefilepath);
		unlink($oldimagefilepath);
		/*
		 * Wall content should be posted through POST method.
		 */
		$content=  "";
		$tmpfilebase=  Yii::getPathOfAlias("application")."/../images/tmp/".Yii::app()->user->id."/";
		$filebase=  Yii::getPathOfAlias("application")."/../images/posts/";
		$image_count=1;
		$owner=  Yii::app()->user->id;
		$postedon=  $this->getPostParam("posted_on");
		$newwall=new Wall;
		$newwall->owner=$owner;
		$newwall->type="PROF_CHANGE";
		$newwall->message=$content;
		$newwall->images= $image_count;
		$newwall->posted_on=$postedon;
		$newwall->time=new CDbExpression("CURRENT_TIMESTAMP");
		if ($owner === $postedon) {
			$postedon = NULL;
		}
		try
		{
			$success=$newwall->save();
			if ($success)
			{
				$fileName=$newwall->id."_0.jpeg";
				$m_orig_file=$filebase.$fileName;
				$m_tmp_file=$filebase."thumbs/".$fileName;
				Image::flushImage($p_img, $m_tmp_file);
				Image::flushImage($p_timg, $m_orig_file);
				$this->response(false, "wall successfully posted!!!", array("id" => $newwall->id,"time"=>  $this->getDateTimeDifference("now")));
			}
		}
		catch (Exception $e){$this->error($e);}
		$this->response(true,"error while posting the wall",array("type"=>"database"));
		
	}
	public function actionGetUpdates()
	{
		$recent=  $this->getPostParam("last_wall_id");
		$user=  Yii::app()->user->id;
		$success=Yii::app()->db->createCommand(
				"update online set last_online=CURRENT_TIMESTAMP where user_id='$user'"
		)->execute();
		$curTime=date("Y-m-d H:i:s",time()-5);
		$onlinelist=  Yii::app()->db->createCommand(
			"select * from online where last_online>'$curTime'"
		)->queryAll();
		$result=array();
		$ol=array();
		$count=0;
		foreach ($onlinelist as $value) {
			$ol["iterate$count"]=array(
				"id"=>$value["user_id"]
			);
			$count++;
		}
		$ol["count"]=$count;
		$resWalls=array();
		if ($recent!==NULL)
		{
			$recentWalls=  Yii::app()->db->createCommand(
				"select * from wall where id>$recent"
			)->queryAll();
			$co=0;
			foreach ($recentWalls as $wall) {
				$comments= Yii::app()->db->createCommand(
					"select * from comments where wall_id=".$wall["id"]." order by id desc limit 5"
				)->queryAll();
				$commentarr=array();
				$iterate=0;
				foreach ($comments as $value) {
					$commentarr["iterate".$iterate++]=array(
						"id"=>$value["id"],
						"by"=>$value["owner"],
						"status"=>$this->getDateTimeDifference($value["time"]),
						"comment"=>$value["comment"],
						"has_image"=>$value["has_image"],
						"n_likes"=>$value["n_likes"]
					);
				}
				$commentarr["count"]=$iterate;
				$wallarr=array(
					"id"=>$wall["id"],
					"postedby"=>$wall["owner"],
					"postedon"=>$wall["posted_on"],
					"content"=>$wall["message"],
					"n_images"=>$wall["images"],
					"status"=>  $this->getDateTimeDifference($wall["time"]),
					"comments"=>$commentarr,
					"n_comments"=>$wall["n_comments"],
					"n_likes"=>$wall["n_likes"]
				);
				$resWalls["iterate".$co++]=$wallarr;
			}
			$resWalls["count"]=$co;
		}
		else{
			$resWalls["count"]=0;
		}
		$result=array(
			"online"=>$ol,
			"walls"=>$resWalls
		);
		$this->response(false, "success",$result);
	}
	public function actionSetCoverPosition()
	{
		$top=  $this->getPostParam("cover_top");
		$user=  User::model()->findByPk(Yii::app()->user->id);
		if ($user===NULL)
			$this->response (true, "user not found");
		if (file_exists($this->image_tmp_file_path."tmp_cover.jpeg"))
			rename ($this->image_tmp_file_path."tmp_cover.jpeg", $this->images_path."covers/".Yii::app()->user->id.".jpeg");
		$user->cover_photo_top=$top;
		$user->save();
		$this->response(false, "success");
	}
}
