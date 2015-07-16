<?php

/**
 * Управление письмами
 *
 * @category Module
 * @package  Module.Letter
 * @author   Timkovsky Alexandr <timkovsky.alexandr@gmail.com>
 */
class LetterModule extends WebModule
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
            'letter.components.*',
            'letter.models.*',
        ));
    }

    /**
     * Получение имени модуля
     * @return string
     */
    public function getName()
    {
        return Yii::t('letter', 'Письма');
    }

    /**
     * Описание модуля
     * @return string
     */
    public function getDescription()
    {
        return Yii::t('letter', 'Управление письмами');
    }

    /**
     * Версия модуля
     * @return string
     */
    public function getVersion()
    {
        return Yii::t('letter', 'Beta 1.0');
    }
    
    /**
     * Получение иконки модуля
     * @return string
     */
    public function getIcon()
    {
        return 'fa fa-send';
    }

    /**
     * Получение навигации
     * @return array
     */
    public function getNavigation()
    {
        return array(
            array(
                'label'   => Yii::t('letter', 'Рассылка'),
                'icon'    => $this->icon,
                'url'     => 'javascript:void(0)',
                'visible' => Yii::app()->user->checkAccess('showNewsletter'),
                'items'   => array(
                    array(
                        'label'   => Yii::t('letter', 'Отправить письмо'),
                        'url'     => array( '/letter/send/index' ),
                        'visible' => Yii::app()->user->checkAccess('showNewsletterSend'),
                    ),
                    array(
                        'label'       => '',
                        'visible'     => Yii::app()->user->checkAccess('showNewsletterTemplate'),
                        'itemOptions' => array(
                            'class' => 'divider',
                        ),
                    ),
                    array(
                        'label'   => Yii::t('letter', 'Шаблоны'),
                        'url'     => array( '/letter/template/index' ),
                        'visible' => Yii::app()->user->checkAccess('showNewsletterTemplate'),
                    ),
                    array(
                        'label'   => Yii::t('letter', 'Категории шаблонов'),
                        'url'     => array( '/letter/category/index' ),
                        'visible' => Yii::app()->user->checkAccess('showNewsletterTemplateCategory'),
                    ),
                ),
            ),
        );
    }

}

