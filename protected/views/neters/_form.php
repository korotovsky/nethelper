<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
    'id'=>'neters-form',
    'enableAjaxValidation' => true,
)); ?>

    <div class="row well<?php if($model->getError('fio') != '') echo ' error' ?>">
        <?php echo $form->textField($model, 'fio', array('style' => 'width: 320px !important', 'placeholder' => 'Фамилия')); ?>
        <span class="help-inline">
            <?php echo $form->error($model, 'fio'); ?>
        </span>
    </div>

    <div class="row well<?php if($model->getError('ilogin') != '') echo ' error' ?>">
        <?php echo $form->textField($model, 'ilogin', array('style' => 'width: 320px !important', 'placeholder' => 'Логин')); ?>
        <span class="help-inline">
            <?php echo $form->error($model, 'ilogin'); ?>
        </span>
    </div>

    <div class="row well<?php if($model->getError('room') != '') echo ' error' ?>">
        <?php echo $form->textField($model, 'room', array('style' => 'width: 320px !important', 'placeholder' => 'Комната')); ?>
        <span class="help-inline">
            <?php echo $form->error($model, 'room'); ?>
        </span>
    </div>

    <div class="row well<?php if($model->getError('ip') != '') echo ' error' ?>">
        <?php if($model->isNewRecord and !$model->manual == "1") { ?>
            <?php 
                foreach(neters::findAddress() as $item) {
                    $address["$item"] = $item;
                }
            ?>
            <?php echo $form->dropDownList($model, 'ip', $address, array('style' => 'width: 320px !important')) ?>
        <?php } else { ?>
            <?php echo $form->textField($model, 'ip', array('style' => 'width: 320px !important', 'placeholder' => 'IP-адрес')); ?>
            <input type="hidden" name="neters[manual]" value="1" />
        <?php } ?>
        <span class="help-inline">
            <?php echo $form->error($model, 'ip'); ?>
        </span>
        <button type="submit" class="btn manual-address <?php $model->manual == '1' ? 'disabled' : '' ?>">Ввести руками</button>
    </div>

    <div class="row well<?php if($model->getError('mac') != '') echo ' error' ?>">
        <?php echo $form->textField($model, 'mac', array('style' => 'width: 320px !important', 'placeholder' => 'MAC-адрес')); ?>
        <span class="help-inline">
            <?php echo $form->error($model, 'mac'); ?>
        </span>
    </div>

    <div class="row well<?php if($model->getError('provider') != '') echo ' error' ?>">
        <?php echo $form->dropDownList($model, 'provider', 
            array('' => 'Выбрать провайдера...', 'e-telecom' => 'E-Telecom','well-telecom' => 'Well-Telecom', 'well-telecom-3' => 'Well-Telecom 3 ка',  'disconnected' => 'Отключен от сети', 'none' => 'Нет интернета'), array('style' => 'width: 320px !important', 'placeholder' => 'Провайдер')) ?>
        <span class="help-inline">
            <?php echo $form->error($model, 'provider'); ?>
        </span>
    </div>

    <div class="row well<?php if($model->getError('description') != '') echo ' error' ?>">
        <?php echo $form->textArea($model, 'description', array('style' => 'width: 320px !important', 'placeholder' => 'Дополнительные заметки')); ?>
        <span class="help-inline">
            <?php echo $form->error($model, 'description'); ?>
        </span>
    </div>

    <div class="row well">
        <button type="submit" class="btn primary"><?php echo $model->isNewRecord ? 'Добавить' : 'Сохранить'; ?></button>
        <a href="<?php echo Yii::app()->createUrl('neters/admin') ?>" class="btn danger">Отмена</a> 
    </div>

<?php $this->endWidget(); ?>

</div><!-- form -->
