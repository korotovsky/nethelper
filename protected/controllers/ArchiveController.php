<?php

class ArchiveController extends Controller {
    public $layout='//layouts/main';
    private $_model;

    public function filters() {
        return array(
            'accessControl',
        );
    }

    public function accessRules() {
        return array(
            array('allow',
                'actions' => array('index', 'view'),
                'users' => array('@'),
            ),
            array('allow',
                'actions' => array('admin', 'delete', 'update', 'create', 'add'),
                'roles' => array('admin'),
            ),
            array('deny',
                'users' => array('*'),
            ),
        );
    }

    public function actionView() {
        $this->render('view', array(
            'model' => $this->loadModel(),
        ));
    }

    public function actionAdd() {
        $model = new archive;
        $neter = archive::getNeter();
        if(Yii::app()->request->isPostRequest) {
            $model->fio = $neter->fio;
            $model->ilogin = $neter->ilogin;
            $model->room = $neter->room;
            $model->ip = '';
            $model->mac = $neter->mac;
            $model->provider = $neter->provider;
            $model->description = $neter->description;
            $model->created = $neter->created;
            $model->modified = new CDbExpression('NOW()');
            if(!$model->save()) {
                throw new CHttpException(500,'Error while add neter to archive.');
            } else {
                if(!neters::model()->deleteByPk($neter->id)) {
                    throw new CHttpException(500,'Error while delete neter from neters.');
                }
            }
            if(!isset($_GET['ajax']))
                $this->redirect(array('index'));
        }
        else
            throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
    }

    public function actionCreate() {
        $model = new archive;

        $this->performAjaxValidation($model);

        if(isset($_POST['archive'])) {
            $model->created = new CDbExpression('NOW()');
            $model->modified = new CDbExpression('NOW()');
            $model->attributes = $_POST['archive'];
            if($model->validate() && $model->save()) {
                $this->redirect(array('view','id'=>$model->id));
            } else {
                $this->render('create', array(
                    'model' => $model,
                ));
            }
        }

        $this->render('create', array(
            'model' => $model,
        ));
    }

    public function actionUpdate() {
        $model = $this->loadModel();

        $this->performAjaxValidation($model);

        if(isset($_POST['archive'])) {
            $model->modified = new CDbExpression('NOW()');
            $model->attributes = $_POST['archive'];
            if($model->validate() && $model->save()) {
                $this->redirect(array('view','id'=>$model->id));
            } else {
                $this->render('update', array(
                    'model' => $model,
                ));
            }
        }

        $this->render('update', array(
            'model' => $model,
        ));
    }

    public function actionDelete() {
        if(Yii::app()->request->isPostRequest) {
            $this->loadModel()->delete();

            if(!isset($_GET['ajax']))
                $this->redirect(array('index'));
        }
        else
            throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
    }

    public function actionIndex() {
        $this->redirect(array('admin'));
    }

    public function actionAdmin() {
        $model = new archive('search');
        $model->unsetAttributes();
        if(isset($_GET['archive']))
            $model->attributes = $_GET['archive'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    public function loadModel() {
        if($this->_model === null) {
            if(isset($_GET['id']))
                $this->_model=archive::model()->findbyPk($_GET['id']);
            if($this->_model===null)
                throw new CHttpException(404, 'The requested page does not exist.');
        }
        return $this->_model;
    }

    protected function performAjaxValidation($model) {
        if(isset($_POST['ajax']) && $_POST['ajax'] === 'archive-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
}
