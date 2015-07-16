<?php
return array(
    'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
    // Автоматическая загрузка компонентов
    'preload'	 => array(
        'log',
    ),
    // Относительные пути
    'aliases'	 => array(
        'bootstrap' => 'ext.bootstrap',
        'booster' => 'ext.booster',
    ),
    // Импортирование классов
    'import'	 => array(
        'bootstrap.behaviors.*',
        'bootstrap.helpers.*',
        'bootstrap.widgets.*',
        'booster.helpers.*',
        'booster.widgets.*',
    ),
    // Модули
    'modules'	 => array(),
    // Компоненты
    'components' => array(
        // База данных
        'db'			 => require(dirname(__FILE__) . '/database.php'),
        // Bootstrap
        'setting' => array(
			'class' => 'application.admin.modules.setting.components.SystemSetting',
        ),
        'bootstrap'		 => array(
            'class' => 'bootstrap.components.BsApi',
        ),
        'cache'=>array(
            'class'=>'system.caching.CFileCache',
        ),
        // Booster
        'booster' => array(
            'class' => 'ext.booster.components.Booster',
        ),
        'image'        => array(
            'class'  => 'application.extensions.image.cimagecomponent',
            // GD or ImageMagick
            'driver' => 'GD',
            // ImageMagick setup path
            'params' => array( 'directory' => './uploads/user/' ),
        ),
        // Логи
        'log'			 => array(
            'class'	 => 'CLogRouter',
            'routes' => array(
                array(
                    'class'	 => 'CFileLogRoute',
                    'levels' => 'error, warning',
                ),
            ),
        ),
        // Ошибки
        'errorHandler'	 => array(
            'errorAction' => 'error/index',
        ),
        // Клиентские скрипты
        'clientScript' => array(
            'packages'  => require_once(dirname( __FILE__ ) . '/mainPackages.php'),
            'scriptMap' => array(
                'jquery.js'  => false,
                'jquery.min.js' => false,
                'jquery.yiiactiveform.js' => false,
            ),
        ),
    ),
    // Параметры
    'params'	 => require(dirname(__FILE__) . '/params.php'),
);
