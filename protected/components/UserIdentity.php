<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
	/**
	 * Authenticates a user.
	 * The example implementation makes sure if the username and password
	 * are both 'demo'.
	 * In practical applications, this should be changed to authenticate
	 * against some persistent user identity storage (e.g. database).
	 * @return boolean whether authentication succeeds.
	 */
	public $userType = 'Front';
	public $username;
	private $_id;
	
	public function authenticate()
	{
		
		$criteria = new CDbCriteria;
		$criteria->addCondition("staffCode = :staffCode");
		$criteria->addCondition("resigned = :resigned");
		$criteria->params = array(
			':staffCode'=>$this->username,
			':resigned'=>"NO",
		);
		
		
		$record = Users::model()->find($criteria); 
            if($record===null)
            { 
                $this->errorCode=self::ERROR_USERNAME_INVALID;
				
            }else if($record->password != md5($this->password)){
				$this->errorCode = self::ERROR_PASSWORD_INVALID;
			}else{
				//$this->staffCode = $record->staffCode0->staffCode;
				//$this->fullname = $record->staffCode0->Fullname;
				
				$this->errorCode = self::ERROR_NONE;
				$this->username = $record->staffCode;
				$this->_id = $record->id;
				$this->setState( 'userlogin', $record->staffCode );
				//$this->setState( 'name',$record->id );
				$this->setState('staffCode', $record->staffCode0->staffCode);
				//$this->setState('staffCode', $record->id);
				$this->setState('fullname', $record->staffCode0->Fullname);
				$this->setState('Id', $record->id);
				$this->setState('name', $record->id);
				//$this->setState('roles', $record->roles);
				
			}
		 return !$this->errorCode;
		/* $users=array(
			// username => password
			'demo'=>'demo',
			'admin'=>'12345',
		);
		if(!isset($users[$this->username]))
			$this->errorCode=self::ERROR_USERNAME_INVALID;
		elseif($users[$this->username]!==$this->password)
			$this->errorCode=self::ERROR_PASSWORD_INVALID;
		else
			$this->errorCode=self::ERROR_NONE;
		return !$this->errorCode; */
	}
	
	public function getId()
    {
        return $this->_id;
    }
}