<?php
return array(
    'import'  => array(
        'application.admin.modules.comment.models.*',
    ),
    'modules' => array(
        'application.admin.modules.comment.CommentModule',
    ),
    'rules'   => array(
        'admin/comments' => '/comment/comment/index',
        'admin/comment/create' => '/comment/comment/create',
        'admin/comment/update/<id:\d+>' => '/comment/comment/update',
        'admin/comment/delete/<id:\d+>' => '/comment/comment/delete',
    )
);
