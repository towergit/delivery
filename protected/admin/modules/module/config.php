<?php
return array(
    'import'  => array(
        'application.admin.modules.module.models.*',
    ),
    'modules' => array(
        'application.admin.modules.module.ModuleModule',
    ),
    'rules'   => array(
        'admin/modules' => '/module/module/index',
    ),
);
