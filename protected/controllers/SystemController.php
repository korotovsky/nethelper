<?php

class SystemController extends Controller {

    public $layout = false;
    private $_model;

    public function filters() {
        return array(
            'accessControl',
        );
    }

    public function accessRules() {
        return array(
            array('allow',
                'actions' => array('dhcp'),
                'roles' => array('admin'),
            ),
            array('deny',
                'users' => array('*'),
            ),
        );
    }

    public function actionDhcp() {
        $status = exec('php ' . Yii::app()->basePath . '/../console.php buildconfig');
        Yii::app()->user->setFlash('dhcp', $status);
    }

}
