<?php

class LayoutController extends CController
{
	public $layout="//layouts/layout";
	public function filters() {
		return array(
			"accessControl"
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
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
		// renders the view file 'protected/views/site/index.php'
		// using the default layout 'protected/views/layouts/main.php'
		$this->render('index');
	}

}