<?php
$preload    = array();
$import     = array();
$modules    = array();
$rules      = array();
$components = array();

$files = glob(dirname(__FILE__) . '/../modules/*');

if (!empty($files))
{
    foreach($files as $file)
    {
        $config = include_once($file . '/config.php');
        $name   = preg_replace('#^.*/([^\.]*)$#', '$1', $file);

        if (!empty($config['preload']))
            $preload = CMap::mergeArray($preload, $config['preload']);

        if (!empty($config['import']))
            $import = CMap::mergeArray($import, $config['import']);

        if (!empty($config['modules']))
        {
            $modules = CMap::mergeArray($modules, array( $name => array( 'class' => $config['modules'][0] ) ));
        }

        if (!empty($config['rules']))
            $rules = CMap::mergeArray($rules, $config['rules']);

        if (!empty($config['components']))
            $components = CMap::mergeArray($components, $config['components']);
    }
}

$backend  = dirname(dirname(__FILE__));
$frontend = dirname($backend);

return CMap::mergeArray(include(dirname(__FILE__) . '/../../config/main.php'),
        array(
        'basePath'       => $frontend,
        // Название сайта
        'name'           => '',
        // Языки
        'language'       => 'ru',
        'sourceLanguage' => 'fr',
        // Пути до основных компонентов
        'controllerPath' => $backend . '/controllers',
        'viewPath'       => $backend . '/views',
        'modulePath'     => $backend . '/modules',
        'runtimePath'    => $backend . '/runtime',
        // Относительные пути
        'aliases'        => array(
            'admin' => $backend,
        ),
        // Предварительная загрузка
        'preload'        => CMap::mergeArray(array(
            'booster'
        ), $preload),
        // Импортирование классов
        'import'         => CMap::mergeArray(array(
            'application.models.*',
            'application.components.*',
            'application.helpers.*',
            'admin.components.*',
            'admin.components.validators.*',
            'admin.models.*',
            ), $import),
        // Модули
        'modules'        => CMap::mergeArray(array(), $modules),
        // Компоненты
        'components'     => CMap::mergeArray($components,
            array(
            // URL менеджер
            'urlManager' => array(
                'urlFormat'      => 'path',
                'showScriptName' => false,
                'caseSensitive'  => true,
                'urlSuffix'      => '',
                'rules'          => CMap::mergeArray($rules,
                    array(
                    // Правила переадресации
                    'admin/'                                                       => 'default/index',
                    'admin/subscribe/<action:\w+>'                                 => 'Subscribe/<action>',
                    // Общие правила
                    'admin/<module:\w+>/<controller:\w+>/<action:\w+>/<id:\d?\w+>' => '<module>/<controller>/<action>',
                    'admin/<module:\w+>/<controller:\w+>/<action:\w+>'             => '<module>/<controller>/<action>',
                    'admin/<module:\w+>/<controller:\w+>'                          => '<module>/<controller>',
                    'admin/<module:\w+>/<controller:\w+>/<action:\w+>/sortableAttribute/<sortableAttribute:\w+>' => '<module>/<controller>/sort',
                    'admin/<controller:\w+>/<action:\w+>'                          => '<controller>/<action>',
                    'admin/<controller:\w+>'                                       => '<controller>',
                    )
                ),
            ),
        )),
    ));
