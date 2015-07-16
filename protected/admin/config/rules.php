<?php
return array(
    /* Основное меню */
    // Акции
    'admin/pools-shares'     => '/share/poole/index',
    'admin/types-shares'     => '/share/type/index',
    'admin/history-changes'  => '/share/historyChange/index',
    'admin/moving'           => '/share/moving/index',
    'admin/subscribe/<action:\w+>'           => '/subscribe/<action>',
    // Обучающая программа
    'admin/stages-learning'  => '/training/stageLearning/index',
    'admin/video-management' => '/training/videoManagement/index',
    'admin/point-system'     => '/training/pointSystem/index',
    'admin/rating-students'  => '/training/ratingStudent/index',
    // Курирование
    'admin/curation'         => '/curation/curation/index',
    // Инвестиционные инструменты
    'admin/tool-kit'         => '/tools/toolKit/index',
    'admin/statistics'       => '/tools/statistic/index',
    // Менеджер задач
    'admin/task-manager'     => '/task/task/index',
    // Тикеты
    'admin/tickets'          => '/ticket/ticket/index',
    // Старая история
    'admin/old-history'      => '/history/history/index',
    // Стандарт
    'admin/'                                                       => 'default/index',
    'admin/<module:\w+>/<controller:\w+>/<action:\w+>/<id:\d?\w+>' => '<module>/<controller>/<action>',
    'admin/<module:\w+>/<controller:\w+>/<action:\w+>'             => '<module>/<controller>/<action>',
    'admin/<module:\w+>/<controller:\w+>'                          => '<module>/<controller>',
    'admin/<controller:\w+>/<action:\w+>'                          => '<controller>/<action>',
    'admin/<controller:\w+>'                                       => '<controller>',
);
