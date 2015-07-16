<?php
return array(
    'modules' => array(
        'application.admin.modules.contentblock.ContentblockModule',
    ),
    'rules'   => array(
        'admin/content-blocks'                                => '/contentblock/contentblock/index',
        'admin/content-block/create'                          => '/contentblock/contentblock/create',
        'admin/content-block/toggle/<pk:\d+>/<attribute:\w+>' => '/contentblock/contentblock/toggle',
        'admin/content-block/update/<id:\d+>'                 => '/contentblock/contentblock/update',
        'admin/content-block/delete/<id:\d+>'                 => '/contentblock/contentblock/delete',
    )
);
