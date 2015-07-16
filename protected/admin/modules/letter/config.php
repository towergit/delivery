<?php
return array(
    'import'  => array(
        'application.admin.modules.letter.models.*',
    ),
    'modules' => array(
        'application.admin.modules.letter.LetterModule',
    ),
    'rules'   => array(
        'admin/send-newsletter'                                 => '/letter/send/index',
        'admin/letter/templates'                                => '/letter/template/index',
        'admin/letter/template/create'                          => '/letter/template/create',
        'admin/letter/template/toggle/<pk:\d+>/<attribute:\w+>' => '/letter/template/toggle',
        'admin/letter/template/update/<id:\d+>'                 => '/letter/template/update',
        'admin/letter/template/delete/<id:\d+>'                 => '/letter/template/delete',
        'admin/letter/categories'                               => '/letter/category/index',
        'admin/letter/category/create'                          => '/letter/category/create',
        'admin/letter/category/toggle/<pk:\d+>/<attribute:\w+>' => '/letter/category/toggle',
        'admin/letter/category/update/<id:\d+>'                 => '/letter/category/update',
        'admin/letter/category/delete/<id:\d+>'                 => '/letter/category/delete',
    )
);
