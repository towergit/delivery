<?php
throw new Exception('Отказ в доступе', '403');
$yii           = dirname(__FILE__) . '/framework/yii.php';
$backendConfig = dirname(__FILE__) . '/protected/admin/config/backend.php';

defined('YII_DEBUG') or define('YII_DEBUG', false);
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL', 3);

require_once($yii);
Yii::createWebApplication($backendConfig)->run();
