<?php

class LoginFilter extends CFilter
{
	protected function preFilter($filterChain) {
		$reqUrl=Yii::app()->request->requestUri;
		$isGuest=Yii::app()->user->isGuest;
		if ($isGuest)
		{
			Yii::app()->controller->response(true,"User not logged in!!!",array("type"=>"login"));
			return false;
		}
		return true;
	}
}