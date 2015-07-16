<?php

/**
 * Заявки на ввод
 *
 * @category Controller
 * @package  Module.Payment
 * @author   Vlad Lotysh <lotysh.vm@gmail.com>
 */
class PaymentController extends BackendController {

    /**
     * @var string модель по умолчанию
     */
    public $defaultModel = 'PaymentObject';

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
                'success'    => Yii::t('payment', 'Платеж на успешно создана'),
                'error'      => Yii::t('payment', 'Ошибка при создании платежа'),
                'redirectTo' => $this->createUrl('index'),
            ),
            'toggle' => array(
                'class'     => 'admin.controllers.action.ToggleAction',
                'modelName' => $this->defaultModel,
                'exception' => Yii::t('payment', 'Заявка на вывод средств не найдена'),
            ),
            'update' => array(
                'class'      => 'admin.controllers.action.UpdateAction',
                'modelName'  => $this->defaultModel,
                'success'    => Yii::t('payment', 'Платеж на успешно изменен'),
                'error'      => Yii::t('payment', 'Ошибка при редактировании платежа'),
                'exception'  => Yii::t('payment', 'Платеж не найден'),
                'redirectTo' => $this->createUrl('index'),
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
