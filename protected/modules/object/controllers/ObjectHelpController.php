<?php

/**
 * Объекты помощи
 *
 * @category Controller
 * @package  Module.Object
 * @author   Timkovsky Alexandr <timkovsky.alexandr@gmail.com>
 */
class ObjectHelpController extends BackendController
{

    /**
     * @var string модель по умолчанию
     */
    public $defaultModel = 'ObjectHelp';

    /**
     * Правила доступа к экшенам
     * @return array
     */
    public function accessRules()
    {
        return array(
            array( 'allow',
                'actions' => array( 'index' ),
//                'roles'   => array( 'showObject' ),
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
            ),
        );
    }

}

