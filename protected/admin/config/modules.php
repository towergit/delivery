<?php
//Получание списка директорий в protected/admin/modules
$dirs = scandir(dirname(__FILE__) . '/../modules');

$modules = array();

foreach($dirs as $name)
{
    if ($name[0] != '.')
    {
        $modules[$name] = array( 'class' => 'application.admin.modules.' . $name . '.' . ucfirst($name) . 'Module' );
    }
}

return $modules;
