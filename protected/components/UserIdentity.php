<?php

class UserIdentity extends CUserIdentity {
    protected $_id;
    
    public function authenticate() {
        $username = $this->username; 
        $password = $this->password;

        $record = users::model()->findByAttributes(array('username' => $username));
        if($record === null) {
            $this->errorCode = self::ERROR_USERNAME_INVALID;
        } elseif($record->password !== $password or empty($password)) {
            $this->errorCode = self::ERROR_PASSWORD_INVALID;
        } else {
            $this->_id = $record->id;
            $this->errorCode = self::ERROR_NONE;
        }
        return !$this->errorCode;
    }
    
    public function getId(){
        return $this->_id;
    }
        
}

?>
