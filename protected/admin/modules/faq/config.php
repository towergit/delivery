<?php
return array(
    'import'  => array(
        'application.admin.modules.faq.models.*',
    ),
    'modules' => array(
        'application.admin.modules.faq.FaqModule',
    ),
    'rules'   => array(
        'admin/faqs'                                          => '/faq/faq/index',
        'admin/faq/create'                                    => '/faq/faq/create',
        'admin/faq/toggle/<id:\d+>/<attribute:\w+>'           => '/faq/faq/toggle',
        'admin/faq/update/<id:\d+>'                           => '/faq/faq/update',
        'admin/faq/delete/<id:\d+>'                           => '/faq/faq/delete',
        'admin/faqs/categories'                               => '/faq/category/index',
        'admin/faqs/category/create'                          => '/faq/category/create',
        'admin/faqs/category/toggle/<id:\d+>/<attribute:\w+>' => '/faq/category/toggle',
        'admin/faqs/category/update/<id:\d+>'                 => '/faq/category/update',
        'admin/faqs/category/delete/<id:\d+>'                 => '/faq/category/delete',
    )
);
