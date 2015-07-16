<!DOCTYPE html>
<html lang="<?php echo Yii::app()->language; ?>">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="interkassa-verification" content="103662f0c41b1905f906ab55f7f526d6" />
        <meta property="og:image" content="https://blago-vest.org/ftp/logo.jpg" />
        <title><?php echo CHtml::encode($this->pageTitle); ?></title>
        <link href="https://code.jquery.com/ui/1.9.2/themes/smoothness/jquery-ui.css" rel="stylesheet" type="text/css" />
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

        $this->beginContent('//layouts/blocks/header');
        $this->endContent();
        ?>

        <div class="container-fluid block-b2">
            <div class="container">
                <div class="row">

                        <div class="col-md-12">

                            <h1><?php echo $this->slogan ? $this->slogan : $this->pageTitle; ?></h1>
                            <?php /*if (isset($this->breadcrumbs)): ?>
                                <?php
                                $this->widget('zii.widgets.CBreadcrumbs', array(
                                    'separator' => ' &nbsp;/&nbsp; ',
                                    'links' => $this->breadcrumbs,
                                ));
                                ?>

                            <?php endif; */ ?>

                        </div>

                </div>
            </div>
        </div>

        <?php
        echo $content;

        $this->beginContent('//layouts/blocks/footer');
        $this->endContent();
        ?>
        <!-- Yandex.Metrika counter -->
            <script type="text/javascript">
                (function (d, w, c) {
                    (w[c] = w[c] || []).push(function() {
                        try {
                            w.yaCounter31359873 = new Ya.Metrika({
                                id:31359873,
                                clickmap:true,
                                trackLinks:true,
                                accurateTrackBounce:true,
                                webvisor:true
                            });
                        } catch(e) { }
                    });

                    var n = d.getElementsByTagName("script")[0],
                        s = d.createElement("script"),
                        f = function () { n.parentNode.insertBefore(s, n); };
                    s.type = "text/javascript";
                    s.async = true;
                    s.src = "https://mc.yandex.ru/metrika/watch.js";

                    if (w.opera == "[object Opera]") {
                        d.addEventListener("DOMContentLoaded", f, false);
                    } else { f(); }
                })(document, window, "yandex_metrika_callbacks");
            </script>
            <noscript><div><img src="https://mc.yandex.ru/watch/31359873" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
        <!-- /Yandex.Metrika counter -->
        
        <div class="modal fade" id="colected" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Уведомление</h4>
            </div>
            <div class="modal-body">
                
                <div style="text-align: center;" class="baner_code" id="">
                    <h3>По данном объекту собрана вся сумма помощи!</h3>
                    <p>Вы можете пожертвовать на другие объекты помощи.<br></p>
                    
                    <div class="detailed" style="margin-left: 100px; margin: 20px auto 0;">
                        <a href="/projects" class=""> Выбрать объект</a>
                    </div>
                </div>
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
            </div>
        </div>
    </div>
</div>
        
    </body>
</html>