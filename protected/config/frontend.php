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

return CMap::mergeArray(
        include(dirname(__FILE__) . '/main.php'),
        array(
        'basePath'          => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
        // Название сайта
        'name'              => 'Crystal-IT',
        // Язык по умолчанию
        'language'          => 'ru',
        'sourceLanguage'    => 'en',
        'preload'           => CMap::mergeArray(array(), $preload),
        // Контроллер по умолчанию
        'defaultController' => 'default',
        // Относительные пути
        'aliases'           => array(
            'admin' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '../admin/',
        ),
        // Предварительная загрузка
        'preload'           => CMap::mergeArray(array(), $preload),
        // Импортирование классов
        // Импортирование классов
        'import'            => CMap::mergeArray(array(
            'application.components.*',
            'application.models.*',
            'application.helpers.*',
            ), $import),
        // Модули
        'modules'           => CMap::mergeArray(array(), $modules),
        // Компоненты
        'components'        => CMap::mergeArray($components,
            array(
            // URL менеджер
            'urlManager' => array(
                'urlFormat'      => 'path',
                'showScriptName' => false,
                'caseSensitive'  => true,
                'urlSuffix'      => '',
                'rules'          => CMap::mergeArray(
                    $rules,
                    array(
                    // Правила переадресации
                    '/'                                                      => 'default/index',
                    'help/'													 => 'default/help',
                    'qiwi/'													 => 'default/qiwi',
                    'volonter'												 => 'default/volonter',
                    'authorization'                                          => '/default/authorization',
                    'webmoney'                                               => '/default/webmoney',
                    'about-fund'                                             => '/default/about_fund',
                    'blog/page/<Material_page:\d+>'                          => '/default/blog',
                    'blog'                                                   => '/default/blog',
                    'blog/<alias:.+>'                                        => '/default/item_blog',
                    'blog_category/<alias:.+>'                               => '/default/blog_category',
                    'blog_archive/<year:\d+>'                                => '/default/blog_archive',
                    'projects/page/<Material_page:\d+>'                      => '/default/projects',
                    'projects/<alias:.+>'                                    => '/default/projects',
                    'projects'                                               => '/default/projects',
                    'project/<alias:.+>'                                     => '/default/item_project',
                    'projects_category/<alias:.+>'                           => '/default/projects_category',
                    'payment/<id:\d+>'                                       => '/default/payment',
                    'payment/step/(<step:\d+>)?'                             => '/default/payment',
                    'payment'                                                => '/default/payment',
                    'team'                                                   => '/default/team',
                    'partners'                                               => '/default/partners',
                    'faq'                                                    => '/default/faq',
                    'select_objects'                                         => '/default/select_objects',
                    'swift'                                                  => '/default/swift',   
                    'reports'                                                => '/default/reports',
                    'contacts'                                               => '/default/contacts',
                    'comingsoon'                                             => '/comingsoon/index',
                    'subscribe'                                              => '/default/subscribe',
                    'lang/<name:\w+>'                                        => '/language/selector/index',
                    'mails/<action:.+>'                                       => '/mail/<action>',
                    //'<controller:\w+>/<action:\w+>/<id:.+>'         => '<controller>/<action>',
                    // Общие правила
                    '<module:\w+>/<controller:\w+>/<action:\w+>/<id:\d?\w+>' => '<module>/<controller>/<action>',
                    '<module:\w+>/<controller:\w+>/<action:\w+>'             => '<module>/<controller>/<action>',
                    '<module:\w+>/<controller:\w+>'                          => '<module>/<controller>',
                    
                    '<controller:\w+>/<action:\w+>'                          => '<controller>/<action>',
                    '<controller:\w+>'                                       => '<controller>',
                    )
                ),
            ),
            )
        ),
        )
);
