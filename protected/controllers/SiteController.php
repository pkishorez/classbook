<?php

class SiteController extends Controller
{
	public $information;
	public function filters() {
		return array(
			"accessControl - login ,register, test, checkuser"
		);
	}
	public function accessRules() {
		return array(
			array("allow",
				"users"=>array("@")
			),
			array("deny")
		);
	}

	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
		$details=  User::model()->findByPk(Yii::app()->user->id);
		$this->information=array("details"=>$details,"isTimeline"=>false);
		// renders the view file 'protected/views/site/index.php'
		// using the default layout 'protected/views/layouts/main.php'
		$this->render('index');
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}

	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
		$isGuest=Yii::app()->user->isGuest;
		if (!$isGuest)
		{
			$this->redirect($this->createUrl("site/index"));
		}
		$model=new LoginForm;

		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		// collect user input data
		if(isset($_POST['LoginForm']))
		{
			$model->attributes=$_POST['LoginForm'];
			$model->username=  strtoupper($model->username);
			// validate user input and redirect to the previous page if valid
			if ($model->validate() && $model->login()){
				$this->redirect("index");
			}
			else{
				$this->renderPartial('login',array("loginerror"=>"Invalid Credentials."));
				Yii::app()->end();
			}
		}
//		// display the login form
//		$date=new DateTime("2/31/2014");
//		echo $date->format ("M j, Y");
		$this->renderPartial('login');
	}
	public function actionCheckUser(){
		$unid=  $this->getPostParam("university_id");
		$qu=  Yii::app()->db->createCommand(
			"select first_time_login from user where id='$unid'"
		)->queryAll();
		foreach ($qu as $value) {
			if ($value["first_time_login"]!=NULL)
				$this->response (true, "User already registered");
			$this->response(false, "success");
		}
		$this->response(true, "USer not found");
	}
	public function actionRegister(){
		if (isset($_POST["Register"])){
			$model=$_POST["Register"];
			foreach ($_POST["Register"] as $key => $value) {
				if (is_string($value)){
					$_POST["Register"][$key]= htmlspecialchars(mysql_escape_string($value));
				}
			}
			/*
			 * Registration logic of the user goes here!!!
			 */
			$model["idno"]=  strtoupper($model["idno"]);
			$user=  User::model()->findByPk($model["idno"]);
			if ($user===NULL){
				echo $this->renderPartial("login",array("register_error"=>"User Not found in database."));
				Yii::app()->end();
			}
			else if($user->first_time_login==false){
				echo $this->renderPartial("login",array("register_error"=>"User already registered."));
				Yii::app()->end();
			}
			/*Thinking here the values are valid!!!*/
			/*
			 * Inserting into database user table
			 */
//			if (strlen($model["password"])<5){
//				echo $this->renderPartial("login",array("register_error"=>"Password length is too small".strlen($model["password"])));
//				Yii::app()->end();
//			}
			$user->password=$model["password"];
			if (strtolower($model["lastName"])=="last name")
				$model["lastName"]="";
			$user->name=$model["firstName"]." ".$model["lastName"];
			$user->first_time_login=false;
			$user->gender=$model["gender"];
			$user->dob= trim($model["year"])."/".trim($model["month"])."/".($model["day"]+1);
			$success=$user->update();
			if ($success){
				mkdir(Yii::getPathOfAlias("application")."/../images/tmp/".$model["idno"]);
				$imgb=Yii::getPathOfAlias("application")."/../images/profiles/";
				copy($imgb."default.jpeg", $imgb.$model["idno"].".jpeg");
				$q=Yii::app()->db->createCommand("insert into profile(id,nickname) values('".$model["idno"]."','".$user->name."')")->execute();
				if ($q!==1){
					echo $this->renderPartial("login",array("register_error"=>"Problem while registering."));
				}
				else
				{
					$loginForm=new LoginForm;
					$loginForm->username=  strtoupper($model["idno"]);
					$loginForm->password= $model["password"];
					// validate user input and redirect to the previous page if valid
					if ($loginForm->validate() && $loginForm->login()){
						$this->redirect("index");
					}
					else{
						$this->renderPartial("login",array("register_error"=>"Error somewhere!!! Please contact kishore."));
						Yii::app()->end();
					}
				}
			}
			else{
				echo $this->renderPartial("login",array("register_error"=>"Invalid register details"));
				//$this->redirect($this->createUrl("site/login"));
			}
		}
		else
			$this->renderPartial("login");
	}

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionTimeline($user="N090041")
	{
		$user=  mysql_escape_string($user);
		$details=  User::model()->findByPk($user);
		if ($details===NULL)
			throw new CHttpException(400);
		else if($details->first_time_login==1)
			throw new CHttpException(400);
		$this->information=array("timelineuserid"=>$user,"details"=>$details,"isTimeline"=>true);
		$this->render("k_timeline",array("timelineuserid"=>$user,"details"=>$details));
	}
	public function actionEditProfile()
	{
		$model=new Profile;
		$user= Yii::app()->user->id;
		$details=  User::model()->findByPk($user);
		$this->information=array("timelineuserid"=>$user,"details"=>$details,"isTimeline"=>true);
		// uncomment the following code to enable ajax-based validation
		/*
		if(isset($_POST['ajax']) && $_POST['ajax']==='profile-auto_profile-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
		*/

		if(isset($_POST['Profile']))
		{
			foreach ($_POST["Profile"] as $key => $value) {
				if (is_string($value)){
					$_POST["Profile"][$key]= htmlspecialchars(mysql_escape_string($value));
				}
			}
			$model->attributes=$_POST['Profile'];
			$_POST["id"]=  Yii::app()->user->id;
			$model->id=  Yii::app()->user->id;
			if($model->validate())
			{
				User::model()->updateByPk(Yii::app()->user->id, array("name"=>$model->nickname));
				Profile::model()->updateByPk(Yii::app()->user->id, $_POST["Profile"]);//update();
				// form inputs are valid, do something here
				$this->render('editprofile',array('model'=>$model,"details"=>$details,"success"=>true,"isTimeline"=>true));
				return;
			}
		}
		$this->render('editprofile',array('model'=>$model,"details"=>$details,"isTimeline"=>true));
	}
	public function actionViewProfile($id=NULL){
		if ($id==NULL)
			$id=  Yii::app ()->user->id;
		else
			$id=  mysql_escape_string ($id);
		echo $id;
		$profile= Yii::app()->db->createCommand("select * from profile where id='$id'")->queryAll();
		$len=0;
		foreach ($profile as $value) {
			$len++;
		}
		if ($len==0)
			throw new CHttpException(400);
		$profile=$profile[0];
		$user= Yii::app()->user->id;
		$details=  User::model()->findByPk($user);
		$this->information=array("timelineuserid"=>$user,"details"=>$details,"profile"=>$profile,"isTimeline"=>true);
		$this->render('viewprofile',array("details"=>$details,"isTimeline"=>true));
	}
	public function actionLogout()
	{
		Yii::app()->user->logout();
		$user=  Yii::app()->user->id;
		$this->redirect(Yii::app()->homeUrl);
	}
}
