<?php

return array(
	'modules' => array(
		'application.admin.modules.log.LogModule',
	),
	'rules' => array(
		'admin/event-log' => '/log/log/index',
		'admin/event-log/view/<id:\d+>' => '/log/log/view',
		'admin/event-log/delete/<id:\d+>' => '/log/log/delete',
		'admin/event-log/clean' => '/log/log/clean',
	)
);
