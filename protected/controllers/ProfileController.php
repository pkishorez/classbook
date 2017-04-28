<?php

class ProfileController extends CController
{
	public function missingAction($actionID) {
		if ($actionID!="")
			$this->redirect($this->createAbsoluteUrl("site/timeline",array("user"=>$actionID)),true);
		else {
			throw new CHttpException(400,"Page not found");
		}
	}
}