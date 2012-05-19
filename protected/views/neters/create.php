<?php

Yii::app()->clientScript->registerScript('check', "
$('.manual-address').click(function(){
    var input = '<input style=\"width: 320px !important\" placeholder=\"IP-адрес\" name=\"neters[ip]\" id=\"neters_ip\" type=\"text\" maxlength=\"255\" /> <input type=\"hidden\" name=\"neters[manual]\" value=\"1\" />';
    var block = $('#neters_ip').parent('div');
    var select = $('#neters_ip').remove();
    $(input).prependTo(block);
    $(this).addClass('disabled');

    return false;
});
");
?>

    <div class="row show-grid" style="margin-top: 20px; margin-left: 0px">
        <h1>Создать пользователя</h1>
        <div class="span12 columns">
            <?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
        </div>
    </div>
