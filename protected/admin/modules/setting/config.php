<?php

return array(
	'preload' => array(
		//'setting',
	),
	'modules' => array(
		'application.admin.modules.setting.SettingModule',
	),
	'components' => array(
		'setting' => array(
			'class' => 'application.admin.modules.setting.components.SystemSetting',
		),
	),
	'rules' => array(
		'admin/settings' => '/setting/setting/index',
		'admin/settings/create' => '/setting/setting/create',
	),
);
