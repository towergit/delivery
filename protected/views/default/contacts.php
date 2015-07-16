<?php
// название страницы
$this->pageTitle = Yii::t('main', Yii::t('main', 'Контакты'));

// хлебные крошки
$this->breadcrumbs = array(
    Yii::t('main', 'Написать нам'),
);

$this->showHeadering = false;

?>
<div class="container contacts">
    <div class="row">
        <div class="col-md-6 col-sm-6">
            <h1><?php echo Yii::t('main', 'Связь с нами'); ?></h1>
            
            <?php
            $form = $this->beginWidget('BsActiveForm', array(
                'id'                   => 'contact',
                'enableAjaxValidation' => true,
                'clientOptions'        => array(
                    'validateOnSubmit' => true,
                ),
            ));
            ?>
                <?php 
                echo $form->textFieldControlGroup($model, 'name', array(
                    'placeholder' => ' ',
                    'groupOptions' => array(
                        'class' => 'pull-left'
                    )
                ));
                echo $form->textFieldControlGroup($model, 'email', array(
                    'placeholder' => ' ',
                    'groupOptions' => array(
                        'class' => 'pull-right'
                    )
                ));
                ?>
            
                <div class="clear"></div>
                
                <?php 
                echo $form->textFieldControlGroup($model, 'subject', array(
                    'placeholder' => ' ',
                ));
                echo $form->textAreaControlGroup($model, 'body', array(
                    'placeholder' => ' ',
                    'row' => '5',
                ));
                ?>
                
                <button type="submit" class="btn btn-default">
                    <?php echo Yii::t('main', 'Отправить'); ?>
                </button>
            <?php $this->endWidget(); ?>
            
        </div>
		<div class="col-md-1 col-sm-1"><div class="vertical-line"></div></div>
        <div class="col-md-5 col-sm-5">
            <h1><?php echo Yii::t('main', 'Наш адрес'); ?></h1>
            <address>
                <div>
                    <p class="pull-left"><?php echo Yii::t('main', 'Адрес'); ?>:</p>
                    <p>
                        <?php echo Yii::t('main', '04300, Украина, Киев'); ?><br />
                        <?php echo Yii::t('main', 'ул. Днепровская набережная 26Ж'); ?></p>
                </div>
                <div class="email-phone">
                    <p class="pull-left"><?php echo Yii::t('main', 'Email'); ?>:</p>
                    <p>
                        <a href="mailto:info@blago-vest.org">info@blago-vest.org</a>
                    </p>
                </div>
                <div>
                    <p class="pull-left"><?php echo Yii::t('main', 'Skype'); ?>:</p>
                    <p>
                        <a class="skype-contacts" href="skype:blago-vest.org?chat">blago-vest.org</a>
                    </p>
                </div>
            </address>
            <div class="footer-help">
                	<a href="<?php echo $this->createUrl('/default/help'); ?>" style="width:200px;">
                            <?php echo Yii::t('main', 'Нужна помощь фонда?'); ?>
                        </a>
                </div>
        </div>
    </div>
</div>

