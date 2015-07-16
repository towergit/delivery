<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of QiwiController
 *
 * @author vlad
 */
class QiwiController extends FrontendController {
//«Ваша заявка принята, администратор проверит зачисление и обработает в ручном режиме в течении суток»

    /**
     * Отправка данных
     * @param string $code код
     */
    public function actionIndex($code) {
        
        Yii::app()->user->setFlash('success', Yii::t('payment', 'Ваша заявка принята, администратор проверит зачисление и обработает в ручном режиме в течении суток'));

        $this->redirect('/qiwi');
        
    }

}
