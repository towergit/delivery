<?php

/**
 * Управление меню
 *
 * @category Module
 * @package  Module.Menu
 * @author   Timkovsky Alexandr <timkovsky.alexandr@gmail.com>
 */
class MenuModule extends WebModule
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
            'menu.models.*',
        ));
    }

    /**
     * Получение имени модуля
     * @return string
     */
    public function getName()
    {
        return Yii::t('menu', 'Меню');
    }

    /**
     * Описание модуля
     * @return string
     */
    public function getDescription()
    {
        return Yii::t('menu', 'Управление меню');
    }

    /**
     * Версия модуля
     * @return string
     */
    public function getVersion()
    {
        return Yii::t('menu', 'Beta 1.0');
    }
    
    /**
     * Получение иконки модуля
     * @return string
     */
    public function getIcon()
    {
        return 'fa fa-bars';
    }

    /**
     * Получение навигации
     * @return array
     */
    public function getNavigation()
    {
        return array(
            array(
                'label'   => Yii::t('menu', 'Управление меню'),
                'icon'    => $this->icon,
                'url'     => 'javascript:void(0)',
                'visible' => Yii::app()->user->checkAccess('showMenu'),
                'items'   => CMap::mergeArray($this->getMenu(), array(
                    array(
                        'label' => Yii::t('menu', 'Список меню'),
                        'url'   => array( '/menu/menu/index' ),
                    ),
                )),
            ),
        );
    }

    /**
     * Получение всех существующих меню
     * @return array
     */
    private function getMenu()
    {
        $items  = array();
        $models = Menu::model()->findAll(array( 'order' => 'id DESC' ));

        if ($models !== null)
        {
            foreach($models as $model)
            {
                $items[] = array(
                    'label' => $model->title,
                    'url'   => Yii::app()->createUrl('/menu/menuitem/index', array( 'menu_id' => $model->id )),
                );
            }
        }
        
        if (count($items))
        {
            $items = CMap::mergeArray($items, array(
                array(
                    'label'       => '',
                    'url'         => 'javascript:void(0)',
                    'itemOptions' => array(
                        'class' => 'divider',
                    ),
                )
            ));
        }

        return $items;
    }

}

