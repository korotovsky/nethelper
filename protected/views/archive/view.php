    <div class="row show-grid" style="margin-top: 20px; margin-left: 0px">
        <h1>Информация о пользователе <?php echo $model->fio; ?> (архив)</h1>

        <a href="<?php echo Yii::app()->createUrl('archive/update', array('id' => $model->id)) ?>" class="btn primary">Редактировать пользователя</a> 
        <?php echo CHtml::ajaxLink(
            "Перенести в пользователи", 
            Yii::app()->createUrl('/archive/restore', 
                array('id' => $model->id)
            ),
            array('type' => 'POST', 'success' => 'js:$(location).attr("href", "' . Yii::app()->createUrl('/neters/admin') . '")'),
            array('confirm' => 'Вы уверены, что хотите восстановить из архива?', 'class' => 'btn danger')); 
        ?>

        <?php $this->widget('zii.widgets.CDetailView', array(
            'data' => $model,
            'cssFile' => false,
            'htmlOptions' => array('class' => 'zebra-striped', 'style' => 'padding-top: 15px'),
            'attributes' => array(
                'id',
                'fio',
                'ilogin',
                'room',
                'ip',
                'mac',
                'provider',
                'description',
                'created',
                'modified',
            ),
        )); ?>
    </div>
