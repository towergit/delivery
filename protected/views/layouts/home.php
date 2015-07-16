<!DOCTYPE html>
<html lang="<?php echo Yii::app()->language; ?>">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="interkassa-verification" content="103662f0c41b1905f906ab55f7f526d6" />
        <meta name="w1-verification" content="199446823013" />
        <meta property="og:image" content="https://blago-vest.org/ftp/logo.jpg" />
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

        $this->beginContent('//layouts/blocks/header');
        $this->endContent();
        ?>

        <div class="container-fluid block-2">
            <div class="container">
                <div class="row">
                    <div class="col-md-8 col-sm-10">
                        <p><?php echo Yii::t('main', 'Когда мы дарим радость и принимаем ее с благодарностью - мы получаем все'); ?></p>
                    </div>
                    <div class="col-md-12 col-sm-12">
                        <a class="detailed" href="/about-fund"><?php echo Yii::t('main', 'Детальнее'); ?></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="container block-3">
            <div class="row">
                <h2><?php echo Yii::t('main', 'Ваша даже небольшая помощь служит поддержкой для многих людей!'); ?></h2>
                <?php $this->widget('application.modules.object.widgets.ElectObjectsWidget'); ?>
            </div>
        </div>

        <div class="container-fluid block-4">
            <div class="container">
                <div class="row">
                    <h1>
                        <span class="patron-block4"><?php echo Yii::t('main', 'Мы рады Вам'); ?>!</span>
                    </h1>
                    <div id="owl-demo-coment" >
                        <div class="item">
                            <div class="col-md-5 col-md-offset-7">
                                <p>Счастье &mdash; это любовь к полезному, выраженная в действии. (Гусенгаджиев Мухтар)</p>
                            </div>
                        </div>

                        <div class="item">
                            <div class="col-md-5 col-md-offset-7">
                                <p>
                                    Радость - разменная монета счастья. (Шопенгауэр)</p>                            </div>
                        </div>
                        <div class="item">
                            <div class="col-md-5 col-md-offset-7">
                                <p>
                                    Благие намерения &ndash; это чеки, которые люди выписывают на банк, где у них нет текущего счета. (Оскар Уайльд)</p>

                            </div>
                        </div>
                        <div class="item">
                            <div class="col-md-5 col-md-offset-7">
                                <p>
                                    Благодарность &mdash; признак благородства души. (Эзоп)</p>
                            </div>
                        </div>
                        <div class="item">
                            <div class="col-md-5 col-md-offset-7">
                                <p><br />
                                    Жизнь может быть полная или скудная, но это зависит не от того, что мы от неё получим, а от того, что мы в неё вложим. (Люси Монтгомери)</p>

                            </div>
                        </div>

                        <div class="item">
                            <div class="col-md-5 col-md-offset-7">

                                <p><br />
                                    &mdash; Где ты?<br />
                                    &mdash; Здесь.<br />
                                    &mdash; Какое время?<br />
                                    &mdash; Сейчас.<br />
                                    &mdash; Кто ты?<br />
                                    &mdash; Этот момент.<br />
                                    (Мирный воин)</p>
                            </div>
                        </div>

                        <div class="item">
                            <div class="col-md-5 col-md-offset-7">
                                <p><br />
                                    Можно очень хорошо узнать людей, наблюдая, на что они тратят деньги. (Касл)</p>
                            </div>
                        </div>

                        <div class="item">
                            <div class="col-md-5 col-md-offset-7">
                                <p><br />
                                    Цена &mdash; это то, что вы платите. Ценность &mdash; это то, что вы получаете. (Уоррен Баффет)</p>

                            </div>
                        </div>

                        <div class="item">
                            <div class="col-md-5 col-md-offset-7">
                                <p><br />
                                    Бизнес, полностью посвященный служению людям, будет иметь только одну проблему с доходами. Они будут крайне высокими. (Генри Форд)</p>

                            </div>
                        </div>


                        <div class="item">
                            <div class="col-md-5 col-md-offset-7">
                                <p><br />
                                    День, в который вы решились что-то сделать, - счастливый день (Японская пословица)</p>
                            </div>
                        </div>



                        <div class="item">
                            <div class="col-md-5 col-md-offset-7">
                                <p><br />
                                    Отдайте десятую часть вашего дохода - и готовьтесь к новым денежным поступлениям. (Луиза Хей)</p>

                            </div>
                        </div>

                        <div class="item">
                            <div class="col-md-5 col-md-offset-7">
                                <p><br />
                                    Есть только один успех &mdash; потратить свою жизнь так, как ты хочешь. (Сомерсет Моэм)</p>
                            </div>
                        </div>
                        <div class="item">
                            <div class="col-md-5 col-md-offset-7">
                                <p><br />
                                    Если вы хотите сделать что-то великое в один прекрасный день, помните: один прекрасный день &mdash; это сегодня. (Джордж Лукас)</p>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <div class="container-fluid block-5">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <h1><?php echo Yii::t('main', 'Наши партнеры'); ?></h1>
                        <div id="owl-demo-patron" >
                            <div class="item">
                                <a target="_blank" href="http://otvetvgenah.ru"><img src="<?php echo $this->assetsBase; ?>/images/patron/genetic.jpg" alt="" /></a>
                            </div>
                            <div class="item">
                                <a target="_blank" href="https://luxe-change.ru"><img src="<?php echo $this->assetsBase; ?>/images/patron/luxe.jpg" alt="" /></a>
                            </div>
                            <div class="item">
                                <a target="_blank" href="https://ingogame.com"><img src="<?php echo $this->assetsBase; ?>/images/patron/investgame.jpg" alt="" /></a>
                            </div>
                            <div class="item">
                                <a target="_blank" href="https://1uom.com"><img src="<?php echo $this->assetsBase; ?>/images/patron/uom.jpg" alt="" /></a>
                            </div>
                            <div class="item">
                                <a target="_blank" href="https://global-ep.com/"><img src="<?php echo $this->assetsBase; ?>/images/patron/global_education_platform.jpg" alt="" /></a>
                            </div>
                            <div class="item">
                                <a target="_blank" href="https://tower-invest.net"><img src="<?php echo $this->assetsBase; ?>/images/patron/tower_investment_fund.jpg" alt="" /></a>
                            </div>
                            <div class="item">
                                <a target="_blank" href="https://royalinvestmentclub.com"><img src="<?php echo $this->assetsBase; ?>/images/patron/royal_investment_club.jpg" alt="" /></a>
                            </div>
                            <div class="item">
                                <a target="_blank" href="http://crystal-it.biz"><img src="<?php echo $this->assetsBase; ?>/images/patron/crystal-it.jpg" alt="" /></a>
                            </div>
                        </div>       
                    </div>
                </div>
            </div>
        </div>

        <div class="container block-6">
            <div class="row"> 
                <h1><?php echo Yii::t('main', 'Проверьте последние новости и события в блоге'); ?></h1>
                <div class="col-md-7 col-sm-7">
                    <?php
                    $this->widget('application.modules.material.widgets.LastMaterialWidget', array(
                        'category' => 'blog',
                    ));
                    ?> 

                </div>
                <div class="col-md-5 col-sm-5">
                    <div class="our">
                        <h2><?php echo Yii::t('main', 'Будьте<br />с нами'); ?></h2>
                        <h3><?php echo Yii::t('main', 'Делайте мир счастливее вместе с «Благовест»!'); ?></h3>
                        <div class="col-md-12 col-sm-12 join">
                            <a href="<?php echo $this->createUrl('/default/team'); ?>">
                                <?php echo Yii::t('main', 'Присоединяйтесь'); ?>
                            </a>
                        </div>
                        <p><?php echo Yii::t('main', 'Мы знаем, что путь к настоящему успеху лежит не через удачную карьеру и достаток, а через душевное благополучие и гармонию с миром. Хорошая работа, счастливая семья и деньги – это само собой разумеющиеся следствия этой гармонии. Вы можете сделать что-то по-настоящему важное прямо сейчас.'); ?></p>   
                    </div>
                </div>
            </div>
        </div>

        <div class="container-fluid block-7">
            <div class="container">
                <div class="row">
                    <h1><?php echo Yii::t('main', 'Отзывы меценатов'); ?></h1>
                    <?php $this->widget('ReviewsWidget'); ?>
                </div>
            </div>
        </div>

        <?php
        $this->beginContent('//layouts/blocks/footer');
        $this->endContent();

        Yii::app()->clientScript->registerScript(uniqid(), "
                $(document).ready(function() {
                    $('#owl-demo').owlCarousel({
                        autoPlay: 5000,
                        items: 3,
                        itemsDesktop: [1199, 3],
                        itemsDesktopSmall: [979, 3],
                        rewindSpeed: 4000
                    });
                    
                    $('#owl-demo-patron').owlCarousel({
                        autoPlay: 4000,
                        items: 5,
                        itemsDesktop: [1199, 3],
                        itemsDesktopSmall: [979, 3],
                        pagination: false,
                        rewindSpeed: 4000
                    });
					$('#owl-demo-coment').owlCarousel({
                        autoPlay: 6000,
                        slideSpeed: 300,
                        paginationSpeed: 400,
                        singleItem: true,
						pagination: false
                    });
                    $('#owl-demo-news').owlCarousel({
                        autoPlay: 6000,
                        slideSpeed: 300,
                        paginationSpeed: 400,
                        singleItem: true,
                    });
                });
            
                var h = $(window).height();

                $(window).scroll(function() {
                    if (($(this).scrollTop() + h) >= $('.block-3 .owl-carousel').offset().top) {
                        $('.block-3 .owl-carousel').css({visibility: 'visible'});
                        $('.block-3 .owl-carousel').addClass('animated zoomIn');
                    }

                    if ($(this).scrollTop() == 0) {
                        if ($(this).hasClass('block-3 .owl-carousel')) {
                            $(this).removeClass().addClass('post');
                        }
                        $(this).css({visibility: 'hidden'});
                    }
                });
            ", CClientScript::POS_END);
        ?>

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

        <!-- Yandex.Metrika counter -->
        <script type="text/javascript">
            (function (d, w, c) {
                (w[c] = w[c] || []).push(function () {
                    try {
                        w.yaCounter31359873 = new Ya.Metrika({
                            id: 31359873,
                            clickmap: true,
                            trackLinks: true,
                            accurateTrackBounce: true,
                            webvisor: true
                        });
                    } catch (e) {
                    }
                });

                var n = d.getElementsByTagName("script")[0],
                        s = d.createElement("script"),
                        f = function () {
                            n.parentNode.insertBefore(s, n);
                        };
                s.type = "text/javascript";
                s.async = true;
                s.src = "https://mc.yandex.ru/metrika/watch.js";

                if (w.opera == "[object Opera]") {
                    d.addEventListener("DOMContentLoaded", f, false);
                } else {
                    f();
                } 
            })(document, window, "yandex_metrika_callbacks");
        </script>
        <noscript><div><img src="https://mc.yandex.ru/watch/31359873" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
        <!-- /Yandex.Metrika counter -->
    </body>
</html>
