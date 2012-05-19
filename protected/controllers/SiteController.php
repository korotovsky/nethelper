<?php

class SiteController extends Controller {
    public $layout = 'application.views.layouts.main';

    public function filters() {
        return array(
            'accessControl',
        );
    }

    public function accessRules() {
        return array(
            array('allow',
                'actions' => array('login', 'logout', 'error'),
                'users' => array('*'),
            ),
            array('allow',
                'actions' => array('index'),
                'users' => array('@'),
            ),
            array('deny',
                'users' => array('*'),
            ),
        );
    }

    public function actions() {
        return array(
        );
    }

    public function actionIndex() {
        $recent = neters::getRecent();
        $stats = neters::getStats();

        $this->render('index', 
            array('recent' => $recent, 'stats' => $stats)
        );
    }

    public function actionError() {
        if($error = Yii::app()->errorHandler->error) {
            if(Yii::app()->request->isAjaxRequest)
                echo $error['message'];
            else
                $this->render('error', $error);
        }
    }

    public function actionLogin() {
        $model = new login;
        if(isset($_POST['ajax']) && $_POST['ajax']==='login-form') {
            sleep(5);
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
        if(isset($_POST['login'])) {
            $model->attributes=$_POST['login'];
            if($model->validate() && $model->login())
                $this->redirect(Yii::app()->user->returnUrl);
        }
        $this->render('login', array('model' => $model));
    }

    public function actionLogout() {
        Yii::app()->user->logout();
        $this->redirect(Yii::app()->homeUrl);
    }
}
