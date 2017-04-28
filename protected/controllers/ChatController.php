<?php

class ChatController extends Controller{
	public function actionMessage(){
		$to=  $this->getPostParam("to");
		$message=  $this->getPostParam("message",true);
		if ($to===NULL)
			$this->response (true, "User should be mentioned");
		else if ($message==NULL)
			$this->response (TRUE, "Message can not be null");
		$query= new Chat();
		$query->frm=  Yii::app()->user->id;
		$query->too=$to;
		$query->message=new CDbExpression('AES_ENCRYPT("'.$message.'","uttik")');
		$query->time=new CDbExpression("CURRENT_TIMESTAMP");
		try{
			$query->save();
		} catch (Exception $ex) {
			$this->response(true, "database error ".$ex->getMessage());
		}
		$this->response(false, "success",array("id"=>$query->id,"time"=>  $this->getDateTimeDifference("now")));
	}
	public function actionSeen()
	{
		$to=  Yii::app()->user->id;
		$from=  $this->getPostParam("from");
		Yii::app()->db->createCommand(
				"update chat_stats set unseen=0 where frm='$from' and too='$to'"
		)->execute();
		$this->response(false, "success",array("time"=>$this->getDateTimeDifference("now"),"to"=>$to,"from"=>$from));
	}
	public function actionKnownPeople(){
		$user=  Yii::app()->user->id;
		$chatStats= Yii::app()->db->createCommand(
				"select DISTINCT * from chat_stats where too='$user' or frm='$user';"
		)->queryAll();
		$resArray=array();
		$count=0;
		foreach ($chatStats as $key => $value) {
			$uusseerr=$value["too"];
			if ($value["frm"]!=$user)
				$uusseerr=$value["frm"];
			$resArray["iterate$count"]=array(
				"user"=>$uusseerr
			);
			$count++;
		}
		$resArray["count"]=$count;
		$this->response(false, "success",$resArray);
	}

	public function actionOnlineList(){
		$test_time=date("Y-m-d H:i:s",time()-30);
		$olist=  Yii::app()->db->createCommand(
			"select * from online where last_online>='$test_time'"
		)->queryAll();
		$count=0;
		$array=array();
		foreach ($olist as $value) {
			$array["iterate$count"]=array(
				"user_id"=>$value["user_id"],
				"last_online"=>  $this->getDateTimeDifference($value["last_online"])
			);
			$count++;
		}
		$array["count"]=$count;
		$this->response(FALSE, "success",$array);
	}
	public function actionMessageNotifications(){
		$user=  Yii::app()->user->id;
		$chatStats= Yii::app()->db->createCommand(
				"select * from chat_stats where too='$user' or frm='$user';"
		)->queryAll();
		$resArray=array();
		$count=0;
		foreach ($chatStats as $key => $value) {
			$resArray["iterate$count"]=array(
				"from"=>$value["frm"],
				"to"=>$value["too"],
				"unseen"=>$value["unseen"], 
				"time"=>  $this->getDateTimeDifference($value["time"])
			);
			$count++;
		}
		$resArray["count"]=$count;
		$this->response(false,"nothing", $resArray);
	}
	public function actionNewMessages(){
		$from=  $this->getPostParam("from");
		$to=  Yii::app()->user->id;
		$last_id=  $this->getPostParam("last_id");
		if ($from===NULL)
		{
			$this->response (true, "From can not be empty");
		}
		$ch_stats= ChatStats::model()->find("frm=:from and too=:to", array("from"=>$from,"to"=>$to));
		if ($ch_stats===null){
			$this->response(true, "Record not found");
		}
		if ($last_id!==NULL)
			$query=  Yii::app()->db->createCommand(
					"select * from chat where too='$to' and frm='$from' and id>$last_id"
			)->queryAll();
		else
		{
			$query=  Yii::app()->db->createCommand(
					"select * from chat where too='$to' and frm='$from'"
			)->queryAll();
		}
		$charray=array();
		$count=0;
		foreach ($query as $value) {
			$charray["iterate$count"]=array(
				"id"=>$value["id"],
				"from"=>$value["frm"],
				"message"=>$value["message"],
				"time"=>  $value["time"]
			);
			$count++;
		}
		Yii::app()->db->createCommand(
				"update chat_stats set unseen=0 where frm='$from' and too='$to'"
		)->execute();
		$charray["count"]=$count;
		$this->response(false, "success",$charray);
	}
	public function actionOldMessages(){
		$from=  $this->getPostParam("from");
		$l_id=  $this->getPostParam("l_ch_id");
		if ($from===NULL)
			$this->response (true, "from can not be null");
		$to=  Yii::app()->user->id;
		$number=  $this->getPostParam("from");
		if ($l_id==NULL){
			try{
				Yii::app()->db->createCommand(
					"insert into chat_stats values('$to','$from',0,CURRENT_TIMESTAMP)"
				)->execute();
				Yii::app()->db->createCommand(
					"insert into chat_stats values('$from','$to',0,CURRENT_TIMESTAMP)"
				)->execute();
			} catch (Exception $ex) {
				;
			}
			$chat=  Yii::app()->db->createCommand(
					"select id,frm,too,cast(AES_DECRYPT(message, 'uttik') as char) as message,time from chat where (frm='$from' and too='$to') or (frm='$to' and too='$from') order by id desc limit 20;"
			)->queryAll();
		}
		else{
			//DECRYPT(message, 'uttik'),
			$chat=  Yii::app()->db->createCommand(
					"select id,frm,too,cast(AES_DECRYPT(message, 'uttik') as char) as message,time from chat where ((frm='$from' and too='$to') or (frm='$to' and too='$from')) and id<$l_id order by id desc limit 20;"
			)->queryAll();
		}
		//$chat=array_reverse($chat);
		$chArray=array();
		$count=0;
		foreach ($chat as $value) {
			$msg=$value["message"];
			$chArray["iterate$count"]=array(
				"id"=>$value["id"],
				"from"=>$value["frm"],
				"to"=>$value["too"],
				"message"=>$msg,
				"time"=> $this->getDateTimeDifference($value["time"])
			);
			$count++;
		}
		$seen=  Yii::app()->db->createCommand(
			"select * from chat_stats where frm='$to' and too='$from'"
		)->queryAll();
		foreach ($seen as $value) {
			$seen=$value;
			break;
		}
		$chArray["seen"]=array(
			"unseen"=>$seen["unseen"],
			"time"=>  $this->getDateTimeDifference($seen["time"])
		);
		$chArray["count"]=$count;
		$this->response(false, "success",$chArray);
	}
}