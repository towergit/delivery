<?php
return array(
    'modules' => array(
        'application.admin.modules.cron.CronModule',
    ),
    'rules'   => array(
        'admin/cron'                                 => '/cron/cron/index',
        'admin/cron/create'                          => '/cron/cron/create',
        'admin/cron/toggle/<pk:\d+>/<attribute:\w+>' => '/cron/cron/toggle',
        'admin/cron/update/<id:\d+>'                 => '/cron/cron/update',
        'admin/cron/delete/<id:\d+>'                 => '/cron/cron/delete',
    )
);
