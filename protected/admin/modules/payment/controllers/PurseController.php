<?php

/**
 * Кошельки платежных систем
 *
 * @category Controller
 * @package  Module.Payment
 * @author   Timkovsky Alexandr <timkovsky.alexandr@gmail.com>
 */
class PurseController extends BackendController
{

    /**
     * @var string модель по умолчанию
     */
    public $defaultModel = 'PaymentPurse';

    /**
     * Правила доступа к экшенам
     * @return array
     */
    public function accessRules()
    {
        return array(
            array( 'allow',
                'actions' => array( 'index' ),
                'roles'   => array( 'showPaymentPurse' ),
            ),
            array( 'allow',
                'actions' => array( 'create' ),
                'roles'   => array( 'createPaymentPurse' ),
            ),
            array( 'allow',
                'actions' => array( 'toggle', 'update' ),
                'roles'   => array( 'updatePaymentPurse' ),
            ),
            array( 'allow',
                'actions' => array( 'delete' ),
                'roles'   => array( 'deletePaymentPurse' ),
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
                    'paymentSystem' => new PaymentSystem,
                ),
            ),
            'create' => array(
                'class'     => 'admin.controllers.action.CreateAction',
                'modelName' => $this->defaultModel,
                'success'   => Yii::t('payment', 'Кошелек успешно создан'),
                'error'     => Yii::t('payment', 'Ошибка при создании кошелька'),
                'renderData' => array(
                    'paymentSystem' => new PaymentSystem,
                ),
            ),
            'toggle' => array(
                'class'     => 'admin.controllers.action.ToggleAction',
                'modelName' => $this->defaultModel,
                'exception' => Yii::t('payment', 'Искомаый кошелек не найден'),
            ),
            'update' => array(
                'class'     => 'admin.controllers.action.UpdateAction',
                'modelName' => $this->defaultModel,
                'success'   => Yii::t('payment', 'Кошелек успешно отредактирован'),
                'error'     => Yii::t('payment', 'Ошибка при редактировании кошелька'),
                'exception' => Yii::t('payment', 'Искомый кошелек не найден'),
                'renderData' => array(
                    'paymentSystem' => new PaymentSystem,
                ),
            ),
            'delete' => array(
                'class'     => 'admin.controllers.action.DeleteAction',
                'modelName' => $this->defaultModel,
                'success'   => Yii::t('payment', 'Кошелек успешно удален'),
                'error'     => Yii::t('payment', 'Ошибка при удалении кошелька'),
                'exception' => Yii::t('payment', 'Искомый кошелек не найден'),
            ),
        );
    }

}

