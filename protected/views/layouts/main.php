<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="language" content="en" />

    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/bootstrap-1.1.1.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css" />
    <?php Yii::app()->clientScript->registerCoreScript('jquery') ?>
    <title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>

    <div class="topbar">
       <div class="fill">
           <div class="container">
            <h3><a href="#"><?php echo CHtml::encode(Yii::app()->name); ?></a></h3>
            <?php if(!Yii::app()->user->isGuest) { ?>
                <?php $this->widget('zii.widgets.CMenu',array(
                    'items' => array(
                        array('label'=>'Главная', 'url'=>array('/site/index')),
                        array('label'=>'Пользователи', 'url'=>array('/neters/admin')),
                        array('label'=>'Архив', 'url'=>array('/archive/admin')),
                        array('label'=>'Перезагрузить DHCP', 'url' => array('#'), 'linkOptions' => array('class' => 'dhcp-btn')),
                    ),
                )); ?>
            <?php } else { ?>
                <?php $this->widget('zii.widgets.CMenu',array(
                    'items' => array(
                        array('label'=>'Главная', 'url'=>array('/site/index')),
                    ),
                )); ?>
            <?php } ?>
                <ul class="nav secondary-nav">
                <li class="menu">
                  <?php if(!Yii::app()->user->isGuest) { ?>
                  <a href="#" class="menu">Аккаунт</a>
                  <ul class="menu-dropdown">
                    <li><a href="#">Настройки</a></li>
                    <li class="divider"></li>
                    <li><a href="<?php echo Yii::app()->createUrl('/site/logout') ?>">Выход</a></li>
                  </ul>
                  <?php } else { ?>
                    <li class="active">
                        <a href="<?php echo Yii::app()->createUrl('/site/login') ?>">Авторизация</a>
                    </li>
                  <?php } ?>
                </li>
              </ul>
        </div>
        </div>
    </div>

    <div class="overlay-main overlay-hide">
        <div class="overlay">
        </div>
        <div class="ov-loading well">
            <span style="margin-right: 15px">Обработка&nbsp;</span>
            <img align="absmiddle" src="<?php echo Yii::app()->request->baseUrl; ?>/images/loader.gif" alt="Обработка..." />
        </div>
    </div>

    <div class="container" style="padding-top: 40px">
        <div class="modal" style="display: none; position: fixed; top: auto; left: auto; margin-top: 20%; margin-left: 200px; z-index: 100">
            <div class="modal-header">
                <h3>Подтверждение перезагрузки DHCP</h3>
                <a href="#" class="close dialog-close">×</a>
            </div>
            <div class="modal-body">
                <p>Блядь, ты точно уверен?</p>
            </div>
            <div class="modal-footer">
                <a href="#" class="btn primary dhcp">Перезагрузить</a>
                <a href="#" class="btn secondary dialog-close">Нет епта!</a>
            </div>
        </div>

        <?php if(Yii::app()->user->hasFlash('dhcp')) { ?>
        <div class="alert-message warning" style="margin: 5px">
            <a class="close" href="#">×</a>
            <p><strong>DHCP: </strong> <?php echo Yii::app()->user->getFlash('dhcp'); ?></p>
        </div>
        <?php } ?>

        <?php echo $content; ?>

    </div><!-- page -->

      <footer>
        <div class="inner">
            <div class="container">
                <p class="right"><a href="#">Наверх</a></p>
                <p><?php echo Yii::powered(); ?></p>
            </div>
        </div>
      </footer>

    <script type="text/javascript">
    /*<![CDATA[*/
    $(function($) {
        $('a.dhcp').live('click',function() {
            $.ajax({ 
                url: '<?php echo Yii::app()->createUrl("system/dhcp") ?>',
                type: 'POST',
                dataType: 'html',
                context: document.body, 
                beforeSend: function() { 
                    $(".dialog-close").parent("div").parent("div").fadeOut("fast", function() { $(this).hide(); } );
                    $(".overlay-main").removeClass("overlay-hide").hide().fadeIn("fast") },
                success: function(data) {
                    $(".overlay-main").fadeOut("fast", function() { $(this).addClass("overlay-hide") });
                    $(location).attr("href", "<?php echo Yii::app()->createUrl(""); ?>");
                }
            });
            return false;
        });
        $("body").live("click", function (e) {
            $('a.menu').parent("li").removeClass("open");
        });
        $("a.menu").live("click", function (e) {
            $(this).parent("li").toggleClass('open');
            return false;
        });
        $("a.close").live("click", function (e) {
            $(this).parent("div").slideUp("fast", function() { $(this).hide(); } );
            return false;
        });
        $("a.dialog-close").live("click", function (e) {
            $(this).parent("div").parent("div").fadeOut("fast", function() { $(this).hide(); } );
            return false;
        });
        $("a.dhcp-btn").live("click", function (e) {
            $(".modal-header").show();
            $(".modal").fadeIn("fast", function() {
                $(this).show();
            });
            return false;
        });
    });
    /*]]>*/
    </script>
</body>
</html>
