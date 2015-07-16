<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?php echo CHtml::encode($this->pageTitle); ?></title>

        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
            <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <body>
        <div class="login-wrapper">
            <div class="bg-pic">
                <img src="<?php echo $this->getAssetsBase(); ?>/images/wallpaper.jpg" alt="" />
                <div class="bg-caption">
                    <h2>
                        Blago-vest.org
                    </h2>
                    <p>
                        &nbsp;
                    </p>
                </div>
            </div>
            <div class="login-container">
                <div>
                    <img src="<?php echo $this->getAssetsBase(); ?>/images/logo.png" alt="" width="120" />
                    <p><?php echo Yii::t('template', 'Вход в свой аккаунт'); ?></p>

                    <?php echo $content; ?>

                    <div class="footer">
                        <div class="row">
                            <div class="col-sm-12">
                                <p>
                                    <small>
                                        <?php echo Yii::t('template', 'Все права защищены'); ?> © <?php echo date('Y'); ?> <strong>Blago-vest.org</strong>.
                                    </small>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>