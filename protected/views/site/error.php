<?php
$this->pageTitle=Yii::app()->name . ' - Ошибка';
?>

    <div class="row show-grid" style="margin-top: 40px">
        <div class="span16 columns well">
            <h2>Ошибка <?php echo $code; ?></h2>
            <?php echo CHtml::encode($message); ?>
        </div>
    </div>

