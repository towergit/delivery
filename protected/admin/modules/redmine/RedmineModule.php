<?php

/**
 * Управление проектами и задачами
 *
 * @category Module
 * @package  Module.Redmine
 * @author   Timkovsky Alexandr <timkovsky.alexandr@gmail.com>
 */
class RedmineModule extends WebModule
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
            'redmine.models.*',
        ));
    }

    /**
     * Получение имени модуля
     * @return string
     */
    public function getName()
    {
        return Yii::t('redmine', 'Redmine');
    }

    /**
     * Описание модуля
     * @return string
     */
    public function getDescription()
    {
        return Yii::t('redmine', 'Управление проектами и задачами');
    }

    /**
     * Версия модуля
     * @return string
     */
    public function getVersion()
    {
        return Yii::t('redmine', 'Beta: 1.0');
    }

    /**
     * Получение иконки модуля
     * @return string
     */
    public function getIcon()
    {
        return 'fa fa-terminal';
    }

    /**
     * Получение навигации
     * @return array
     */
    public function getNavigation()
    {
        return array(
            array(
                'label' => Yii::t('redmine', 'Redmine'),
                'icon'  => $this->icon,
                'url'   => 'javascript:void(0)',
                'items' => array(
                    array(
                        'label' => Yii::t('redmine', 'Доска задач'),
                        'url'   => array( '/redmine/dashboard/index' ),
                    ),
                    array(
                        'label'       => '',
                        'url'         => 'javascript:void(0)',
                        'itemOptions' => array(
                            'class' => 'divider',
                        ),
                    ),
                    array(
                        'label' => Yii::t('redmine', 'Персонал'),
                        'url'   => array( '/redmine/staff/index' ),
                    ),
                    array(
                        'label' => Yii::t('redmine', 'Проекты'),
                        'url'   => array( '/redmine/project/index' ),
                    ),
                    array(
                        'label' => Yii::t('redmine', 'Проблемы'),
                        'url'   => array( '/redmine/issue/index' ),
                    ),
                ),
            ),
        );
    }

}

