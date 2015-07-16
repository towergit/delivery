<?php
return array(
    'import'  => array(
        'application.admin.modules.menu.models.*',
    ),
    'modules' => array(
        'application.admin.modules.menu.MenuModule',
    ),
    'rules'   => array(
        'admin/menus'                                          => '/menu/menu/index',
        'admin/menu/create'                                    => '/menu/menu/create',
        'admin/menu/toggle/<pk:\d+>/<attribute:\w+>'           => '/menu/menu/toggle',
        'admin/menu/update/<id:\d+>'                           => '/menu/menu/update',
        'admin/menu/delete/<id:\d+>'                           => '/menu/menu/delete',
        'admin/menu/<menu_id:\d+>/menu-items'                  => '/menu/menuitem/index',
        'admin/menu/<menu_id:\d+>/menu-item/create'            => '/menu/menuitem/create',
        'admin/menu/menu-item/toggle/<pk:\d+>/<attribute:\w+>' => '/menu/menuitem/toggle',
        'admin/menu/<menu_id:\d+>/menu-item/update/<id:\d+>'   => '/menu/menuitem/update',
        'admin/menu/<menu_id:\d+>/menu-item/delete/<id:\d+>'   => '/menu/menuitem/delete',
    )
);
