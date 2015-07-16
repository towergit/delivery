<?php

/**
 * Избранные материалы
 *
 * @category Controller
 * @package  Module.Material
 * @author   Timkovsky Alexandr <timkovsky.alexandr@gmail.com>
 */
class ElectController extends BackendController
{

    /**
     * @var string модель по умолчанию
     */
    public $defaultModel = 'Elect';

    /**
     * Правила доступа к экшенам
     * @return array
     */
    public function accessRules()
    {
        return array(
            array( 'allow',
                'actions' => array( 'index', 'sort' ),
                'roles'   => array( 'showMaterial' ),
            ),
            array( 'deny',
                'users' => array( '*' ),
            ),
        );
    }

    /**
     * Экшены
     * @return array
     */
    public function actions()
    {
        return array(
            'index'  => array(
                'class'     => 'admin.controllers.action.IndexAction',
                'modelName' => $this->defaultModel,
                'scenario'  => 'search',
                'renderData' => array(
                    'category' => new MaterialCategory,
                ),
            ),
            'sort'   => array(
                'class'     => 'admin.controllers.action.SortableAction',
                'modelName' => $this->defaultModel,
            ),
        );
    }

}

