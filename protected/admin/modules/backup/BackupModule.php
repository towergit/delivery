<?php

/**
 * Управление резервными копиями
 *
 * @category Module
 * @package  Module.Backup
 * @author   Timkovsky Alexandr <timkovsky.alexandr@gmail.com>
 */
class BackupModule extends WebModule
{
    /**
     * Инициализация модуля
     * setImport - импортирует при запуске любого контроллера этого модуля
     * setComponents - импортирует компоненты
     */
    public function init()
    {
        parent::init();

        $this->setImport(array(
            'backup.components.*',
        ));
    }

    /**
     * Получение имени модуля
     * @return string
     */
    public function getName()
    {
        return Yii::t('backup', 'Резервные копии');
    }

    /**
     * Описание модуля
     * @return string
     */
    public function getDescription()
    {
        return Yii::t('backup', 'Управление резервными копиями');
    }

    /**
     * Версия модуля
     * @return string
     */
    public function getVersion()
    {
        return Yii::t('backup', '1.01');
    }
    
    /**
     * Получение иконки модуля
     * @return string
     */
    public function getIcon()
    {
        return 'fa fa-database';
    }

    /**
     * Получение навигации
     * @return array
     */
    public function getNavigation()
    {
        return array(
            array(
                'label'   => Yii::t('backup', 'Резервные копии'),
                'detail'  => $this->getLastBackup(),
                'icon'    => $this->icon,
                'url'     => array( '/backup/backup/index' ),
                'visible' => Yii::app()->user->checkAccess('showBackup'),
            ),
        );
    }

    /**
     * Получение последней даты back-up
     * @return string
     */
    private function getLastBackup()
    {
        $backup = new BackupDatabase();
        $array  = array();

        foreach(glob($backup->path . DIRECTORY_SEPARATOR . '*') as $filename)
            $array['created'] = date("d.m.y", filectime($filename));

        $date = end($array);

        if ($date)
            return Yii::t('backup', 'Последний back-up :date', array( ':date' => $date ));
        else
            return Yii::t('backup', 'Нет резервных копий');
    }

}

