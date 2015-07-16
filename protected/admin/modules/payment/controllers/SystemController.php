<?php

/**
 * Платежные системы
 *
 * @category Controller
 * @package  Module.Payment
 * @author   Timkovsky Alexandr <timkovsky.alexandr@gmail.com>
 */
class SystemController extends BackendController {

    /**
     * @var string модель по умолчанию
     */
    public $defaultModel = 'PaymentSystem';

    /**
     * Правила доступа к экшенам
     * @return array

      public function accessRules()
      {
      return array(
      array( 'allow',
      'actions' => array( 'index' ),
      'roles'   => array( 'showPaymentPaymentSystem' ),
      ),
      array( 'allow',
      'actions' => array( 'create' ),
      'roles'   => array( 'createPaymentPaymentSystem' ),
      ),
      array( 'allow',
      'actions' => array( 'toggle', 'update' ),
      'roles'   => array( 'updatePaymentPaymentSystem' ),
      ),
      array( 'allow',
      'actions' => array( 'delete' ),
      'roles'   => array( 'deletePaymentPaymentSystem' ),
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
            'create' => array(
                'class' => 'admin.controllers.action.CreateAction',
                'modelName' => $this->defaultModel,
                'success' => Yii::t('payment', 'Платежная система успешно создана'),
                'error' => Yii::t('payment', 'Ошибка при создании платежной системы'),
            ),
            'toggle' => array(
                'class' => 'admin.controllers.action.ToggleAction',
                'modelName' => $this->defaultModel,
                'exception' => Yii::t('payment', 'Искомая платежная система не найдена'),
            ),
            'update' => array(
                'class' => 'admin.controllers.action.UpdateAction',
                'modelName' => $this->defaultModel,
                'success' => Yii::t('payment', 'Платежная система успешно отредактирована'),
                'error' => Yii::t('payment', 'Ошибка при редактировании платежной системы'),
                'exception' => Yii::t('payment', 'Искомая платежная система не найдена'),
            ),
            'delete' => array(
                'class' => 'admin.controllers.action.DeleteAction',
                'modelName' => $this->defaultModel,
                'success' => Yii::t('payment', 'Платежная система успешно удалена'),
                'error' => Yii::t('payment', 'Ошибка при удалении платежной системы'),
                'exception' => Yii::t('payment', 'Искомая платежная система не найдена'),
            ),
            'sort' => array(
                'class' => 'admin.controllers.action.SortableAction',
                'modelName' => $this->defaultModel,
            )
        );
    }

}
