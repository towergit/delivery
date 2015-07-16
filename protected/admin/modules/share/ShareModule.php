<?php

/**
 * Управление акциями
 *
 * @category Module
 * @package  Module.Share
 * @author   Timkovsky Alexandr <timkovsky.alexandr@gmail.com>
 */
class ShareModule extends WebModule
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
            'share.models.*',
        ));
    }

    /**
     * Получение имени модуля
     * @return string
     */
    public function getName()
    {
        return Yii::t('share', 'Акции');
    }

    /**
     * Описание модуля
     * @return string
     */
    public function getDescription()
    {
        return Yii::t('share', 'Управление акциями');
    }

    /**
     * Версия модуля
     * @return string
     */
    public function getVersion()
    {
        return Yii::t('share', 'Beta: 1.0');
    }
    
    /**
     * Получение иконки модуля
     * @return string
     */
    public function getIcon()
    {
        return 'fa fa-th';
    }

    /**
     * Получение навигации
     * @return array
     */
    public function getNavigation()
    {
        return array(
            array(
                'label'   => Yii::t('share', 'Акции'),
                'icon'    => $this->icon,
                'url'     => 'javascript:void(0)',
                'visible' => Yii::app()->user->checkAccess('showShare'),
                'items'   => array(
                    array(
                        'label' => Yii::t('share', 'Пулы акций'),
                        'url'   => array( '/share/poole/index' ),
                        'visible' => Yii::app()->user->checkAccess('showSharePool'),
                    ),
                    array(
                        'label' => Yii::t('share', 'Типы акций'),
                        'url'   => array( '/share/type/index' ),
                        'visible' => Yii::app()->user->checkAccess('showShareType'),
                    ),
                    array(
                        'label' => Yii::t('share', 'История изменения стоимости'),
                        'url'   => array( '/share/historyChange/index' ),
                        'visible' => Yii::app()->user->checkAccess('showShareHistoryChange'),
                    ),
                    array(
                        'label' => Yii::t('share', 'Перемещение акций'),
                        'url'   => array( '/share/moving/index' ),
                        'visible' => Yii::app()->user->checkAccess('showShareMoving'),
                    ),
                    array(
                        'label' => Yii::t('share', 'Заявки на покупку акций'),
                        'url'   => array( '/share/purchase/index' ),
                        'visible' => Yii::app()->user->checkAccess('showSharePurchase'),
                    ),
                ),
            ),
        );
    }

}

