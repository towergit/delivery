<?php
return array(
    '/'                                                      => '/default/index',
    'comingsoon' => '/comingsoon/index',
    '<module:\w+>/<controller:\w+>/<action:\w+>/<id:\d?\w+>' => '<module>/<controller>/<action>',
    '<module:\w+>/<controller:\w+>/<action:\w+>'             => '<module>/<controller>/<action>',
    '<module:\w+>/<controller:\w+>'                          => '<module>/<controller>',
    '<controller:\w+>/<action:\w+>'                          => '<controller>/<action>',
    '<controller:\w+>'                                       => '<controller>',
);
