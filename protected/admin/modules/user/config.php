<?php
return array(
    'import'     => array(
        'application.admin.modules.user.models.*',
    ),
    'modules'    => array(
        'application.admin.modules.user.UserModule',
    ),
    'components' => array(
        'authManager' => array(
            'class'           => 'CDbAuthManager',
            'connectionID'    => 'db',
            'defaultRoles'    => array( 'quest' ),
            'assignmentTable' => '{{auth_assignment}}',
            'itemTable'       => '{{auth_item}}',
            'itemChildTable'  => '{{auth_item_child}}',
        ),
        'user'        => array(
            'class'          => 'admin.modules.user.components.WebUser',
            'loginUrl'       => array( '/user/login' ),
            'allowAutoLogin' => false,
        ),
        'session'     => array(
            'class'                  => 'admin.modules.user.components.Session',
            'autoCreateSessionTable' => true,
            'connectionID'           => 'db',
            'timeout'                => 1500,
            'sessionTableName'       => '{{user_session}}',
            'sessionName'            => 'session',
        ),
    ),
    'rules'      => array(),
);
