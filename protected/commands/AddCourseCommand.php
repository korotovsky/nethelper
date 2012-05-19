<?php

class AddCourseCommand extends CConsoleCommand {
    public $dns;
    public $address;
    public $gateway;
    public $ip;
    public $mac;
    public $count;

    public function run($args) {
        $lines = file('/var/www/nethelper/protected/data/1st-course.txt');
        if(!$lines) {
            throw new CHttpException(500,'file 1st-course is empty.');
        }

        foreach($lines as $line) {
            $model = new archive;

            $model->fio = $line;
            $model->provider = 'disconnected';

            $model->description = '1й Курс 2011 год, добавлен автоматически.';
            $model->ilogin = '';
            $model->room = '';
            $model->ip = '';
            $model->mac = '00-00-00-00-00-00';

            $model->created = new CDbExpression('NOW()');
            $model->modified = new CDbExpression('NOW()');

            if(!$model->save()) {
                throw new CHttpException(500,'Error while add neter to archive.');
            } 
        }
    }

}

?>
