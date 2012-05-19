<?php

class NetersController extends Controller {

    public $layout = '//layouts/main';
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
                'actions' => array('admin', 'delete', 'update', 'create', 'restore'),
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

    public function actionCreate() {
        $model = new neters;

        $this->performAjaxValidation($model);

        if(isset($_POST['neters'])) {
            $model->created = new CDbExpression('NOW()');
            $model->modified = new CDbExpression('NOW()');
            $model->attributes = $_POST['neters'];
            if($model->validate() && $model->save()) {
                $status = exec('php ' . Yii::app()->basePath . '/../console.php buildconfig');
                Yii::app()->user->setFlash('dhcp', $status);
                $this->redirect(array('admin'));
            } else {
                $this->render('create', array(
                    'model' => $model,
                ));
            }
        } else {
            $this->render('create', array(
                'model' => $model,
            ));
        }
    }

    public function actionRestore() {
        $model = new neters;
        $archive = neters::getNeter();
        if(Yii::app()->request->isPostRequest) {
            $address = neters::findAddress();
            $model->fio = $archive->fio;
            $model->ilogin = $archive->ilogin;
            $model->room = $archive->room;
            $model->ip = $address[0];
            $model->mac = $archive->mac;
            $model->provider = $archive->provider;
            $model->description = $archive->description;
            $model->created = $archive->created;
            $model->modified = new CDbExpression('NOW()');
            if(!$model->save()) {
                throw new CHttpException(500,'Ошибка при добавлении пользователя');
            } else {
                if(!archive::model()->deleteByPk($archive->id)) {
                    throw new CHttpException(500,'Ошибка при удалении пользователя из архива');
                }
            }
            
            $status = exec('php ' . Yii::app()->basePath . '/../console.php buildconfig');
            Yii::app()->user->setFlash('dhcp', $status);

            if(!isset($_GET['ajax']))
                $this->redirect(array('index'));
        }
        else
            throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
    }

    public function actionUpdate() {
        $model = $this->loadModel();

        $this->performAjaxValidation($model);

        if(isset($_POST['neters'])) {
            $model->modified = new CDbExpression('NOW()');
            $model->attributes=$_POST['neters'];
            if($model->validate() && $model->save()) {
                $status = exec('php ' . Yii::app()->basePath . '/../console.php buildconfig');
                Yii::app()->user->setFlash('dhcp', $status);
                $this->redirect(array('view','id'=>$model->id));
            } else {
                $this->render('update',array(
                    'model'=>$model,
                ));
            }
        } else {
            $this->render('update',array(
                'model'=>$model,
            ));
        }
    }

    public function actionDelete() {
        if(Yii::app()->request->isPostRequest) {
            $this->loadModel()->delete();
            $status = exec('php ' . Yii::app()->basePath . '/../console.php buildconfig');
            Yii::app()->user->setFlash('dhcp', $status);

            if(!isset($_GET['ajax']))
                $this->redirect(array('index'));
        }
        else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }

    public function actionIndex() {
        $this->redirect(array('admin'));
    }

    public function actionAdmin() {
        $model = new neters('search');
        $model->unsetAttributes();
        if(isset($_GET['neters']))
            $model->attributes=$_GET['neters'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    public function loadModel() {
        if($this->_model === null) {
            if(isset($_GET['id']))
                $this->_model = neters::model()->findbyPk($_GET['id']);
            if($this->_model === null)
                throw new CHttpException(404, 'The requested page does not exist.');
        }
        return $this->_model;
    }

    protected function performAjaxValidation($model) {
        if(isset($_POST['ajax']) && $_POST['ajax'] === 'neters-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
}
