<?php

class neters extends CActiveRecord {
    public $manual;

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function tableName() {
        return 'neters';
    }

    public function rules() {
        return array(
            array('fio, ilogin, room, ip, mac, provider', 'required'),
            array('fio, ip, mac', 'unique', 'className' => 'neters'),
            array('fio, room, ip, mac, ilogin', 'length', 'max' => 255),
            array('provider', 'length', 'max' => 14),
            array('mac', 'match', 'pattern' => '/^([0-9a-fA-F]{2}[-]){5}[0-9a-fA-F]{2}$/i'),
            array('ip', 'match', 'pattern' => '/^\d{3}.\d{2}.\d{1,3}.\d{1,3}$/i'),
            array('description, ip, manual', 'safe'),
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
        return archive::model()->find($criteria);
    }

    public static function getRecent() {
        $criteria = new CDbCriteria;
        $criteria->select = '*';                
        $criteria->order = 'modified DESC';
        $criteria->limit = 5;
        return neters::model()->findAll($criteria);
    }

    public static function getStats() {
        $criteria = new CDbCriteria;
        $criteria->select = '*';                
        $criteria->condition = 'provider = :provider';
        $criteria->params = array(':provider' => 'e-telecom');
        $stats['e-telecom'] = neters::model()->count($criteria);

        $criteria = new CDbCriteria;
        $criteria->select = '*';                
        $criteria->condition = 'provider = :provider';
        $criteria->params = array(':provider' => 'well-telecom');
        $stats['well-telecom'] = neters::model()->count($criteria);

        $criteria = new CDbCriteria;
        $criteria->select = '*';                
        $criteria->condition = 'provider = :provider';
        $criteria->params = array(':provider' => 'well-telecom-3');
        $stats['well-telecom-3'] = neters::model()->count($criteria);

        $criteria = new CDbCriteria;
        $criteria->select = '*';                
        $criteria->condition = 'provider = :provider';
        $criteria->params = array(':provider' => 'disconnected');
        $stats['disconnected'] = neters::model()->count($criteria);

        $criteria = new CDbCriteria;
        $criteria->select = '*';                
        $criteria->condition = 'provider = :provider';
        $criteria->params = array(':provider' => 'none');
        $stats['none'] = neters::model()->count($criteria);

        $criteria = new CDbCriteria;
        $criteria->select = '*';
        $stats['all'] = neters::model()->count($criteria);

        return $stats;
    }

    public static function findAddress() {
        $criteria = new CDbCriteria;
        $criteria->select = 'ip';                
        $neters = neters::model()->findAll($criteria);
        foreach($neters as $item) {
            $ips['db'][] = $item->ip;
        }
        for($j = 0; $j < 4; $j++) {
            for($i = 10; $i < 170; $i++) {
                $ips['all'][] = "172.23.16" . $j . "." . $i;
            }
        }
        $ips['filtered'] = array_diff($ips['all'], $ips['db']);
        $rand = array_rand($ips['filtered'], 20);
        foreach($rand as $v) {
            $ips['rand'][] = $ips['filtered'][$v];
        }
        return $ips['rand'];
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
        return new CActiveDataProvider('neters', array(
            'criteria' => $criteria,
            'pagination'=>array(
                'pageSize' => 30,
            ),
        ));
    }
}
