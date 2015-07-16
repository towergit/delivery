<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of DeliveryController
 *
 * @author vlad
 */
class MailController extends FrontendController {
    
    public function actionLastnews() {
            Yii::import('application.modules.letter.models.EmailTemplate');
            
            $Subscribes = Subscribe::model()->findAllByAttributes(array('subscribe' => 1));
            
            $criteria = new CDbCriteria;
            $criteria->limit = '1';
            $criteria->order = 'id DESC';            
            $model = Material::model()->active()->find($criteria);
                 
            $params['title'] = $model->title;
            $params['text'] = $model->description;
            $params['link'] = Yii::app()->createAbsoluteUrl('blog/'.$model->alias);
            


               $ii = 1;
            foreach ($Subscribes as $sub) {
                            $mailer = new Mailer;
            $temp = EmailTemplate::getTemplate('last_news');
            $mailer->from('info@blago-vest.org', 'BLAGOVEST');
            $mailer->subject('Обновления на сайте фонда «Благовест»');
                $params['unsubscribe'] = Yii::app()->createAbsoluteUrl('mails/unsubscribe?user_id='.$sub->id);
                $mailer->templateMessage($temp->text,$params);       
                $mailer->to($sub->email);
                echo '<br>';
                    var_dump($sub->email);
                 var_dump($mailer->send());
                 var_dump($ii++);
                 unset($mailer);
            }

                exit();
         
    }
    
    public function actionSuccess() {
                         
            $params['name'] = 'Чувак';
                        
            $temp = EmailTemplate::getTemplate('success');
            
            $mailer = new Mailer;
            $mailer->to('lotysh.vm@gmail.com');
            $mailer->from('info@blago-vest.org', 'BLAGOVEST');
            $mailer->subject('Описание');
            $mailer->templateMessage($temp->text,$params);
            var_dump($mailer->send());
            exit();
    }
    
    public function actionUnsubscribe() {
          

        if(!isset($_GET['user_id']))
              $this->redirect( '/' );
        
        $userid = $_GET['user_id'];
        $MailUser = Subscribe::model()
                ->find( 
                        array(
                                'condition' => 'id = :id',
                                'params' => array( ':id' => $userid )
                            )
                    );

        if( !is_null( $MailUser ) ){
            
            $MailUser->subscribe = 0 ;
            if($MailUser->save())        
                 Yii::app()->user->setFlash('success', Yii::t('main', 'Вы успешно отписаны от рассылки!'));
            else
                Yii::app()->user->setFlash('error', Yii::t('main', 'Внутреняя ошибка сервера!'));
        }

        $this->redirect( '/' );
    }
    
}
