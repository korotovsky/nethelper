    <div class="row show-grid" style="margin-top: 20px; margin-left: 0px">
        <h1>Информация о пользователе <?php echo $model->fio; ?></h1>

        <a href="<?php echo Yii::app()->createUrl('neters/update', array('id' => $model->id)) ?>" class="btn primary">Редактировать пользователя</a>

        <?php $this->widget('zii.widgets.CDetailView', array(
            'data'=>$model,
            'attributes'=>array(
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
            'cssFile' => false,
            'htmlOptions' => array('class' => 'zebra-striped', 'style' => 'padding-top: 15px'),
        )); ?>
    </div>
