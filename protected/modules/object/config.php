<?php
return array(
    'import'  => array(
        'application.admin.modules.object.models.*',
    ),
    'modules' => array(
        'application.admin.modules.object.ObjectModule',
    ),
    'rules'   => array(
        'admin/objects' => '/object/objectHelp/index'
    )
);
