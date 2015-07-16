<?php

return array(
    'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
    'name'=>'My Console Application',
    'import'=>array(
        'application.models.*',
        'application.components.*',
    ),
    'components'=>array(

        'db'=>array(
            'connectionString'		 => 'mysql:host=localhost;dbname=blagovest',
            'username'				 => 'root',
            'password'				 => '',
            'charset'				 => 'utf8',
            'tablePrefix'			 => 'aes_',
            'emulatePrepare'		 => true,
            'enableProfiling'		 => true,
            'enableParamLogging'	 => true,
            'schemaCachingDuration'	 => 180,
        ),
    ),
    'params'	 => require(dirname(__FILE__) . '/params.php'),
);