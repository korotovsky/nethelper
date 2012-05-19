<?php $this->pageTitle=Yii::app()->name; ?>

    <div class="row show-grid" style="margin-top: 40px">
        <div class="span7 columns well right">
            <h4>Последние 5 изменений в пользователях:</h4>
            <ul class="ul-recent">
                <?php foreach($recent as $item) { ?>
                    <li><?php echo CHtml::link($item->fio, Yii::app()->createUrl('neters/view', array('id' => $item->id))) ?></li>
                <?php } ?>
            </ul>
        </div>
        <div class="span7 columns well left">
            <h4>Статистика:</h4>
            <ul class="ul-stats">
                <?php foreach($stats as $k => $v) { ?>
                    <li><b><?php echo $k ?></b>: <?php echo $v ?> пользователей.</li>
                <?php } ?>
            </ul>
        </div>
    </div>
