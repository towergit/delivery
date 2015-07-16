<?php
return array(
    'import'     => array(
        'application.modules.user.models.*',
    ),
    'modules'    => array(
        'application.modules.user.UserModule',
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
            'class'          => 'application.modules.user.components.WebUser',
            'loginUrl'       => '/',
            'allowAutoLogin' => false,
        ),
        'session'     => array(
            'class'                  => 'application.modules.user.components.Session',
            'autoCreateSessionTable' => true,
            'connectionID'           => 'db',
            'timeout'                => 1500,
            'sessionTableName'       => '{{user_session}}',
            'sessionName'            => 'session',
        ),
    ),
    'rules'      => array()
);
