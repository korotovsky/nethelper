<?php

class users extends CActiveRecord {

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function tableName() {
        return 'users';
    }

    public function rules() {
        return array(
            array('password, created, modified', 'required'),
            array('login', 'length', 'max' => 40),
            array('name, password, email', 'length', 'max' => 100),
            array('id, login, name, password, email, created, modified', 'safe', 'on' => 'search'),
        );
    }

    public function relations() {
        return array(
        );
    }

    public function attributeLabels() {
        return array(
            'id' => 'Id',
            'login' => 'Login',
            'name' => 'Name',
            'password' => 'Password',
            'email' => 'Email',
            'created' => 'Created',
            'modified' => 'Modified',
        );
    }

    public function search() {
        $criteria = new CDbCriteria;
        $criteria->compare('id', $this->id);
        $criteria->compare('login', $this->login, true);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('password', $this->password, true);
        $criteria->compare('email', $this->email, true);
        $criteria->compare('created', $this->created, true);
        $criteria->compare('modified', $this->modified, true);
        return new CActiveDataProvider('users', array(
            'criteria' => $criteria,
        ));
    }
}
