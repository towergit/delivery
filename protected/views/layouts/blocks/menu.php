<?php
$this->widget('zii.widgets.CMenu',
    array(
    'id'                 => 'menu',
    'submenuHtmlOptions' => array(
        'class' => 'dropdown-menu',
    ),
    'encodeLabel'        => false,
    'htmlOptions'        => array(
        'class' => 'nav navbar-nav',
    ),
    'items'              => array(
        array(
            'label' => Yii::t('main', 'Главная'),
            'url'   => array( '/default/index' ),
        ),
        array(
            'label' => Yii::t('main', 'О фонде'),
            'url'   => array( '/default/about_fund' ),
        ),
        array(
            'label' => Yii::t('main', 'Проекты'),
            'url'   => array( '/default/projects' ),
        ),
        array(
            'label' => Yii::t('main', 'Команда'),
            'url'   => array( '/default/team' ),
        ),
        array(
            'label' => Yii::t('main', 'Партнеры'),
            'url'   => array( '/default/partners' ),
        ),
        array(
            'label' => Yii::t('main', 'Блог'),
            'url'   => array( '/default/blog' ),
        ),
        array(
            'label' => Yii::t('main', 'Отчеты'),
            'url'   => array( '/default/reports' ),
        ),
        array(
            'label' => Yii::t('main', 'Контакты'),
            'url'   => array( '/default/contacts' ),
        ),
    ),
));
?>