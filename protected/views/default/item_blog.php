<?php
// название страницы
$this->pageTitle = $model->category->title;

// хлебные крошки
$this->breadcrumbs = array(
    Yii::t('main', 'Блог') => $this->createUrl('/default/blog'),
    $model->category->title => $this->createUrl('/default/blog_category', array('alias' => $model->category->alias)),
    $model->title,
);
?>

<div class="container about-fund">
    <div class="row">

        <div class="col-md-12">
            <div class="content-news">
                <h1><?php echo $model->title; ?></h1>
                <h5>
                    <?php echo Yii::t('main', 'Категория'); ?>: 
                    <a href="<?php echo $this->createUrl('/default/blog_category', array('alias' => $model->category->alias)); ?>">
                        <?php echo $model->category->title; ?>
                    </a> / 
                    <a class="anchor-coments" href="#comments"><?php echo $model->countComments(); ?> <?php echo Yii::t('main', 'комментарий|комментария|комментариев', array($model->countComments())); ?></a>
                </h5>
                <?php echo $model->text; ?>


                <script type="text/javascript">(function () {
                        if (window.pluso)
                            if (typeof window.pluso.start == "function")
                                return;
                        if (window.ifpluso == undefined) {
                            window.ifpluso = 1;
                            var d = document, s = d.createElement('script'), g = 'getElementsByTagName';
                            s.type = 'text/javascript';
                            s.charset = 'UTF-8';
                            s.async = true;
                            s.src = ('https:' == window.location.protocol ? 'https' : 'http') + '://share.pluso.ru/pluso-like.js';
                            var h = d[g]('body')[0];
                            h.appendChild(s);
                        }
                    })();</script>
                <div class="pluso" data-background="transparent" data-options="medium,square,line,horizontal,counter,theme=04" data-services="vkontakte,odnoklassniki,facebook,twitter,google"></div>


                <div class="line-news"></div>
                <div class="new-coments" id="comments">
                    <h2><?php echo Yii::t('main', 'Комментарии'); ?></h2>
                <?php
                $this->widget('application.modules.comment.widgets.CommentListWidget', array(
                    'ownerName' => 'material',
                    'ownerId' => $model->id,
                ));
                ?>
                </div>
                <div class="line-news"></div>
                <h2><?php echo Yii::t('main', 'Оставить комментарий'); ?></h2>
<?php
$this->widget('application.modules.comment.widgets.CommentFormWidget', array(
    'ownerName' => 'material',
    'ownerId' => $model->id,
    'redirectTo' => $this->createUrl('/default/item_blog', array('alias' => $model->alias)),
));
?>
            </div>
        </div>


    </div>
</div>