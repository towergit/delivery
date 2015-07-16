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
    <body class="error">
        <div class="container-fluid text-center">
            <div class="block">
                <?php echo $content; ?>
            </div>
        </div>
        <div class="footer text-center">
            <div class="block">
                <div class="copyright">
                    <?php echo Yii::t('template', 'Все права защищены'); ?> © <?php echo date('Y'); ?> <strong>Blago-vest.org</strong>.
                </div>
            </div>
        </div>
    </body>
</html>