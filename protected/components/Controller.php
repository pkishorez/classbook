<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends CController
{
	/**
	 * @var string the default layout for the controller view. Defaults to '//layouts/column1',
	 * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
	 */
	public $layout='//layouts/column1';
	/**
	 * @var array context menu items. This property will be assigned to {@link CMenu::items}.
	 */
	public $menu=array();
	/**
	 * @var array the breadcrumbs of the current page. The value of this property will
	 * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
	 * for more details on how to specify this property.
	 */
	public $breadcrumbs=array();
	
	/**
	 * This function is used to avoid mysql injection by wrapping $_POST in this function.
	 * If html should be converted to text, call second param to true.
	 * @param type $id id of $_POST to return
	 * @param type $convert_to_text to convert html to valid text or not
	 * @return text value of $_POST with escaped quotes.
	 */
	public function getPostParam($id,$convert_to_text=false)
	{
		$value=NULL;
		if (isset($_POST[$id]))
		{
			$value=  mysql_real_escape_string ($_POST[$id]);
			if ($convert_to_text){
				$value= htmlentities($value);
				$value=  str_replace("\\n", "<br>", $value);
			}
		}
		return $value;
	}
	public function response($error,$message,$array=array())
	{
		if (!is_array($array)){
			$array=array("data"=>$array);
		}
		$basic=array("error"=>$error,"message"=>$message);
		$array=array_merge($basic, $array);
		$json=CJSON::encode($array);
		echo $json;
		Yii::app()->end();
	}

	public function error($e)
	{
		$this->response(true, $e->getMessage());
	}
	public function getDateTimeDifference($datetime){
		$now=new DateTime("now");
		$past=new DateTime($datetime);
		$diff=$past->diff($now);
		//echo $diff->format("%y years %m months %d days %h hours %i minutes %s seconds!!!<br>");
		$dday=$diff->format("d");
		$dmonth=$diff->format("m");
		$dhour=$diff->format("%H");
		$dminutes=$diff->format("%i");
		$dseconds=$diff->format("%s");
		
		$pastyear=$past->format("Y");
		$thisyear=$now->format("Y");
		
		$pastmonth=$past->format("n");
		$thismonth=$now->format("n");
		
		$pastday=$past->format("j");
		$thisday=$now->format("j");
		
		if ($pastyear!==$thisyear)
			return $past->format ("M j, Y");
		else
		{
			if ($thismonth!==$pastmonth)
				return $past->format("F j");
			else
			{
				if ($thisday===$pastday)
				{
					return "Today at ".$past->format("g:i a");
				}
				else if ($dday<=1)
					return "Yesterday at ".$past->format("g:i a");
				else
					return $past->format("F j")." at ".$past->format("g:i a");
			}
		}
	}

	public function getNonUpdatableDateTimeDifference($datetime){
		$now=new DateTime("now");
		$past=new DateTime($datetime);
		$diff=$past->diff($now);
		//echo $diff->format("%y years %m months %d days %h hours %i minutes %s seconds!!!<br>");
		$dday=$diff->format("d");
		$dmonth=$diff->format("m");
		$dhour=$diff->format("%H");
		$dminutes=$diff->format("%i");
		$dseconds=$diff->format("%s");
		
		$pastyear=$past->format("Y");
		$thisyear=$now->format("Y");
		
		$pastmonth=$past->format("n");
		$thismonth=$now->format("n");
		
		$pastday=$past->format("j");
		$thisday=$now->format("j");
		
		if ($pastyear!==$thisyear)
			return $past->format ("M j, Y");
		else
		{
			if ($thismonth!==$pastmonth)
				return $past->format("F j");
			else
			{
				if ($thisday===$pastday)
				{
					if ($dhour==0){
						if ($dminutes==0)
							return $dseconds." seconds ago";
						if ($dminutes==1)
							return "1 minute ago";
						return $dminutes." minutes ago";
					}
					if ($dhour==1)
						return "1 hour ago";
					else if ($dhour<=3)
						return "$dhour hours ago";
					return "Today at ".$past->format("g:i a");
				}
				else if ($dday<=1)
					return "Yesterday at ".$past->format("g:i a");
				else
					return $past->format("F j")." at ".$past->format("g:i a");
			}
		}
	}
	
}
