<?php

/**
 * Заявки на ввод
 *
 * @category Controller
 * @package  Module.Payment
 * @author   Timkovsky Alexandr <timkovsky.alexandr@gmail.com>
 */
class InputController extends BackendController
{

    /**
     * @var string модель по умолчанию
     */
    public $defaultModel = 'InputMoney';

    /**
     * Правила доступа к экшенам
     * @return array
     */
    public function accessRules()
    {
        return array(
            array( 'allow',
                'actions' => array( 'index' ),
                'roles'   => array( 'showPaymentInputMoney' ),
            ),
            array( 'allow',
                'actions' => array( 'create' ),
                'roles'   => array( 'createPaymentInputMoney' ),
            ),
            array( 'allow',
                'actions' => array( 'toggle', 'update' ),
                'roles'   => array( 'updatePaymentInputMoney' ),
            ),
            array( 'allow',
                'actions' => array( 'delete' ),
                'roles'   => array( 'deletePaymentInputMoney' ),
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
                'class'      => 'admin.controllers.action.IndexAction',
                'modelName'  => $this->defaultModel,
                'scenario'   => 'search',
                'renderData' => array(
                    'paymentPurse'  => new PaymentPurse,
                    'paymentSystem' => new PaymentSystem,
                ),
            ),
            'create' => array(
                'class'      => 'admin.controllers.action.CreateAction',
                'modelName'  => $this->defaultModel,
                'success'    => Yii::t('payment', 'Заявка на вывод средств успешно создана'),
                'error'      => Yii::t('payment', 'Ошибка при создании заявки на вывод средств'),
                'renderData' => array(
                    'user'          => new User,
                    'paymentPurse'  => new PaymentPurse,
                    'paymentSystem' => new PaymentSystem,
                ),
            ),
            'toggle' => array(
                'class'     => 'admin.controllers.action.ToggleAction',
                'modelName' => $this->defaultModel,
                'exception' => Yii::t('payment', 'Заявка на вывод средств не найдена'),
            ),
            'update' => array(
                'class'      => 'admin.controllers.action.UpdateAction',
                'modelName'  => $this->defaultModel,
                'success'    => Yii::t('payment', 'Заявка на вывод средств успешно отредактирована'),
                'error'      => Yii::t('payment', 'Ошибка при редактировании заявки на вывод средств'),
                'exception'  => Yii::t('payment', 'Заявка на вывод средств не найдена'),
                'renderData' => array(
                    'user'          => new User,
                    'paymentPurse'  => new PaymentPurse,
                    'paymentSystem' => new PaymentSystem,
                ),
            ),
            'delete' => array(
                'class'     => 'admin.controllers.action.DeleteAction',
                'modelName' => $this->defaultModel,
                'success'   => Yii::t('payment', 'Заявка на вывод средств успешно удалена'),
                'error'     => Yii::t('payment', 'Ошибка при удалении заявки на вывод средств'),
                'exception' => Yii::t('payment', 'Заявка на вывод средств не найдена'),
            ),
        );
    }

}

