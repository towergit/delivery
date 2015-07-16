<?php
return array(
    'import'     => array(
        'application.admin.modules.language.models.*',
        'application.admin.modules.language.components.LanguageBehavior',
    ),
    'modules'    => array(
        'application.admin.modules.language.LanguageModule',
    ),
    'components' => array(
        'urlManager' => array(
            'class' => 'application.admin.modules.language.components.LangUrlManager',
        ),
    ),
    'rules'      => array(
        'admin/languages'                                => '/language/language/index',
        'admin/language/create'                          => '/language/language/create',
        'admin/language/toggle/<pk:\d+>/<attribute:\w+>' => '/language/language/toggle',
        'admin/language/update/<id:\d+>'                 => '/language/language/update',
        'admin/language/delete/<id:\d+>'                 => '/language/language/delete',
    )
);
