<?php
return array(
    'import'  => array(
        'application.admin.modules.gallery.models.*',
    ),
    'modules' => array(
        'application.admin.modules.gallery.GalleryModule',
    ),
    'rules'   => array(
        'admin/gallery'                                 => '/gallery/gallery/index',
        'admin/gallery/create'                          => '/gallery/gallery/create',
        'admin/gallery/toggle/<id:\d+>/<attribute:\w+>' => '/gallery/gallery/toggle',
        'admin/gallery/update/<id:\d+>'                 => '/gallery/gallery/update',
        'admin/gallery/delete/<id:\d+>'                 => '/gallery/gallery/delete',
    )
);
