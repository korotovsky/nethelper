<?php

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
    $('.search-form').toggle();
    return false;
});
$('#archive-grid a.restore').live('click',function() {
    if(!confirm('Вы уверены, что хотите восстановить из архива?')) return false;
    $.fn.yiiGridView.update('archive-grid', {
        type:'POST',
        url:$(this).attr('href'),
        success:function() {
            $.fn.yiiGridView.update('archive-grid');
        }
    });
    return false;
});
");
?>

    <div class="row show-grid" style="margin-top: 20px">
        <h1>Управление пользователями (архив)</h1>

        <a href="<?php echo Yii::app()->createUrl('archive/create') ?>" class="btn primary">Новый пользователь</a>
        <?php $this->widget('zii.widgets.grid.CGridView', array(
            'id' => 'archive-grid',
            'dataProvider' => $model->search(),
            'filter' => $model,
            'beforeAjaxUpdate' => 'js:function(id) { 
                $(".overlay-main").removeClass("overlay-hide").hide().fadeIn("fast");
            }',
            'afterAjaxUpdate' => 'js:function(id, data) {
                $(".overlay-main").fadeOut("fast", function() { $(this).addClass("overlay-hide") });
            }',
            'template' => '
                <div class="show-grid">
                    {pager}
                </div>
                <div class="show-grid left">
                    {summary}
                </div>
                <div class="changelist-results">
                    {items}
                </div>
                <div class="show-grid">
                    {summary} {pager}
                </div> 
            ',
            'cssFile' => false,
            'pagerCssClass' => 'pagination',
            'pager' => array(
                'class' => 'LinkPager',
                'cssFile' => false,
                'header' => '',
            ),
            'htmlOptions' => array('class' => 'zebra-striped'),
            'columns' => array(
                /* 'id', */
                array(
                    'type' => 'html',
                    'name' => 'fio',
                    'value' => 'CHtml::link("$data->fio", Yii::app()->createUrl("archive/view", array("id" => $data->id)))',
                ),
                'ilogin',
                'room',
                'ip',
                'mac',
                array(
                    'name' => 'provider',
                    'value' => '$data->provider',
                    'filter' => array(
                        'e-telecom' => 'E-Telecom', 
                        'well-telecom' => 'Well-Telecom', 
                        'well-telecom-3' => 'Well-Telecom 3 ка', 
                        'disconnected' => 'Отключен', 
                        'none' => 'Нет интернета',
                    ),
                ),
                /* 'description', */
                'created',
                'modified',
                array(
                    'class' => 'CButtonColumn',
                    'header' => 'Действия',
                    'template'=>'{view} {update} {delete} {restore}',
                    'buttons' => array(
                        'restore' => array(
                            'label' => 'Восстановить',
                            'options' => array('class' => 'restore'),
                            'url' => 'Yii::app()->createUrl("neters/restore", array("id" => $data->id))',
                            'imageUrl' => Yii::app()->baseUrl . '/images/restore.png',
                        ),
                    ),
                ),
            ),
        )); ?>
        <!--</div>-->
    </div>
