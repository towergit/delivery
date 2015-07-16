<?php
return array(
    // Jquery
    'jquery'       => array(
        'basePath' => 'application.assets',
        'js'       => array(
            'js/jquery/' . (YII_DEBUG ? 'jquery-2.0.3.js' : 'jquery-2.0.3.min.js'),
        ),
    ),
    // Ui jquery
    'jquery.ui'    => array(
        'basePath' => 'application.assets',
        'js'       => array(
            'js/ui/' . (YII_DEBUG ? 'jquery-ui-1.10.3.custom.js' : 'jquery-ui-1.10.3.custom.min.js'),
        ),
        'depends'  => array( 'jquery' ),
    ),
    // Cookie
    'cookie'       => array(
        'basePath' => 'application.assets',
        'js'       => array(
            'js/cookie/jquery.cookie.js',
        ),
        'depends'  => array( 'jquery' ),
    ),
    // Bootstrap
    'bootstrap'    => array(
        'basePath' => 'application.assets',
        'js'       => array(
            'js/bootstrap/' . (YII_DEBUG ? 'bootstrap.js' : 'bootstrap.min.js'),
        ),
        'css'      => array(
            'css/bootstrap/' . (YII_DEBUG ? 'bootstrap.css' : 'bootstrap.min.css'),
        ),
        'depends'  => array( 'jquery' ),
    ),
    // Font-awesome
    'font-awesome' => array(
        'basePath' => 'application.assets',
        'css'      => array(
            'css/font-awesome/' . (YII_DEBUG ? 'font-awesome.css' : 'font-awesome.min.css'),
        ),
    ),
    'yiiactiveform' => array(
        'basePath' => 'application.assets',
        'js'      => array(
            'js/jquery.yiiactiveform.js',
        ),
    ),
    // Основные
    'main'         => array(
        'basePath' => 'application.assets',
        'depends'  => array(
            'jquery',
            'jquery.ui',
            'bootstrap',
            'cookie',
            'yiiactiveform'
        ),
    ),
    // Backend
    'backend'      => array(
        'basePath' => 'application.admin.assets',
        'js'       => array(
            'js/jquery.yiiactiveform.js',
            'js/nprogress/nprogress.js',
            'js/scrollbar/jquery.scrollbar.js',
            'js/new.js',
            'js/scripts.js',
        ),
        'css'      => array(
            'css/nprogress/nprogress.css',
            'css/scrollbar/jquery.scrollbar.css',
            'css/flaticon.css',
            'css/animate.css',
            'css/main.css',
            'css/chat.css',
            'css/global-search.css',
            'css/header.css',
            'css/notification.css',
            'css/sidebar.css',
            'css/breadcrumbs.css',
            'css/grid-table.css',
            'css/error.css',
            'css/email.css',
        ),
        'depends'  => array(
            'main',
            'font-awesome',
        ),
    ),
);
