<?php

/**
 * Планировщик задач
 *
 * @category Module
 * @package  Module.Cron
 * @author   Timkovsky Alexandr <timkovsky.alexandr@gmail.com>
 */
class CronModule extends WebModule
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
            'cron.models.*',
        ));
    }

    /**
     * Получение имени модуля
     * @return string
     */
    public function getName()
    {
        return Yii::t('cron', 'Планировщик задач');
    }

    /**
     * Описание модуля
     * @return string
     */
    public function getDescription()
    {
        return Yii::t('cron', 'Управление планировщиком задач');
    }

    /**
     * Версия модуля
     * @return string
     */
    public function getVersion()
    {
        return Yii::t('cron', 'Beta 1.0');
    }
    
    /**
     * Получение иконки модуля
     * @return string
     */
    public function getIcon()
    {
        return 'fa fa-bolt';
    }

    /**
     * Получение навигации
     * @return array
     */
    public function getNavigation()
    {
        return array(
            array(
                'label'   => Yii::t('cron', 'Планировщик задач'),
                'detail'  => $this->getNumberTasks(),
                'icon'    => $this->icon,
                'url'     => array( '/cron/cron/index' ),
                'visible' => Yii::app()->user->checkAccess('showCron'),
            ),
        );
    }

    /**
     * Получение количества активных задач
     * @return string
     */
    private function getNumberTasks()
    {
        $count = Cron::model()->active()->count();

        if ($count)
            return $count . ' ' . Yii::t('cron', 'задача|задачи|задач', $count) . ' ' . Yii::t('cron', 'на выполнении');
        else
            return Yii::t('cron', 'Нет задач для выполнения');
    }

}

