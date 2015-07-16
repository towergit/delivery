<?php
// название страницы
$this->pageTitle = Yii::t('main', Yii::t('main', 'FAQ'));

// слоган
$this->slogan = Yii::t('main', Yii::t('main', 'Ответы на часто задаваемые вопросы'));

// хлебные крошки
$this->breadcrumbs = array(
    Yii::t('main', 'Ответы на часто задаваемые вопросы'),
);
?>

<?php if ($models !== null): ?>
    <div class="container faq">
        <h1><?php echo Yii::t('main', 'Пожалуйста, убедитесь, что Вы ознакомились с FAQ'); ?></h1>

        <?php foreach($models as $category): ?>
            <h3><?php echo $category->title; ?></h3>

            <div class="row">
                <?php foreach($category->faqs as $faq): ?>
                    <div class="col-md-12">
                        <div class="issue issue-over">
                            <h4 class="pull-left"><?php echo $faq->question; ?></h4>
                            <div class="button-plus pull-right">
                                <i class="fa fa-plus"></i>
                            </div>
                            <div class="clear"></div>
                            <div class="issue-text">
                                <?php echo $faq->answer; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endforeach; ?>
    </div>
    <div class="container-fluid answer">
        <div class="container">
            <div class="row">
                <h1><?php echo Yii::t('main', 'У вас еще есть вопросы?'); ?> <b><?php echo Yii::t('main', 'Спросите нас'); ?></b></h1>
                <p><?php echo Yii::t('main', 'Если выше Вы не нашли ответ на свой вопрос - задайте<br />его нам. Мы Вам ответим.'); ?></p>
                <div class="ask">
                    <a href="<?php echo $this->createUrl('/default/contacts'); ?>">
                        <?php echo Yii::t('main', 'Задать вопрос'); ?>
                    </a>
                </div>	
            </div>
        </div>
    </div>

    <?php
    Yii::app()->clientScript->registerScript(uniqid(),
        "
            $(document).ready(function() {
                $('.button-plus').click(function() {
                    var parentTag = $(this).parent();
                    parentTag.toggleClass('issue-over', 900); 

                    if (parentTag.hasClass('issue-over'))
                        $(this).find('i.fa').removeClass('fa-plus').addClass('fa-minus');
                    else
                        $(this).find('i.fa').removeClass('fa-minus').addClass('fa-plus');
                });
            });
        ", CClientScript::POS_END);
    ?>
<?php endif; ?>