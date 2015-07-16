<?php

/**
 * Description of SubscribeController
 *
 * @author vlad
 */
class SubscribeController extends BackendController
{
    public function actionIndex() {
        echo '1';
        exit();
    }
    
    public function actionLastnews() {
       # $subscribes = Subscribe::model()->active()->findAll();
        
        $subscribes = array(
            'dudina.olesya.nikol@gmail.com',
            'lotysh.vm@gmail.com',
            'Gangsta1@i.ua',
        );
        
       /* foreach ($subscribes as $sub) {
            echo '<p>'.$sub->id.'</p>';
        }

        exit();*/
        
            Yii::import('application.modules.letter.models.EmailTemplate');
            Yii::import('admin.modules.material.models.Material');
            
            $criteria = new CDbCriteria;
            $criteria->limit = '1';
            $criteria->order = 'id DESC';
           
            $model = Material::model()->active()->find($criteria);
                 
            $params['title'] = $model->title;
            $params['text'] = $model->description;
            $params['link'] = Yii::app()->createAbsoluteUrl('blog/'.$model->alias);

            $temp = EmailTemplate::getTemplate('last_news');
            
            $mailer = new Mailer;
            
            $mailer->from('info@blago-vest.net');
            $mailer->subject('Описание');
            $mailer->templateMessage($temp->text,$params);
            
            foreach ($subscribes as $sub) {
                $mailer->to($sub);
                echo $mailer->send();
                echo '<br>';
                
            }

            exit();
           // $mailer->send();
            
    }
}
