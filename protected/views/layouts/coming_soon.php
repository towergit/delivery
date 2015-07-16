<!DOCTYPE html>
<html lang="<?php echo Yii::app()->language; ?>">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?php echo CHtml::encode($this->pageTitle); ?></title>
        <link rel="icon" href="<?php echo $this->assetsBase; ?>/images/favicon.ico" type="image/x-icon">

        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
            <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <body>
        <?php
        $this->beginContent('//layouts/blocks/alert'); 
        $this->endContent();
        ?>
        <div class="container-fluid cap">
            <div class="container">
                <div class="row">
                    <div class="col-md-7">
                        <a href="<?php echo Yii::app()->homeUrl; ?>">
                            <img src="<?php echo $this->assetsBase; ?>/images/logo_cap.png" alt="" />
                        </a>
                        <h1><?php echo Yii::t('main', 'Что-то грандиозное скоро произойдет'); ?></h1>
                        <h3><?php echo Yii::t('main', 'Следите за стартом проекта. Оставьте нам свой адрес электронной почты для уведомлений'); ?></h3>
                        <div class="countdown countdown-container ">
                            <div class="clock row">
                                <div class="clock-item clock-days countdown-time-value col-xs-3 " style="">
                                    <div class="wrap">
                                        <div class="inner">
                                            <div  class="clock-canvas" style="background: #ebc642">
                                                <canvas id="canvas-days" width="132" height="159" ></canvas>
                                            </div>
                                            <div class="text">
                                                <p class="val days">0</p>
                                                <p class="type-days type-time"><?php echo Yii::t('main', 'Дней'); ?></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="clock-item clock-hours countdown-time-value col-xs-3 ">
                                    <div class="wrap">
                                        <div class="inner">
                                            <div  class="clock-canvas" style="background: #dcba3e">
                                                <canvas id="canvas-hours" width="132" height="159"></canvas>
                                            </div>
                                            <div class="text">
                                                <p class="val hours">0</p>
                                                <p class="type-hours type-time"><?php echo Yii::t('main', 'Часов'); ?></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="clock-item clock-minutes countdown-time-value col-xs-3 ">
                                    <div class="wrap">
                                        <div class="inner">
                                            <div  class="clock-canvas" style="background: #c9b13d">
                                                <canvas id="canvas-minutes" width="132" height="159"></canvas>
                                            </div>
                                            <div class="text">
                                                <p class="val minutes">0</p>
                                                <p class="type-minutes type-time"><?php echo Yii::t('main', 'Минут'); ?></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div>
                            <?php echo $content; ?>
                        </div>	
                        <p class="copyright"><?php echo Yii::t('main', '© Copyright :year. Все права защищены. Разработано в Crystal-IT.', array( ':year' => date('Y') )); ?></p>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>