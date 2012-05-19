    <div class="row show-grid" style="margin-top: 20px; margin-left: 0px">
        <h1>Обновить пользователя <?php echo $model->fio; ?>  (архив)</h1>
        <div class="span12 columns">
            <?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
        </div>
    </div>
