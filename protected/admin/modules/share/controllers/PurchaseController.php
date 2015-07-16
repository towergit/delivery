<?php

/**
 * Заявки на покупку акций
 *
 * @category Controller
 * @package  Module.Share
 * @author   Timkovsky Alexandr <timkovsky.alexandr@gmail.com>
 */
class PurchaseController extends BackendController
{

    /**
     * @var string модель по умолчанию
     */
    public $defaultModel = 'SharePurchase';

    /**
     * Правила доступа к экшенам
     * @return array
     */
    public function accessRules()
    {
        return array(
            array( 'allow',
                'actions' => array( 'purchase' ),
                'users'   => array( '*' ),
            ),
            array( 'allow',
                'actions' => array( 'index' ),
                'roles'   => array( 'showSharePurchase' ),
            ),
            array( 'allow',
                'actions' => array( 'toggle', 'update' ),
                'roles'   => array( 'updateSharePurchase' ),
            ),
            array( 'allow',
                'actions' => array( 'delete' ),
                'roles'   => array( 'deleteSharePurchase' ),
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
                    'type' => new ShareType,
                ),
            ),
            'toggle' => array(
                'class'     => 'admin.controllers.action.ToggleAction',
                'modelName' => $this->defaultModel,
                'exception' => Yii::t('share', 'Искомая заявка не найдена'),
            ),
//            'update' => array(
//                'class'      => 'admin.controllers.action.UpdateAction',
//                'modelName'  => $this->defaultModel,
//                'success'    => Yii::t('share', 'Заявка успешно отредактирована'),
//                'error'      => Yii::t('share', 'Ошибка при редактировании заявки'),
//                'exception'  => Yii::t('share', 'Искомая заявка не найдена'),
//                'renderData' => array(
//                    'type' => new ShareType,
//                ),
//            ),
            'delete' => array(
                'class'     => 'admin.controllers.action.DeleteAction',
                'modelName' => $this->defaultModel,
                'success'   => Yii::t('share', 'Заявка успешно удалена'),
                'error'     => Yii::t('share', 'Ошибка при удалении заявки'),
                'exception' => Yii::t('share', 'Искомая заявка не найдена'),
            ),
        );
    }

    public function actionUpdate($id)
    {
        $model = CActiveRecord::model($this->defaultModel)->findByPk($id);

        if ($model === null)
            Yii::app()->user->setFlash('error', Yii::t('share', 'Искомая заявка не найдена'));

        if (isset($_POST['ajax']) && $_POST['ajax'] === strtolower($this->defaultModel) . '-form')
        {
            echo BsActiveForm::validate($model);
            Yii::app()->end();
        }

        if (isset($_POST[$this->defaultModel]))
        {
            $model->attributes = $_POST[$this->defaultModel];

            if ($model->save())
            {
                if ($model->status == SharePurchase::STATUS_CONDUCTED)
                {
                    $template = LetterTemplate::model()->findByCode('purchase');
                    
                    if ($template !== null)
                    {
                        $params['type'] = $model->type->title;
                        $params['price'] = $model->price;

                        $mailer = new Mailer;
                        $mailer->to($model->user->email);
                        $mailer->from('1uom.com');
                        $mailer->subject($template->title);
                        $mailer->templateMessage($template->text, $params);
                        
                        if ($mailer->send())
                        {
                            Yii::app()->user->setFlash('success', Yii::t('share', 'Заявка успешно отредактирована'));
                            Yii::app()->user->setFlash('info', Yii::t('share', 'Подтверждение отослано пользователю'));
                        }
                        else
                            Yii::app()->user->setFlash('success', Yii::t('share', 'Заявка успешно отредактирована'));
                    }
                }
                else
                    Yii::app()->user->setFlash('success', Yii::t('share', 'Заявка успешно отредактирована'));
            }
            else
                Yii::app()->user->setFlash('error', Yii::t('share', 'Ошибка при редактировании заявки'));

            $this->redirect(array( 'index' ));
        }

        $this->render('update', array(
            'model' => $model,
            'type'  => new ShareType,
        ));
    }

    public function actionPurchase()
    {
        if (isset($_POST))
        {
            $array = array();

            foreach($_POST as $key => $item)
                $array[$key] = mb_convert_encoding($item, 'UTF-8', 'WINDOWS-1251');

            $model = new SharePurchase;

            if (isset($array['type']))
                $model->type_id = $array['type'];

            if (isset($array['quantity']))
                $model->count = $array['quantity'];

            if (isset($array['user_id']))
                $model->user_id = $array['user_id'];

            if (isset($array['price']))
                $model->price = $array['price'];

            unset($array['type']);
            unset($array['quantity']);
            unset($array['user_id']);
            unset($array['price']);
            unset($array['submit']);

            $model->data = CJSON::encode($array);
            $model->save(false);
        }

        $this->redirect('https://1uom.com/profile/stocks?status=1');
    }

}

