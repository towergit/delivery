<?php

/**
 * Платежная система Perfectmoney
 *
 * @category Controller
 * @package  Module.Payment
 * @author   Timkovsky Alexandr <timkovsky.alexandr@gmail.com>
 */
class SwiftController extends FrontendController {

    /**
     * Отправка данных
     * @param string $code код
     */
    public function actionIndex($code) {

        Yii::app()->user->setFlash('success', Yii::t('payment', 'Ваша заявка принята, администратор проверит зачисление и обработает в ручном режиме в течении суток'));

        $this->redirect('/swift');
    }

}
