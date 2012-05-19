<?php

class WebUser extends CWebUser {
    private $_model = null;
 
    function getRole() {
        if($user = $this->getModel()) {
            return $user->role;
        }
    }
 
    private function getModel() {
        if (!$this->isGuest && $this->_model === null){
            $this->_model = users::model()->findByPk($this->id, array('select' => '*'));
        }
        return $this->_model;
    }
}

?>
