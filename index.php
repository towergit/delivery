<?php
throw new Exception('Отказ в доступе', '403');
$yii = dirname(__FILE__) . '/framework/yiilite.php';
$frontendConfig	 = dirname(__FILE__) . '/protected/config/frontend.php';

defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL', 3);
require_once($yii);
Yii::createWebApplication($frontendConfig)->run();
