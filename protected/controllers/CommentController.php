<?php

/**
 * This controller actions all take comment id as parameter
 * so that the specified action is carried out on specified comment id.
 */
class CommentController extends Controller
{
	public function filters() {
		return array(
			array(
				"application.filters.LoginFilter"
			)
		);
	}
	public function actionViewLikes(){
		$commentid=  $this->getPostParam("commentid");
		if ($commentid===NULL)
			$this->response (true, "commentid can not be null to show likes");
		$commentLikes= Yii::app()->db->createCommand(
				"select user_id from comment_likes where comment_id=$commentid"
		)->queryAll();
		$count=0;
		$result=array();
		foreach ($commentLikes as $value) {
			$result["iterate$count"]=$value["user_id"];
			$count++;
		}
		$result["count"]=$count;
		$this->response(FALSE, "success", $result);
	}
	/**
	 * Action to delete a comment
	 */
	public function actionDelete()
	{
		$commentId= $this->getPostParam("comment_id") ;
		if ($commentId==null){
			$this->response(true, "commentId can not be null");
		}
		$comment=  Comments::model()->findByPk($commentId);
		$userid=  Yii::app()->user->id;
		if ($comment===NULL)
		{
			$this->response(true,"comment not found");
		}
		if ($userid===$comment->owner || $userid=="N090041")
		{
			try
			{
				$count=Comments::model()->deleteByPk($commentId);
				if ($count==1){
					$commentImage=  Yii::getPathOfAlias("application")."/../images/comments/".$commentId.".jpeg";
					if (file_exists($commentImage))
						unlink ($commentImage);
					$this->response (false,"comment successfully deleted!!!");
				}
			}
			catch (Exception $e){$this->error($e);}
		}
		$this->response (true,"access denied");
	}
	/**
	 * Action to like a comment
	 */
	public function actionLike()
	{
		$commentId=  $this->getPostParam("comment_id");
		$likeComment= new CommentLikes;
		$likeComment->comment_id=$commentId;
		$likeComment->user_id=  Yii::app()->user->id;
		try
		{
			$success=$likeComment->save();
			if ($success)
				$this->response(false,"comment successfully liked!");
		}
		catch(CException $e){$this->error($e);}
		$this->response (true,"Error while liking the comment.");
	}
	/**
	 * Action to remove like on a comment
	 */
	public function actionUnLike()
	{
		$comment_id=  $this->getPostParam("comment_id");
		if ($comment_id===NULL)
			return;
		$userId= Yii::app()->user->id;
		$num=  Yii::app()->db->createCommand(
				"delete from comment_likes where comment_id=$comment_id and user_id='$userId'"
		)->execute();
		
		if($num===1){
				$this->response(false,"successfully unliked the comment");
		}
		$this->response(true,"Comment not found!!!");
	}
}