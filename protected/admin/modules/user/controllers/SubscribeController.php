<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of SubscribeController
 *
 * @author vlad
 */
class SubscribeController extends BackendController {

    /**
     * @var string модель по умолчанию
     */
    public $defaultModel = 'Subscribe';

    /**
     * Правила доступа к экшенам
     * @return array

      public function accessRules()
      {
      return array(
      array( 'allow',
      'actions' => array( 'index' ),
      'roles'   => array( 'showUser' ),
      ),
      array( 'allow',
      'actions' => array( 'create' ),
      'roles'   => array( 'createUser' ),
      ),
      array( 'allow',
      'actions' => array( 'toggle', 'update' ),
      'roles'   => array( 'updateUser' ),
      ),
      array( 'allow',
      'actions' => array( 'delete' ),
      'roles'   => array( 'deleteUser' ),
      ),
      array( 'deny',
      'users' => array( '*' ),
      ),
      );
      } */

    /**
     * Экшены
     * @return array
     */
    public function actions() {
        return array(
            'index' => array(
                'class' => 'admin.controllers.action.IndexAction',
                'modelName' => $this->defaultModel,
                'scenario' => 'search',
            ),
            'toggle' => array(
                'class' => 'admin.controllers.action.ToggleAction',
                'modelName' => $this->defaultModel,
                'exception' => Yii::t('user', 'Искомый объект не найден'),
            ),
        );
    }

}
