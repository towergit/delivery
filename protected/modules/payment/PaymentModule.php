<?php

/**
 * Управление платежами
 *
 * @category Module
 * @package  Module.Payment
 * @author   Timkovsky Alexandr <timkovsky.alexandr@gmail.com>
 */
class PaymentModule extends WebModule
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
            'payment.components.*',
            'payment.models.*',
        ));
    }

    /**
     * Получение имени модуля
     * @return string
     */
    public function getName()
    {
        return Yii::t('payment', 'Платежи');
    }

    /**
     * Описание модуля
     * @return string
     */
    public function getDescription()
    {
        return Yii::t('payment', 'Управление платежами');
    }

    /**
     * Версия модуля
     * @return string
     */
    public function getVersion()
    {
        return Yii::t('payment', 'Beta 1.0');
    }
    
    /**
     * Получение иконки модуля
     * @return string
     */
    public function getIcon()
    {
        return 'fa fa-credit-card';
    }

    /**
     * Получение навигации
     * @return array
     */
    public function getNavigation()
    {
        return array(
            array(
                'label'   => Yii::t('payment', 'Платежи'),
                'icon'    => $this->icon,
                'url'     => 'javascript:void(0)',
              //  'visible' => Yii::app()->user->checkAccess('showPayment'),
                'items'   => array(
                    array(
                        'label'   => Yii::t('payment', 'История денежных средств'),
                        'url'     => array( '/ph/index' ),
                    ),
                    
                ),
            ),
        );
    }

}

