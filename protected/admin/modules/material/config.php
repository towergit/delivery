<?php
return array(
    'import'  => array(
        'application.admin.modules.material.models.*',
    ),
    'modules' => array(
        'application.admin.modules.material.MaterialModule',
    ),
    'rules'   => array(
        'admin/materials/elect'                                    => '/material/elect/index',
        'admin/materials'                                          => '/material/material/index',
        'admin/materials/material/create'                          => '/material/material/create',
        'admin/materials/material/toggle/<pk:\d+>/<attribute:\w+>' => '/material/material/toggle',
        'admin/materials/material/update/<id:\d+>'                 => '/material/material/update',
        'admin/materials/material/delete/<id:\d+>'                 => '/material/material/delete',
        'admin/materials/categories'                               => '/material/category/index',
        'admin/materials/category/create'                          => '/material/category/create',
        'admin/materials/category/toggle/<pk:\d+>/<attribute:\w+>' => '/material/material/toggle',
        'admin/materials/category/update/<id:\d+>'                 => '/material/category/update',
        'admin/materials/category/delete/<id:\d+>'                 => '/material/category/delete',
    )
);
