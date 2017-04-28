<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
	public $firsttimelogin;
	public $name=null;
	/**
	 * Authenticates a user.
	 * The example implementation makes sure if the username and password
	 * are both 'demo'.
	 * In practical applications, this should be changed to authenticate
	 * against some persistent user identity storage (e.g. database).
	 * @return boolean whether authentication succeeds.
	 */
	public function authenticate()
	{
		$user=  User::model()->findByPk($this->username);
		$this->name=$user->name;
		$this->errorCode=  self::ERROR_NONE;
		if ($user===NULL)
			$this->errorCode=  self::ERROR_USERNAME_INVALID;
		else{
			$this->firsttimelogin=$user->first_time_login;
			if ($this->password!==$user->password)
				$this->errorCode=  self::ERROR_PASSWORD_INVALID;
			else
			{
				$this->name=$user->name;
				$this->errorCode=  self::ERROR_NONE;
			}
		}
		return !$this->errorCode;
	}
}