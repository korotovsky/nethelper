<?php

class archive extends CActiveRecord {

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function tableName() {
        return 'archive';
    }

    public function rules() {
        return array(
            array('fio, provider', 'required'),
            array('fio', 'unique', 'className' => 'archive'),
            array('fio, room, ip, mac, ilogin', 'length', 'max' => 255),
            array('provider', 'length', 'max' => 14),
            array('description', 'safe'),
            array('id, fio, room, ip, mac, provider, description, created, modified, ilogin', 'safe', 'on' => 'search'),
        );
    }

    public function relations() {
        return array(
        );
    }

    public function attributeLabels() {
        return array(
            'id' => 'Номер',
            'fio' => 'ФИО',
            'room' => 'Комната',
            'ip' => 'IP Адрес',
            'mac' => 'MAC',
            'provider' => 'Провайдер',
            'description' => 'Описание',
            'created' => 'Создан',
            'modified' => 'Изменен',
            'ilogin' => 'Логин',
        );
    }

    public static function getNeter() {
        $criteria = new CDbCriteria;
        $criteria->select = '*';                
        $criteria->condition = 'id = :id';
        $criteria->params = array(':id' => $_GET['id']);
        return neters::model()->find($criteria);
    }

    public function search() {
        $criteria = new CDbCriteria;
        if(!Yii::app()->request->isAjaxRequest) {
            $criteria->order = 'modified DESC';
        }
        $criteria->compare('id', $this->id);
        $criteria->compare('fio', $this->fio, true);
        $criteria->compare('room', $this->room, true);
        $criteria->compare('ip', $this->ip, true);
        $criteria->compare('mac', $this->mac, true);
        $criteria->compare('provider', $this->provider, true);
        $criteria->compare('description', $this->description, true);
        $criteria->compare('created', $this->created, true);
        $criteria->compare('modified', $this->modified, true);
        $criteria->compare('ilogin', $this->ilogin, true);
        return new CActiveDataProvider('archive', array(
            'criteria' => $criteria,
            'pagination'=>array(
                'pageSize' => 30,
            ),
        ));
    }
}
