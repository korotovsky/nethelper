<?php
$this->pageTitle=Yii::app()->name . ' - Авторизация';
?>

    <div class="row show-grid" style="margin-top: 20px; margin-left: 0px">
        <div class="span10 columns">
            <h1>Вход</h1>

            <div class="form">
            <?php $form=$this->beginWidget('CActiveForm', array(
                'id' => 'login-form',
                'enableAjaxValidation' => true,
            )); ?>

                <div class="row well<?php if($model->getError('username') != '') echo ' error' ?>">
                    <?php echo $form->textField($model, 'username'); ?>
                    <span class="help-inline">
                        <?php echo $form->error($model, 'username'); ?>
                    </span>
                </div>

                <div class="row well<?php if($model->getError('password') != '') echo ' error' ?>">
                    <?php echo $form->passwordField($model, 'password'); ?>
                    <span class="help-inline">
                        <?php echo $form->error($model, 'password'); ?>
                    </span>
                </div>

                <div class="row well">
                    <button type="submit" class="btn primary">Авторизоваться</button>
                </div>
            <?php $this->endWidget(); ?>
            </div><!-- form -->
        </div>
    </div>


</div>
