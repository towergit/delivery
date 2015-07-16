<?php

/**
 * Управление ответами на вопросы
 *
 * @category Module
 * @package  Module.Faq
 * @author   Timkovsky Alexandr <timkovsky.alexandr@gmail.com>
 */
class FaqModule extends WebModule
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
            'faq.models.*',
        ));
    }

    /**
     * Получение имени модуля
     * @return string
     */
    public function getName()
    {
        return Yii::t('faq', 'FAQ');
    }

    /**
     * Описание модуля
     * @return string
     */
    public function getDescription()
    {
        return Yii::t('faq', 'Управление ответами на вопросы');
    }

    /**
     * Версия модуля
     * @return string
     */
    public function getVersion()
    {
        return Yii::t('faq', 'Beta 1.0');
    }
    
    /**
     * Получение иконки модуля
     * @return string
     */
    public function getIcon()
    {
        return 'fa fa-comments';
    }

    /**
     * Получение навигации
     * @return array
     */
    public function getNavigation()
    {
        return array(
            array(
                'label'   => Yii::t('faq', 'FAQ'),
                'icon'    => $this->icon,
                'url'     => 'javascript:void(0)',
                'visible' => Yii::app()->user->checkAccess('showFAQ'),
                'items'   => array(
                    array(
                        'label'   => Yii::t('faq', 'Список FAQ'),
                        'url'     => array( '/faq/faq/index' ),
                        'visible' => Yii::app()->user->checkAccess('showFAQ'),
                    ),
                    array(
                        'label'   => Yii::t('faq', 'Категории FAQ'),
                        'url'     => array( '/faq/category/index' ),
                        'visible' => Yii::app()->user->checkAccess('showFAQCategory'),
                    ),
                ),
            ),
        );
    }

}

