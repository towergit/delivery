<?php
return array(
    'modules' => array(
        'application.admin.modules.backup.BackupModule',
    ),
    'rules'   => array(
        'admin/back-up'                    => '/backup/backup/index',
        'admin/back-up/create'             => '/backup/backup/create',
        'admin/back-up/download/<file:.+>' => '/backup/backup/download',
        'admin/back-up/restore/<file:.+>'  => '/backup/backup/restore',
        'admin/back-up/delete/<file:.+>'   => '/backup/backup/delete',
        'admin/back-up/truncate'           => '/backup/backup/truncate',
        'admin/back-up/remove'             => '/backup/backup/remove',
    )
);
