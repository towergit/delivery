<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

Yii::import('application.modules.letter.models.EmailTemplate');

/**
 * Description of EmailBahavior
 *
 * @author vlad
 */
class EmailBahavior extends CActiveRecordBehavior {

    public $emailType = ''; 
    public $data = array();
    public $successPayment = 0;

    public function paymentComplite($params = array()) {

        $params['name'] = $this->owner->name;
        $temp = EmailTemplate::getTemplate('success');
        $mailer = new Mailer;
        $mailer->to($this->owner->email);
        $mailer->from('info@blago-vest.org', 'BLAGOVEST');
        $mailer->subject('Благодарим за помощь!');
        $mailer->templateMessage($temp->text, $params);
        $mailer->send();
        
        return true;
    }

}
